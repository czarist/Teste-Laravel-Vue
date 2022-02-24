const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js').vue()
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'resources/css/app.css'
    ],"public/css/app.css")

.browserSync('localhost:8000')
.disableSuccessNotifications();
