<?php 
  require_once 'assets/conf.php';
  $pagetitle = $home; //Do NOT Edit!!!
  require_once 'parts/head.php';  
?>
<body> <?php //open document body...closing is in footer.php ?>
  <div class="container-fluid body-con" id="bbkg"> <?php //open document content container...closing is in footer.php ?>
    <?php require_once 'parts/header.php'; ?>
	<div class="row">
	</div>
	<div class="row main-con" id="main-con">
	  <div id="home-text" class="col-sm-6 col-md-7">
	  
	  </div>
	  <div id="home-log" class="col-sm-6 col-md-5">
	    <div id="card">
		  <h4><span><i class="fa fa-server"></i></span> Access Area</h4>
		  <hr>
		  <div class="" id="acct-txt">
		    <p id="acct-txt-in">Enter your login details in the form below</p>
		  </div>
		  <div class="acct-form" id="acct-form-con">
	      <div class="form-con front" id="log-form-con">
		    <form class="" id="log-form">
			  <div class="frm-chk" id=""></div>
			  <div id="user-con">
			  <div class="input-group">
			    <span class="input-group-addon"><i class="fa fa-user"></i></span>
			    <input class="form-control" id="usern" name="usern" type="text" placeholder="Username or Email or Phone" required />				
			  </div>
			  <div class="err txt-err" id="usern-err" style=""></div>
			  </div>
			  <div id="userp-con">
			    <span class="tip-txt" id="pass-tip">Click to see password</span>
			    <div class="input-group">
				  <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
				  <input class="form-control" id="userp" name="userp" type="password" placeholder="Password" required />				  
				  <span class="input-group-addon tips nsh" id="pass-show"><i class="fa fa-eye-slash"></i></span>
				</div>
				<div class="err txt-err" id="userp-err"></div>
			  </div>
			  <div>
			    <span class="tip-txt" id="rem-tip-txt">Do not check this on a shared computer</span>
			    <div class="input-group">			  
			      <input class="" id="" type="checkbox" /> Remember me <span id="rem-tip" class="tips"><i class="fa fa-info-circle"></i></span>			  
			      <span class="input-group-btn">
				    <button type="submit" id="log-btn" class="btn btn-success btns" style=""><i class="glyphicon glyphicon-log-in"></i> Sign In </button><br>
			      </span>			  
			    </div>
			  </div>
			  <div class="">
			    
			  </div>
		    </form>
		  </div>		  
		  <div class="form-con back" id="reg-form-con">
		  </div>
		</div><br>
		<div class="text-center" id="acct-ft">
			<span id="acct-ft1" class="text-center acct">New Member? Create Account</span> <span class="" id="rPass"> | Forgot Password</span>
		</div>
		</div>
	  </div>	  
	</div>
	
	<!--Begin Modals-->
	<div class="modals" id="modal-back">
		<div class="" id="modal-con">
			<div class="" id="modal-hs">
				<span id="modal-hd"></span>
				<span id="modal-cls"> <i class="fa fa-times"></i> </span>			  
			</div>			
			<div class="" id="modal-bd">			
			</div>
			<div>
				<div class="" id="modal-ft">			
				</div>
			</div>
		</div>
	</div>
	<!--End Modals-->
	<?php require "parts/footer.php";
	//document div container, body, and html closed by footer.php file
	?>