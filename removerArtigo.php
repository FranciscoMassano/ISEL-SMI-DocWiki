<?php
require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

$idPublicacao = $_GET['idPublicacao'];
$isvalid = true;
// vamos fazer a conecção com a base de dados
dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

$queryDel = "SELECT * FROM `$dataBaseName`.`recursos` " . "WHERE `idPublicacao`='$idPublicacao'";

$queryResult = mysqli_query($GLOBALS['ligacao'], $queryDel);


if ($queryResult) {
    while ($row = mysqli_fetch_row($queryResult)) {
        $idRecurso = $row[0];
        $tipo = $row[3];

        switch ($tipo) {
            case "foto":
                $queryDel = "Delete FROM `$dataBaseName`.`imagem` " . "WHERE `idRecurso`='$idRecurso'";
                break;
            case "texto":
                $queryDel = "Delete FROM `$dataBaseName`.`texto` " . "WHERE `idRecurso`='$idRecurso'";
                break;
            case "filme":
                $queryDel = "Delete FROM `$dataBaseName`.`filme` " . "WHERE `idRecurso`='$idRecurso'";
                break;
            case "musica":
                $queryDel = "Delete FROM `$dataBaseName`.`musica` " . "WHERE `idRecurso`='$idRecurso'";
                break;
        }
        $queryDelResult = mysqli_query($GLOBALS['ligacao'], $queryDel);
        if (!$queryDelResult) {
            $isvalid = false;
            break;
        }

        $queryDel = "Delete FROM `$dataBaseName`.`recursos` " . "WHERE `idRecurso`='$idRecurso'";
        $queryDelRecursoResult = mysqli_query($GLOBALS['ligacao'], $queryDel);

        if (!$queryDelRecursoResult) {
            $isvalid = false;
        }
    }
    $queryDel = "SELECT titulo FROM `$dataBaseName`.`publicacoes` " . "WHERE `idPublicacao`='$idPublicacao'";
    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryDel);
    
    $titulo = mysqli_fetch_array($queryResult)[0];
    
    $pathIlustraction = "D:\Temp\upload\contents\publicacoes";
    $pathIlustraction = $pathIlustraction . DIRECTORY_SEPARATOR . $titulo;
    
    deleteDirectory($pathIlustraction);

    $queryDel = "Delete FROM `$dataBaseName`.`publicacoes` " . "WHERE `idPublicacao`='$idPublicacao'";
    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryDel);

    if (!$queryResult) {
        $isvalid = false;
    }
} else {
    $isvalid = false;
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
                    <strong>Danger!!</strong> Ocorreu algo de errado...
                    <?php
                    header('Refresh: 3; LoginPage.php');
                    ?>
                </div>
            <?php } else {
                ?>
                <div class="alert" style="background-color: #27AE60 ">
                    <span class="closebtn" onclick="this.parentElement.style.display = 'none';" >&times;</span> 
                    <strong>Success!!</strong> Artigo criado com sucesso...
                </div>
                <?php
            }
            header('Refresh: 100; OsMeusArtigos.php');
            ?>
        </div>
    </body>
</html>