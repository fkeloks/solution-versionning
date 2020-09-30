const mix = require('laravel-mix');

mix.setPublicPath('www/public/dist');

mix.sass('www/assets/scss/app.scss', 'www/public/dist/css/app.css');
mix.babel('www/assets/js/app.js', 'www/public/dist/js/app.js');

mix.sass('www/assets/scss/themes/light.scss', 'www/public/dist/css/themes/light.css');
mix.sass('www/assets/scss/themes/dark.scss', 'www/public/dist/css/themes/dark.css');

mix.disableNotifications();