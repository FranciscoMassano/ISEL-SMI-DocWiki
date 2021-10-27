<?php
include_once( "config.php" );

session_start();
$captchaValue = @substr(md5(time()), 0, 9);
$_SESSION['captcha'] = $captchaValue;

$imageCaptcha = ImageCreateFromPNG( "images/fundocaptch.png" );

$colorCaptchaRed = ImageColorAllocate($imageCaptcha, 255, 0, 0);
$colorCaptchaBlue = ImageColorAllocate($imageCaptcha, 0, 0, 255);

$fontName = "Vera.ttf";

$fontCaptcha = $fontsDirectory.$fontName;

$code1 = substr($captchaValue, 0, 4);
$code2 = substr($captchaValue, 4, 9);

ImageTTFText(
        $imageCaptcha,      // Image
        20,                 // Font size
        -5,                 // Font angle
        40,                 // X position
        30,                 // Y position
        $colorCaptchaRed,   // Font color
        $fontCaptcha,       // Font type
        $code1              // Text to write
);

ImageTTFText(
        $imageCaptcha,      // Image
        20,                 // Font size
        5,                  // Font angle
        120,                // X position
        30,                 // Y position
        $colorCaptchaBlue,  // Font color
        $fontCaptcha,       // Font type
        $code2              // Text to write
);

header( "Content-type: image/png" );

ImagePNG( $imageCaptcha /*, "nome do ficheiro de output"*/  );

ImageDestroy( $imageCaptcha );
?>
