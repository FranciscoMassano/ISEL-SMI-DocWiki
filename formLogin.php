<?php
require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );
session_start();
header('Content-Type: text/html; charset=utf-8');

$UserName = $_POST['login'];
$password = $_POST['pass'];
$isvalid = false;

if ($_SESSION['captcha'] == $_POST['captcha']) {
    // vamos fazer a conecção com a base de dados
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

    $queryGetChallenge = "SELECT * FROM `$dataBaseName`.`users` " .
            "WHERE `UserName`='$UserName'";

    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetChallenge);

    $record = mysqli_fetch_array($queryResult);
    if ($record != null) {
        
        $UserIdSql = $record[0];
        $passwordSql = $record[6];
        $activeSql = $record[9];

        $isValidPassword = strcmp($password, $passwordSql) == 0 ? true : false;

        if ($isValidPassword && $activeSql) {
            $isvalid = true;
            $_SESSION['UserId'] = $UserIdSql;
            header('Location: LandingPage.php');
        } else {
            dbDisconnect();
            $messageError = "Aconteceu algo de errado, tente novamente!!";
        }
    } else {
        $messageError = "Aconteceu algo de errado, tente novamente!!";
    }
} else {
    $messageError = "Aconteceu algo de errado, tente novamente!!";
}
?>

<!DOCTYPE html>
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
            if (!$isvalid) {
                ?>
                <div class="alert" style="background-color: #f44336 ">
                    <span class="closebtn" onclick="this.parentElement.style.display = 'none';" >&times;</span> 
                    <strong>Danger!!</strong> <?php echo $messageError; ?>
                    <?php
                    header('Refresh: 3; LoginPage.php');
                    ?>
                </div>
            <?php }
            ?>
        </div>
    </body>
</html>