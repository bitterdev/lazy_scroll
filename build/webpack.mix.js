let mix = require('laravel-mix');
const path = require("path");

mix.setResourceRoot('../');
mix.setPublicPath('../');

mix
    .sass('assets/lazy-scroll.scss', './css/lazy-scroll.css', {
        sassOptions: {
            includePaths: [
                path.resolve(__dirname, './node_modules/')
            ]
        }
    })
    .js('assets/lazy-scroll.js', './js/lazy-scroll.js')