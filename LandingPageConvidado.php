<?php
require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

// vamos fazer a conecção com a base de dados
dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;
mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

$imageUrl = "D:\Temp\upload\contents\\fotoDefault.jpg";
$imageUrl = addslashes($imageUrl);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
            />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet"/>

        <title>Ver Todos os Artigos</title>
        <!--
        Reflux Template
        https://templatemo.com/tm-531-reflux
        -->
        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <!-- Additional CSS Files -->
        <link rel="stylesheet" href="assets/css/fontawesome.css" />
        <link rel="stylesheet" href="assets/css/templatemo-style.css" />
        <link rel="stylesheet" href="assets/css/owl.css" />
        <link rel="stylesheet" href="assets/css/lightbox.css" />
        <style>
            .ui-menu-item{display: block !important;}
        </style>
    </head>

    <body>
        <div id="page-wraper">
            <!-- Sidebar Menu -->
            <div class="responsive-nav">
                <i class="fa fa-bars" id="menu-toggle"></i>
                <div id="menu" class="menu" style="z-index: 9 !important">
                    <i class="fa fa-times" id="menu-close"></i>
                    <div class="container">
                        <div class="image">
                            <a href="UserPage.php"><img src="showImage.php?imageURL=<?php echo $imageUrl; ?>"></a>
                        </div>
                        <br>
                        <div class="white-button">
                            <a href="CriarConta.php">Criar Conta</a>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section about-me" data-section="section1">
                <div class="container">
                    <div class="section-heading">
                        <h2>Todos os Artigos Disponiveis</h2>
                        <div class="line-dec"></div>
                    </div>

                    <?php
                    $queryGetChallenge = "SELECT * FROM `$dataBaseName`.`publicacoes`";
                    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetChallenge);

                    if ($queryResult) {
                        while ($row = mysqli_fetch_row($queryResult)) {
                            $idArtigo = $row[0];
                            $titulo = $row[2];
                            $resumo = $row[4];
                            $ilustracao = $row[5];
                            ?>
                            <div class="left-image-post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="left-image">
                                            <img src="showImage.php?imageURL=<?php echo $ilustracao; ?>" style="width: auto; height: auto">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="right-text">
                                            <h4><?php echo $titulo; ?></h4>
                                            <p><?php echo $resumo; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><hr><br>
                            <?php
                        }
                    }
                    ?>
                </div>
            </section>
        </div>


        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 

        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- <script src="assets/js/isotope.min.js"></script> -->
        <script src="assets/js/owl-carousel.js"></script>
        <script src="assets/js/lightbox.js"></script>
        <script src="assets/js/custom.js"></script>

    </body>
</html>
