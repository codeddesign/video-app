@extends('app._base')

@section('page_name') CREATE CAMPAIGN @endsection

@section('content')
<style type="text/css">
    .selectadtype-overlay li {
        cursor: pointer;
    }

    .selectadtype-overlay li.disabled {
        pointer-events: none;
    }

    .videosize {
        width: 90px !important;
    }

    .selectadtype-overlay button {
        background: #8883B9;
        text-align: center;
        display: inline-block;
        width: 200px;
        height: 46px;
        line-height: 46px;
        font-size: 12px;
        color: #FFFFFF;
        border: none;
        cursor: pointer;
    }

    .message {
        max-width: 650px;
        padding: 10px 0;
        margin: 0 auto;
    }

    .message.error {
        background: red;
    }

    .message.success {
        background: green;
    }

    label.white {
        float: left;
        width: 100%;
        font-size: 10px;
        color: white;
        font-weight: 600;
        margin-bottom: 9px;
    }
</style>


<div class="selectadtype-overlay" v-cloak>
    <div id="adcreation-form">
        <div class="steps clearfix">
            <ul>
                <li v-for="(index, tab) in tabs" :class="{'current': step == tab.name, 'disabled': tab.disabled}" @click="toStep(index + 1)">
                    <span class="number">@{{ index + 1 }}.</span> @{{ tab.title }}
                </li>
            </ul>
        </div>

        <!-- start select ad type -->
        <div class="adcreation-section" v-show="step == 'type'">
            <div class="selectadtype-title">Select your ad type to proceed:</div>
            <div class="selectadtype-wrapper">
                <ul class="selectadtype-adtypes">
                    <li v-for="(type, info) in campaign_types" :class="{'disabled': !info.available}" @click="pickAdType(type)">
                        <img :src="'/assets/images/adtype-'+type+'.png'">
                        <div class="selectadtype-adtypetitle">@{{ info.title }}</div>
                        <div class="selectadtype-adtypeselect">select this ad</div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- end select ad type -->

        <!-- start create ad name -->
        <div class="adcreation-section" v-show="step == 'name'">
            <div class="selectadtype-title">
                @{{ selectedCampaign.has_name ? 'Create a Reference Name for your Ad:' : 'Ad your youtube link' }}

                <div class="message error" v-if="error">
                    @{{ error }}
                </div>
            </div>
            <div class="selectadtype-wrapper">
                <div class="createcampaign-fulltoparea">
                    <div class="campaign-creationwrap createcampaign-middlecreatewrap">
                        <form name="campaignForm" @submit.prevent.default="checkPreview()">
                            <div class="campaign-creationyoutube" v-if="!selectedCampaign.has_name">
                                <label for="campaign_name">Youtube</label>
                                <input id="campaign_name" type="text" placeholder="https://www.youtube.com/watch?v=AbcDe1FG234" required v-model="campaign.video">
                            </div>

                            <div class="campaign-creationyoutube" v-if="selectedCampaign.has_name">
                                <label for="campaign_name">NAME</label>
                                <div class="campaignform-error hidden">Already same title exists.</div>
                                <input id="campaign_name" type="text" placeholder="Reference name.." required v-model="campaign.name">
                            </div>

                            <div class="campaign-creationvidsize">
                                <label for="video_size">VIDEO SIZE</label>

                                <select id="video_size" class="yt-uix-form-input-select-element" required v-model="campaign.size">
                                    <option v-for="size in sizes" :value="size">@{{size.description | capitalize }}</optgroup>
                                </select>
                            </div>

                            <button>PROCEED TO PREVIEW</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end create ad name -->

        <div class="adcreation-section" v-show="step == 'preview'">
            <div class="selectadtype-title">
                <div v-if="!loading">Your video preview</div>
                <div v-else>Please wait..</div>
            </div>

            <div class="selectadtype-wrapper">
                <div class="createcampaign-fulltoparea">
                    <div class="campaign-creationwrap createcampaign-middlecreatewrap preview" v-el:preview-container></div>
                </div>
            </div>

            <div style="clear: both;color: white;padding-top: 20px;text-align: center;" v-show="!loading">
                <button @click="save()">Save</button>
            </div>
        </div>

        <div class="adcreation-section" v-show="step == 'code'">
            <div class="selectadtype-title">
                <div class="message success" v-if="!loading">
                    Campaign "@{{ savedCampaign.name }}" is now saved
                </div>
                <div v-if="loading">Please wait..</div>
            </div>

            <div style="margin: 0 auto;" v-if="!loading">
                <div class="createcampaign-fulltoparea">
                    <div class="campaign-creationwrap createcampaign-middlecreatewrap" style="background: none;">
                        <label for="embed_js" class="white" style="font-size: 14px">Copy and paste the code below in your website:</label>
                        <textarea id="embed_js" style="width: 100%;height: 100%;resize: none;" v-el:embed-js-code @click="selectEmbedText()"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/vuepack.js"></script>
<script>
    new Vue({
        el: '.selectadtype-overlay',
        data: {
            campaign_types: {!!$campaign_types!!},
            step: 'type',
            tabNo: 0,
            loading: false,
            error: false,
            tabs: [{
                name: 'type',
                title: 'Select Ad Type',
                disabled: false
            }, {
                name: 'name',
                title: 'Create Ad Name',
                disabled: true
            }, {
                name: 'preview',
                title: 'Preview Campaign',
                disabled: true
            }, {
                name: 'code',
                title: 'Get Code',
                disabled: true
            }],
            sizes: [{
                value: 'auto',
                description: 'auto'
            }, {
                value: 'small',
                description: '560 x 315'
            }, {
                value: 'medium',
                description: '640 x 360'
            }, {
                value: 'large',
                description: '853 x 480'
            }, {
                value: 'hd720',
                description: '1280 x 729'
            }],
            campaign: {
                type: false,
                name: '',
                size: {
                    value: 'auto',
                    description: 'auto'
                },
                video: ''
            },
            backup: {},
            savedCampaign: {}
        },
        ready: function() {
            // hold a clean copy of campaign
            this.backup = JSON.parse(JSON.stringify(this.campaign));
        },

        computed: {
            selectedCampaign: function() {
                return this.campaign_types[this.campaign.type];
            },
            campaignData: function() {
                var data = JSON.parse(JSON.stringify(this.campaign));

                data['size'] = this.campaign.size.value;

                return data;
            }
        },

        methods: {
            resetCampaign: function() {
                Object.keys(this.campaign).forEach(function(key) {
                    this.campaign[key] = this.backup[key];
                }.bind(this));
            },

            nextStep: function(index) {
                index -= 1;

                this.tabs[index].disabled = false;

                this.step = this.tabs[index].name;
            },
            toStep: function(index) {
                index -= 1;

                var tab = this.tabs[index];

                if (index == 0) {
                    this.resetCampaign();
                }

                this.tabs.forEach(function(tab, i) {
                    if (i > index) {
                        tab.disabled = true;
                    }
                });

                console.log(tab);

                if (!tab.disabled) {
                    this.step = tab.name;
                }
            },
            pickAdType: function(type) {
                this.campaign.type = type;

                this.nextStep(2);
            },
            addJSPreview: function(src) {
                var script;

                if (!src) {
                    this.$els.previewContainer.innerHTML = '';

                    return false;
                }

                script = document.createElement('script');
                script.src = src;

                this.$els.previewContainer.appendChild(script);
            },
            checkPreview: function() {
                this.nextStep(3);

                this.loading = true;
                this.error = false;
                this.addJSPreview();

                this.$http.post('/app/campaign/preview-link', this.campaignData)
                    .then(function(response) {
                        this.loading = false;

                        this.addJSPreview(response.data.url);
                    })
                    .catch(function(response) {
                        this.error = response.data.message;

                        this.toStep(2);
                    });
            },
            save: function() {
                this.nextStep(4);

                this.loading = true;

                this.$http.post('/app/campaign/save', this.campaignData)
                    .then(function(response) {
                        this.loading = false;

                        this.resetCampaign();

                        this.tabs.forEach(function(tab, i) {
                            if (i > 0 && i < 4) {
                                tab.disabled = true;
                            }
                        });

                        this.savedCampaign = response.data.campaign;

                        this.$nextTick(function() {
                            this.$els.embedJsCode.value = '<script src="' + response.data.url + '"><\/script>';
                        });
                    });
            },
            selectEmbedText: function() {
                this.$els.embedJsCode.select();
            }
        }
    })
</script>




<!-- HIDDEN FOR NOW
    <div class="createcampain-adtestingwrap">
        <div class="createcampaign-adtestingarea">
            <div class="createcampaign-adtestingtitle">Ad Testing Area</div>
            <div class="createcampaign-browseroutwrap">
                <div class="createcampaign-browsercircles"></div>
                <div class="createcampaign-browsericons"></div>
                <div class="createcampaign-browserbar"></div>
                <div class="createcampaign-browserwhitearea">
                    <div class="createcampaign-browserleft">
                        <div class="createcampaign-browserinwrap">
                            <div class="createcampaign-browserbar1" style="width:350px;background:#CCCCCC;"></div>
                            <div class="createcampaign-browserbar1" style="width:300px;"></div>
                            <div class="createcampaign-browserbar1" style="margin-left:12px;width:255px;"></div>
                            <div class="createcampaign-browserbar1" style="width:550px;"></div>
                        </div>
                        <div class="createcampaign-browserinwrap">
                            <div class="createcampaign-browserbar2" style="width:100%;"></div>
                        </div>
                        <div class="createcampaign-browserinwrap">
                            <div class="createcampaign-browserbar3"></div>

                            <div class="createcampaign-browserbar1" style="width:338px;"></div>
                            <div class="createcampaign-browserbar1" style="width:288px;"></div>
                            <div class="createcampaign-browserbar1" style="margin-left:12px;width:98px;"></div>
                            <div class="createcampaign-browserbar1" style="width:399px;"></div>
                            <div class="createcampaign-browserbar1" style="width:335px;"></div>
                            <div class="createcampaign-browserbar1" style="width:100px;"></div>
                            <div class="createcampaign-browserbar1" style="margin-left:12px;width:285px;"></div>
                            <div class="createcampaign-browserbar1" style="width:399px;"></div>
                        </div>
                        <div class="createcampaign-browserinwrap">
                            <div class="createcampaign-browserbar3"></div>

                            <div class="createcampaign-browserbar1" style="width:338px;"></div>
                            <div class="createcampaign-browserbar1" style="width:288px;"></div>
                            <div class="createcampaign-browserbar1" style="margin-left:12px;width:98px;"></div>
                            <div class="createcampaign-browserbar1" style="width:399px;"></div>
                            <div class="createcampaign-browserbar1" style="width:335px;"></div>
                            <div class="createcampaign-browserbar1" style="width:100px;"></div>
                            <div class="createcampaign-browserbar1" style="margin-left:12px;width:285px;"></div>
                            <div class="createcampaign-browserbar1" style="width:399px;"></div>
                        </div>
                        <div class="createcampaign-browserinwrap">
                            <div class="createcampaign-browserbar3"></div>

                            <div class="createcampaign-browserbar1" style="width:338px;"></div>
                            <div class="createcampaign-browserbar1" style="width:288px;"></div>
                            <div class="createcampaign-browserbar1" style="margin-left:12px;width:98px;"></div>
                            <div class="createcampaign-browserbar1" style="width:399px;"></div>
                            <div class="createcampaign-browserbar1" style="width:335px;"></div>
                            <div class="createcampaign-browserbar1" style="width:100px;"></div>
                            <div class="createcampaign-browserbar1" style="margin-left:12px;width:285px;"></div>
                            <div class="createcampaign-browserbar1" style="width:399px;"></div>
                        </div>
                    </div>
                    <div class="createcampaign-browserright">
                        <div class="createcampaign-browserinwrap">
                            <div class="createcampaign-browserbar4"></div>
                            <div class="createcampaign-browserbar1" style="width:90px;"></div>
                            <div class="createcampaign-browserbar1" style="width:120px;"></div>
                        </div>
                        <div class="createcampaign-browserinwrap">
                            <div class="createcampaign-browserbar4"></div>
                            <div class="createcampaign-browserbar1" style="width:90px;"></div>
                            <div class="createcampaign-browserbar1" style="width:120px;"></div>
                        </div>
                        <div class="createcampaign-browserinwrap">
                            <div class="createcampaign-browserbar4"></div>
                            <div class="createcampaign-browserbar1" style="width:90px;"></div>
                            <div class="createcampaign-browserbar1" style="width:120px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->
@endsection
