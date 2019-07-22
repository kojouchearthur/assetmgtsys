<?php
    session_start();
    require 'assets/conf.php';
    require 'assets/assetmgtconf.php';
    $pagetitle = $adasst;
        
    if(!isset($_SESSION['logged-in'])){
        header('Location: index.php');
    }

    /*
    $devicetype = array('LAP'=>'Laptop','DSK'=>'Desktop PC (exluding Monitor, Mouse, Keyboard, etc)','MON'=>'Monitor','KBD'=>'Keyboard','MSE'=>'Mouse',
    'PRT'=>'Printer','SCN'=>'Scanner','CPR'=>'Photocopier','SVR'=>'Server','ROU'=>'Router','SWT'=>'Switch','HUB'=>'Hub','UPS'=>'UPS','PHN'=>'Mobile Phone','TEL'=>'Deskphone','MDM'=>'Internet Modem','MIF'=>'MiFi Device','OTHR'=>'Other Device' );
    */

    require 'parts/head.php';
?>
<style>
    .frm-label{
        font-size:12px;
        font-weight:normal;
        margin-bottom:0px;
    }
</style>
<body>
<noscript><div style='text-align:center;color:red;position:relative;'>Kindly Enable Javascript on this browser</div></noscript>
    <div class='container-fluid body-con other-bod' id='bbkg'>
    <?php require 'parts/header.php';  ?>
        <div class='row' id=''></div>
        <div class='row main-con' id=''>
            <div class='col-sm-1 col-md-2' id=''></div>
            <div class='col-sm-10 col-md-8' id=''>
                <?php require "adasstform.php"; ?>

            </div>
            <div class='col-sm-1 col-md-2' id=''></div>

        </div>
    <?php require 'parts/footer.php'; ?>