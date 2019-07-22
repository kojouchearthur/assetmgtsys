<?php
session_start();
require "../lib/plug.php";
require "../assets/reuse.php";
require "../assets/conf.php";
require "../assets/assetmgtconf.php";

$acct = '';
$devuseremail = '';
$modifiedby = $_SESSION['logged-in'];

if(isset($_POST['uniqueid'])){
    if($_POST['uniqueid']=='undefined' || $_POST['uniqueid']=='null'){
        echo "Error"."`"."<span><i class='fa fa-times fa-3x'></i></span><br>Unrecognized Account<span><i class='fa fa-times fa-2x'></i></span><br>Unrecognized Account!!!";
        exit();
    }else{
        $acct= cleanValidate(testInput($_POST['uniqueid']),'string');
    }
}

if(isset($_REQUEST['uniqueid'])){
    if($_REQUEST['uniqueid']=='undefined' || $_REQUEST['uniqueid']=='null'){
        echo "Error"."`"."<span><i class='fa fa-times fa-3x'></i></span><br>Unrecognized Account";
        exit();
    }else{
        $acct= cleanValidate(testInput($_REQUEST['uniqueid']),'string');
    }    
}

/* Code block to change user account password */
if(isset($_POST['newpwd'])){
    $newpwd = md5(cleanValidate(testInput($_POST['newpwd']),'string'));
    if(isset($_POST['confnewpwd'])){
        $confnewpwd = md5(cleanValidate(testInput($_POST['confnewpwd']),'string'));
        if($newpwd === $confnewpwd){
            $query = "UPDATE users SET password='$newpwd',modifiedby='$modifiedby' WHERE uniqueid='$acct'";
//          $query1 = "INSERT into notification(type,category,author,description,date) VALUES()";

            $result = mysqli_query($con,$query);
//          $result1 = mysqli_query($con,$query1);

            if($result){
                echo "Password Changed Successfully";
            }else{
                echo "Error"."`"."Oouch, some error occurred. Kindly try again.". mysqli_error($con);
                exit();
            }
        }else{
            echo "Error"."`"."Passwords do not match. Kindly re-enter same password twice";
            exit();
        }
    }else{
        echo "Error"."`"."Kindly enter the new password twice";
        exit();
    }
}

/* Code Section to Block or Unblock User Accounts */
if(isset($_REQUEST['acctstate'])){
    $acctstate = strtolower(cleanValidate(testInput($_REQUEST['acctstate']),'string'));
    if($acctstate == 'active'){
        $query = "UPDATE users SET blocked=1 WHERE uniqueid='$acct'";
        // $query1 = "INSERT INTO notifications() VALUES()";

        $result = mysqli_query($con,$query);
        // $result1 = mysqli_query($con,$query1);

        if($result){
            echo "Account blocked successfully";
            echo "`btn-default`Blocked`<i class='fa fa-toggle-off' style='font-size:14px';></i> Blocked ";
        }else{
            echo "Error"."`"."Sorry, unable to block account at this time.<br>Try again soon...";
            exit();
        }
    }elseif($acctstate == 'blocked'){
        $query = "UPDATE users SET blocked=0 WHERE uniqueid='$acct'";
        // $query1 = "INSERT INTO notifications() VALUES()";
        
        $result = mysqli_query($con,$query);
        // $result1 = mysqli_query($con,$query1);
        
        if($result){
            echo "Account Unblocked successfully";
            echo "`btn-success`Active`<i class='fa fa-toggle-on' style='font-size:14px';></i> Active ";
        }else{
            echo "Error"."`"."Sorry, unable to unblock this account at the moment.<br>Try again soon...";
            exit();
        }
    }else{
        echo "Error"."`"."Some Error occurred. Try again soon";
        exit();
    }
}

?>