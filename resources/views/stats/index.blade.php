<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" id="token" value="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    </head>

    <body>
        <style type="text/css">
            .container {
                padding: 0;
                margin: 30px auto
            }

            .filter-header {
                padding: 8px;
                font-weight: bold;
                font-size: 14px;
            }

            ul.types {
                font-size: 12px;
            }

            span.type-name {
                display: inline-block;
                min-width: 40px;
            }

            div.separator {
                height: 1px;
                background: #ccc;
                margin-bottom: 20px;
            }

            .total {
                margin-top: 20px;
                font-weight: bold;
                font-size: 26px;
                text-align: center;
            }
        </style>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="filter-header">Filters</div>

                    <ul class="list-group types">
                        <li class="list-group-item" v-for="type in response.types | orderBy 'name'" :class="{active: type.active}" @click="add(type)">
                            <span class="type-name">@{{ type.name }}</span>
                            <span>@{{type.event.replace('content', '') | lowercase }}</span>
                        </li>
                    </ul>

                    <div class="separator"></div>

                    <div>
                        <input type="date" placeholder="yyy-mm-dd" v-model="filter.from">
                        <input type="date" placeholder="yyyy-mm-dd" v-model="filter.to">
                    </div>

                    <div class="separator"></div>

                    <button class="btn btn-success btn-block" @click="fetch()">Update</button>

                    <div class="total" v-show="ready">Total: @{{ response.info.total }}</div>
                </div>
                <div class="col-md-10">
                    <div v-show="!ready">Please wait..</div>

                    <div v-show="ready">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Campaign</th>
                                    <th>Name</th>
                                    <th>Event</th>
                                    <th>Created</th>
                                    <th>Referer</th>
                                </tr>
                            </thead>
                            <tr v-for="event in response.info.events">
                                <td>@{{ event.id }}</td>
                                <td>@{{ event.campaign_id }}</td>
                                <td>@{{ event.name }}</td>
                                <td>@{{ event.event }}</td>
                                <td>@{{ event.created_at }}</td>
                                <td>@{{ event.referer }}</td>
                            </tr>
                        </table>

                        <nav v-show="totalPages > 1">
                            <ul class="pagination">
                                <li v-for="page in totalPages" @click.prevent.default="toPage(page + 1)" :class="{active: filter.page == (page + 1)}">
                                    <a href="#">
                                        @{{ page + 1 }} <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/js/vuepack.js"></script>
        <script>
            new Vue({
                el: 'body',
                data: {
                    ready: false,
                    response: {
                        types: [],
                        info: {
                            events: [],
                            total: 0
                        }
                    },
                    filter: {
                        types: {},
                        from: false,
                        to: false,
                        page: 1,
                        limit: 10
                    }
                },
                ready: function() {
                    this.$http.post('/stats-101/info', this.filter)
                        .then(function(response) {
                            response.data.types.forEach(function(type, index) {
                                response.data.types[index].active = false;
                            });

                            this.response = response.data;

                            this.ready = true;
                        });
                },
                computed: {
                    totalPages: function() {
                        var total = this.response.info.total / this.filter.limit;

                        return total;
                    }
                },

                methods: {
                    add: function(type) {
                        var unique = type.name + type.event;

                        type.active = !type.active;

                        if (this.filter.types[unique]) {
                            delete this.filter.types[unique];
                            return false;
                        }

                        this.filter.types[unique] = {
                            name: type.name,
                            event: type.event
                        };
                    },
                    fetch: function(pageNo) {
                        this.ready = false;

                        this.$http.post('/stats-101/info', this.filter)
                            .then(function(response) {
                                this.response.info = response.data.info;

                                this.ready = true;
                            });
                    },
                    toPage: function(pageNo) {
                        this.ready = false;
                        this.filter.page = pageNo;

                        this.$http.post('/stats-101/info', this.filter)
                            .then(function(response) {
                                this.response.info.events = response.data.info.events;

                                this.ready = true;
                            });
                    }
                }
            });
        </script>
    </body>

</html>
