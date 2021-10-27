<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="Css/LoginCss.css" >
        <link rel="shortcut icon" href="Img/Dokuwiki_logo.png">
        <title>Login Page</title>
        <?php
        header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        ?>
    </head>

    <body>
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Icon -->
                <div class="fadeIn first" style="background-color:#F8F9F9 !important">
                    <br>
                    <img src="img/login.png" id="icon" alt="User Icon"/>
                </div>

                <!-- Login Form -->

                <div class="container" style="background-color:#F8F9F9 !important">
                    <form method="post" action="formLogin.php">
                        <br/>
                        <div class="row">
                            <div class="col">
                                <input type="text" id="login" class="fadeIn second" name="login" placeholder="USERNAME" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="password" id="password" class="fadeIn third" name="pass" placeholder="PASSWORD" required>
                            </div>
                        </div>
                        <div class="row"style="margin: 0px !important">
                            <div class="col" style="margin: 0px !important">
                                <input type="text" id="captcha" class="fadeIn third" name="captcha" placeholder="Inserir Captcha"  autocomplete="off" required>
                            </div>
                            <div class="col">
                                <img src="captcha.php"/>
                            </div>
                        </div>
                        <br/>
                        <input type="submit" class="fadeIn fourth" value="Log In">
                    </form>
                </div>
                <!-- Remind Passowrd -->
                <div id="formFooter" style="background-color:#E5E8E8 !important">
                    <a class="underlineHover" href="LandingPageConvidado.php" style="color:#34495E !important">Entrar como convidado?</a>
                    <a class="underlineHover" href="CriarConta.php" style="color:#34495E !important">Deseja criar conta?</a>
                </div>
            </div>
        </div>
    </body>
</html>