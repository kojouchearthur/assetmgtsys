<?php
require "../assets/conf.php";
require "../assets/assetmgtconf.php";
require "../assets/reuse.php";
require "../lib/plug.php";

$dev = '';
if(isset($_REQUEST['devasstnum'])){
    $dev = cleanValidate(testInput($_REQUEST['devasstnum']),'string');
}


$query = "SELECT * FROM assets WHERE assetnum='$dev'";
$result = mysqli_query($con,$query);


if(!$result){
    echo "Unable to fetch Device Info";
    die();
}else{
    $devinfo = mysqli_fetch_assoc($result);

    echo "<h5 style='text-align:center; font-size:11px; font-weight:bold; margin-top:0px;'>Device Type: ".strtoupper($devinfo['devicetype'])."</h5>";
    echo "<table id='devinftab' class='table table-responsive table-condensed mod-tab dev-inf' style=''>";
    echo "<tbody style='font-size:12px;'>
    <tr style=''>
        <td style='width:50%;'><span class='inftit' style=''>Brand: </span><br>".$devinfo['brand']."</td>    
        <td class=''><span class='inftit' style=''>Asset No.: </span><br>".$devinfo['assetnum']."</td>
    </tr>
    <tr style=''>
        <td><span class='inftit' style=''>Model: </span><br>".$devinfo['model']."</td>    
        <td class=''><span class='inftit' style=''>Serial No.: </span><br>".$devinfo['serialimei']."</td>
    </tr>
    ";

    if($devinfo['ram']!=='' && $devinfo['ram']!=='N/A'){
        echo "
        <tr>
            <td><span class='inftit'>RAM: </span><span class='right-itm inftit' style='display:inline-block;text-indent:40px;'>HDD: </span><br>".$devinfo['ram']."<span class='right-itm' style='display:inline-block;text-indent:45px;'>".$devinfo['hdd']."</span></td>
            <td><span class='inftit'>Processor: </span><br>".$devinfo['processor']."</td>
        </tr>
        ";
    }

echo "
    <tr>
        <td><span class='inftit'>Other Description:</span></td>
        <td>".$devinfo['otherdesc']."</td>
    </tr>
    <tr>
        <td><span class='inftit' style=''>Date Purchased: </span><br>".Date('D, d-M-Y',$devinfo['purchasedateraw'])."</td>
        <td class=''><span class='inftit' style=''>Device Cost: </span><br> &#8358;".number_format($devinfo['devicecost'],2,'.',',')."</td>
    </tr>
    <tr>
        <td><span class='inftit'>Vendor: </span><br>".$devinfo['vendor']."</td>
        <td><span class='inftit'>Purchased By: </span><br>".$devinfo['boughtby']."</td>
    </tr>
    </tbody>
    </table>";
    $devusers = explode('::',$devinfo['deviceuserrecord']);
    $curdevuser = $devusers[count($devusers)-1];
    
    $initdevuser = $devusers[0];

    if(count($devusers)==1){
        $devusers = $devinfo['deviceuserrecord'];
        $initdevuser = $rcntpstdevuser = $curdevuser = $devusers;
    }elseif(count($devusers)==2){
        $rcntpstdevuser = $initdevuser = $devusers[0];
    }elseif(count($devusers)>2){
        $rcntpstdevuser = $devusers[count($devusers)-2];
    }

    $curdevuserdet = explode(':',$curdevuser);
    $rcntpstdevuserdet = explode(':',$rcntpstdevuser);
    $initdevuserdet = explode(':',$initdevuser);

    echo "<h6 style='text-decoration:none;text-align:center;'><strong>Usage Summary</strong></h6>";
    echo "<table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>
        <tr>
            <td style='width:50%; padding-left:40px;border-top:gray solid 1px;'>
            <span class='inftit' style='display:inline-block;text-indent:0px;'>";if(isset($curdevuserdet[9])){echo "Last User";}else{echo "Current User";}echo"</span><br><br>
            <span class='inftit'>Name: </span><br>
            <span class='inftit'>Email: </span><br>
            <span class='inftit'>Position: </span><br>
            <span class='inftit'>Location: </span><br>
            <span class='inftit'>Date Assigned: </span><br>";
            if(isset($curdevuserdet[9])){
                echo "<span class='inftit'>Date Returned: </span><br>";
            }
            echo "
            <span class='inftit'></span>
            </td>
            <td style='border-top:gray solid 1px;'>
            <span></span><br><br>
            <span>".$curdevuserdet[0]."</span><br>
            <span>".$curdevuserdet[1]."</span><br>
            <span>".$curdevuserdet[3]."</span><br>
            <span>".$curdevuserdet[4]."</span><br>
            <span>".Date('D, d-M-Y',$curdevuserdet[7])."</span><br>";
            if(isset($curdevuserdet[9])){
                echo "<span>".Date('D, d-M-Y',$curdevuserdet[9])."</span>";
            }
            echo "</td>
        </tr></table>
        <table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>
        <!--<tr style='border-bottom:gray solid 1px'><td style='border-bottom:gray solid 1px'>&nbsp;</td><td style='border-bottom:gray solid 1px'>&nbsp;</td></tr>-->
        <tr style='border-top:gray solid 1px;'>
            <td style='width:50%; border-right:gray solid 1px;border-top:gray solid 1px;line-height:25px;'>
            <span class='inftit' style='display:inline-block;text-indent:5px;'>Recent Past User</span><br>
            <span class='inftit'>Name: </span>".$rcntpstdevuserdet[0]."<br>
            <span class='inftit'>Email: </span>".$rcntpstdevuserdet[1]."<br>
            <span class='inftit'>Position: </span>".$rcntpstdevuserdet[3]."<br>
            <span class='inftit'>Location: </span>".$rcntpstdevuserdet[4]."<br>
            <span class='inftit'>Assigned: </span>".Date('D, d-M-y',$rcntpstdevuserdet[7])."<br>";
            if(isset($rcntpstdevuserdet[9])){
               echo "<span class='inftit'>Returned: </span>".Date('D, d-M-y',$rcntpstdevuserdet[9])."<br>";
            }
        echo "
            </td>
            <td style='border-top:gray solid 1px;line-height:25px;line-height:25px;'>
            <span class='inftit' style='display:inline-block;text-indent:15px;'>Initial User</span><br>
            <span class='inftit'>Name: </span>".$initdevuserdet[0]."<br>
            <span class='inftit'>Email: </span>".$initdevuserdet[1]."<br>
            <span class='inftit'>Position: </span>".$initdevuserdet[3]."<br>
            <span class='inftit'>Location: </span>".$initdevuserdet[4]."<br>
            <span class='inftit'>Assigned: </span>".Date('D, d-M-y',$initdevuserdet[7])."<br>";
            if(isset($initdevuserdet[9])){
               echo "<span class='inftit'>Returned: </span>".Date('D, d-M-y',$initdevuserdet[9])."<br>";
            }
        
        echo"
            </td>
        </tr>
        </table>";
}



?>