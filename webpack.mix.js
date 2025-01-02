const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    // .react()
    .extract(['popper.js', 'bootstrap', 'vue', 'jquery', 'blueimp-gallery'])
    .scripts(['resources/js/tagsinput.js'], 'public/js/custom.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    //.copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce')
    .copy('node_modules/html5-qrcode/html5-qrcode.min.js', 'public/js/html5-qrcode.min.js')
    .copy('node_modules/print-js/dist/print.js', 'public/js/print.js')
    .copy('node_modules/tinymce', 'public/js/tinymce');

var browser_sync = process.env.BROWSER_SYNC;

if (browser_sync) {
    browser_sync = browser_sync.toLowerCase();
} // End of if (browser_sync)

var app_url = process.env.APP_URL;
console.log(`APP_URL: ${app_url}`);

var browser_sync_enable = false;

switch(browser_sync) {
    case 'true':
    case '1':
    case 'yes':
    browser_sync_enable = true;
    break;
    default:
    browser_sync_enable = false;
} // End of switch(browser_sync)

if (browser_sync_enable) {
    mix.browserSync(app_url);
} // End of if (browser_sync)