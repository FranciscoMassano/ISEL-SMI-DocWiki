<?php
    require_once( "../Lib/lib.php" );
    
    // TODO validate input data
    $imageUrl = $_GET['imageURL'];
    
    $thumbFileNameAux = $imageUrl;
    $thumbMimeFileName = "filme";
    $thumbTypeFileName = "mp4";

    header( "Content-type: $thumbMimeFileName/$thumbTypeFileName");
    header( "Content-Length: " . filesize($thumbFileNameAux) );

    $thumbFileHandler = fopen( $thumbFileNameAux, 'rb' );
    fpassthru( $thumbFileHandler );

    fclose( $thumbFileHandler );
?>