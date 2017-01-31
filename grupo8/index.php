<!DOCTYPE html>
            <html lang="pt-br">

            <head>

                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta name="description" content="">
                <meta name="author" content="">
                <base href="/grupo8/" />

                <title>Acesso - grupo8</title>

                <!-- Bootstrap Core CSS -->
                <link href="css/bootstrap.min.css" rel="stylesheet">
                    <style>/*
            * Specific styles of signin component
            */
           /*
            * General styles
            */
           body, html {

               background-repeat: no-repeat;

           }
           html{ height:100%; background-image: linear-gradient(rgb(31, 40, 103), rgb(39, 41, 43)); }

           .card-container.card {
               width: 350px;
               padding: 40px 40px;
           }

           .btn {
               font-weight: 700;
               height: 36px;
               -moz-user-select: none;
               -webkit-user-select: none;
               user-select: none;
               cursor: default;
           }

           /*
            * Card component
            */
           .card {
               background-color: #F7F7F7;
               /* just in case there no content*/
               padding: 20px 25px 30px;
               margin: 0 auto 25px;
               margin-top: 50px;
               /* shadows and rounded borders */
               -moz-border-radius: 2px;
               -webkit-border-radius: 2px;
               border-radius: 2px;
               -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
               -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
               box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
           }

           .profile-img-card {
               width: 96px;
               height: 96px;
               margin: 0 auto 10px;
               display: block;
               -moz-border-radius: 50%;
               -webkit-border-radius: 50%;
               border-radius: 50%;
           }

           /*
            * Form styles
            */
           .profile-name-card {
               font-size: 16px;
               font-weight: bold;
               text-align: center;
               margin: 10px 0 0;
               min-height: 1em;
           }

           .reauth-email {
               display: block;
               color: #404040;
               line-height: 2;
               margin-bottom: 10px;
               font-size: 14px;
               text-align: center;
               overflow: hidden;
               text-overflow: ellipsis;
               white-space: nowrap;
               -moz-box-sizing: border-box;
               -webkit-box-sizing: border-box;
               box-sizing: border-box;
           }

           .form-signin #inputEmail,
           .form-signin #inputPassword {
               direction: ltr;
               height: 44px;
               font-size: 16px;
           }

           .form-signin input[type=email],
           .form-signin input[type=password],
           .form-signin input[type=text],
           .form-signin button {
               width: 100%;
               display: block;
               margin-bottom: 10px;
               z-index: 1;
               position: relative;
               -moz-box-sizing: border-box;
               -webkit-box-sizing: border-box;
               box-sizing: border-box;
           }

           .form-signin .form-control:focus {
               border-color: rgb(104, 145, 162);
               outline: 0;
               -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
               box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
           }

           .btn-signin {
               /*background-color: #4d90fe; */
               background-color: rgb(104, 145, 162);
               /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
               padding: 0px;
               font-weight: 700;
               font-size: 14px;
               height: 36px;
               -moz-border-radius: 3px;
               -webkit-border-radius: 3px;
               border-radius: 3px;
               border: none;
               -o-transition: all 0.218s;
               -moz-transition: all 0.218s;
               -webkit-transition: all 0.218s;
               transition: all 0.218s;
           }

           .btn-signin:hover,
           .btn-signin:active,
           .btn-signin:focus {
               background-color: rgb(9, 25, 138);
               color:#FFF;
           }

           .forgot-password {
               color: rgb(104, 145, 162);
           }

           .forgot-password:hover,
           .forgot-password:active,
           .forgot-password:focus{
               color: rgb(12, 97, 33);
           }
           </style>
                            </head>
                            <body style="background-color: inherit;">
            <div class="container">
                <div class="card card-container">
                    <img class="retina" src="http://notcake.com.br/wp-content/themes/notcake/img/logo.png" style="margin:0 auto; width:150px; display:block;">
                    <form id="send" class="form-signin" onsubmit="login(); return false;" method="post">
                        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="" name="email">
                        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="" name="senha">
                        <input type="hidden" id="exec" name="exec" value="doLogin">
                        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Acessar</button>
                        <div id="message" class="alert-info" style="text-align:center; display:none;"></div>
                    </form>
                </div>
            </div>
            <script>
                function login() {
                    $("#message").removeAttr("class");

                    $("#message").addClass("alert-info");
                    $("#message").html("Aguarde...");
                    $("#message").fadeIn("slow");
                    $.ajax({
                        type: "POST",
                        url: "actions.php",
                        processData: false,
                        data: $("#send").serialize(),
                        dataType: 'json',
                        success: function (data) {
                            $("#message").removeAttr("class");
                            $("#message").html(data.message);

                            console.log(data);
                            if (data.status == true) {
                                $("#message").addClass("alert-success");
                                $("#message").html(data.message);
                                $("#message").fadeIn("slow");
                                setTimeout(function () {
                                    window.location = 'home.php';
                                }, 2000);
                            }
                            else {
                                $("#message").addClass("alert-danger");
                                $("#message").html(data.message);
                                $("#message").fadeIn("slow");
                            }
                        }
                    });
                }
            /*$("*[required]").fadeOut();*/
            </script>
            <script src="js/jquery.js"></script>

                        </body></html>