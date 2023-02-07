var emailUser;
var phoneuser;
var sendOtp = false;
var userId;
var nameUser;
$('form').on('submit', function(e) {
    $("#loading-login").show();
    $("#submit").hide('fadeOut');
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': tokenCsrf,
            'X-Requested-With': 'XMLHttpRequest',
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers': 'Origin, Content-Type, X-Auth-Token',
            'Access-Control-Allow-Credentials': 'true',
            'Access-Control-Max-Age': '86400',
            'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With'
        }
    });
    $.ajax({
        type: "POST",
        url: 'login',
        dataType: 'json',
        // headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        // },
        data: $("#userLogin").serialize(),
        success: function(msg) {
            //success
            if (typeof msg.name == 'undefined') {
                $("#loading-login").hide();
                $("#submit").show('fadeIn');
                $("#error").show();
                $("#message-error").html('Periksa Kembali Akun Anda!');
                return;
            }
            emailUser = msg.email;
            //validasi format phone number, if first 0 or +62 then remove
            let hp = msg.phone
            if(hp != null){
                if(hp.indexOf("0") == 0){
                    hp = hp.replace("0", "");
                }
                if(hp.indexOf("+62") == 0){
                    hp = hp.replace("+62", "");
                }
            }
            phoneuser = hp;
            sendOtp = msg.sendOtp;
            userId = msg.id;
            nameUser = msg.name;
            checkModalOtp()
        },
        error: function(msg) {
            //errror csrf then reload page
            if (msg.status == 419 || msg.responseJSON.message == 'CSRF token mismatch.') {
                toastr['error'](
                    'Session sudah habis, reload page!',
                    'Silahkan coba lagi', {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
                setTimeout(function() {
                    window.location.href = '/'
                }, 400);
            }
            $("#error").show()
            var notifError = msg.responseJSON.message;
            if (notifError == 'Undefined variable: person_array') {
                notifError = 'Akun tidak terdaftar di Active Directory!';
            }
            $("#message-error").html(notifError);
            $("#loading-login").hide();
            $("#submit").show('fadeOut');
        }
    });
});

function successLogin(name){
    toastr['success'](
        'Akun berhasil login!',
        '👋 Selamat Datang ' + name, {
            closeButton: true,
            tapToDismiss: false
        }
    );
    setTimeout(function() {
        var extendUrl = $("#extend").val();
        if(extendUrl !== ""){
            if(extendUrl.indexOf("extend") > -1){
                var url = extendUrl.split("extend=")[1];
                //remove %2F, %3A, %3F, %3D, %26
                url = url.replace(/%2F/g, "/");
                url = url.replace(/%3A/g, ":");
                url = url.replace(/%3F/g, "?");
                url = url.replace(/%3D/g, "=");
                url = url.replace(/%26/g, "&");
                window.location.href = url;
            }else{
                window.location.href = extendUrl;
            }
        }else{
            window.location.href = '/dashboard'
        }
    }, 400);
}

//modal popup
var modalPlatform = new bootstrap.Modal(document.getElementById('modal-pilih'), {
    keyboard: false,
    backdrop: 'static'
})
// modalPlatform.show();
var modalOtp = new bootstrap.Modal(document.getElementById('modal-otp'), {
    keyboard: false,
    backdrop: 'static'
})
// modalOtp.show();
//show email or wa
$("#otp-email").on('click', function(event){
    $("#show-email").show();
    $("#show-wa").hide();
    $("#phone-number").val("");
    //add required to id email-user form
    $("#email").attr('required', true);
    $("#phone-number").removeAttr('required');
    $("#email-user").val(emailUser);
    $("#send-otp-email").show();
    $("#send-otp-wa").hide();
})
$("#otp-wa").on('click', function(event){
    $("#show-wa").show();
    $("#show-email").hide();
    $("#email-user").val("");
    //add required to id phone-number form
    $("#phone-number").attr('required', true);
    $("#email-user").removeAttr('required');
    $("#phone-number").val(phoneuser);
    $("#send-otp-wa").show();
    $("#send-otp-email").hide();
})

function filterNolFirst(){
    var value = $("#phone-number").val();
    if(value.length == 1){
        if(value == 0){
            $("#phone-number").val("");
        }
    }
}
//fitur cursor OTP
$(".cursor_otp").on('keyup', function(){
    //cursor focus in first
    if($(this).val().length == 1){
        $(this).next().focus();
    }
    //validasi only numeric
    var value = $(this).val();
    if(value.length == 1){
        $(this).next().focus();
    }
    //if length value > 1, then split to next focus
    if(value.length > 1){
        var split = value.split("");
        var i = 0;
        $(this).next().focus();
        $(this).next().val(split[1]);
        $(this).val(split[0]);
    }
    //if value is last, then submit
    if($(this).hasClass('last')){
        let wa = $("#phone-number").val();
        let mail = $("#email-user").val();
        if(wa != ""){
            submitOtp();
        }
        if(mail != ""){
            submitOtpEmail();
        }
    }

})

$("#reset_otp").on('click', function(event){
    event.preventDefault();
    $(".cursor_otp").val("");
    $(".cursor_otp").first().focus();
})

//funtion countdown otp for 5 minute with format minute : second
var timerOn = false;
let time = timeOtpExpired*60;

function timerOtp(remaining, timerOn) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;

  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('countdown-otp').innerHTML = m + ':' + s;
  remaining -= 1;

  localStorage.setItem('timerOtp', remaining);

  if(remaining >= 0 && timerOn) {
    //set to local storage

    setTimeout(function() {
        if(timerOn){
            timerOtp(remaining, timerOn);
        }
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    waktuHabis();
    $("#reset_otp").hide();
    $("#resend_otp").show();
    return;
  }
  waktuHabis();
}
//check if localtorage filled, then time set from locatroge
if(localStorage.getItem('timerOtp') !== null && localStorage.getItem('timerOtp') > 0){
    remaining = localStorage.getItem('timerOtp');
    timerOtp(remaining, true)
}else{
    if(timerOn){
        timerOtp(time, true);
    }
}

function resetTimer(){
    localStorage.setItem('timerOtp', 0);
    localStorage.removeItem('timerOtp');
    timerOn = false;
    return;
}

function waktuHabis(){
    resetTimer()
    $("#reset_otp").hide();
    $("#resend_otp").show();
    $("#timeover").show()
}
function resendOtp(){
    $("#loading-otp").show();
    resetTimer();
    timerOn = true;
    timerOtp(time, timerOn);
    if($("#phone-number").val() != ''){
        $("#send-otp-wa").click();
    }
    if($("#email-user").val() != ''){
        $("#send-otp-email").click();
    }

    $(".cursor_otp").first().focus();
    $(".cursor_otp").val("");
    $("#resend_otp").hide();
    $("#reset_otp").show();
    $("#reset_otp").click();
}
function checkModalOtp(){
    if(sendOtp){
        modalPlatform.show();
    }else{
        successLogin(nameUser);
    }
}

function submitOtp(){
//get value from input name otp[]
    var otpInput = [];
    $(".cursor_otp").each(function(){
        var nilai = $(this).val();
        otpInput.push(nilai);
    });
    //check if value is empty
    var empty = false;
    for(var x=0; x < otpInput.length; x++){
        if(otpInput[x] == ""){
            empty = true;
        }
    }
    if(empty){
        Swal.fire(
            'Oops!',
            'Periksa kembali, Kode OTP tidak boleh kosong.',
            'error'
        )
        return;
    }
    //array to string
    otpInput = otpInput.join("");
    //check if value is correct
    $.ajax({
        type: "GET",
        url: 'verify-otp',
        dataType: 'json',
        data: {
            otp: otpInput,
            phone: $("#phone-number").val()
        },
        success: function(msg) {
            if(msg.status == "success"){
                //reset timer
                resetTimer();
                //hide modal
                modalOtp.hide();
                successLogin(nameUser)
            }else{
                Swal.fire(
                    'Oops!',
                    msg.message,
                    'error'
                );
                //reset cursor
                $(".cursor_otp").first().focus();
                $(".cursor_otp").val("");
                $("#resend_otp").hide();
                $("#reset_otp").show();
                $("#reset_otp").click();
            }
        },
        error: function(msg){
            Swal.fire(
                'Oops!',
                 msg.responseJSON.message,
                'error'
            );
            //reset cursor
            $(".cursor_otp").first().focus();
            $(".cursor_otp").val("");
            $("#resend_otp").hide();
            $("#reset_otp").show();
            $("#reset_otp").click();
        }
    });

}//end function

//send via wa
$("#send-otp-wa").on('click', function(event){
    event.preventDefault();
    $("#header-whatsapp").show();
    $("#header-email").hide();
    $(".loading-modal").show();
    $("#send-otp-email").hide();
    $("#send-otp-wa").hide();
    $("#reset_otp").show();
    $("#timeover").hide()
    $("#loading-otp").hide();
    let numberPhone = $("#phone-number").val();
    //validasi length phone number
    if(numberPhone.length > 12){
        //swal alert
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Nomor telepon tidak valid, Periksa kembali nomor telepon anda!',
        });
        $(".loading-modal").hide();
        return;
    }
    $("#nomor-whatsapp").html('0'+numberPhone);
    $.ajax({
        type: "GET",
        url: 'send-otp-wa',
        dataType: 'json',
        data: {
            phone: $("#phone-number").val(),
            userId: userId
        },
        success: function(msg) {
            $(".loading-modal").hide();
            if(msg.status == "error"){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',   
                    text: msg.message,
                });
            }else{
                modalPlatform.hide();
                //close modal platform
                //set timer
                timerOn = true;
                timerOtp(time, timerOn);
                modalOtp.show();
            }
        },
        error: function(msg){
            $(".loading-modal").hide();
            //close modal platform
            //swal alert
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Nomor telepon tidak valid, Periksa kembali nomor telepon anda!',
            });
            $("#send-otp-wa").show();
            modalOtp.hide();
            modalPlatform.show();
        }
    });
});


$("#send-otp-email").on('click', function(event){
    event.preventDefault();
    $("#header-whatsapp").hide();
    $("#header-email").show();
    $(".loading-modal").show();
    $("#send-otp-email").hide();
    $("#send-otp-wa").hide();
    $("#reset_otp").show();
    $("#timeover").hide()
    $("#loading-otp").hide();
    let emailPost = $("#email-user").val();
    //validasi length phone number
    if(emailPost == ''){
        //swal alert
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Email tidak valid, Periksa kembali email anda!',
        });
        $(".loading-modal").hide();
        return;
    }
    $("#email-view").html(emailPost);
    $.ajax({
        type: "GET",
        url: 'send-otp-mail',
        dataType: 'json',
        data: {
            email: $("#email-user").val(),
            userId: userId
        },
        success: function(msg) {
            $(".loading-modal").hide();
            if(msg.status == "error"){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',   
                    text: msg.message,
                });
                $("#send-otp-email").show();
            }else{
                modalPlatform.hide();
                //close modal platform
                //set timer
                timerOn = true;
                timerOtp(time, timerOn);
                modalOtp.show();
            }
        },
        error: function(msg){
            $(".loading-modal").hide();
            //close modal platform
            //swal alert
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email tidak valid, Periksa kembali email anda!',
            });
            $("#send-otp-email").show();
            modalOtp.hide();
            modalPlatform.show();
        }
    });
});

function submitOtpEmail(){
    //get value from input name otp[]
        var otpInput = [];
        $(".cursor_otp").each(function(){
            var nilai = $(this).val();
            otpInput.push(nilai);
        });
        //check if value is empty
        var empty = false;
        for(var x=0; x < otpInput.length; x++){
            if(otpInput[x] == ""){
                empty = true;
            }
        }
        if(empty){
            Swal.fire(
                'Oops!',
                'Periksa kembali, Kode OTP tidak boleh kosong.',
                'error'
            )
            return;
        }
        //array to string
        otpInput = otpInput.join("");
        //check if value is correct
        $.ajax({
            type: "GET",
            url: 'verify-otp',
            dataType: 'json',
            data: {
                otp: otpInput,
                email: $("#email-user").val()
            },
            success: function(msg) {
                if(msg.status == "success"){
                    //reset timer
                    resetTimer();
                    //hide modal
                    modalOtp.hide();
                    successLogin(nameUser)
                }else{
                    Swal.fire(
                        'Oops!',
                        msg.message,
                        'error'
                    );
                    //reset cursor
                    $(".cursor_otp").first().focus();
                    $(".cursor_otp").val("");
                    $("#resend_otp").hide();
                    $("#reset_otp").show();
                    $("#reset_otp").click();
                }
            },
            error: function(msg){
                Swal.fire(
                    'Oops!',
                     msg.responseJSON.message,
                    'error'
                );
                //reset cursor
                $(".cursor_otp").first().focus();
                $(".cursor_otp").val("");
                $("#resend_otp").hide();
                $("#reset_otp").show();
                $("#reset_otp").click();
            }
        });
    
}//end function
    