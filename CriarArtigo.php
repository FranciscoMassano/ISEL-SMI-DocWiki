<?php
session_start();
if (!isset($_SESSION['UserId'])) {
    header('Location: LoginPage.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
        <title>Criar Artigo</title>
        <style>
            .Sub{
                text-decoration: none;
                display: inline-block;
                padding: 8px 16px;
                background-color: rgba(0, 0, 0, 0.9);
                color: white;
            }

            .Sub:hover {
                background-color: #ddd;
                color: black;
            }

            .back{
                float:right;
                text-decoration: none;
                display: inline-block;
                padding: 8px 14px;
                background-color: rgba(0, 100, 0, 0.9);
                color: white;
            }

            .back:hover {
                background-color: #ddd;
                color: black;
            }

            .Add{
                float:right;
                text-decoration: none;
                display: inline-block;
                padding: 4px 4px;
                margin: 2px;
                background-color: #CACFD2;
                color: black;
            }

            .Add:hover {
                background-color: #909497;
                color: black;
            }
        </style>
    </head>
    <body style="background-color: #717D7E !important;" >
        <div class="main-content">
            <div class="container mt-7">
                <!-- Table -->
                <div class="row">
                    <div class="col-xl-8 m-auto order-xl-1">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h2 class="mb-0">Criar Artigo</h2>
                                    </div>
                                    <div class="col-4 text-right"></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form  method = "POST" onsubmit="return verifySubmit()" action="formArtigo.php" enctype="multipart/form-data">
                                    <h6 class="heading-small text-muted mb-4">Informaçôes do Artigo</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-username">Titulo</label>
                                                    <input type="text" name="input-titulo" class="form-control form-control-alternative" placeholder="Título" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-first-name">Resumo</label>
                                                    <label style="color: red; font-size:9px;">*Maximo de 570 caracteres</label>
                                                    <textarea rows="8" class="form-control form-control-alternative" name="input-resumo" id="input-resumo" style="resize: none;" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-last-name">Ilustração</label>
                                                    <label style="color: red; font-size:11px;">*Imagem para caracterizar o recurso</label>
                                                    <input type="file" name="file-ilustracao" class="form-control form-control-alternative" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <!-- Address -->
                                    <div class="pl-lg-4" id = "sectionDiv">
                                        <h6 class="heading-small text-muted mb-4">Secção 1</h6>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-city">Genero do Recurso</label>
                                                    <br> 
                                                    <input type="radio" name="input-type_1" id="idfilme" value="filme" required> Filme 
                                                    <label style="color: red; font-size:9px;">*apenas suporta mp4</label>
                                                    <br> 
                                                    <input type="radio" name="input-type_1" id="idfoto" value="foto"> Fotografia
                                                    <label style="color: red; font-size:9px;">*apenas suporta png e jpg</label>
                                                    <br>
                                                    <input type="radio" name="input-type_1" id="idmusica" value="musica"> Música
                                                    <label style="color: red; font-size:9px;">*apenas suporta mp3</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-city">Carregar o Recurso</label>
                                                    <input type="file" name="file-carregarRecurso_1" id ="file-carregarRecurso_1" class="form-control form-control-alternative" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-first-name">Texto</label>
                                                    <textarea rows="8" class="form-control form-control-alternative" name="input-Texto_1" style="resize: none;" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <input type="hidden" name ="valConter" id="valConter" value=""/>
                                    <input class="back" type="submit" value="Submeter">
                                </form>
                                <button class="Add" id = "btnDel">DEL</button>
                                <button class="Add" id = "btnAddtoList">ADD</button>
                                <button onclick="goBack()" class="Sub">&laquo; Previous</button>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var counter = 1;
            document.getElementById('valConter').value = counter;
            function goBack() {
                window.history.back();
            }

            $(function () {
                $('#btnAddtoList').click(function () {
                    console.log("ENTROU")
                    counter++;
                    document.getElementById('valConter').value = counter;
                    var newDiv = $('<hr class="my-4" id = "hr' + counter + '">  \n\
                                     <div class="row" id = "sect' + counter + '"> \n\
                                        <h6 class="heading-small text-muted mb-4">Secção ' + counter + '</h6>\n\
                                            <div class="col-lg-4"> \n\
                                                <div class="form-group focused"> \n\
                                                    <label class="form-control-label" for="input-city">Genero do Recurso</label> \n\
                                                    <br>  \n\
                                                    <input type="radio" name="input-type_' + counter + '" id="idfilme" value="filme" required> Filme \n\
                                                    <label style="color: red; font-size:9px;">*apenas suporta mp4</label>\n\
                                                    <br> \n\
                                                    <input type="radio" name="input-type_' + counter + '" id="idfoto" value="foto"> Fotografia\n\
                                                    <label style="color: red; font-size:9px;">*apenas suporta png e jpg</label>\n\
                                                    <br> \n\
                                                    <input type="radio" name="input-type_' + counter + '" id="idmusica" value="musica"> Música\n\
                                                    <label style="color: red; font-size:9px;">*apenas suporta mp4</label>\n\
                                                </div>\n\
                                            </div>\n\
                                            <div class="col-lg-8">\n\
                                                <div class="form-group">\n\
                                                    <label class="form-control-label" for="input-city">Carregar o Recurso</label>\n\
                                                    <input type="file" name="file-carregarRecurso_' + counter + '" id="file-carregarRecurso_' + counter + '" class="form-control form-control-alternative" required>\n\
                                                </div>\n\
                                            </div>\n\
                                            <div class="col-lg-12">\n\
                                                <div class="form-group">\n\
                                                    <label class="form-control-label" for="input-first-name">Texto</label>\n\
                                                    <textarea rows="8" class="form-control form-control-alternative" name="input-Texto_' + counter + '" id="input-Texto_' + counter + '" style="resize: none;" required></textarea>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>');
                    $('#sectionDiv').append(newDiv);
                });
            });

            $(function () {
                $('#btnDel').click(function () {
                    if (counter < 2) {
                        counter = 2;
                    }
                    var id = ("#sect" + counter);
                    var hr = ("#hr" + counter);
                    $(id).remove();
                    $(hr).remove();
                    counter--;
                    document.getElementById('valConter').value = counter;
                });
            });

            function verifySubmit() {
                var resumo = document.getElementById("input-resumo").value;


                for (var n = 1; n <= counter; n++) {
                    var recurso = document.getElementById("file-carregarRecurso_" + n).value;
                    var tipoRecurso = recurso.substring(recurso.lastIndexOf(".") + 1);
                    var radios = document.getElementsByName("input-type_" + n);
                    var inputType;
                    for (var i = 0, length = radios.length; i < length; i++) {
                        if (radios[i].checked) {
                            inputType = radios[i].value;
                        }
                    }

                    switch (tipoRecurso) {
                        case "jpg":
                        case "png":
                            console.log(tipoRecurso);
                            if (inputType !== "foto") {
                                alert("O Tipo de recurso, não corresponde ao recurso introduzido");
                                return false;
                            }
                            break;
                        case "mp4":
                            if (inputType !== "filme") {
                                console.log("FALHOU FILME");
                                alert("O Tipo de recurso, não corresponde ao recurso introduzido");
                                return false;
                            }
                            break;
                        case "mp3":
                            if (inputType !== "musica"){
                            console.log("FALHOU MUSICA");
                            alert("O Tipo de recurso, não corresponde ao recurso introduzido");
                            return false;
                            }
                            break;
                        default :
                            alert("Formato do recurso não suportado");
                            break;
                    }
                }
                if (resumo.length > 570) {
                    alert("Excedeu de caracteres possiveis no resumo");
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>
