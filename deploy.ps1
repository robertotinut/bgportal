# PowerShell One-Click Deployment Script for BGPortal
Param(
    [string]$msg = "Update BGPortal system"
)

$ErrorActionPreference = "Stop"

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host " [1/3] Staging & Committing Changes..." -ForegroundColor Yellow
Write-Host "=========================================" -ForegroundColor Cyan
git add .
git commit -m "$msg" --allow-empty

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host " [2/3] Pushing to GitHub (main)..." -ForegroundColor Yellow
Write-Host "=========================================" -ForegroundColor Cyan
git push origin main

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host " [3/3] Deploying to VPS (43.133.154.13)..." -ForegroundColor Yellow
Write-Host "=========================================" -ForegroundColor Cyan

$plink = "C:\Users\LENOVO\.gemini\antigravity-ide\brain\db129503-35c9-4e4d-bd59-ddf1b3aac74e\scratch\plink.exe"
$pass = "shadow-64`$-storm"
$vpsCmd = "cd /var/www/bgportal; git pull origin main; composer install --no-dev --optimize-autoloader; php artisan migrate --force; php artisan db:seed --force; php artisan config:cache; php artisan route:cache; php artisan view:cache; sudo chown -R ubuntu:www-data /var/www/bgportal/storage /var/www/bgportal/bootstrap/cache; chmod -R 775 /var/www/bgportal/storage /var/www/bgportal/bootstrap/cache"

& $plink -batch -hostkey "SHA256:Unx7PP+hIiXEGkDjyvjeavYGjkSH9axtNwy+yDsufF4" -pw $pass ubuntu@43.133.154.13 $vpsCmd

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host " Deployment Completed Successfully!" -ForegroundColor Green
Write-Host "=========================================" -ForegroundColor Cyan
