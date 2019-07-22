<?php
require "../assets/conf.php";
require "../assets/assetmgtconf.php";
require "../assets/reuse.php";
require "../lib/plug.php";

$dev = '';

if(isset($_REQUEST['devasstnum'])){
    $dev = $_REQUEST['devasstnum'];
}

$query = "SELECT * FROM assets WHERE assetnum='$dev'";
$result = mysqli_query($con,$query);


if(!$result){
    echo "Unable to fetch Device Info";
    die();
}else{
    $devinfo = mysqli_fetch_assoc($result);

    echo "<br><h5 style='text-align:center; font-size:11px; font-weight:bold; margin-top:0px;'>Device Type: ".strtoupper($devinfo['devicetype'])."</h5>";
    echo "<div class='' id='' style='margin:0 auto;max-width:500px;'>
    <table id='devinftab' class='table table-responsive table-condensed mod-tab dev-inf' style=''>";
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
    </table></div>";
    $devusers = explode('::',$devinfo['deviceuserrecord']);

    echo "<h6 style='text-decoration:none;text-align:center;'><strong>Usage Details</strong></h6>
    <div class='' id='' style='margin:0 auto;max-width:500px;'>
    <table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>";
    $i = 0;
    while(count($devusers)>$i){
        $devuserdet = explode(':',$devusers[$i]);

        echo"<tr>
            <td style='width:50%;border-top:gray solid 1px;'>
            <span class='inftit' style='display:inline-block;text-indent:0px;'>User Details</span><br>
            <span class='inftit'>Name: </span><br>
            <span class='inftit'>Email: </span><br>
            <span class='inftit'>Position: </span><br>
            <span class='inftit'>Location: </span><br>
            <span class='inftit'>Date Assigned: </span><br>";
            if(isset($devuserdet[9])){
                echo "<span class='inftit'>Date Returned: </span><br><br>";
            }
        echo"</td>
            <td style='border-top:gray solid 1px;'>
            <span></span><br>
            <span>".$devuserdet[0]."</span><br>
            <span>".$devuserdet[1]."</span><br>
            <span>".$devuserdet[3]."</span><br>
            <span>".$devuserdet[4]."</span><br>
            <span>".Date('D, d-M-Y',$devuserdet[7])."</span><br>";
            if(isset($devuserdet[9])){
                echo Date('D, d-M-y',$devuserdet[9])."<br><br>";
            }
        echo"</td>
        </tr>";
        $i++;
    }
    echo"
    </table></div>";
}



?>