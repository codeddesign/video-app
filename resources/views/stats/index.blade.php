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
                            <div>@{{ e.event }} : @{{ e.total }}</div>
                            <div v-if="errorInfo(e.event)"><em>@{{ errorInfo(e.event) }}</em></div>
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
                    to: '',
                    errors: {
                        1012: "The ad response was not recognized as a valid VAST ad.",
                        200: "The ad response was not understood and cannot be parsed.",
                        301: "The VAST URI provided, or a VAST URI provided in a subsequent Wrapper element, was either unavailable or reached a timeout, as defined by the video player.",
                        302: "The maximum number of VAST wrapper redirects has been reached.",
                        303: "At least one VAST wrapper loaded and a subsequent wrapper or inline ad load has resulted in a 404 response code.",
                        400: "There was an error playing the video ad.",
                        402: "Failed to load media assets from a VAST response.",
                        403: "Assets were found in the VAST ad response for linear ad, but none of them matched the video player's capabilities.",
                        603: "A companion ad failed to load or render.",
                        900: "An unexpected error occurred and the cause is not known.",
                        1004: "Ads list response was malformed.",
                        1005: "There was a problem requesting ads from the server.",
                        1006: "Listener for at least one of the required vast events was not added.",
                        1007: "No assets were found in the VAST ad response.",
                        1008: "The ad slot is not visible on the page.",
                        1009: "Empty VAST response.",
                        1010: "There was an error loading the ad.",
                        1020: "There was an error initializing the stream.",
                        1101: "Invalid arguments were provided to SDK methods.",
                        1102: "Generic invalid usage of the API.",
                        1103: "The version of the runtime is too old.",
                        1201: "Another VideoAdsManager is still using the video.",
                        1202: "A video element was not specified where it was required.",
                        1205: "Content playhead was not passed in, but list of ads has been returned from the server."
                    }
                },
                methods: {
                    errorInfo: function(name) {
                        var chunks = name.split(':'),
                            code = chunks[1];

                        if (name.indexOf('fail') === -1) {
                            return false;
                        }

                        console.log(name, code, this.errors);
                        if (!this.errors[code]) {
                            return false
                        }

                        return this.errors[code];;
                    },
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
