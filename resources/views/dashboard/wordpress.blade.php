@extends('dashboard._base')

@section('content')

<div class="accountpasswrap page-wordpress" v-cloak>
    <div class="accountpass-leftsep" style="width:100%;">
        <div class="display-septext">SITE VALIDATION</div>
    </div>

    <form action="/account/edit" method="post" @submit.prevent="add">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="site._token">

        <div>
            <label>ADD A NEW SITE</label>
            <input name="link" placeholder="http://example.com" required v-model="site.link">
        </div>

        <button type="submit">REQUEST APPROVAL</button>
    </form>
    <div class="sitevalidation-howitworkswrap">
    	<div class="sitevalidation-howitworks"><span></span> HOW APPROVAL WORKS</div>
    	
    	<div class="sitevalidation-worksaddtl"><span>NEW WEBSITE APPROVAL MAY TAKE UP TO 24 HOURS.</span>  <br>YOU WILL RECIEVE AN EMAIL ONCE YOUR WEBSITE HAS BEEN APPROVED.</div>
    </div>

    <div class="accountpass-accountidwrap" style="margin-bottom:30px;">
        <div class="accountpass-accountidtitle">WEBSITES ADDED</div>

        <div v-for="site in sites">
            <div class="accountpass-accountid">
                <div class="sitevalidation-sitelink">@{{ site.link }}</div>
                <div class="sitevalidation-timestamp">MARCH 15, 2016</div>
                <!-- site approval alert -->

                <!-- end approval alert -->
                <button v-on:click="remove(site.id)" class="sitevalidation-removesite">REMOVE</button>
                
                <div class="sitevalidation-siteapproved">APPROVED</div>
                <div class="sitevalidation-sitepending">PENDING</div>
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
