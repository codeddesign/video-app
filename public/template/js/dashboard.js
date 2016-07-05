$(document).ready(function() {
    $('#video_url').keyup($.debounce(1000, checkValidation));
});

function checkValidation() {
    var url = $('#video_url').val();
    var Id = getYouTubeID(url);
    if(typeof Id == "string") {
        $('.status-icon i').removeClass('fa-check').removeClass('fa-times').addClass('fa-spinner fa-pulse');
        $('.status-icon').removeClass('red').removeClass('green').addClass('blue');
        $.get('https://www.googleapis.com/youtube/v3/videos?id=' + Id + '&key=AIzaSyAIjv2KfeLl3IFlS841O8ctyDKytX0togE&part=snippet,contentDetails,statistics,status')
            .done(function(data) {
                if(data.items.length) {
                    $('.status-icon i').removeClass('fa-times').removeClass('fa-spinner fa-pulse').addClass('fa-check');
                    $('.status-icon').removeClass('blue').removeClass('red').addClass('green');
                    $('#campaign_name').val(data.items[0].snippet.localized.title);
                } else {
                    $('.status-icon i').removeClass('fa-check').removeClass('fa-spinner fa-pulse').addClass('fa-times');
                    $('.status-icon').removeClass('blue').removeClass('green').addClass('red');
                    $('#campaign_name').val('');
                }
            });
    } else {
        $('.status-icon i').removeClass('fa-check').removeClass('fa-spinner fa-pulse').addClass('fa-times');
        $('.status-icon').removeClass('blue').removeClass('green').addClass('red');
        $('#campaign_name').val('');
    }
}

function getYouTubeID(url) {
    var ID = '';
    url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    if(url[2] !== undefined) {
        ID = url[2].split(/[^0-9a-z_\-]/i);
        ID = ID[0];
    } else {
        ID = url;
    }
    return ID;
}

function createCampaign() {
    $('.campaignform-error').addClass('hidden');

    $.ajax({
        type: 'POST',
        url: '/campaign',
        data: {
            _token : document.getElementsByName('_token')[0].value,
            video_url : $('#video_url').val(),
            campaign_name : $('#campaign_name').val(),
            video_width : $('#video_width').val(),
            video_height : $('#video_height').val()
        }
    }).done(function(data) {
        if(data.status == 1) {
            location.href = '/campaign/view/' + data.id;
        } else {
            $('.campaignform-error').removeClass('hidden');
        }
    });

    return false;
}

function autoResize() {
    if($('#auto_resize').is(':checked')) {
        $('#video_width').val("1024");
        $('#video_height').val("768");
    } else {
        $('#video_width').val("");
        $('#video_height').val("");
    }
}