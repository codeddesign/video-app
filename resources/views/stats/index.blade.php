<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" id="token" value="{{ csrf_token() }}">
    </head>

    <body>
        <style type="text/css">
            * {
                box-sizing: border-box;
            }

            html {
                height: 100%;
            }

            body {
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .list-group {
                padding-left: 0;
                margin-bottom: 20px;
            }

            .list-group-item:first-child {
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
            }

            .list-group-item {
                position: relative;
                display: block;
                padding: 10px 15px;
                margin-bottom: -1px;
                background-color: #fff;
                border: 1px solid #ddd;
            }

            .container {
                max-width: 50%;
                margin: 20px auto;
            }

            .row {
                display: flex;
                color: black;
            }
            
            .row:nth-child(2) {
	            background: blue;
            }

            .box {
                cursor: pointer;
                display: inline-flex;
                flex: 1;
                min-height: 100px;
                margin-right: 20px;
                justify-content: center;
                align-items: center;
                border: 1px black solid;
            }

            .row > .box:last-child {
                margin-right: 0;
            }

            .box.active {
                background: yellow;
            }
        </style>

        <div class="container">
            <div v-show="!loading">
                from:
                <input type="text" placeholder="yyyy-mm-dd" v-model="from">
                <br/> to:
                <input type="text" placeholder="yyyy-mm-dd" v-model="to">
                <br/>
                <button @click="fetch">Go</button>
                <br/>
                <br/>
                <br/>

                <div class="row" v-if="stats">
                    <div class="box" v-for="(name, events) in stats | orderBy 'name'" :class="{'active': current == events}" @click="current = events">
                        <span>@{{ name | uppercase }}</span>
                    </div>
                </div>

                <div class="row" v-if="stats && current">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="e in current | orderBy 'event'">
                            <span>@{{ e.event}} : @{{ e.total }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div v-show="loading">
                Please wait..
            </div>
        </div>

        <script src="/assets/js/vuepack.js"></script>
        <script>
            new Vue({
                el: 'body',
                data: {
                    loading: false,
                    stats: false,
                    current: false,
                    from: '',
                    to: ''
                },
                methods: {
                    fetch: function() {
                        var url = '/stats-101/info?from=' + this.from + '&to=' + this.to;

                        this.loading = true;

                        this.$http.get(url, this.filter)
                            .then(function(response) {
                                this.stats = response.data;

                                this.loading = false;
                                this.current = false;
                            });
                    }
                }
            });
        </script>
    </body>

</html>
