<?php
require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );
session_start();
if (!isset($_SESSION['UserId'])) {
    header('Location: LandingPageConvidado.php');
} else {
    $userID = $_SESSION['UserId'];
}

if (isset($_GET['idpublicacao'])) {
    $idpublicacao = $_GET['idpublicacao'];
} else {
    $idpublicacao = $_POST['idPublicacao'];
}


// vamos fazer a conecção com a base de dados
dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

$queryString = "SELECT * FROM `$dataBaseName`.`publicacoes` WHERE `idPublicacao`='$idpublicacao'";
$queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

if ($queryResult) {
    $record = mysqli_fetch_array($queryResult);
    ?>


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
            <script type="text/javascript" src="scripts/AdvertisingDemoHTML5.js"></script>
            <link rel="shortcut icon" href="Img/Dokuwiki_logo.png">
            <title><?php echo $record['titulo']; ?></title>
            <?php
            header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            ?>

            <style>
                .white-button a {
                    display: inline-block;
                    padding: 12px 20px;
                    background-color: #fff;
                    color: #a43f49;
                    font-size: 13px;
                    font-weight: 800;
                    letter-spacing: 0.5px;
                    text-transform: uppercase;
                    transition: all 0.5s;
                }

                .white-button a:hover {
                    background-color: #a43f49;
                    color: #fff;
                }
            </style>
        </head>
        <body style="background-color: #717D7E !important" onload="initializeHTML5()">
            <div class="main-content">
                <div class="container mt-7">
                    <!-- Table -->
                    <div class="row">
                        <div class="col-xl-8 m-auto order-xl-1">
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h3 class="mb-0"><?php echo $record['titulo']; ?></h3>
                                        </div>
                                        <?php
                                        if ($record['idUser'] === $userID) {
                                            ?>
                                            <div class="white-button" >
                                                <a href="removerArtigo.php?idPublicacao=<?php echo $record['idPublicacao']; ?>" style="float: right !important;">Remover</a>
                                            </div>
                                        <?php } ?>
                                        <div class="col-4 text-right"></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6 class="heading-small text-muted mb-4">Resumo do Artigo</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <img src="showImage.php?imageURL=<?php echo $record['ilustracao']; ?>" width="300" height="200" align="right" style="margin: 0 0 0 30px;">
                                                <p style="text-align: justify; text-justify: inter-word;"><?php echo $record['resumo']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <?php
                                    $queryString = "SELECT * FROM `$dataBaseName`.`recursos` WHERE `idPublicacao`='$idpublicacao'";
                                    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);
                                    $aux = 1;
                                    if ($queryResult) {
                                        while ($row = mysqli_fetch_row($queryResult)) {
                                            $idRecurso = $row[0];
                                            
                                            $nSec = $row[1];
                                            $types = $row[3];
                                            switch ($types) {
                                                case "foto":
                                                    $queryString = "SELECT * FROM `$dataBaseName`.`imagem` WHERE `idRecurso`='$idRecurso'";
                                                    $queryResultFoto = mysqli_query($GLOBALS['ligacao'], $queryString);
                                                    if ($queryResultFoto) {
                                                        $recordfoto = mysqli_fetch_array($queryResultFoto);
                                                        ?>
                                                        <div class="card-body">
                                                            <div class="pl-lg-4">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <img src="showImage.php?imageURL=<?php echo $recordfoto['dados']; ?>" width="300" height="auto" align="right" style="margin: 0 0 0 30px;"/>
                                                                        <?php
                                                                    }
                                                break;
                                                case "filme":
                                                    $queryString = "SELECT * FROM `$dataBaseName`.`filme` WHERE `idRecurso`='$idRecurso'";
                                                    $queryResultFilme = mysqli_query($GLOBALS['ligacao'], $queryString);
                                                    
                                                    if($queryResultFilme){
                                                        $recordfoto = mysqli_fetch_array($queryResultFilme);
                                                    ?>
                                                        <div class="card-body">
                                                            <div class="pl-lg-4">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <video id = "my_video" width = "600" height = "350" poster = "Img/video.png" controls preload = "metadata" >
                                                                            <source src = "showFilme.php?imageURL=<?php echo $recordfoto['dados']; ?>" />
                                                                            Your browser do not support HTML5 video!Try a different browser instead.
                                                                        </video>
                                                                        <br>
                                                                        <br>
                                                                        <?php
                                                    }
                                                    break;
                                                case "musica":
                                                    $queryString = "SELECT * FROM `$dataBaseName`.`musica` WHERE `idRecurso`='$idRecurso'";
                                                    $queryResultFilme = mysqli_query($GLOBALS['ligacao'], $queryString);
                                                    
                                                    if($queryResultFilme){
                                                        $recordfoto = mysqli_fetch_array($queryResultFilme);
                                                    ?>
                                                        <div class="card-body">
                                                            <div class="pl-lg-4">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <audio controls>
                                                                            <source src = "showAudio.php?imageURL=<?php echo $recordfoto['dados']; ?>" />
                                                                            Your browser do not support HTML5 video!Try a different browser instead.
                                                                        </audio>
                                                                        <br>
                                                                        <br>
                                                                        <?php
                                                    }
                                                    break;
                                                case "texto":
                                                    $queryString = "SELECT * FROM `$dataBaseName`.`texto` WHERE `idRecurso`='$idRecurso'";
                                                    $queryResultFoto = mysqli_query($GLOBALS['ligacao'], $queryString);
                                                    if ($queryResultFoto) {
                                                        $recordfoto = mysqli_fetch_array($queryResultFoto);
                                                        ?><p style="text-align: justify; text-justify: inter-word;"><?php echo $recordfoto['dados']; ?></p>
                                                    <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    break;
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
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
        // Get the Video Object
        theVideo = document.getElementById("my_video");
                        </script>
                        </body>
                        </html>