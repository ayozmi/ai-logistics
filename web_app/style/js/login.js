$(function (){
    let ajaxCall = '';

    $('form').on('submit', function (e){
        e.preventDefault();
        let email = $('#email_input').val();
        let password = $('#password_input').val();
        if (ajaxCall !== ''){
            ajaxCall.abort();
        }
        ajaxCall = $.post('ajax/login.ajax.php', {
            email: email,
            password: password,
            captchaResponse: grecaptcha.getResponse()
        }, function (data){
            if (data.error === null){
                //Success
                window.location.href = "index.php?id=1";
            }
            else{
                //Failure
            }
        },'json')
    })
});