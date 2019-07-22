<?php
    session_start();
    if($_SESSION['logged-in']!=='superadmin' && $_SESSION['logged-in'] !== 'admin'){
        echo "<script>alert('Access Denied!!!')</script>";
        header("Location: dashboard.php");
    }elseif(!isset($_SESSION['logged-in'])){
        header("Location: index.php");
    }

    require 'assets/conf.php';
    $pagetitle = $signup;
    require 'parts/head.php';
?>
<body>
<noscript><div style="color:red;text-align:center;position:relative;">Kindly enable Javascript on this browser</div></noscript>
<div class="container-fluid body-con" id="bbkg">
  <div class="" id=""> <?php require 'parts/header.php'; ?> </div>
  <div class="row" id=""> </div>
  <div class="row main-con" id="main-con">
    <div class="col-sm-12" id="">
        <div class="form-con" id="form-con">
            <div class="signup-form-con" id="signup-con">
                <form class="" id="signup-form" action="" method="">
                    <div id="" class="">
                        <div class="frm-hd" id="">
                            <h4 class="acct-txt text-center">Enter Your Credentials</h4>
                            <hr>
                        </div>
                        <div class="frm-chk" id=""></div>
                        <div class="user-con" id="">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input class="form-control names" type="text" id="names" name="names" required placeholder="Your Name"/>                            
                            </div>
                            <div class="err txt-err" id="names-err"></div>
                        </div><br>
                        <div class="email-con" id="">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input class="form-control" type="email" id="email" name="email" required placeholder="Your Email"/>                            
                            </div>
                            <div class="err txt-err" id="email-err"></div>
                        </div><br>
                        <div class="phone-con">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input class="form-control" type="tel" id="phone" name="phone" placeholder="Enter Phone (Optional)" />
                            </div>
                            <div class="err txt-err" id="phone-err"></div>
                        </div><br>
                        <div class="pass-con">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input class="form-control" type="password" id="pass" name="pass" placeholder="Enter Password" required />                            
                            </div>
                            <div class="txt-err err" id="pass-err"></div>
                        </div><br>
                        <div class="pass-conf-con">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input class="form-control re-type" type="password" id="pass-conf" name="pass-conf" placeholder="Enter Password" required />                            
                            </div>
                            <div class="txt-err err" id="pass-conf-err"></div>
                        </div>
                        <div class="" id="">
                            <span class="tip-txt" id="rem-tip-txt">Do not check this on a shared computer</span>
                            <div class="input-group">			  
                                <input class="" id="rem-pass" type="checkbox" /> Remember me <span id="rem-tip" class="tips"><i class="fa fa-info-circle"></i></span>			  
                                <span class="input-group-btn">
                                    <button type="submit" id="crtBtn" class="btn btn-success btns" style=""> Create Account <i class="fa fa-user-plus"></i></button><br>
                                </span>			  
                            </div>
                        </div><br>
                        <!--
                        <div class="text-center" id="acct-ft">
                            <span id="acct-ft1" class="text-center acct">New Member? Create Account</span> <span class="" id="rPass"></span>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
  <?php include 'parts/footer.php'; ?>