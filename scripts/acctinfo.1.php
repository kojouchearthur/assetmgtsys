<?php
require "../assets/conf.php";
require "../assets/assetmgtconf.php";
require "../assets/reuse.php";
require "../lib/plug.php";

if(isset($_REQUEST['uniqueid'])){
    $acct = cleanValidate($_REQUEST['uniqueid'],'string');  
}

$query = "SELECT * FROM users WHERE uniqueid='$acct'";
$result = mysqli_query($con,$query);

if(!$result){
    echo "Unable to fetch Acct Info";
    exit();
}else{
    $acctinfo = mysqli_fetch_assoc($result);

    echo "<h5 style='text-align:center; font-size:12px; font-weight:bold; margin-top:0px;'>Account: <span style='font-weight:normal;'>".ucfirst($acctinfo['fname'])." ".ucfirst($acctinfo['lname'])." (".$acctinfo['email'].")</span>"."</h5>";
    echo "<table id='devinftab' class='table table-responsive table-condensed mod-tab dev-inf' style=''>";
    echo "<tbody style='font-size:12px;'>
    <tr style=''>
        <td style='width:50%;'><span class='inftit' style=''>Username: </span><br>".$acctinfo['username']."</td> 
        <td class=''><span class='inftit' style=''>User ID: </span><br>".$acctinfo['uniqueid']."</td>
    </tr>
    <tr style=''>
        <td><span class='inftit' style=''>Account Type: </span><br>";if($acctinfo['accttype']==0){echo"Standard";}else{echo"Administrator";} echo"</td>
        <td class=''><span class='inftit' style=''>Phone No.: </span><br>".$acctinfo['phone']."</td>
    </tr>";

echo " 
    <tr>
        <td><span class='inftit' style=''>Date Added: </span><br>".Date('D, d-M-Y',$acctinfo['joindateraw'])."</td>
        <td class=''><span class='inftit' style=''>Added By: </span><br>".$acctinfo['addedby']."</td>
    </tr>    
    </tbody>
    </table>";

    $query1 = "SELECT * FROM asset_users WHERE (addedby = '$acct' OR modifiedby='$acct') ORDER BY id";
    $res1 = mysqli_query($con,$query1);

    /*
    $devusers = explode('::',$acctinfo['deviceuserrecord']);
    $curdevuser = $devusers[count($devusers)-1];
    
    $initdevuser = $devusers[0];

    if(count($devusers)==1){
        $devusers = $acctinfo['deviceuserrecord'];
        $initdevuser = $rcntpstdevuser = $curdevuser = $devusers;
    }elseif(count($devusers)==2){
        $rcntpstdevuser = $initdevuser = $devusers[0];
    }elseif(count($devusers)>2){
        $rcntpstdevuser = $devusers[count($devusers)-2];
    }

    $curdevuserdet = explode(':',$curdevuser);
    $rcntpstdevuserdet = explode(':',$rcntpstdevuser);
    $initdevuserdet = explode(':',$initdevuser);
    */

    echo "<h6 style='text-decoration:none;text-align:center;'><strong>Account Activity Summary</strong></h6>";
/*  echo "<table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>
        <tr>
            <td style='width:50%; padding-left:40px;border-top:gray solid 1px;'>
            <span class='inftit' style='display:inline-block;text-indent:0px;'>Current User</span><br><br>
            <span class='inftit'>Name: </span><br>
            <span class='inftit'>Email: </span><br>
            <span class='inftit'>Position: </span><br>
            <span class='inftit'>Location: </span><br>
            <span class='inftit'>Date Assigned: </span><br>
            <span class='inftit'></span>
            </td>
            <td style='border-top:gray solid 1px;'>
            <span></span><br><br>
            <span>".$curdevuserdet[0]."</span><br>
            <span>".$curdevuserdet[1]."</span><br>
            <span>".$curdevuserdet[3]."</span><br>
            <span>".$curdevuserdet[4]."</span><br>
            <span>".Date('D, d-M-Y',$curdevuserdet[6])."</span>
            </td>
        </tr>
        </table> */
        echo "
        <table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>
        <!--<tr style='border-bottom:gray solid 1px'><td style='border-bottom:gray solid 1px'>&nbsp;</td><td style='border-bottom:gray solid 1px'>&nbsp;</td></tr>-->
        <tr style='border-top:gray solid 1px;'>
            <td style='width:50%; border-right:gray solid 1px;border-top:gray solid 1px;line-height:25px;'>
            <span class='inftit' style='display:inline-block;text-indent:5px;'>Latest Activity</span><br>
            <span class='inftit'>Name: </span>".$rcntpstdevuserdet[0]."<br>
            <span class='inftit'>Email: </span>".$rcntpstdevuserdet[1]."<br>
            <span class='inftit'>Position: </span>".$rcntpstdevuserdet[3]."<br>
            <span class='inftit'>Location: </span>".$rcntpstdevuserdet[4]."<br>
            <span class='inftit'>Assigned: </span>".Date('D, d-M-y',$rcntpstdevuserdet[6])."<br>";
            if(isset($rcntpstdevuserdet[8])){
               echo "<span class='inftit'>Returned: </span>".Date('D, d-M-y',$rcntpstdevuserdet[8])."<br>";
            }
        echo "
            </td>
            <td style='border-top:gray solid 1px;line-height:25px;line-height:25px;'>
            <span class='inftit' style='display:inline-block;text-indent:15px;'>First Activity</span><br>
            <span class='inftit'>Name: </span>".$initdevuserdet[0]."<br>
            <span class='inftit'>Email: </span>".$initdevuserdet[1]."<br>
            <span class='inftit'>Position: </span>".$initdevuserdet[3]."<br>
            <span class='inftit'>Location: </span>".$initdevuserdet[4]."<br>
            <span class='inftit'>Assigned: </span>".Date('D, d-M-y',$initdevuserdet[6])."<br>";
            if(isset($initdevuserdet[8])){
               echo "<span class='inftit'>Returned: </span>".Date('D, d-M-y',$initdevuserdet[8])."<br>";
            }
        
        echo "
            </td>
        </tr>
        </table>";
}

?>