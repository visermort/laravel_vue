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
    .styles('resources/assets/css/style.css', 'public/css/custom.css')
    .js([
        'resources/assets/app/app.js'
        // 'resources/assets/app/components/comm.js',
        // 'resources/assets/app/components/greed.js',
        // 'resources/assets/app/components/modal.js',
        // 'resources/assets/app/components/comm.vue',
        // 'resources/assets/app/components/greed.vue',
        // 'resources/assets/app/components/modal.vue',
        //  'resources/assets/app/payments.vue'

    ]
    , 'public/js/custom.js')
    .sourceMaps()
    .version();
