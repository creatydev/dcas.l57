const mix = require('laravel-mix');
require('laravel-mix-tailwind');

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
    .sass('resources/sass/app.scss', 'public/css')
    .copy('node_modules/font-awesome/fonts/*', 'public/fonts/')
    .copy('node_modules/ionicons/dist/fonts/*', 'public/fonts/')
    .copy('node_modules/material-design-iconic-font/dist/fonts/*', 'public/fonts/')
    .copy('node_modules/simple-line-icons/fonts/*', 'public/fonts/')
    .tailwind();

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                loader: 'ts-loader',
                options: {appendTsSuffixTo: [/\.vue$/]},
                exclude: /node_modules/,
            },
        ],
    },
    resolve: {
        extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx'],
    },
});
