<?php
require_once( "../Lib/db.php" );

$flags[] = FILTER_NULL_ON_FAILURE;

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING, $flags);

if ($method == 'POST') {
    $_INPUT_METHOD = INPUT_POST;
    $_INPUT = $_POST;
} elseif ($method == 'GET') {
    $_INPUT_METHOD = INPUT_GET;
    $_INPUT = $_GET;
} else {
    echo "Invalid HTTP method (" . $method . ")";
    exit();
}

// Vamos buscar o token ao URL
$token = $_INPUT["token"];

// Establecimento da ligação à base de dados 
dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;
mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

// Vamos buscar o idUser com o token recebido 
$queryGetChallenge = "SELECT `idUser` FROM `$dataBaseName`.`challenge` " .
        "WHERE `challenge`='$token'";
$queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetChallenge);

if ($queryResult) {
    $idUser = mysqli_fetch_array($queryResult)['idUser'];

    // Fazemos Update na BD
    $queryUpdateUserActive = "UPDATE `$dataBaseName`.`users` SET `active` = '1' WHERE `idUser` = '$idUser'";

    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryUpdateUserActive);

    if ($queryResult) {
        $queryDeleteChallenge = "DELETE FROM `$dataBaseName`.`challenge` WHERE `challenge`='$token'";

        $queryResult = mysqli_query($GLOBALS['ligacao'], $queryDeleteChallenge);

        if ($queryResult) {
            $isvalid = true;
        } else {
            $isvalid = false;
        }
    }
}
dbDisconnect();
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
            if(!$isvalid){
        ?>
        <div class="alert" style="background-color: #f44336 ">
            <span class="closebtn" onclick="this.parentElement.style.display = 'none';" >&times;</span> 
            <strong>Danger!!</strong> UPS ocorreu um erro inesperado, tente novamente..
        </div>
        <?php
            } else {
        ?>
        <div class="alert" style="background-color: #27AE60 ">
            <span class="closebtn" onclick="this.parentElement.style.display = 'none';" >&times;</span> 
            <strong>Success!!</strong> Validação realizada com sucesso.
        </div>
        <?php
            }
            header('Refresh: 3; http://26.70.85.194/examples-smi/DocWiki/LoginPage.php');
        ?>
        </div>
        
    </body>
</html>