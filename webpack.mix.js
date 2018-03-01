let mix = require('laravel-mix');

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

mix.js('resources/assets/js/entries/auth/login.js', 'public/js/auth');
mix.js('resources/assets/js/entries/modules/home.js', 'public/js/modules');
mix.js('resources/assets/js/entries/modules/profile.js', 'public/js/modules');
mix.js('resources/assets/js/entries/modules/users/roles.js', 'public/js/modules/users');
mix.js('resources/assets/js/entries/modules/users/users.js', 'public/js/modules/users');
mix.js('resources/assets/js/entries/modules/settings/general_settings.js', 'public/js/modules/settings');
/**MIX_REPLACER**/

mix.copy( 'node_modules/font-awesome/css/font-awesome.min.css',  'public/css/font-awesome/css' );
mix.copy( 'node_modules/font-awesome/fonts',  'public/css/font-awesome/fonts' );

mix.copy('node_modules/normalize.css/normalize.css', 'public/css/normalize/');

mix.copy('resources/assets/fonts', 'public/fonts');

mix.js('resources/assets/js/vue-dash.js', 'public/js')
    .sass('resources/assets/sass/vue_dash.scss', 'public/css')
    .extract([ 'vue', 'axios', 'lodash', 'moment' ], 'public/js/vendor.js');