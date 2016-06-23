@extends('dashboard._base')

@section('content')

<div class="accountpasswrap page-wordpress" v-cloak>
    <div class="accountpass-leftsep" style="width:100%;">
        <div class="display-septext">Add new wordpress site</div>
    </div>

    <form action="/account/edit" method="post" @submit.prevent="add">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="site._token">

        <div>
            <label>NEW SITE</label>
            <input name="link" placeholder="http://example.com" required v-model="site.link">
        </div>

        <button type="submit">ADD</button>
    </form>

    <div class="accountpass-accountidwrap" style="float: left;max-width: 700px;width: calc(100% - 60px);margin-left: 30px;margin-top: 30px;margin-right: 30px;">
        <div class="accountpass-accountidtitle">Added</div>

        <div v-for="site in sites">
            <div class="accountpass-accountid" style="text-align: left;margin-top: 1px;">
                <span style="padding-left: 10px;">@{{ site.link }}</span>
                <span class="campview-campoff campview-campoffactive" style="cursor: pointer; float: right;margin: 14px;"
                    @click="remove(site.id)"
                ></span>
            </div>
        </div>
    </div>
</div>

<script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.25/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.8.0/vue-resource.js"></script>
<script type="text/javascript">
new Vue({
    el: '.page-wordpress',
    data: {
        site: {
            link: '',
            _token: ''
        },

        sites: []
    },

    created: function() {
        this.$http.get('/wordpress/sites')
            .then(function(response) {
                this.sites = response.data;
            });
    },

    methods: {
        add: function() {
            this.$http.post('/wordpress/add', this.site)
                .then(function(response) {
                    if (response.data.error) {
                        alert(response.data.error);
                        return false;
                    }

                    this.site.link = '';

                    this.$set('sites', response.data);
                });
        },

        remove: function(id) {
            this.$http.get('wordpress/remove/' + id)
                .then(function(response) {
                    this.$set('sites', response.data);
                });
        }
    }
});
</script>

@endsection
