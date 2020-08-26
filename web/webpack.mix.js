const mix = require('laravel-mix');
const path = require('path');

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

mix.webpackConfig({
    resolve: {
        // extensions: ['.js', '.vue', '.json'],
        alias: {
            "@": path.resolve(__dirname, "resources/js/"),
            "@components": path.resolve(__dirname, "resources/js/components/"),
            "@store": path.resolve(__dirname, "resources/js/store/"),
        }
    }
});

mix.browserSync({
    proxy: '0.0.0.0:8081',
    open: false
})
    .js('resources/js/app.js', 'public/js');
