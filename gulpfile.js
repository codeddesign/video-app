var elixir = require('laravel-elixir');

elixir.config.sourceMaps = false;

elixir(function(mix) {
    mix.scripts([
        './node_modules/vue/dist/vue.min.js',
        './node_modules/vue-resource/dist/vue-resource.min.js',
        'app.js'
    ]);
});
