const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js/vendor.js')
    .sass('resources/assets/sass/app.scss', 'public/css/vendor.css')
    .sass('resources/assets/css/custom.scss', 'public/css/custom.css')
    .styles('resources/assets/css/timeline.css', 'public/css/timeline.css')
    .js('resources/assets/app/app_grid.js', 'public/js/grid.js')
    .js('resources/assets/app/app_tree.js', 'public/js/tree.js')
    .js('resources/assets/app/app_grid_start.js', 'public/js/start_grid.js')
    .js('resources/assets/app/calendar.js', 'public/js/calendar.js')
    .sourceMaps()
    .version();
    //.browserSync('testlaravel.local');
