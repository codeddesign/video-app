Vue.config.devtools = true;

/**
 * Temporary solution for 'used' tokens.
 *
 * If a POST is being made an extra GET request is done
 * to fetch a new csrf_token
 */
Vue.http.interceptors.push(function(request, next) {
    var $token = document.querySelector('#token');

    if (request.method == 'post') {
        Vue.http.headers.common['X-CSRF-TOKEN'] = $token.getAttribute('value');

        // this.$http.get('/app/token')
        //     .then(function(response) {
        //         $token.setAttribute('value', response.data.token);
        //     })
        //     .catch(function() {
        //         console.error('Failed to get token')
        //     })
    }

    next();
});

Vue.component('app-modal', {
    template: `
        <div class="app_modal-overlay" v-show="visible">
            <div class="app_modal">
                <span class="app_modal-close" @click="close">&times;</span>
                <div class="app_modal-body">
                    <div class="app_modal-title" v-show="title">{{ title }}</div>
                    <div class="app_modal-content" v-show="body">
                        <div v-if="!html"> {{ body }} </div>
                        <div v-else>{{{ body }}}</div>
                    </div>

                    <div class="app_modal-footer" v-show="confirm">
                        <button class="proceed" @click="proceed" :disabled="loading">Proceed</button>
                    </div>
                </div>
            </div>
        </div>`,
    data: function() {
        return {
            visible: false,
            title: false,
            body: false,
            confirm: false,
            callback: false,
            loading: false,
            html: false
        }
    },

    events: {
        'modal-open': function(setup, callback) {
            this.title = setup.title || false;
            this.body = setup.body || false;
            this.confirm = setup.confirm || false;
            this.html = setup.html || false;
            this.callback = callback || false;

            this.loading = false;

            this.open();
        },

        'modal-close': function() {
            this.close();
        }
    },

    methods: {
        open: function(callback) {
            this.visible = true;
        },

        close: function() {
            this.visible = false;
        },

        proceed: function() {
            if (typeof this.callback == 'function') {
                this.loading = true;

                this.callback();

                return false;
            }

            this.close();
        }
    }
});