# package-english

php artisan vendor:publish --provider="Foostart\English\EnglishServiceProvider" --force
php artisan db:seed --class=EnglishSeeder