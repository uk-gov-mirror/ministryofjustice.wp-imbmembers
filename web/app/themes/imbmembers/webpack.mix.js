const mix_ = require('laravel-mix');

mix_.setPublicPath('./dist/')
    .js([
        './assets/scripts/components/treenav.js',
        './assets/scripts/main.js'
    ], 'main.min.js')
    .sass('./assets/sass/editor-style.scss', 'editor-style.min.css')
    .sass('./assets/sass/main.scss', 'main.min.css')
    .copy('./assets/fonts/*', 'dist/fonts/')
    .js('./modernizr.js', 'dist/modernizr.min.js');

if (mix_.inProduction()) {
    mix_.version();
} else {
    mix_.sourceMaps();
}
