<?php
require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
session_start();

if (!isset($_SESSION['UserId'])) {
    header('Location: LoginPage.php');
}

$userID = $_SESSION['UserId'];

// vamos fazer a conecção com a base de dados
dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;
mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);
$queryGetChallenge = "SELECT  FROM `$dataBaseName`.`users` " . "WHERE `idUser`='$userID'";

$queryResult = mysqli_query($GLOBALS['ligacao'], $queryGetChallenge);

if ($queryResult) {
    $queryrole = "SELECT idRole FROM `$dataBaseName`.`permissions` " . "WHERE `idUser`='$userID'";
    $queryResultRole = mysqli_query($GLOBALS['ligacao'], $queryrole);

    if ($queryResultRole) {
        $roleUser = mysqli_fetch_array($queryResultRole)[0];
        if ($roleUser != 1) {
            header('Location: LoginPage.php');
        }
    }
}
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
        <link rel="shortcut icon" href="Img/Dokuwiki_logo.png">
        <title>Gerir Users</title>
        <?php
        header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        ?>
        <style>
            /* The container */
            .container {
                display: block;
                position: relative;
                padding-left: 35px;
                margin-bottom: 12px;
                font-size: 22px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            /* Hide the browser's default checkbox */
            .container input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
                height: 0;
                width: 0;
            }

            /* Create a custom checkbox */
            .checkmark {
                position: absolute;
                top: 0;
                left: 0;
                height: 25px;
                width: 25px;
                background-color: #eee;
            }

            /* When the checkbox is checked, add a blue background */
            .container input:checked ~ .checkmark {
                background-color: #2196F3;
            }
            
            /* When the checkbox is checked, add a blue background */
            .container input:disabled ~ .checkmark{
                background-color: red;
            }

            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after {
                content: "";
                position: absolute;
                display: none;
            }

            /* Show the checkmark when checked */
            .container input:checked ~ .checkmark:after {
                display: block;
            }

            /* Style the checkmark/indicator */
            .container .checkmark:after {
                left: 9px;
                top: 5px;
                width: 5px;
                height: 10px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }
        </style>
    </head>
    <body>
        <br>
        <div class="main-content">
            <!-- Table -->
            <div class="row">
                <div class="col-xl-8 m-auto order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Gerir Users</h3>
                                </div>
                                <div class="col-4 text-right"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method = "POST" action="removeUser.php">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="heading-small text-muted mb-4">Gerir Admins</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="heading-small text-muted mb-4">Eliminar Users</h6>
                                        </div>
                                    </div>

                                    <?php
                                    $queryGetUsers = "SELECT * FROM `$dataBaseName`.`users`";
                                    $queryResultUsers = mysqli_query($GLOBALS['ligacao'], $queryGetUsers);
                                    if ($queryResultUsers) {
                                        ?>

                                        <?php
                                        while ($rowUsers = mysqli_fetch_row($queryResultUsers)) {
                                            $userIdRow = $rowUsers[0];
                                            $nome = $rowUsers[3];
                                            $queryGetUsersPermissions = "SELECT idRole FROM `$dataBaseName`.`permissions` " . "WHERE `idUser`='$userIdRow'";
                                            $queryResultUsersPermissions = mysqli_query($GLOBALS['ligacao'], $queryGetUsersPermissions);

                                            if ($queryResultUsersPermissions) {
                                                $roleUsersPermissions = mysqli_fetch_array($queryResultUsersPermissions)[0];
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="container"><?php echo $nome; ?>
                                                            <input type="checkbox" name="check-admin[]" value="<?php echo $userIdRow; ?>" <?php if ($roleUsersPermissions == 1) { ?>checked="checked" <?php } ?>>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="container"><?php echo $nome; ?>
                                                            <input type="checkbox" name="checkuser[]" value="<?php echo $userIdRow; ?>" <?php if ($roleUsersPermissions == 1) { ?>disabled<?php } ?>>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <input class="back" type="submit" value="Submeter">
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
        </div>
    </body>
    <
</html>