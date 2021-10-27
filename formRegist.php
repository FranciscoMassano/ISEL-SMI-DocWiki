<?php
require_once( "../Lib/lib.php" );
require_once( "../Lib/lib-mail-v2.php" );
require_once( "../Lib/HtmlMimeMail.php" );
require_once( "../Lib/db.php" );

$flags[] = FILTER_NULL_ON_FAILURE;

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING, $flags);
$referer = filter_input(INPUT_SERVER, 'HTTP_REFERER', FILTER_SANITIZE_STRING, $flags);
$pathImgUser = "D:\Temp\upload\contents";
if ($referer == NULL) {
    echo "Invalid HTTP REFERER";
    exit();
}

if ($method == 'POST') {
    $_INPUT_METHOD = INPUT_POST;
} elseif ($method == 'GET') {
    $_INPUT_METHOD = INPUT_GET;
} else {
    echo "Invalid HTTP method (" . $method . ")";
    exit();
}

// vamos fazer a conecção com a base de dados
dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

$isvalid = true;
$userName = $_POST['input-UserName'];
$password = $_POST['input-Password'];
$name = $_POST['input-Name'];
$email = $_POST['input-Email'];
$genero = $_POST['Sex'];
$Nacionalidade = $_POST['input-nacionalidade'];
$telemovel = $_POST['phone'];
$dataNascimento = $_POST['input-DataNascimento'];
$fotoName = $_FILES['file']['name'];

// Vamos buscar o idUser com o token recebido 
$queryGetChallenge = "SELECT `UserName` FROM `$dataBaseName`.`users` " .
        "WHERE `UserName`='$userName'";
$queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetChallenge);

if (mysqli_fetch_array($queryResult) != null && $isvalid) {
    $isvalid = false;
    $messageError = "O User Name introduzido já existe";
}

// Vamos buscar o idUser com o token recebido 
$queryGetChallenge = "SELECT `Email` FROM `$dataBaseName`.`users` " .
        "WHERE `Email`='$email'";
$queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetChallenge);

if (mysqli_fetch_array($queryResult) != null && $isvalid) {
    $isvalid = false;
    $messageError = "O email introduzido já existe";
}

if ($isvalid) {
    if ($fotoName !== '') {
        $foto = addslashes($fotoName);
        $src = $_FILES['file']['tmp_name'];
        $dst = $pathImgUser . DIRECTORY_SEPARATOR . $userName . ".jpg";
        copy($src, $dst);
    } else {
        $fotoName = "fotoDefault.jpg";
        $dst = $pathImgUser . DIRECTORY_SEPARATOR . $fotoName;
    }
    $dst = addslashes($dst);

    // Vamos inserir na base de dados o novo user "auth-basic."
    $queryInsertUser = "INSERT INTO `$dataBaseName`.`users` (`UserName`, `Email`, `Nome`, `DataNascimento`, `Genero`, `Password`, `Telefone`, `Nacionalidade`, `Active`, `Foto`) " .
            "VALUES ('$userName', '$email', '$name', '$dataNascimento', '$genero', '$password', '$telemovel', '$Nacionalidade', 'FALSE', '$dst');";

    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryInsertUser);

    if ($queryResult) {
        $queryString = "SELECT `idUser` FROM `$dataBaseName`.`users` " . "WHERE `UserName`='$userName'";
        $queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

        if ($queryResult) {
            $idUser = mysqli_fetch_array($queryResult)[0];
            $Today = date("Y-m-d H:i:s");
            $Token = $idUser . str_replace(" ", "*", $Today);

            $Message = "Caro(a) {$name}, \n" .
                    "De forma a confirmar o seu email, por fazer clique no link que se segue. \n" .
                    "http://26.70.85.194/examples-smi/DocWiki/validation.php/url?token={$Token}\n \n" .
                    "Com os melhores cumprimentos, \n" .
                    "Equipa de suporte DocoWiki. \n";

            // Vamos inserir na base de dados o novo user "auth-basic."
            $queryInsertUser = "INSERT INTO `$dataBaseName`.`permissions` (`idUser`, `idRole`) " .
                    "VALUES ('$idUser', '2');";

            $queryResult = mysqli_query($GLOBALS['ligacao'], $queryInsertUser);

            $queryInsertChallenge = "INSERT INTO `$dataBaseName`.`challenge` (`idUser`, `challenge`, `RegisterDate`) " .
                    "VALUES ('$idUser', '$Token', '$Today');";

            $queryResult = mysqli_query($GLOBALS['ligacao'], $queryInsertChallenge);

            if ($queryResult) {
                // vamos buscar á tabela de emails, o email que vai enviar a mensagem
                $queryString = "SELECT * FROM `$dataBaseName`.`email-accounts` WHERE `id`='1'";

                $queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);
                $record = mysqli_fetch_array($queryResult);

                //[0] => 1 [id] => 1 
                //[1] => Gmail - SMI [accountName] => Gmail - SMI 
                //[2] => smtp.gmail.com [smtpServer] => smtp.gmail.com 
                //[3] => 465 [port] => 465 
                //[4] => 1 [useSSL] => 1 
                //[5] => 30 [timeout] => 30 
                //[6] => g26smi@gmail.com [loginName] => g26smi@gmail.com 
                //[7] => G26smi123 [password] => G26smi123 
                //[8] => g26smi@gmail.com [email] => g26smi@gmail.com 
                //[9] => Sistemas Multimédia para a Internet [displayName] => Sistemas Multimédia para a Internet )

                $Subject = "Validação do email.";
                $smtpServer = $record['smtpServer'];
                $port = intval($record['port']);
                $useSSL = boolval($record['useSSL']);
                $timeout = intval($record['timeout']);
                $loginName = $record['loginName'];
                $password = $record['password'];
                $fromEmail = $record['email'];
                $fromName = $record['displayName'];

                mysqli_free_result($queryResult);

                dbDisconnect();

                $result = sendAuthEmail($smtpServer, $useSSL, $port, $timeout, $loginName, $password, $fromEmail, $fromName,
                        $userName . " <" . $email . ">", NULL, NULL, $Subject, $Message, FALSE, NULL);
            } else {
                dbDisconnect();
                $result = false;
            }
        } else {
            dbDisconnect();
            $result = false;
        }
    } else {
        dbDisconnect();
        $result = false;
    }
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
                </div>
                <?php
            } else {
                ?>
                <div class="alert" style="background-color: #27AE60 ">
                    <span class="closebtn" onclick="this.parentElement.style.display = 'none';" >&times;</span> 
                    <strong>Success!!</strong> Foi-lhe enviado um email para validar o seu registo.
                </div>
                <?php
            }
            header('Refresh: 3; LoginPage.php');
            ?>
        </div>
    </body>
</html>