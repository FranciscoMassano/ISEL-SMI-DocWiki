<?php
require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );
session_start();

if (!isset($_SESSION['UserId'])) {
    header('Location: LoginPage.php');
}

$existeArtigo = false;
$titulo = $_POST['input-titulo'];

// vamos fazer a conecção com a base de dados
dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

$queryGetTitulo = "SELECT titulo FROM `$dataBaseName`.`publicacoes` WHERE `titulo`='$titulo'";

$queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetTitulo);
$record = mysqli_fetch_array($queryResult);
if ($record != null) {
    $existeArtigo = true;
} else {
    $userID = $_SESSION['UserId'];
    $CounterSection = $_POST['valConter'];
    $resumo = $_POST['input-resumo'];
    $ilustracao = $_FILES['file-ilustracao']['name'];

    $pathIlustraction = "D:\Temp\upload\contents\publicacoes";
    $pathIlustraction = $pathIlustraction . DIRECTORY_SEPARATOR . $titulo;
    $Today = date("Y-m-d");

    mkdir($pathIlustraction);

    $src = $_FILES['file-ilustracao']['tmp_name'];
    $dst = $pathIlustraction . DIRECTORY_SEPARATOR . $titulo . ".jpg";
    $dst = addslashes($dst);
    copy($src, $dst);

    $queryInsertArtigo = "INSERT INTO `$dataBaseName`.`Publicacoes` (`idUser`, `titulo`, `PublicacaoRegister`, `resumo`, `ilustracao`)" .
            "VALUES ('$userID', '$titulo', '$Today', '$resumo', '$dst');";

    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryInsertArtigo);

    if ($queryResult) {
        $queryGetIdPubli = "SELECT idPublicacao FROM `$dataBaseName`.`publicacoes` WHERE `titulo`='$titulo'";

        $queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetIdPubli);

        if ($queryResult) {
            $idPublicacao = mysqli_fetch_array($queryResult)['idPublicacao'];

            $SectionNumb = 1;
            do {
                $inputType = $_POST["input-type_" . strval($SectionNumb)];
                $texto = $_POST["input-Texto_" . strval($SectionNumb)];

                $pathSection = $pathIlustraction . DIRECTORY_SEPARATOR . "seccao_" . strval($SectionNumb);
                $src = $_FILES["file-carregarRecurso_" . strval($SectionNumb)]['tmp_name'];

                $queryInsertArtigo = "INSERT INTO `$dataBaseName`.`Recursos` (`nSeccao`, `idPublicacao`, `tipoRecurso`)" .
                        "VALUES ('$SectionNumb', '$idPublicacao', '$inputType');";
                //echo $queryInsertArtigo;
                $queryResult = mysqli_query($GLOBALS['ligacao'], $queryInsertArtigo);

                if ($queryResult) {

                    $queryGetIdPubli = "SELECT * FROM `$dataBaseName`.`recursos` ORDER BY `idRecurso` DESC LIMIT 1";

                    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetIdPubli);

                    if ($queryResult) {
                        $idRecurso = mysqli_fetch_array($queryResult)['idRecurso'];
                        
                        mkdir($pathSection);

                        switch ($inputType) {
                            case "filme":
                                $dst = $pathSection . DIRECTORY_SEPARATOR . $titulo . ".mp4";
                                $dst = addslashes($dst);
                                copy($src, $dst);
                                $queryInsertArtigo = "INSERT INTO `$dataBaseName`.`filme` (`idRecurso`, `dados`)" . "VALUES ('$idRecurso', '$dst');";
                                break;
                            case "foto":
                                $dst = $pathSection . DIRECTORY_SEPARATOR . $titulo . ".jpg";
                                $dst = addslashes($dst);
                                copy($src, $dst);
                                $queryInsertArtigo = "INSERT INTO `$dataBaseName`.`imagem` (`idRecurso`, `dados`)" . "VALUES ('$idRecurso', '$dst');";
                                break;
                            case "musica":
                                $dst = $pathSection . DIRECTORY_SEPARATOR . $titulo . ".mp3";
                                $dst = addslashes($dst);
                                copy($src, $dst);
                                $queryInsertArtigo = "INSERT INTO `$dataBaseName`.`musica` (`idRecurso`, `dados`)" . "VALUES ('$idRecurso', '$dst');";
                                break;
                        }

                        $queryResult = mysqli_query($GLOBALS['ligacao'], $queryInsertArtigo);

                        if (!$queryResult) {
                            $existeArtigo = true;
                        }
                    }
                }
                
                $queryInsertArtigo = "INSERT INTO `$dataBaseName`.`Recursos` (`nSeccao`, `idPublicacao`, `tipoRecurso`)" .
                        "VALUES ('$SectionNumb', '$idPublicacao', 'texto');";

                $queryResult = mysqli_query($GLOBALS['ligacao'], $queryInsertArtigo);

                if ($queryResult) {
                    $queryGetIdPubli = "SELECT * FROM `$dataBaseName`.`recursos` ORDER BY `idRecurso` DESC LIMIT 1";

                    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetIdPubli);

                    if ($queryResult) {
                        $idRecurso = mysqli_fetch_array($queryResult)['idRecurso'];
                        $texto = str_replace("'","", $texto);
                        $queryInsertArtigo = "INSERT INTO `$dataBaseName`.`texto` (`idRecurso`, `dados`)" . "VALUES ('$idRecurso', '$texto');";
                        $queryResult = mysqli_query($GLOBALS['ligacao'], $queryInsertArtigo);
                        if (!$queryResult) {
                            $existeArtigo = true;
                        }
                    }
                }
                $SectionNumb++;
            } while ($SectionNumb <= $CounterSection);
        }
    }
}
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="Img/Dokuwiki_logo.png">
        <style>
            .alert {
                padding: 20px;
                color: white;
            }

            .closebtn {
                margin-left: 15px;
                color: white;
                font-weight: bold;
                float: right;
                font-size: 22px;
                line-height: 20px;
                cursor: pointer;
                transition: 0.3s;
            }

            .closebtn:hover {
                color: black;
            }
        </style>
    </head>
    <body>
        <div>
            <?php
            if ($existeArtigo) {
                ?>
                <div class="alert" style="background-color: #f44336 ">
                    <span class="closebtn" onclick="this.parentElement.style.display = 'none';" >&times;</span> 
                    <strong>Danger!!</strong> UPS já existe um artigo com este nome...
                </div>
                <?php
            } else {
                ?>
                <div class="alert" style="background-color: #27AE60 ">
                    <span class="closebtn" onclick="this.parentElement.style.display = 'none';" >&times;</span> 
                    <strong>Success!!</strong> Artigo criado com sucesso...
                </div>
                <?php
            }
            header('Refresh: 3; LandingPage.php');
            ?>
        </div>

    </body>
</html>




