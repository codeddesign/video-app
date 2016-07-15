var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.scripts(
        [
            './node_modules/vue/dist/vue.min.js',
            './node_modules/vue-resource/dist/vue-resource.min.js',
            'vue.js'
        ],
        'public/js/vuepack.js'
    );
});
