<?php

require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );

if (isset($_POST['search'])) {
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

    $query = "SELECT * FROM `$dataBaseName`.`publicacoes` WHERE titulo like '".$_POST['search']."%'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);

    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("value" => $row['idPublicacao'], "label" => $row['titulo']);
    }

    echo json_encode($response);
} else{
    echo json_encode("ERRO");
}
exit;