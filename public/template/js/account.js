var request_id = '';

$(document).ready(function() {
    $('.loginform-error').hide();
    $('.verify-success').hide();

    $('.verify-success').on('click','button',function() {
        location.href = '/settings';
    });
});

function checkValidate() {

    if(document.getElementsByName('password')[0].value != document.getElementsByName('confirm_password')[0].value) {
        $('.loginform-error').html("Password doesn't match!").show();
    } else {
        $('.loginform-error').hide();

        $.ajax({
            type: "POST",
            url: '/account/register',
            data: {
                _token : document.getElementsByName('_token')[0].value,
                email : document.getElementsByName('email')[0].value,
                password : document.getElementsByName('password')[0].value
            }
        }).done(function (data) {
            if(data['status'] == 0) {
                $('.loginform-error').html("This account already exists!").show();
            } else {
                $("form[name='userForm']").addClass('hidden');
                $("form[name='phoneForm']").removeClass('hidden');
            }
        });
    }

    return false;
}

function postVerify() {

    $('.loginform-error').hide();

    $.ajax({
        type: "POST",
        url: '/account/verify',
        data: {
            _token : document.getElementsByName('_token')[0].value,
            number : document.getElementsByName('number')[0].value
        }
    }).done(function (data) {
        if(data['status'] == 0) {
            request_id = data['request_id'];
            $("form[name='phoneForm']").addClass('hidden');
            $("form[name='pinForm']").removeClass('hidden');
        } else if(data['status'] == 10) {
            $('.loginform-error').html('You phone number used many times. Please try with other number or try again after 5 minutes').show();
        } else if(data['status'] == 3) {
            $('.loginform-error').html('Wrong number').show();
        }
    });

    return false;
}

function getVerify() {
    $('.loginform-error').hide();

    $.ajax({
        type: "GET",
        url: '/account/verify',
        data: {
            _token : document.getElementsByName('_token')[0].value,
            request_id : request_id,
            pin : document.getElementsByName('pin')[0].value,
            email : document.getElementsByName('email')[0].value,
            password : document.getElementsByName('password')[0].value
        }
    }).done(function (data) {
        if(data['status'] == 0) {
            $('.user-creation').hide();
            $('.verify-success').show();
        } else if(data['status'] == 16) {
            $('.loginform-error').html('Wrong PIN number').show();
        }
    });

    return false;
}