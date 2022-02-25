const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js').vue()
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'resources/css/app.css',
        'resources/css/bootstrap.min.css',
        'resources/css/main.css',
        'resources/css/perfect-scrollbar.css',
        'resources/css/structure.css'
    ],"public/css/app.css")

    .babel([
        "resources/js/common.js",
        "resources/js/jquery-3.1.1.min.js",
        "resources/js/popper.min.js",
        "resources/js/bootstrap.min.js",
        "resources/js/perfect-scrollbar.min.js",
        "resources/js/custom.js"
    ], "public/js/common.min.js")


.browserSync('localhost:8000')
.disableSuccessNotifications();
