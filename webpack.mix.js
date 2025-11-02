const mix = require('laravel-mix');

mix.js('public/tailadmin/js/index.js', 'public/js/app.js')
   .postCss('public/tailadmin/css/style.css', 'public/css', [
       require('tailwindcss'),
   ])
   .setPublicPath('public')
   .version();
