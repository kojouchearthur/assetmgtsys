<?php
    session_start();
    require '../assets/conf.php';
    require '../assets/assetmgtconf.php';
    require "../assets/reuse.php";
    require "../lib/plug.php";

    $pagetitle = $adasst;
        
    if(!isset($_SESSION['logged-in'])){
        header('Location: index.php');
    }

    require '../parts/head.php';
?>
<style>
    .frm-label{
        font-size:12px;
        font-weight:normal;
        margin-bottom:0px;
    }
</style>
<!--Section-->
<body>
    <!--Section-->
<noscript><div style='text-align:center;color:red;position:relative;'>Kindly Enable Javascript on this browser</div></noscript>
    <!--Section-->
    <div class='container-fluid body-con other-bod' id='bbkg'>
    <!--Section-->
    <?php require '../parts/header.php'; ?>
        <!--Section-->
        <div class='row' id=''></div>
        <div class='row main-con' id=''>
            <div class='col-sm-1 col-md-2' id=''></div>
            <div class='col-sm-10 col-md-8' id=''>
                <!--Section-->
                <?php    
                    $dev = cleanValidate($_REQUEST['devasstnum'],'string');

                    $query = "SELECT * FROM assets WHERE assetnum='$dev'";
                    $result = mysqli_query($con,$query);

                    if(!$result){
                        echo "Unable to fetch Device Info";
                        exit();
                    }else{
                        $devinfo = mysqli_fetch_assoc($result);
                        $devcond = '';
                        $devstock = '';
                        $devretstat = '';

                        if($devinfo['healthy']==0){
                            $devcond = 'faulty';
                        }else{
                            $devcond = 'working';
                        }

                        if($devinfo['sold']==1){
                            $devstock = 'sold';
                            $devretstat = 'disabled';
                        }else{
                            $devstock = 'unsold';
                            $devretstat = '';
                        }

                        if($devinfo['assigned']==0 && $devinfo['sold']==1){
                            $devretstat = 'disabled';
                        }elseif($devinfo['assigned']==0){
                            $devretstat = '';
                        }else{
                            $devretstat = 'disabled';
                        }

                        echo "<br><h5 style='text-align:center; font-size:11px; font-weight:bold; margin-top:0px;'>Device Type: ".strtoupper($devinfo['devicetype'])."</h5>";
                        echo "<div class='' id='' style='margin: 0 auto;max-width:500px;'>
                        <table id='devinftab' class='table table-responsive table-condensed mod-tab dev-inf' style=''>";
                        echo "<tbody style='font-size:12px;'>
                        <tr style=''>
                            <td style='width:50%;'><span class='inftit' style=''>Brand: </span><br>".$devinfo['brand']."</td>
                            <td class=''><span class='inftit' style=''>Asset No.: </span><br><span id='devasstnum'>".$devinfo['assetnum']."</span></td>
                        </tr>
                        <tr style=''>
                            <td><span class='inftit' style=''>Model: </span><br>".$devinfo['model']."</td>    
                            <td class=''><span class='inftit' style=''>Serial No.: </span><br>".$devinfo['serialimei']."</td>
                        </tr>";

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
                        <tr><td colspan=2><br></td></tr>
                        <tr>
                            <td style='text-align:center;' colspan=2><span class='inftit' style='text-decoration:underline;'>Device Status (Returned Devices ONLY)</span></td>
                        </tr>
                        <tr>
                        <td style='text-align:right;font-size:14px;'>
                            <span class='inftit'><i class='fas fa-wrench'></i> Faulty: </span>
                        </td>
                        <td style='font-weight:bold;'>
                            <button class='btn btn-default btn-sm' type='button' style='font-size:12px;' id='devcond' data-devstat='".$devcond."' ".$devretstat.">
                                 No <span id='devcondtog' style='font-size:13px;color:";if($devcond=='faulty'){echo "red;' class='on'><i class='fa fa-toggle-on'>";}else{echo "gray;' class='off'><i class='fa fa-toggle-off'>";}echo"</i></span> Yes 
                            </button>&nbsp;<span class='ams-busy' style=''><i class='fa fa-cog fa-spin' style='font-size:16px;'></i></span>
                        </td>
                        </tr>
                        <tr>
                        <td style='text-align:right;font-size:14px;'>
                            <span class='inftit'><i class='fas fa-handshake'></i> Sold: </span>
                        </td>
                        <td style='font-weight:bold;'>
                            <button class='btn btn-default btn-sm' type='button' style='font-size:12px;' id='devstock' data-devstat='".$devstock."' ".$devretstat.">
                                 No <span id='devstocktog' style='font-size:13px;color:";if($devstock=='sold'){echo "teal;' class='on'><i class='fa fa-toggle-on'>";}else{echo "gray;' class='off'><i class='fa fa-toggle-off'>";}echo"</i></span> Yes 
                            </button>&nbsp;<span class='ams-busy' style=''><i class='fa fa-cog fa-spin' style='font-size:16px;'></i></span>
                        </td>
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
                            <tr style=''>
                                <td style='width:50%;border-top:gray solid 1px;line-height:30px;'>";
                                if(isset($curdevuserdet[8])){
                                    echo "<span class='inftit' id='devusertit' style='display:inline-block;text-indent:0px;'>Last User</span><br>";
                                }else{
                                    echo "<span class='inftit' id='devusertit' style='display:inline-block;text-indent:0px;'>Current User</span><br>";
                                }                                
                            echo"    
                                <span class='inftit'>Name: </span><br>
                                <span class='inftit'>Email: </span><br>
                                <span class='inftit'>Position: </span><br>
                                <span class='inftit'>Location: </span><br>
                                <span class='inftit'>Date Assigned: </span><br>
                                <span class= 'inftit'>Date Returned: </span>
                                </td>";

                                echo"                                
                                <td style='border-top:gray solid 1px;line-height:30px;'>
                                <span></span><br>
                                <span id='devusername'>".$curdevuserdet[0]."</span><br>
                                <span id='devuseremail'>".$curdevuserdet[1]."</span><br>
                                <span id='devuserdesignation'>".$curdevuserdet[3]."</span><br>
                                <span id='devuserlocation'>".$curdevuserdet[4]."</span><br>
                                <span id='devdateassigned'>".Date('D, d-M-Y',$curdevuserdet[7])."</span><br>";
                                if(isset($curdevuserdet[9])){
                                    echo "<div id='retdat'>".Date('D, d-M-Y',$curdevuserdet[9])."</div>";
                                }else{
                                    echo "
                                    <div class='' id='retdat'>
                                        <div class='input-group input-group-sm' id=''>
                                            <span class='input-group-addon'><i class='fa fa-calendar'></i></span>
                                            <input type='date' class='form-control' placeholder='' id='retdevval' min='".Date('Y-m-d',$curdevuserdet[7])."' max='".Date('Y-m-d',time())."' value='".Date('Y-m-d',time())."'>
                                            <div class='input-group-btn'><button type='button' id='retdev' class='btn btn-success btn-xs' disabled><i class='fa fa-check'></i></button></div>
                                        </div>
                                    </div>";
                                }
                                echo "
                                </td>
                            </tr>";
                            echo "</table>
                            <div class='err txt-err' id='updt'></div>";
                    }
                ?>

                <div class='form-con' id='adasst-form-con-con'>
                    <div class='adasst-form-con' id='adasst-form-con'>
                        <form class='' id='reasgnasst-form' method='' action=''>
                            <div class='formcontents' id=''>
                                <!--
                                <div class='frm-hd' id=''>
                                    <h4 class='text-center'>Enter Device Details</h4>
                                    <hr>
                                </div>
                                -->
                                <div class='frm-chk' id=''></div>                                
                                    <fieldset id='reasgncontents' class='' <?php if($devinfo['assigned']==1 || $devinfo['healthy']==0 || $devinfo['sold']==1){echo 'disabled';}else{echo '';} ?>>
                                        <legend style='font-size: 16px;'>New Device User</legend>
                                        <div class='' id=''>
                                            <div class='' id='asst-user-con'>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'><i class='fa fa-user'></i></span>
                                                    <input type='text' class='form-control names' id='asst-user' name='deviceuser' placeholder='Device User' required />
                                                </div>
                                                <div class='err text-err'></div>
                                            </div>
                                            
                                            <div class='' id='asst-userdesignation-con'>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'><i class='fa fa-briefcase'></i></span>
                                                    <input type='text' class='form-control' id='asst-userdesignation' name='deviceuserdesignation' placeholder='Enter User Designation, e.g GHR, Head Audit, Accountant, etc' required />
                                                </div>
                                                <div class='err text-err'></div>
                                            </div>
                                            <div class='' id='email-con'>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'><i class='fa fa-envelope'></i></span>
                                                    <input type='email' class='form-control' id='asst-useremail' name='deviceuseremail' placeholder='Enter User Email Address' required />
                                                </div>
                                                <div class='err text-err'></div>
                                            </div>
                                            <div class='' id='asst-userlocation-con'>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'><i class='fa fa-map-marker'></i>&nbsp;</span>
                                                    <input type='text' list='userlocation' class='form-control' id='asst-userlocation' name='deviceuserlocation' placeholder='Enter User Location' required />
                                                </div>
                                                <div class='err text-err'></div>
                                                <datalist id='userlocation'>
                                                    <option value='Lagos (H/O)'>
                                                    <option value='Oghara'>
                                                    <option value='PHC'>
                                                </datalist>
                                            </div>
                                            <div class='' id='assigned-date-con'>
                                                <label class='frm-label'>Date Assigned: </label>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'><i class='fa fa-calendar-alt'></i></span>
                                                    <input type='date' class='form-control' id='assigned-date' name='dateassigned' placeholder='Enter Date User received Device' min='<?php if(isset($curdevuserdet[9])){echo date('Y-m-d',$curdevuserdet[9]);}else{echo date('Y-m-d',$curdevuserdet[7]);} ?>' max='<?php echo date("Y-m-d"); ?>' value='<?php echo date("Y-m-d"); ?>' required/>
                                                </div>
                                                <div class='err text-err'></div>
                                            </div>
                                            <div class='' id='assetnum-con'>
                                                <label class='frm-label'>Asset Number: </label>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'><i class='fa fa-stamp'></i></span>
                                                    <input type='text' class='form-control' id='assetnum' name='assetnum' placeholder='Enter Asset Number, if any' value='<?php echo $devinfo['assetnum']; ?>' disabled />
                                                </div>
                                                <div class='err text-err'></div>
                                            </div>
                                        </div>
                                    </fieldset><br>
                                    <?php
                                    // if(isset($curdevuserdet[8])&&($devinfo['healthy']==1)&&($devinfo['sold']==0)){
                                        echo "
                                        <div class='' id=''>
                                            <div class='input-group'>
                                                <span class='input-group-btn' id='crtbtn-con'>
                                                    <button type='submit' id='crtBtn' class='btn btn-success btns btn-block'"; if($devinfo['assigned']==1 || $devinfo['healthy']==0 || $devinfo['sold']==1){echo 'disabled';}else{echo '';} echo" style='background:navy;float:right; font-size:3 em;'><i class='fa fa-folder-plus'></i> ReAssign Device </button><br>
                                                </span>
                                            </div>
                                        </div>";
                                   /*  }else{
                                        echo "
                                        <div class='' id=''>
                                            <div class='input-group'>
                                                <span class='input-group-btn' id='crtbtn-con'>
                                                    <div type='submit' id='crtBtn' class='btn btn-danger btns btn-block' style='background:;float:right; font-size:3 em;' disabled><i class='fas fa-exclamation-triangle'></i> Cannot reAssign Device </div><br>
                                                </span>
                                            </div>
                                        </div>";
                                    } */
                                    ?>
                                
                            </div>
                        </form><br>
                    </div>
                </div><br>
            </div>
            <script>
                /* if(document.getElementsByClassName('dsbl')){
                    for(var i=0;i<document.getElementsByClassName('dsbl').length;i++){
                        document.getElementsByClassName('dsbl')[i].setAttribute('disabled','');
                    }                    
                } */
                
            // document.getElementById('reasgnasst-form');
            // $('#reasgnasst-form input,:submit').attr('disabled',);
            </script>
            </div>
            <!--Section-->
            <div class='col-sm-1 col-md-2' id=''></div>
        </div>
    <!--Section-->
    <?php require '../parts/footer.php'; ?>