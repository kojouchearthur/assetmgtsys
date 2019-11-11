<?php 
	session_start();
    require '../lib/plug.php';
    if(isset($_POST['usern']) && isset($_POST['userp'])){
        trim($_POST['usern']);
        trim($_POST['userp']);
        if((filter_var($_POST['usern'], FILTER_SANITIZE_STRING)) || (filter_var($_POST['usern'], FILTER_SANITIZE_EMAIL))){
            $usern = $_POST['usern'];
        }
        if(filter_var($_POST['userp'], FILTER_SANITIZE_STRING)){
            $userp = md5($_POST['userp']);
        }
    }else{
        echo "Enter Email/Password";
        exit();
    }

    $query = "SELECT * FROM users WHERE (username='$usern' OR email='$usern') AND password='$userp'";
    $result = mysqli_query($con,$query);    

    if($result){
        $row = mysqli_num_rows($result);
        if($row==1){
        //  echo 'Good Login'.'`';
        //  echo '<i class="fa fa-check fa-3x"></i><br>Logged In Successfully'.'`';
            $user = mysqli_fetch_assoc($result);
            if($user['blocked']==0){
                $_SESSION['logged-in']= $user['username'];
            //	echo 'location.href="profile.php"';
                header("Location: ../dashboard.php");
            }else{
                echo 'Error'.'`'.'<i class="fa fa-exclamation-triangle fa-3x"></i><br>Account Blocked<br>Contact System Administrator!!!';
                exit();
            }            
        }else{
            echo 'Error Bad Login'.'`';
            echo '<i class="fa fa-times fa-3x"></i><br>Check Login Details!!!';
            exit();
        }
    } else{
        echo 'Unknown Error'.'`';
        echo '<i class="fa fa-times fa-3x"></i><br><span style="font-size:13px;">Connection Error...<em>It\'s on us, not you!</em></span>';
        exit();
    }
    mysqli_close($con);
?>