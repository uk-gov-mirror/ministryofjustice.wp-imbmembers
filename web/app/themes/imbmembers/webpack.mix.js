const mix_ = require('laravel-mix');


mix_.setPublicPath('./dist/')
    .js(['./assets/assets/_main.js', './assets/js/'], 'js/scripts.min.js')
    .sass('./assets/styles/main.scss', 'css/main.min.css')
    .browserSync();


if (mix_.inProduction()) {
    mix_.version();
} else {
    mix_.sourceMaps();
}
