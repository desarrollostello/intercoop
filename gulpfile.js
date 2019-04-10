var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

/*elixir(function(mix) {
    mix.sass('app.scss');
});*/
elixir(function(mix) {
    mix.styles([
        'animate.css',
        'croppic.css',
        'style.css',
        'timeline.css',
        'my-timeline.css'
    ], 'html/css/style.css', null);
    mix.scripts([
        'init.js'
    ], 'html/js/init.min.js');
    // Specifying a specific output filename...
    //mix.styles('html/css/style.css');
});
