<?php
session_start();
require "../lib/plug.php";
require "../assets/reuse.php";
require "../assets/conf.php";
require "../assets/assetmgtconf.php";

if(isset($_POST['devicetype']) && isset($_POST['brand']) && isset($_POST['vendor']) && isset($_POST['devicecost']) && isset($_POST['deviceuser']) && isset($_POST['deviceuseremail'])){
    
    $devtype = cleanValidate($_POST['devicetype'], 'string');

//  $devicename = getdevicetype($devtype);
    $devicename = $devicetype[$devtype];

    $brand = testInput($_POST['brand']);
    $brand = cleanValidate($brand,'string');

    if(isset($_POST['model'])){
        $model = cleanValidate($_POST['model'],'string'); 
    }else{
        $model = 'N/A';
    }

    if(isset($_POST['serialimei'])){
        $serialimei = cleanValidate($_POST['serialimei'],'string');
    }else{
        $serialimei = 'N/A';
    }

    if(isset($_POST['ram'])){
        $ram = cleanValidate($_POST['ram'],'string');
    }else{
        $ram = 'N/A';
    }

    if(isset($_POST['hdd'])){
        $hdd = cleanValidate($_POST['hdd'],'string');
    }else{
        $hdd = 'N/A';
    }
    
    if(isset($_POST['processor'])){
        $processor = cleanValidate($_POST['processor'],'string');
    }else{
        $processor = 'N/A';
    }

    if(isset($_POST['devicedetails'])){
        $devicedetails = testInput($_POST['devicedetails']);
        $devicedetails = cleanValidate($devicedetails,'string');        
    }else{
        echo "Error"."`"."Device Description/details is required";
        exit();
    }

    $vendor = cleanValidate($_POST['vendor'],'string');

    if(isset($_POST['vendordetails'])){
        $vendordetails = testInput($_POST['vendordetails']);
        $vendordetails = cleanValidate($vendordetails,'string');
    }else{
        echo "Error"."`"."Vendor Details is required";
        exit();
    }

    if(isset($_POST['purchasedate'])){
        $purchasedate = $_POST['purchasedate'];        
        $pdtraw = explode("-",$purchasedate);
        $purchasedateraw = mktime(0,0,0,$pdtraw[1],$pdtraw[2],$pdtraw[0]);
        $newpurdate = Date("Y-M-d",$purchasedateraw);
    }else{
        echo "Error"."`"."Purchase Date is required";
        exit();
    }

    if(isset($_POST['devicecost'])){
        $devicecost = testInput($_POST['devicecost']);
        $devicecost = cleanValidate($devicecost,'float');
    }else{
        echo "Error"."`"."Device Cost is required!!!";
        exit();
    }

    if(isset($_POST['boughtby'])){
        $boughtby = testInput($_POST['boughtby']);
        $boughtby = cleanValidate($boughtby,'string');
    }else{
        echo "Error"."`"."Name of Buyer is required!!!";
        exit();
    }

    $deviceuser = testInput($_POST['deviceuser']);
    $deviceuser = cleanValidate($deviceuser,'string');
    if(count(explode(' ',$deviceuser))>1){
        $fname = explode(' ',$deviceuser)[0];
        $lname = explode(' ',$deviceuser)[1];
    }else{
        echo "Error"."`"."Device User Full Name is Required";
        exit();
    }

    if(isset($_POST['deviceuserlocation'])){        
        $deviceuserlocation = cleanValidate(testInput($_POST['deviceuserlocation']),'string');
    }else{
        echo "Error"."`"."User Location is Required";
        exit();
    }   

    if(isset($_POST['deviceuserdesignation'])){        
        $deviceuserdesignation = cleanValidate(testInput($_POST['deviceuserdesignation']),'string');
    }else{
        echo "Error"."`"."User Designation/Position is Required";
        exit();
    }

    if(isset($_POST['dateassigned'])){
        $dateassigned = $_POST['dateassigned'];
        $dtasraw = explode("-",$dateassigned);
        $dateassignedraw = mktime(0,0,0,$dtasraw[1],$dtasraw[2],$dtasraw[0]);
    }else{
        echo "Error"."`"."Date Device was assigned to the user is Required";
        exit();
    }

    $deviceid = $devtype.'-'.getuniqueid();
    
    if(isset($_POST['extassetnum'])&&strlen($_POST['extassetnum'])>10){
        $assetnum = cleanValidate(testInput($_POST['extassetnum']),'string');
    }else{
        $assetnum = siteaccr.'-'.$deviceid;
    }   

    $dateaddedraw = time();

    $addedby = $_SESSION['logged-in'];

    $modifiedby = $_SESSION['logged-in'];

    $usertype ='';

    $devicestate = 'New';

    $deviceuserrecord = '';

    $devicedesc = $brand.' '.$model.' '.$ram.' '.$processor.' '.$hdd.' '.$devicedetails;
//  $deviceinfo = $dateassigned.':'.$dateassignedraw.':'.$deviceid.':'.$assetnum.':'.$devicename.':'.$devicedesc;

    $deviceinfo = $deviceid.':'.$assetnum.':'.$devicename.':'.$devicedesc.':'.$devicestate.':'.$dateassigned.':'.$dateassignedraw;

    if(cleanValidate($_POST['deviceuseremail'],'email')){
        $deviceuseremail = $_POST['deviceuseremail'];
        if(itExists('email','assetusers',$deviceuseremail)==0){
            $deviceuserid = getuniqueid(4,3);
            $usertype = 'New';
        //  $deviceuserrecord = $deviceuser.':'.$deviceuseremail.':'.$deviceuserid.':'.$deviceuserdesignation.':'.$deviceuserlocation.':'.$dateassigned.':'.$dateassignedraw;            
            $query1 = "INSERT INTO assetusers(fname,lname,email,userid,recentdesignation,recentlocation,devicerecord,dateaddedraw,addedby,modifiedby) 
            VALUES('$fname','$lname','$deviceuseremail','$deviceuserid','$deviceuserdesignation','$deviceuserlocation','$deviceinfo',$dateaddedraw,'$addedby','$modifiedby')";
        /*
            $query2 = "INSERT INTO asset_users(fname,lname,email,userid,recentdesignation,recentlocation,deviceid,assetnum,devicetype,devicedesc,dateassigned,dateassignedraw,addedby,dateaddedraw,modifiedby) 
            VALUES('$fname','$lname','$deviceuseremail','$deviceuserid','$deviceuserdesignation','$deviceuserlocation','$deviceid','$assetnum','$devicename','$devicedesc','$dateassigned',$dateassignedraw,'$addedby',$dateaddedraw,'$modifiedby')";
        */
        }else{
            $query2a = "SELECT userid FROM assetusers WHERE email='$deviceuseremail'";
            $res2a = mysqli_query($con,$query2a);
            $deviceuserid = mysqli_fetch_array($res2a)[0];
            $usertype = 'Existing';
        //  $deviceuserrecord = $deviceuser.':'.$deviceuseremail.':'.$deviceuserid.':'.$deviceuserdesignation.':'.$deviceuserlocation.':'.$dateassigned.':'.$dateassignedraw;
            $query1 = "UPDATE assetusers SET recentdesignation='$deviceuserdesignation',recentlocation='$deviceuserlocation',modifiedby='$modifiedby',devicerecord=CONCAT_WS('::',devicerecord,'$deviceinfo') WHERE userid='$deviceuserid'";
        /*  
            $query2 = "INSERT INTO asset_users(fname,lname,email,userid,recentdesignation,recentlocation,deviceid,assetnum,devicetype,devicedesc,dateassigned,dateassignedraw,addedby,dateaddedraw,modifiedby)
            VALUES('$fname','$lname','$deviceuseremail','$deviceuserid','$deviceuserdesignation','$deviceuserlocation','$deviceid','$assetnum','$devicename','$devicedesc','$dateassigned',$dateassignedraw,'$addedby',$dateaddedraw,'$modifiedby')";
        */
        }
    }

    $deviceuserrecord = $deviceuser.':'.$deviceuseremail.':'.$deviceuserid.':'.$deviceuserdesignation.':'.$deviceuserlocation.':'.$usertype.':'.$dateassigned.':'.$dateassignedraw;

    $query = "INSERT INTO assets(devicetype,brand,model,serialimei,ram,hdd,processor,otherdesc,assetnum,deviceid,vendor,vendordetails,purchasedate,purchasedateraw,newpurdate,devicecost,boughtby,deviceuserrecord,dateaddedraw,addedby,modifiedby) 
            VALUES ('$devicename','$brand','$model','$serialimei','$ram','$hdd','$processor','$devicedetails','$assetnum','$deviceid','$vendor','$vendordetails','$purchasedate',$purchasedateraw,'$newpurdate',$devicecost,'$boughtby','$deviceuserrecord',$dateaddedraw,'$addedby','$modifiedby')";

    $query2 = "INSERT INTO asset_users(fname,lname,email,userid,recentdesignation,recentlocation,usertype,deviceid,assetnum,devicetype,devicedesc,devicestate,dateassigned,dateassignedraw,addedby,dateaddedraw,modifiedby) 
    VALUES('$fname','$lname','$deviceuseremail','$deviceuserid','$deviceuserdesignation','$deviceuserlocation','$usertype','$deviceid','$assetnum','$devicename','$devicedesc','$devicestate','$dateassigned',$dateassignedraw,'$addedby',$dateaddedraw,'$modifiedby')";

//  $query3 = "INSERT INTO notifications() VALUES()";

    $res = mysqli_query($con,$query);
    $res1 = mysqli_query($con,$query1);
    $res2 = mysqli_query($con,$query2);
//  $res3 = mysqli_query($con,$query3);

    if($res && $res1 && $res2){
        echo "<span style='color:green;'><i class='fa fa-check fa-4x'></i></span> ";
    }else{
        echo "Error"."`"."Some Error occurred while adding Device/User";
        exit();
    }
    mysqli_close($con);
    
}else{
    echo "Error"."`"."Kindly Fill out all required fields";
    exit();
}

?>