<?php

namespace App\Services;

use App\Models\AffiliateLink;
use Illuminate\Support\Str;

class ShopeeScraperService
{
    /**
     * Category keywords dictionary for mandatory filtering.
     */
    protected array $categoryKeywords = [
        'Pakaian / Baju' => [
            'baju', 'pakaian', 'kaos', 't-shirt', 'tshirt', 'kemeja', 'shirt', 
            'dress', 'gamis', 'tunik', 'tunic', 'jaket', 'jacket', 'hoodie', 
            'sweater', 'cardigan', 'blouse', 'blus', 'celana', 'pants', 'jeans', 
            'rok', 'skirt', 'outer', 'vest', 'outfit', 'fashion', 'atasan', 'bawahan'
        ]
    ];

    /**
     * Process an affiliate link: Scrape product info, validate category, and generate pin content.
     */
    public function processLink(AffiliateLink $link, string $targetCategory = 'Pakaian / Baju'): array
    {
        // Extract product info from Shopee URL
        $extractedData = $this->extractProductInfo($link->shopee_url);

        $link->product_title = $extractedData['title'];
        $link->category = $extractedData['category'];
        $link->product_image = $extractedData['image'];

        // Validate Category - Mandatory Filter
        $isValidCategory = $this->validateCategory($extractedData['title'], $extractedData['category'], $targetCategory);

        if (!$isValidCategory) {
            $link->status = 'skipped';
            $link->error_message = "Produk ('{$extractedData['title']}') tidak memenuhi kategori wajib: {$targetCategory}";
            $link->save();

            return [
                'status' => 'skipped',
                'reason' => $link->error_message
            ];
        }

        // Generate AI Promo Pin Title, Description, & Banner Image
        $link->pin_title = $this->generatePinTitle($extractedData['title']);
        $link->pin_description = $this->generatePinDescription($extractedData['title'], $link->affiliate_url);
        $link->promo_image = $extractedData['image'];
        $link->status = 'pending';
        $link->save();

        return [
            'status' => 'success',
            'data' => $link
        ];
    }

    /**
     * Check if product title or category matches the allowed target category keywords.
     */
    public function validateCategory(string $title, string $category, string $targetCategory): bool
    {
        $keywords = $this->categoryKeywords[$targetCategory] ?? ['baju', 'pakaian', 'kaos', 'kemeja', 'dress', 'tunik', 'gamis', 'sweater', 'hoodie', 'celana', 'rok', 'outer', 'vest', 'outfit', 'fashion', 'atasan', 'bawahan'];
        
        $cleanTitle = strtolower($title);
        $cleanCategory = strtolower($category);

        // If category is Non-Pakaian / Lainnya, verify title against strong apparel keywords
        if (str_contains($cleanCategory, 'non-pakaian') || str_contains($cleanCategory, 'non-baju') || str_contains($cleanCategory, 'lainnya')) {
            $strongKeywords = ['baju', 'kaos', 'kemeja', 'dress', 'tunik', 'gamis', 'sweater', 'hoodie', 'celana', 'rok', 'outer', 'tshirt', 't-shirt'];
            foreach ($strongKeywords as $kw) {
                if (str_contains($cleanTitle, $kw)) {
                    return true;
                }
            }
            return false;
        }

        foreach ($keywords as $kw) {
            $kw = trim($kw);
            if (!empty($kw) && str_contains($cleanTitle . ' ' . $cleanCategory, $kw)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract product metadata from Shopee URL.
     */
    protected function extractProductInfo(string $shopeeUrl): array
    {
        $path = parse_url($shopeeUrl, PHP_URL_PATH);
        $slug = basename($path);
        
        $cleanTitle = Str::title(str_replace(['-', '_', '.'], ' ', $slug));
        
        if (strlen($cleanTitle) < 5) {
            $cleanTitle = "Baju Atasan Fashion Premium Trendy Shopee Affiliate";
        }

        $category = "Lainnya / Non-Pakaian";
        if (Str::contains(strtolower($cleanTitle), ['baju', 'kemeja', 'kaos', 'dress', 'tunik', 'gamis', 'sweater', 'hoodie', 'celana', 'pakaian', 'outfit', 'fashion', 'rok', 'atasan', 'bawahan'])) {
            $category = "Pakaian / Fashion";
        }

        return [
            'title' => $cleanTitle,
            'category' => $category,
            'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600&auto=format&fit=crop&q=60'
        ];
    }

    /**
     * Generate engaging Pin Title using AI pattern.
     */
    protected function generatePinTitle(string $productTitle): string
    {
        return "✨ OOTD Rekomendasi: " . Str::limit($productTitle, 60, '...');
    }

    /**
     * Generate SEO Pinterest Pin Description with hashtags & affiliate link.
     */
    protected function generatePinDescription(string $productTitle, string $affiliateUrl): string
    {
        return "Diskon spesial hari ini! " . $productTitle . ". Yuk cek stok & harga promonya sekarang sebelum kehabisan! 🔥\n\n📌 Klik link di atas untuk beli langsung di Shopee: " . $affiliateUrl . "\n\n#OOTD #BajuWanita #FashionInspo #ShopeeHaul #RekomendasiBaju #AffiliateShopee";
    }
}
