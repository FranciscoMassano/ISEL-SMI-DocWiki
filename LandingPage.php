<?php
require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
session_start();
if (!isset($_SESSION['UserId'])) {
    header('Location: LandingPageConvidado.php');
}
$userID = $_SESSION['UserId'];

// vamos fazer a conecção com a base de dados
dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

$queryGetChallenge = "SELECT * FROM `$dataBaseName`.`users` " . "WHERE `idUser`='$userID'";

$queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetChallenge);

if ($queryResult) {
    $record = mysqli_fetch_array($queryResult);
    $imageUrl = $record['Foto'];
    $userName = $record['UserName'];
}
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
        <link rel="shortcut icon" href="Img/Dokuwiki_logo.png">
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
                        <div class="author-content">
                            <h4><?php echo $userName; ?></h4>
                        </div>
                        <div class="white-button">
                            <a href="Logout.php">Logout</a>
                        </div>
                        <br>
                        <div id="divBusca">
                            <form method="post" action="VerArtigo.php">
                                <tr>
                                    <td><input type='text' name ="autocomplete" id='autocomplete' size="30" style="z-index: 900; width: auto" placeholder="Procure o seu artigo aqui..."></td>
                                </tr>
                                <input type="hidden" id="idPublicacao" name="idPublicacao"></input>
                                <input type="image" id="btnBusca" name="submit" src="Img/pesquisa.png" border="0" width="30" height="auto" alt="Submit" />
                            </form>
                        </div>
                        <br>
                        <nav class="main-nav">
                            <ul class="main-menu">
                                <?php
                                $queryrole = "SELECT idRole FROM `$dataBaseName`.`permissions` " . "WHERE `idUser`='$userID'";
                                $queryResultRole = mysqli_query($GLOBALS['ligacao'], $queryrole);

                                if ($queryResultRole) {
                                    $roleUser = mysqli_fetch_array($queryResultRole)[0];
                                    if ($roleUser == 1){
                                        ?><li><a href="gerirUsers.php">Gerir users</a></li><?php
                                    }
                                }
                                ?>
                                <li><a href="OsMeusArtigos.php">Os meus Artigos</a></li>
                                <li><a href="LandingPage.php">Todos os Artigos</a></li>
                                <li><a href="CriarArtigo.php">Criar Artigo</a></li>
                            </ul>
                        </nav>
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
                                            <div class="white-button">
                                                <a href="VerArtigo.php?idpublicacao=<?php echo $idArtigo; ?>">Ver Artigo</a>
                                            </div>
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

        <!-- Script -->
        <script type='text/javascript' >
            $('.ui-autocomplete').css('display-');
            $(function () {
                $("#autocomplete").autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "fetchData.php",
                            type: 'post',
                            dataType: "json",
                            data: {
                                search: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#autocomplete').val(ui.item.label); // display the selected text
                        $('#idPublicacao').val(ui.item.value); // display the selected text
                        return false;
                    },
                    focus: function (event, ui) {
                        $("#autocomplete").val(ui.item.label);
                        return false;
                    },
                });
            });
        </script>
    </body>
</html>
