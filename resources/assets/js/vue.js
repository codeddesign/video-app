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

        this.$http.get('/token')
            .then(function(response) {
                $token.setAttribute('value', response.data.token);
            })
            .catch(function() {
                console.error('Failed to get token')
            })
    }

    next();
});
