# Update project guide
This document is a guide to update this project.

## Laravel security fix
Laravel use patch or minor tag for security fix.

**How to update ?**

You need to create a branch from `production` branch!
```bash
echo "Check composer.json laravel/framework version"
read -r -p "Okey, major or minor version is fixed? [Y/n] " response
if [[ $response == "n" || $response == "N" || $response == "no" || $response == "No" ]]; then
  echo "You have to fix it!"
  exit 1;
fi

# Update Laravel
composer update laravel/framework
 
echo "Have a look at Laravel release note or Laravel blog post: https://blog.laravel.com/releases"
read -r -p "Okey, no used feature updated? [Y/n] " response
if [[ $response == "n" || $response == "N" || $response == "no" || $response == "No" ]]; then
  echo "You have to fix it!"
  exit 1;
fi

# Clear cache for test
php artisan config:clear
php artisan cache:clear
php artisan view:clear

 # Run PHPUnit tests!
.vendor/bin/phpunit -colors=never

echo "\nGood, let check app!\n"
read -r -p "All it's ok for you? [y/N] " response
if [[ $response == "n" || $response == "N" || $response == "no" || $response == "No" ]]; then
  echo "You have to fix it!"
  exit 1;
fi
```

No you have to push and deploy on PP.  
It's good en PP, envoy in production.

## Package security fix
// TODO