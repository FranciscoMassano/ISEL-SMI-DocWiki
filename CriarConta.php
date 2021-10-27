<html>
    <head>
        <!-- tag Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta http-equiv="Pragma" content="no-cache">
        <!-- tag link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="Css/CriarContaCss.css">
        <!-- tag Script -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="shortcut icon" href="Img/Dokuwiki_logo.png">
        <title>Criar Conta</title>
        <?php
        header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        ?>
    </head>
    <body>
        <div class="main-content">
            <div class="container mt-7">
                <!-- Table -->
                <div class="row">
                    <div class="col-xl-8 m-auto order-xl-1">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Criar Conta</h3>
                                    </div>
                                    <div class="col-4 text-right"></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form  method = "POST" enctype="multipart/form-data" onsubmit="return verifySubmit()" action="formRegist.php">
                                    <h6 class="heading-small text-muted mb-4">Informações do Utilizador</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-username">Username</label>
                                                    <label style="color: red; font-size:9px;">*Sem espaços, min 3 max 20 letras, pode utilizar ?!.*[_.] </label>
                                                    <input type="text" id="input-UserName" name="input-UserName" class="form-control form-control-alternative" placeholder="Username" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-first-name">Password</label>
                                                    <label style="color: red; font-size:9px;">*Minimo 8 carateres, pelos menos 1 letra e 1 numero</label>
                                                    <input type="text" id="input-Password" name="input-Password" class="form-control form-control-alternative" placeholder="Password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-last-name">Nome</label>
                                                    <input type="text" id="input-Name" name="input-Name" class="form-control form-control-alternative" placeholder="Nome" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-email">Email</label>
                                                    <input type="email" name="input-Email" class="form-control form-control-alternative" placeholder="Email" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <!-- Address -->
                                    <h6 class="heading-small text-muted mb-4">Informações</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">Genero</label>
                                                    <br> 
                                                    <input type="radio" name="Sex" id="input-genero" value="M" required> Masculino 
                                                    <br> 
                                                    <input type="radio" name="Sex" id="input-genero" value="F"> Feminino
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">Nacionalidade</label>
                                                    <select class="countrypicker form-control form-control-alternative" name="input-nacionalidade" data-live-search="true" data-default="United States" data-flag="true"></select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group focused">
                                                    <label class="form-control-label">Telemovel</label>
                                                    <input type="tel" id="phone" name="phone" class="form-control form-control-alternative"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Data de Nascimento</label> 
                                                    <input type="date" id="input-DataNascimento" name="input-DataNascimento" class="form-control form-control-alternative" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="form-control-label">Foto de Perfil</label> 
                                                    <input type="file" name="file" class="form-control form-control-alternative">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="back" type="submit" value="Submeter">
                                </form>
                                <button onclick="goBack()" class="Sub">&laquo; Previous</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
        </div>
        <!--Scripts-->
        <script src="js/countrypicker.min.js"></script>
        <script>
<!-- fun Back -->;
        function goBack() {
            window.history.back();
        };
        <!-- fun Phone -->
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js", });
        
        var regexUserName = /^(?=[a-zA-Z0-9._]{3,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/;
        var regexPassword = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        var regexNome = /^(?=[a-zA-Z ]{3,125}$)/;
        
        function verifySubmit() {
            let userName = document.getElementById("input-UserName").value;
            let password = document.getElementById("input-Password").value;
            let nome = document.getElementById("input-Name").value;
            let dataNascimento = document.getElementById("input-DataNascimento").value;
            let phoneNumber = phoneInput.getNumber();
            
            if (!regexUserName.test(userName)) {
                alert("UserName incorrecto!");
                return false;
            } else if (!regexPassword.test(password)) {
                alert("Password invalida!");
                return false;
            } else if (!regexNome.test(nome)) {
                alert("Nome com poucos caracteres ou muito extenso!");
                return false;
            } else if (!phoneInput.isValidNumber()) {
                alert("Numero de Telemovel incorrecto!");
                return false;
            } else if (!verifyDate()) {
                alert("Data de Nascimento invalida!");
                return false;
            } 
            else {
                return true;
            }
        };
        
        function verifyDate() {
            let dataNascimento = document.getElementById("input-DataNascimento").value;
            var today = new Date();
            var d2 = new Date(dataNascimento);
            return (d2 < today);
        };
        </script>
    </body>
</html>