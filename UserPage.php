<?php
require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );

session_start();
if (!isset($_SESSION['UserId'])) {
    header('Location: LoginPage.php');
}

$userID = $_SESSION['UserId'];

// vamos fazer a conecção com a base de dados
dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

$queryGetChallenge = "SELECT * FROM `$dataBaseName`.`users` " .
        "WHERE `idUser`='$userID'";

$queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetChallenge);

if ($queryResult) {
    $record = mysqli_fetch_array($queryResult);
    $userName = $record['UserName'];
    $email = $record['Email'];
    $Name = $record['Nome'];
    $birtdayDate = $record['DataNascimento'];
    $gender = $record['Genero'] === "M" ? "Masculino" : "Feminino";
    $phoneNumb = $record['Telefone'];
    $Nationality = $record['Nacionalidade'];
    $imageUrl = $record['Foto'];
}

dbDisconnect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
        <link rel="stylesheet"
              href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css"
              integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX"
              crossorigin="anonymous">
        <link
            href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"
            rel="stylesheet">
        <link rel="stylesgeet"
              href="https://rawgit.com/creativetimofficial/material-kit/master/assets/css/material-kit.css">
        <link rel="stylesheet" type="text/css" href="Css/UserPageCSS.css">
        <link rel="shortcut icon" href="Img/Dokuwiki_logo.png">
        <title>User Page</title>
        <?php
        header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        ?>
        <style>
            #map{
                height: 700px;
                width: auto;
                margin: auto;
            }
        </style>
    </head>


    <body class="profile-page" style="background-color: #717D7E !important;">


        <div class="page-header header-filter" data-parallax="true"></div>
        <div class="main main-raised" style="margin-bottom: 5% !important;">
            <div class="profile-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 ml-auto mr-auto">
                            <div class="profile">
                                <div class="avatar">
                                    <img src="showImage.php?imageURL=<?php echo $imageUrl; ?>" alt="Circle Image" class="img-raised rounded-circle img-fluid"/>
                                </div>
                                <div class="description text-center">
                                    <h3 class="title">Nome:</h3>
                                    <p><?php echo $Name; ?></p>
                                    <h3 class="title">Nomo Utilizador:</h3>
                                    <p><?php echo $userName; ?></p>
                                    <h3 class="title">Nacionalidade:</h3>
                                    <p><?php echo $Nationality; ?></p>
                                    <h3 class="title">Sexo:</h3>
                                    <p><?php echo $gender; ?></p>
                                    <h3 class="title">Data de Nascimento:</h3>
                                    <p><?php echo $birtdayDate; ?></p>
                                    <h3 class="title">Numero de telefone:</h3>
                                    <p><?php echo $phoneNumb; ?></p>
                                    <br>
                                    <h3 class="title">A sua localização</h3>
                                    <label style="color: red; font-size:9px;">*Se não conseder autorização para aceder-mos à sua localização, será apresentada a do ISEL</label>
                                    <p id="p1"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <br/>
            <div id="map"></div>
            <br>
            <script>
                function initMap() {
                    if (navigator.geolocation) {
                        var teste = navigator.geolocation.getCurrentPosition(function (position) {
                            var pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            console.log("POS");
                            var map = new google.maps.Map(document.getElementById("map"), {

                                zoom: 20,
                                center: pos
                            });
                            console.log("MAP");
                            var marker = new google.maps.Marker({
                                position: {lat: pos.lat, lng: pos.lng},
                                map: map
                            });
                            console.log("MARKER");
                            const element = document.getElementById("p1");
                            const node = document.createTextNode("Latitude:" + pos.lat + " Longitude: " + pos.lng);
                            element.appendChild(node);
                        });
                    } 
                    
        
        /*else {
                        var pos = {
                            lat: 38.75,
                            lng: -9.11
                        };
                        console.log("POS");
                        var map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 20,
                            center: pos
                        });
                        console.log("MAP");
                        var marker = new google.maps.Marker({
                            position: {lat: pos.lat, lng: pos.lng},
                            map: map
                        });
                        console.log("MARKER");
                        const element = document.getElementById("p1");
                        const node = document.createTextNode("ISEL");
                        element.appendChild(node);
                    }*/
                }
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBswXr4dRroQk-vlV-0X6U0SCIF_YXpkvA&callback=initMap"></script>
    </body>
</html>