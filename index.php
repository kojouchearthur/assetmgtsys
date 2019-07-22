<?php
	session_start();
    require 'assets/conf.php';
    $pagetitle = $home;
    require 'parts/head.php';
	if (isset($_SESSION['logged-in'])){
		header('Location: dashboard.php');
	}
?>
<body>
<noscript><div style='text-align:center;color:red;position:relative;'>Kindly Enable Javascript on this browser</div></noscript>
<div class='container-fluid body-con' id='bbkg'>
  <div class='' id=''> <?php require 'parts/header.php'; ?> </div>
  <div class='row' id=''> </div>
  <div class='row main-con' id='main-con'>
    <div class='col-xs-2 col-sm-2'></div>
	<div class='col-xs-12 col-sm-8' id=''>
        <div class='form-con' id='form-con'>
            <div class='login-form-con' id='login-con'>
                <form class='' id='log-form' action='' method=''>                
                    <div class='' id=''>
                        <h4 class='acct-txt text-center'>Enter Login Credentials</h4>
                        <hr>
                    </div>
                    <div class='frm-chk' id='' style='display:none;'><?php $GLOBALS['mktm']  = mktime(0,0,0,3,31,2014); echo date("Y-m-d h:i",$mktm)."---".mktime($mktm); ?></div>
                    <div class='user-con' id=''>
                        <div class='input-group'>
                            <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                            <input class='form-control' type='text' id='usern' name='usern' required placeholder='Username or Email' autocomplete="on" required/>                            
                        </div>
                        <div class='err' id='usern-err'></div>
                    </div><br>
                    <div class='userp-con'>
                        <div class='input-group'>
                            <span class='input-group-addon'><i class='fa fa-lock'></i></span>
                            <input class='form-control' type='password' id='userp' name='userp' placeholder='Enter Password' autocomplete="on" required />
                        </div>
                        <div class='err' id='userp-err'></div>
                    </div>
                    <div class='' id=''>
                        <span class='tip-txt' id='rem-tip-txt'>Do not check this on a shared computer</span>
                        <div class='input-group'>			  
                            <input class='' id='rem-pass' type='checkbox' /> Remember me <span id='rem-tip' class='tips'><i class='fa fa-info-circle'></i></span>			  
                            <span class='input-group-btn'>
                                <button type='submit' id='log-btn' class='btn btn-success btns' style=''><i class='glyphicon glyphicon-log-in'></i> Sign In </button><br>
                            </span>			  
                        </div>
                    </div><br>
                    <?php
                    if(isset($_SESSION['admin'])){
                        echo "<div class='text-center' id='acct-ft'>
                            <span id='acct-ft1' class='text-center acct'>New Member? Create Account</span> <span class='' id='rPass'></span>
                            </div>";
                    }
                    ?>                   
                </form>
            </div>
        </div>
    </div>
	<div class='col-xs-12 col-sm-2'></div>
  </div>
  <?php include 'parts/footer.php'; ?>