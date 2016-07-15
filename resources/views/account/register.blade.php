@extends('account._base') @section('content')
<div class="user-creation" v-cloak>
    <div class="loginform-registertitle" v-show="step != 'completed'">NEW ACCOUNT</div>
    <div class="loginform-error"></div>

    <form @submit.prevent="register" v-show="step == 'credentials'">
        <div class="error" v-show="error">@{{ error }}</div>

        <div>
            <input type="email" name="email" placeholder="Email Address..." required v-model="user.email" v-el:email>
            <span class="loginemailicon"></span>
        </div>

        <div>
            <input type="password" name="password" placeholder="Password" required v-model="user.password">
            <span class="loginpassicon"></span>
        </div>

        <div>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required v-model="user.password_confirm">
            <span class="loginpassicon"></span>
        </div>

        <button>CONTINUE</button>
    </form>

    <form @submit.prevent.default="addPhone" v-show="step == 'phone'">
        <div class="error" v-show="error">@{{ error }}</div>

        <div>
            <input type="tel" name="phone" placeholder="Phone number.." required v-model="user.phone" v-el:phone>
            <span class="loginemailicon"></span>
        </div>

        <button>VERIFY NUMBER</button>
    </form>

    <form @submit.prevent.default="codeConfirm" v-show="step == 'phone_code'">
        <div class="error" v-show="error">@{{ error }}</div>

        <div>
            <input type="text" name="phone_code" placeholder="Enter verification number.." required v-model="user.phone_code" v-el:phoneCode>
        </div>

        <button>CONFIRM VERIFICATION NUMBER</button>
    </form>

    <div v-show="step == 'completed'" style="text-align: center;color: white;">
        <img src="/template/images/verify-success.png">

        <p>Success!</p>
        <p>Proceed to login page</p>
    </div>
</div>

@include('account._additional', ['on' => 'register'])

<script src="/js/all.js"></script>
<script>
    new Vue({
        el: 'body',
        data: {
            step: 'credentials',
            error: false,
            user: {
                email: '',
                password: '',
                password_confirm: '',
                phone: '',
                phone_code: ''
            }
        },
        ready: function() {
            this.$els.email.focus();
        },
        methods: {
            requestThenNext: function(path, data, next) {
                this.error = false;

                this.$http.post(path, data)
                    .then(function(response) {
                        if (response.data.message) {
                            this.error = response.data.message;
                        }

                        if (next) {
                            this.step = next;

                            this.$nextTick(function() {
                                if (this.$els[next]) {
                                    this.$els[next].focus();
                                }
                            });
                        }
                    })
                    .catch(function(response) {
                        if (response.data.message) {
                            this.error = response.data.message;

                            return false;
                        }
                    });
            },

            register: function() {
                if (this.user.password != this.user.password_confirm) {
                    this.error = 'Passwords do not match';
                    return false;
                }

                this.requestThenNext('/account/register', this.user, 'phone');
            },
            addPhone: function() {
                var data = {
                    phone: this.user.phone
                };

                this.requestThenNext('/account/verify-phone', data, 'phone_code')
            },
            codeConfirm: function() {
                var data = {
                    phone_code: this.user.phone_code
                };

                this.requestThenNext('/account/verify-phone-code', data, 'completed')
            }
        }
    });
</script>

@endsection
