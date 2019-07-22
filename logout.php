<?php
	session_start();
	
	session_destroy();

	require_once("assets/conf.php");
	require_once("assets/assetmgtconf.php");
	require_once("parts/head.php");
	
	echo "<body><script>document.write('<div style=\"text-align:center;background-color:white;color:#002;font-size:15px;font-family:Arial;height:100%;width:100%;\"><br><span><i class=\"fas fa-thumbs-up fa-3x\"></i></span><br>You have logged out successfully!!!</div>');
	setTimeout(function(){location.href = 'index.php';},2500);</script></body>";
//	header("Location: index.php");
?>