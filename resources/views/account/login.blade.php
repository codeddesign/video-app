@extends('account._base')
@section('content')

<form @submit.prevent="login" v-cloak>
    <div class="error" v-show="error">@{{ error }}</div>

    <div>
        <input type="email" name="email" placeholder="email address.." required v-model="user.email" v-el:email>
        <span class="loginemailicon"></span>
    </div>

    <div>
        <input type="password" name="password" placeholder="password.." required v-model="user.password">
        <span class="loginpassicon"></span>
    </div>

    <button>LOGIN</button>
</form>

@include('account._additional', ['on' => 'login'])

<script src="/js/vuepack.js"></script>
<script>
    new Vue({
        el: 'body',
        data: {
            error: false,
            user: {
                email: '',
                password: ''
            }
        },

        ready: function() {
            this.$els.email.focus()
        },

        methods: {
            login: function() {
                this.error = false;

                this.$http.post('/account/login', this.user)
                    .then(function(response) {
                        this.user.password = '';

                        if (response.data.redirect) {
                            location.href = response.data.redirect;

                            return false;
                        }

                        console.error('Failed to authenticate. Contact dev if problem persists.');
                    })
                    .catch(function(response) {
                        this.user.password = '';

                        this.error = (response.data) ? response.data.message : response;
                    });
            }
        }
    });
</script>

@endsection
