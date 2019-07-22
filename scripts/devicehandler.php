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

if(isset($_POST['devuseremail'])){
    $devuseremail= cleanValidate(testInput($_POST['devuseremail']),'email');
}

if(isset($_REQUEST['devasstnum'])){
    $dev = testInput($_REQUEST['devasstnum']);
}

if(isset($_POST['assetnum'])){
    $dev = testInput($_POST['assetnum']);
}

if(isset($_REQUEST['assetnum'])){
    $dev = testInput($_REQUEST['assetnum']);
}

$query0 = "SELECT * FROM asset_users WHERE assetnum='$dev' AND email='$devuseremail'";
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
    $newonedev = '';
    $oldonedev = '';

    for($i=0;$i<count($devrecord);$i++){
        $onedev = explode(':',$devrecord[$i]);
        if(!isset($onedev[7]) && !isset($onedev[8]) && $onedev[1]==$dev){
            $onedev[7] = $datereturned;
            $onedev[8] = $datereturnedraw;
            $newonedev .= $onedev[0].":".$onedev[1].":".$onedev[2].":".$onedev[3].":".$onedev[4].":".$onedev[5].":".$onedev[6].":".$onedev[7].":".$onedev[8];            
            if($i==count($devrecord)-1){
                $newdevrecord .= $newonedev;
            }else{
                $newdevrecord .= $newonedev."::";
            }
        }else{
            if(isset($onedev[7]) && isset($onedev[8])){
                $oldonedev .= $onedev[0].":".$onedev[1].":".$onedev[2].":".$onedev[3].":".$onedev[4].":".$onedev[5].":".$onedev[6].":".$onedev[7].":".$onedev[8];
            }else{
                $oldonedev .= $onedev[0].":".$onedev[1].":".$onedev[2].":".$onedev[3].":".$onedev[4].":".$onedev[5].":".$onedev[6];
            }
            
            if($i==count($devrecord)-1){
                $newdevrecord .= $oldonedev;
            }else{
                $newdevrecord .= $oldonedev."::";
            }
        }
    }    

    $query = "UPDATE assets SET deviceuserrecord=CONCAT_WS(':',deviceuserrecord,'$datereturned:$datereturnedraw'), assigned=0, modifiedby='$modifiedby' WHERE assetnum='$dev'";
    $query1 = "UPDATE asset_users SET returned=1, datereturned='$datereturned', datereturnedraw=$datereturnedraw, modifiedby='$modifiedby' WHERE email='$devuseremail' AND assetnum='$dev'";
    $query2 = "UPDATE assetusers SET devicerecord='$newdevrecord', modifiedby='$modifiedby' WHERE email='$devuseremail'";
//  $query3 = "INSERT INTO notifications() VALUES()";

    $res = mysqli_query($con,$query);
    $res1 = mysqli_query($con,$query1);
    $res2 = mysqli_query($con,$query2);
//  $res3 = mysqli_query($con,$query3);

    if($res && $res1 && $res2){
        echo "Device Record Updated Successfully"."`".Date('D, d-M-Y',$datereturnedraw)."`".Date('Y-m-d',$datereturnedraw);
    }else{
        echo "Error"."`"."<span style='color:red;'><i class='fa fa-exclamation-triangle'></i> Unable to update Device Record at this time. Kindly try again soon</span>";
    }
}

/**Code Block for reassigning Device to a different user*/

if(isset($_POST['deviceuser'])){
    if(isset($_POST['deviceuseremail']) && isset($_POST['dateassigned'])){        
        $deviceuser = cleanValidate(testInput($_POST['deviceuser']),'string');
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

        $addedby = $_SESSION['logged-in'];
        $modifiedby = $_SESSION['logged-in'];
        $dateaddedraw = time();
        $assetnum = $dev;
        $devicename = $devdet['devicetype'];
        $deviceid = $devdet['deviceid'];
        $devicedesc = $devdet['devicedesc'];
        $usertype ='';
        $devicestate = 'Used';

        $deviceinfo = $deviceid.':'.$assetnum.':'.$devicename.':'.$devicedesc.':'.$devicestate.':'.$dateassigned.':'.$dateassignedraw;

        if($devdet['returned']==0){
            echo "Error"."`"."<span style='color:red;'><i class='fa fa-exclamation-triangle'></i></span><br>Set the date this device was returned by ".$devdet['fname']." ".$devdet['lname'];
            exit();
        }

        if(cleanValidate($_POST['deviceuseremail'],'email')){
            $deviceuseremail = $_POST['deviceuseremail'];
            if(itExists('email','assetusers',$deviceuseremail)==0){
                $deviceuserid = getuniqueid(4,3);
                $usertype = "New";
           
                $query2 = "INSERT INTO assetusers(fname,lname,email,userid,recentdesignation,recentlocation,devicerecord,dateaddedraw,addedby,modifiedby) 
                VALUES('$fname','$lname','$deviceuseremail','$deviceuserid','$deviceuserdesignation','$deviceuserlocation','$deviceinfo',$dateaddedraw,'$addedby','$modifiedby')";                
            }else{
                $query2a = "SELECT userid FROM assetusers WHERE email='$deviceuseremail'";
                $res2a = mysqli_query($con,$query2a);
                $deviceuserid = mysqli_fetch_array($res2a)[0];
                $usertype = "Existing";
            
                $query2 = "UPDATE assetusers SET recentdesignation='$deviceuserdesignation',recentlocation='$deviceuserlocation',modifiedby='$modifiedby',devicerecord=CONCAT_WS('::',devicerecord,'$deviceinfo') WHERE email='$deviceuseremail'";
            }

            $deviceuserrecord = $deviceuser.':'.$deviceuseremail.':'.$deviceuserid.':'.$deviceuserdesignation.':'.$deviceuserlocation.':'.$usertype.':'.$dateassigned.':'.$dateassignedraw;

            $query = "UPDATE assets SET deviceuserrecord=CONCAT_WS('::',deviceuserrecord,'$deviceuserrecord'),modifiedby='$modifiedby',assigned=1 WHERE assetnum='$dev'";
            $query1 = "INSERT INTO asset_users(fname,lname,email,userid,recentdesignation,recentlocation,usertype,deviceid,assetnum,devicetype,devicedesc,devicestate,dateassigned,dateassignedraw,returned,addedby,dateaddedraw,modifiedby)
                    VALUES('$fname','$lname','$deviceuseremail','$deviceuserid','$deviceuserdesignation','$deviceuserlocation','$usertype','$deviceid','$assetnum','$devicename','$devicedesc','$devicestate','$dateassigned',$dateassignedraw,0,'$addedby',$dateaddedraw,'$modifiedby')";
        //  $query3 = "INSERT INTO notifications()VALUES()";

            $res = mysqli_query($con,$query);
            $res1 = mysqli_query($con,$query1);
            $res2 = mysqli_query($con,$query2);
        //  $res3 = mysqli_query($con,$query3);

            if($res && $res1 && $res2){
                echo "Device has been successfully reassigned to <br>".$fname." ".strtoupper($lname)."`";
                echo $fname." ".$lname."`".$deviceuseremail."`".$deviceuserdesignation."`".$deviceuserlocation."`".Date('D, d-M-Y',$dateaddedraw);
            }else{
                echo "Error"."`"."Unable to reassign this device at this time. Try again soon";
                exit();
            }
        }
    }else{
        echo "Error"."`"."Kindly enter all the required fields";
        exit();
    }
}

if(isset($_REQUEST['devcond'])){
    $devcond = strtolower(cleanValidate(testInput($_REQUEST['devcond']),'string'));
    if($devcond=='faulty'){
        $query = "UPDATE assets SET healthy=1 WHERE assetnum='$dev'";
        // $query1 = "INSERT INTO notifications() VALUES()";

        $res = mysqli_query($con,$query);
        // $res1 = mysqli_query($con,$query1);

        if($res){
            echo "Device marked as Working";
            echo "`working`gray`<i class='fa fa-toggle-off'></i>";
        }else{
            echo "Error`Unable to mark device as working";
            exit();
        }
    }elseif($devcond=='working'){
        $query = "UPDATE assets SET healthy=0 WHERE assetnum='$dev'";
        // $query1 = "INSERT INTO notifications() VALUES()";

        $res = mysqli_query($con,$query);
        // $res1 = mysqli_query($con,$query1);

        if($res){
            echo "Device marked as Faulty";
            echo "`faulty`red`<i class='fa fa-toggle-on'></i>";
        }else{
            echo "Error`Unable to mark device as faulty";
            exit();
        }
    }else{
        echo "Error`Some Error Occured in changing Device Health state";
        exit();
    }
}

if(isset($_REQUEST['devstock'])){
    $devcond = strtolower(cleanValidate(testInput($_REQUEST['devstock']),'string'));
    if($devcond=='sold'){
        $query = "UPDATE assets SET sold=0 WHERE assetnum='$dev'";
        // $query1 = "INSERT INTO notifications() VALUES()";

        $res = mysqli_query($con,$query);
        // $res1 = mysqli_query($con,$query1);

        if($res){
            echo "Device marked as unsold";
            echo "`unsold`gray`<i class='fa fa-toggle-off'></i>";
        }else{
            echo "Error`Unable to mark device as sold";
            exit();
        }
    }elseif($devcond=='unsold'){
        $query = "UPDATE assets SET sold=1 WHERE assetnum='$dev'";
        // $query1 = "INSERT INTO notifications() VALUES()";

        $res = mysqli_query($con,$query);
        // $res1 = mysqli_query($con,$query1);

        if($res){
            echo "Device marked as Sold";
            echo "`sold`teal`<i class='fa fa-toggle-on'></i>";
        }else{
            echo "Error`Unable to mark device as Sold";
            exit();
        }
    }else{
        echo "Error'Some Error Occured in changing Device Stock status";
        exit();
    }
}
?>