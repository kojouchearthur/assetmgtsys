<?php
session_start();

require "../assets/conf.php";
require "../assets/assetmgtconf.php";
require "../assets/reuse.php";
require "../lib/plug.php";

$acct = '';
if(isset($_REQUEST['uniqueid'])){
    $acct = cleanValidate($_REQUEST['uniqueid'],'string');
}

$query = "SELECT * FROM users WHERE uniqueid='$acct'";
$result = mysqli_query($con,$query);

if(!$result){
    echo "Unable to fetch Account Info";
    exit();
}else{
    $acctinfo = mysqli_fetch_assoc($result);
    $acctusern = $acctinfo['username'];
    $acctstate = '';
    if($acctinfo['blocked']==0){
        $acctstate = 'Active';
    }else{
        $acctstate = 'Blocked';
    }

    echo "<br><h5 style='text-align:center; font-size:12px; font-weight:bold; margin-top:0px;'>Account: <span style='font-weight:normal;'>".ucfirst($acctinfo['fname'])." ".ucfirst($acctinfo['lname'])." (".$acctinfo['email'].")</span>";
            if(($_SESSION['logged-in']=='admin' || $_SESSION['logged-in']=='superadmin') && ($acctinfo['accttype']==0)){
                echo "<span class='' id='' style='margin-top:-10px;float: right;'><span class='ams-busy' style='display:none;'><i class='fa fa-cog fa-spin' style='font-size:16px;'></i></span> &nbsp;<button id='acctstate' class='btn btn-sm ";if($acctstate=='Active'){echo "btn-success";}else{echo "btn-default";}echo"' data-state='".$acctstate."'><i class='fa ";if($acctstate=='Active'){echo "fa-toggle-on";}else{echo "fa-toggle-off";} echo"' style='font-size:14px;'></i> ".$acctstate." </button>&emsp;</span>";
            }
        echo"</h5>";
        echo "<div class='' id='' style='margin: 0 auto;max-width:500px;'>
        <table id='devinftab' class='table table-responsive table-condensed mod-tab dev-inf' style=''>";
        echo "<tbody style='font-size:12px;'>
        <tr style=''>
            <td style='width:50%;'><span class='inftit' style=''>Username: </span><br>".$acctinfo['username']."</td>    
            <td class=''><span class='inftit' style=''>User ID: </span><br><span id='itemuniquenum'>";if($_SESSION['logged-in']=='admin' || $_SESSION['logged-in']=='superadmin'){echo $acctinfo['uniqueid'];}else{echo "**********";}echo"</span></td>
        </tr>
        <tr style=''>
            <td><span class='inftit' style=''>Account Type: </span><br>";if($acctinfo['accttype']==0){echo "Standard";}else{echo "Administrator";}echo "</td>
            <td class=''><span class='inftit' style=''>Phone No.: </span><br>".$acctinfo['phone']."</td>
        </tr>";

    echo "
        <tr>
            <td><span class='inftit' style=''>Date Added: </span><br>".Date('D, d-M-Y',$acctinfo['joindateraw'])."</td>
            <td class=''><span class='inftit' style=''>Created By: </span><br>".$acctinfo['addedby']."</td>
        </tr>                        
        </tbody>
        </table></div>";
//    $devusers = explode('::',$acctinfo['deviceuserrecord']);
    $query1 = "SELECT * FROM asset_users WHERE(addedby='$acctusern' OR modifiedby='$acctusern') ORDER BY updatetrack DESC";
    $res1 = mysqli_query($con,$query1);
    $numacty = mysqli_num_rows($res1);
//    $acctacty = mysqli_fetch_assoc($res1);

    echo "<h6 style='text-decoration:none;text-align:center;'><strong>Account Activity</strong></h6>
    <div class='' id='' style='margin:0 auto;max-width:500px;'>
    <table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>";
    
    if($res1){
        if($numacty==0){
            echo "<tr style='text-align:center;'><td>No Activity by this account yet.</td></tr>";
        }
        $i = 0;
        while(($acctacty=mysqli_fetch_assoc($res1))!==null){
        //$acctacty = explode(':',$devusers[$i]);        
        
        echo"<tr>
            <td style='width:50%;border-top:gray solid 1px;'>
            <span class='inftit' style='display:inline-block;text-align:center;'>Account Activity</span><br>
            <span class='inftit'>Device Type: </span><br>
            <span class='inftit'>Asset No.: </span><br>
            <span class='inftit'>Type: </span><br>
            <span class='inftit'>User: </span><br>
            <span class='inftit'>Email: </span><br>
            <span class='inftit'>Position: </span><br>
            <span class='inftit'>Location: </span><br>
            <span class='inftit'>Date Assigned: </span><br>";
            if($acctacty['datereturnedraw']!=0){
                echo "<span class='inftit'>Date Returned: </span><br>";
            }
        echo"<span class='inftit'>Device Details: </span><br>
            </td>
            <td style='border-top:gray solid 1px;'>
            <span></span><br>
            <span>".strtoupper($acctacty['devicetype'])."</span><br>
            <span>".$acctacty['assetnum']."</span><br>
            <span>";if($acctacty['devicestate']=='New'){echo "Fresh Assign";}else{echo "ReAssign";}echo"</span><br>
            <span>".ucfirst($acctacty['fname'])." ".ucfirst($acctacty['lname'])."</span><br>
            <span>".$acctacty['email']."</span><br>
            <span>".$acctacty['recentdesignation']."</span><br>
            <span>".$acctacty['recentlocation']."</span><br>
            <span>".Date('D, d-M-Y',$acctacty['dateassignedraw'])."</span><br>";
            if($acctacty['datereturnedraw']!=0){
                echo Date('D, d-M-y',$acctacty['datereturnedraw'])."<br>";
            }
        echo"<span>".$acctacty['devicedesc']."</span><br>
        </td>
        </tr>";
        $i++;
        }
    }else{
        echo "<tr style='text-align:center;'><td>Unable to fetch Account Activity, try again soon.</td></tr>";
    }
    
    echo"
    </table></div>";
}



?>