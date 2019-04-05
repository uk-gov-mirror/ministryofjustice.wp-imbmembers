const mix_ = require('laravel-mix');

mix_.setPublicPath('./dist/')
    .js([
        './assets/scripts/components/treenav.js',
        './assets/scripts/main.js'
    ], 'main.min.js')
    .less('./assets/styles/editor-style.less', 'editor-style.min.css')
    .less('./assets/styles/main.less', 'main.min.css')
    .options({
        processCssUrls: false
    })
    .copy('./node_modules/bootstrap/fonts/*', 'dist/fonts/')
    .js('./modernizr.js', 'dist/modernizr.min.js');

if (mix_.inProduction()) {
    mix_.version();
} else {
    mix_.sourceMaps();
}
