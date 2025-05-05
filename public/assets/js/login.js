(function () {
    $('.to-recover').on("click", function () {
        $("#form_login").hide();
        $("#registerform").hide();
        $("#requestemailverificationform").hide();

        $("#recoverform").fadeIn();
    });

    $('.to-register').on("click", function () {
        $("#form_login").hide();
        $("#recoverform").hide();
        $("#requestemailverificationform").hide();

        $("#registerform").fadeIn();
    });

    $('.to-login').on("click", function () {
        $("#registerform").hide();
        $("#recoverform").hide();
        $("#requestemailverificationform").hide();

        $("#form_login").fadeIn();
    });

    $('.to-activationrequest').on("click", function () {
        $("#registerform").hide();
        $("#recoverform").hide();
        $("#form_login").hide();

        $("#requestemailverificationform").fadeIn();
    });

    $("#form_login").submit(function (e) {
        e.preventDefault();
        var formLogin = new FormData($("#form_login")[0]);
        console.log(base_url + "/auth/dologin");
        $.ajax({
            url: base_url + "/auth/dologin",
            type: "post",
            data: formLogin,
            processData: false,
            contentType: false,
            cache: false,
            complete: function(){
                $("#form_login [type='submit']").removeAttr("disabled");
            },
            success: function (response) {
                console.log(response);
                if (response.status === "ok") {
                    $.toast({
                        heading: 'Success',
                        text: response.message,
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#f96868',
                        position: 'top-right'
                    })
                    setTimeout(function () {
                        window.location.replace(base_url+"/apps/dashboard");
                    }, 2000);
                } else {
                    $.toast({
                        heading: 'Danger',
                        text: response.message,
                        showHideTransition: 'slide',
                        icon: 'error',
                        loaderBg: '#f2a654',
                        position: 'top-right'
                    })
                }
            },
        });
    });

    var location = null;
    function ipLookUp () {
        $.ajax('http://ip-api.com/json')
            .then(
                function success(response) {
                    location = response;
                },

                function fail(data, status) {
                    location = null;
                }
            );
    }
    //ipLookUp();

    function getSearchParameters() {
        var prmstr = window.location.search.substr(1);
        return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
    }

    function transformToAssocArray( prmstr ) {
        var params = {};
        var prmarr = prmstr.split("&");
        for ( var i = 0; i < prmarr.length; i++) {
            var tmparr = prmarr[i].split("=");
            params[tmparr[0]] = tmparr[1];
        }
        return params;
    }

    var params = getSearchParameters();

})();