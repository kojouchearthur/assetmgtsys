<?php
    if(!isset($pagetitle) || $pagetitle == '' || $pagetitle==' '){
        $title = $site." - ".$desc;
    }else{
        $title = $pagetitle." - ".$site;
    }
?>
<!doctype html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='content-type' content='text/html'>
    <meta name='HandheldFriendly' content='true'>
    <meta name='MobileOptimized' content='width'>
    <meta name='robots' content='index,follow'>
    <meta name='description' content=''>
    <meta name='keywords' content=''>
    <meta http-equiv='refresh' content=''>
    <meta http-equiv='X-UA-Compatible' content='IE=edge, chrome=1'>
    <title><?php echo $title; ?> </title>
    <link rel='shortcut icon' href=<?php echo "'".$icon."'"; ?>/>
    
    <!--add css files-->
    <link rel='stylesheet' href='css/bootstrap.min.css'>
    <link rel='stylesheet' href='css/fontawesome.min.css'>
    <link rel='stylesheet' href='css/all.min.css'>
    <link rel='stylesheet' href='css/assetmgt.css'>

    <!--add js files-->
    <script src='js/jquery-3.3.1.min.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <script src='js/fontawesome.min.js'></script>
    <script src='js/all.min.js'></script>
    <script src='js/addjs.js'></script>
</head>
<?php echo ""; ?>