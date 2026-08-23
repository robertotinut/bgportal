#!/bin/bash
# Bash Deployment Script for BGPortal
COMMIT_MSG="${1:-Update project}"

echo "========================================="
echo " 🚀 1/3: Staging & Committing Changes..."
echo "========================================="
git add .
git commit -m "$COMMIT_MSG" --allow-empty

echo "========================================="
echo " 📤 2/3: Pushing to GitHub (main)..."
echo "========================================="
git push origin main

echo "========================================="
echo " 🌐 3/3: Deploying to VPS (43.133.154.13)..."
echo "========================================="
ssh ubuntu@43.133.154.13 "cd /var/www/bgportal && git pull origin main && composer install --no-dev --optimize-autoloader && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && sudo chown -R www-data:www-data /var/www/bgportal/storage /var/www/bgportal/bootstrap/cache"

echo "========================================="
echo " 🎉 Deployment Completed Successfully!"
echo "========================================="
