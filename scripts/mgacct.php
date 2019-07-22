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
                    if(isset($_REQUEST['uniqueid'])){
                        $useracct = cleanValidate($_REQUEST['uniqueid'],'string');
                    }

                    $query = "SELECT * FROM users WHERE uniqueid='$useracct'";
                    $result = mysqli_query($con,$query);

                    if(!$result){
                        echo "Unable to fetch Account Info";
                        exit();
                    }else{
                        $acctinfo = mysqli_fetch_assoc($result);
                        $acctstate = '';
                        if($acctinfo['blocked']==0){
                            $acctstate = 'Active';
                        }else{
                            $acctstate = 'Blocked';
                        }

                        echo "<br><h5 style='text-align:center; font-size:12px; font-weight:bold; margin-top:0px;'>Account: <span style='font-weight:normal;'>".ucfirst($acctinfo['fname'])." ".ucfirst($acctinfo['lname'])." (".$acctinfo['email'].")</span>";
                            if(($_SESSION['logged-in']=='admin' || $_SESSION['logged-in']=='superadmin') && ($acctinfo['accttype']==0)){
                                echo "<span class='' id='' style='margin-top:-10px;float: right;'><span class='ams-busy' style=''><i class='fa fa-cog fa-spin' style='font-size:16px;'></i></span> &nbsp;<button id='acctstate' class='btn btn-sm ";if($acctstate=='Active'){echo "btn-success";}else{echo "btn-default";}echo"' data-state='".$acctstate."'><i class='fa ";if($acctstate=='Active'){echo "fa-toggle-on";}else{echo "fa-toggle-off";} echo"' style='font-size:14px;'></i> ".$acctstate." </button>&emsp;</span>";
                            }
                        echo"</h5>";
                        echo "<div class='' id='' style='margin: 0 auto;max-width:500px;'>
                        <table id='devinftab' class='table table-responsive table-condensed mod-tab dev-inf' style=''>";
                        echo "<tbody style='font-size:12px;'>
                        <tr style=''>
                            <td style='width:50%;'><span class='inftit' style=''>Username: </span><br>".$acctinfo['username']."<span class=''><input class='acctuniquenum' id='' type='hidden' value='".$acctinfo['uniqueid']."' /></span></td>
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
                        </table>";
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
                        /*
                        echo "<br><h6 style='text-decoration:none;text-align:center;'><strong>Account Activity Summary</strong></h6>";
                         
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
                                <span id='devdateassigned'>".Date('D, d-M-Y',$curdevuserdet[6])."</span><br>";
                                if(isset($curdevuserdet[8])){
                                    echo "<div id='retdat'>".Date('D, d-M-Y',$curdevuserdet[8])."</div>";
                                }else{
                                    echo "
                                    <div class='' id='retdat'>
                                        <div class='input-group input-group-sm' id=''>
                                            <span class='input-group-addon'><i class='fa fa-calendar'></i></span>
                                            <input type='date' class='form-control' placeholder='' id='retdevval' min='".Date('Y-m-d',$curdevuserdet[6])."' max='".Date('Y-m-d',time())."' value='".Date('Y-m-d',time())."'>
                                            <div class='input-group-btn'><button type='button' id='retdev' class='btn btn-success btn-xs' disabled><i class='fa fa-check'></i></button></div>
                                        </div>
                                    </div>";
                                }
                                echo"
                                </td>
                            </tr></table>";
                            */
                            echo "
                            <div class='err txt-err' id='updt'></div>
                            <br>
                            ";
                    }
                ?>

            <?php
                if($_SESSION['logged-in']=='superadmin' || $_SESSION['logged-in']=='admin'){
                    echo"
                        <div class='form-con' id='adasst-form-con-con'>
                            <div class='adasst-form-con' id='adasst-form-con'>
                                <form class='' id='chgpwd-form' method='' action=''>
                                    <div class='formcontents' id=''>
                                        <div class='frm-chk' id=''></div>
                                        <fieldset>
                                            <legend style='font-size: 16px;'>Change Account Password</legend>
                                            <div class='' id=''>                                           
                                                <div class='' id='newpass-con'>
                                                    <label class='frm-label'>New Password: </label>
                                                    <div class='input-group'>
                                                        <span class='input-group-addon'><i class='fa fa-lock'></i></span>
                                                        <input type='password' class='form-control' id='newpwd' name='newpwd' placeholder='Enter New Password' autocomplete='on' required/>
                                                    </div>
                                                    <div class='err text-err'></div>
                                                </div>
                                                <div class='' id='confnewpass-con'>
                                                    <label class='frm-label'>Re-type Password: </label>
                                                    <div class='input-group'>
                                                        <span class='input-group-addon'><i class='fa fa-lock'></i></span>
                                                        <input type='password' class='form-control re-type' id='confnewpwd' name='confnewpwd' placeholder='Re-type New Password' autocomplete required/>
                                                    </div>
                                                    <div class='err text-err'></div>
                                                </div>
                                            </div>
                                        </fieldset><br>                                   
                                        <div class='' id=''>
                                            <div class='input-group'>
                                                <span class='input-group-btn' id='crtbtn-con'>
                                                    <button type='submit' id='crtBtn' class='btn btn-success btns btn-block' style='background:green;float:right; font-size:3 em;'><i class='fa fa-check'></i> Change Password </button><br>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form><br>
                            </div>
                        </div><br>
                    ";
                }elseif($_SESSION['logged-in'] == $acctinfo['username']){
                    echo "
                        <div class='form-con' id='adasst-form-con-con'>
                            <div class='adasst-form-con' id='adasst-form-con'>
                                <form class='' id='chgpwd-form' method='' action=''>
                                    <div class='formcontents' id=''>
                                        <div class='frm-chk' id=''></div>                             
                                        <fieldset>
                                            <legend style='font-size: 16px;'>Change Your Password</legend>
                                            <div class='' id=''>                                           
                                                <div class='' id='newpass-con'>
                                                    <label class='frm-label'>New Password: </label>
                                                    <div class='input-group'>
                                                        <span class='input-group-addon'><i class='fa fa-lock'></i></span>
                                                        <input type='password' class='form-control' id='newpwd' name='newpwd' placeholder='Enter New Password' autocomplete='on' required/>
                                                    </div>
                                                    <div class='err text-err'></div>
                                                </div>
                                                <div class='' id='confnewpass-con'>
                                                    <label class='frm-label'>Re-type Password: </label>
                                                    <div class='input-group'>
                                                        <span class='input-group-addon'><i class='fa fa-lock'></i></span>
                                                        <input type='password' class='form-control re-type' id='confnewpwd' name='confnewpwd' placeholder='Re-type New Password' autocomplete required/>
                                                    </div>
                                                    <div class='err text-err'></div>
                                                </div>
                                            </div>
                                        </fieldset><br>                                   
                                        <div class='' id=''>
                                            <div class='input-group'>
                                                <span class='input-group-btn' id='crtbtn-con'>
                                                    <button type='submit' id='crtBtn' class='btn btn-success btns btn-block' style='background:green;float:right; font-size:3 em;'><i class='fa fa-check'></i> Change Password </button><br>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form><br>
                            </div>
                        </div><br>
                    ";
                }
            ?>
                
            </div>
            </div>
            <!--Section-->
            <div class='col-sm-1 col-md-2' id=''></div>
        </div>
    <!--Section-->
    <?php require '../parts/footer.php'; ?>