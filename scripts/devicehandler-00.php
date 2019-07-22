<?php
session_start();
require "../lib/plug.php";
require "../assets/reuse.php";
require "../assets/conf.php";
require "../assets/assetmgtconf.php";

$dev = '';
$devuseremail = '';

if(isset($_REQUEST['devuseremail'])){
    $devuseremail= cleanValidate(testInput($_REQUEST['devuseremail']),'email');
}


if(isset($_REQUEST['devasstnum'])){
    $dev = testInput($_REQUEST['devasstnum']);
}

$query0 = "SELECT * FROM assets WHERE assetnum='$dev'";
$res0 = mysqli_query($con,$query0);
$devdet = mysqli_fetch_assoc($res0);

if(isset($_REQUEST['datereturned'])){
    $datereturned = $_REQUEST['datereturned'];
    $datretraw = explode('-',$datereturned);
    $datereturnedraw = mktime(0,0,0,$datretraw[1],$datretraw[2],$datretraw[0]);
    $modifiedby = $_SESSION['logged-in'];

    $query2a = "SELECT devicerecord FROM assetusers where email='$devuseremail'";
    $res2a = mysqli_query($con,$query2a);
    $devrec = mysqli_fetch_array($res2a)[0];
    $devrecord = explode('::',$devrec);
    $newdevrecord = '';

    for($i=0;$i<count($devrecord);$i++){
        $onedev = explode(':',$devrecord[$i]);
        if(!isset($onedev[6]) && !isset($onedev[7]) && $onedev[1]==$dev){
//          $thisdev = $onedev;
            $onedev[6] = $datereturned;
            $onedev[7] = $datereturnedraw;
            $newdevrecord = $devrec;
        }
    }

    $query = "UPDATE assets SET deviceuserrecord=CONCAT_WS(':',deviceuserrecord,'$datereturned:$datereturnedraw'), assigned=0, modifiedby='$modifiedby' WHERE assetnum='$dev'";
    $query1 = "UPDATE asset_users SET datereturned='$datereturned', datereturnedraw=$datereturnedraw, modifiedby='$modifiedby' WHERE email='$devuseremail' AND assetnum='$dev'";
    $query2 = "UPDATE assetusers SET devicerecord='$newdevrecord',modifiedby=$modifiedby WHERE email='$devuseremail'";

    $res = mysqli_query($con,$query);
    $res1 = mysqli_query($con,$query1);
    $res2 = mysqli_query($con,$query2);

    if($res && $res1 && $res2){
        echo "Device Record Updated Successfully"."`".Date('D, d-M-Y',$datereturnedraw);
    }else{
        echo "Error"."`"."Unable to update Device Record at this time. Kindly try again soon";
    }
}/*else{
    echo "Date Device was returned is required";
    exit();
}*/


if(isset($_POST['deviceuser'])){
    if(isset($_POST['deviceuseremail']) && isset($_POST['dateassigned'])){
        $deviceuser = testInput($_POST['deviceuser']);
        $deviceuser = cleanValidate($deviceuser,'string');
        $names = explode(' ',$deviceuser);
        if(count($names)>1){
            $fname = $names[0];
            $lname = $names[1];
        }else{
            echo "Error"."`"."Device User Full name is required";
            exit();
        }

        if(isset($_POST['deviceuserdesignation'])){
            $deviceuserdesignation = cleanValidate(testInput($_POST['deviceuserdesignation']),'string');
        }else{
            echo "Error"."`"."Device User Designation is required";
            exit();
        }

        if(isset($_POST['deviceuserlocation'])){
            $deviceuserlocation = cleanValidate(testInput($_POST['deviceuserlocation']),'string');
        }else{
            echo "Error"."`"."Device User Location is required";
            exit();
        }

        if(isset($_POST['dateassigned'])){
            $dateassigned = $_POST['dateassigned'];
            $dtasraw = explode('-',$dateassigned);
            $dateassignedraw = mktime(0,0,0,$dtasraw[1],$dtasraw[2],$dtasraw[0]);
        }else{
            echo "Error"."`"."Date Device is assigned to user is Required";
            exit();
        }

        $modifiedby = $_SESSION['logged-in'];

        if(cleanValidate($_POST['deviceuseremail'],'email')){
            $deviceuseremail = $_POST['deviceuseremail'];
            if(itExists('email','assetusers',$deviceuseremail)==0){
                $deviceuserid = getuniqueid(4,3);
                $deviceuserrecord = $deviceuser.':'.$deviceuseremail.':'.$deviceuserid.':'.$deviceuserdesignation.':'.$deviceuserlocation.':'.$dateassigned.':'.$dateassignedraw;
                $query1 = "INSERT INTO assets ";
            }else{
                $query2a = "SELECT userid FROM assetusers WHERE email='$deviceuseremail'";
                $res2a = mysqli_query($con,$query2a);
                $deviceuserid = mysqli_fetch_array($res2a)[0];
                $deviceuserrecord = $deviceuser.':'.$deviceuseremail.':'.$deviceuserid.':'.$deviceuserdesignation.':'.$deviceuserlocation.':'.$dateassigned.':'.$dateassignedraw;
            }
        }
    }

}else{
    echo "Error"."`"."Kindly enter all the required fields";
    exit();
}

?>