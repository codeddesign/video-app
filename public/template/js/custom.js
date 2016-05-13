// VIDEOJS

videojs.plugin('beforeAdsPlugin', function(myPluginOptions) {
    myPluginOptions = myPluginOptions || {};
    var playerID = myPluginOptions.playerID;

    var player = this;
    var doneBeforeAds = false;
    
    player.on('play', function(){
        if(!doneBeforeAds){
            this.pause();
        }else{
            document.querySelector('#' + playerID + ' .before-ads').style.display = "none";
        }
    })
    player.on('firstplay', function(){
        document.querySelector('#' + playerID + ' .vjs-control-bar').style.display = "none";
        this.pause()
        this.userActive(false);
        this.overlay({
            content: '<strong>Overlay content</strong>',
            overlays: [
                {
                    align: "bottom",
                    content: '\
                    	<div class="beforeadsoverlay"></div>\
                        <div class="before-ads">\
                            <a href="#" target="_blank"><img src="http://video.dev999.com/template/images/ads-image/before-ads.jpg" width="50%" height="50%"></a>\
                            <span id="ads-timer" class="ads-timer">video will begin in <span id="timeinseconds" class="timeinseconds">...</span></span>\
                        </div>\
                    ',
                    start: 0,
                    end: 0.1
                }, 
                {
                    content: '\
                		<div class="duringplayad">\
                			<a href="/" target="_blank">\
                				<img src="http://video.dev999.com/template/images/ads-image/during-play-ads.jpg" width="365px" height="38px" >\
                			</a>\
                			<div class="exitinad"></div>\
                		</div>\
                    ',
                    start: 0.2,
                    end: 1000,
                    align: 'bottom-small-ads'
                },
                {
                    content: '\
                		<a href="/">\
                			<div class="videoplayerlogo" target="_blank" title="Videoadz"></div>\
                		</a>\
                    ',
                    //start: "mouseover",
                    //end: "mouseout",
                    start: 0,
                    end: 1000,
                    align: 'top-left'
                },
                {
                    content: '\
                		<div class="vidsharewrap">\
                			<div class="vidshareurl"></div>\
                			<div class="vidsharefb"></div>\
                			<div class="vidsharetw"></div>\
                		</div>\
                    ',
                    start: 0,
                    end: 1000,
                    align: 'top-right'
                }
            ]
          });
        var timerValue = 5;
        var myVar = window.setInterval(function(){
            if(timerValue<=0){
                clearInterval(myVar);
                doneBeforeAds = true;
                document.querySelector('#' + playerID + ' .vjs-control-bar').style.display = "block";
                player.play();
                return;
            }
            document.getElementById('timeinseconds').innerHTML = timerValue;
            timerValue--;
        }, 1000)
    });

});

var loadAfterglow = function(playerID){
    window.setTimeout(function(){
        if(!afterglow){
            loadAfterglow();
        }else{
            initCustomAdsPlayer(playerID);
        }
    }, 200);
}
function initCustomAdsPlayer(playerID){
    var myPlayer = afterglow.getPlayer(playerID);

    myPlayer.beforeAdsPlugin({playerID: playerID});
}
loadAfterglow('video2light')