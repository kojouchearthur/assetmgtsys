<?php
    session_start();
    require '../lib/plug.php';
    require '../assets/reuse.php';
    
    if(isset($_POST['names']) && isset($_POST['email']) && isset($_POST['pass'])){
/*      if(filter_var($_POST['names'], FILTER_SANITIZE_STRING)){
            if(count(explode(" ", $_POST['names'])) > 1){
                $names = explode(" ",$_POST['names']);
                $fname = $names[0];
                $lname = $names[1];
            }else{
                echo "Error"."`"."<span class='fa fa-times fa-3x'></span><br>Enter Full names";
                exit();
            }
        }   */
        
        $names = testInput($_POST['names']);
        $names = cleanValidate($names, 'string');
        if(count(explode(" ", $names))>1){
            $names = explode(" ",$names);
            $fname = $names[0];
            $lname = $names[1];
        }else{
            echo "Error"."`"."<span class='fa fa-times fa-3x'></span><br>Enter Full names";
            exit();
        }
    
        if(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)){
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                if((itExists('email','users',$_POST['email']))>0){
                    echo "Error"."`"."<span class='fa fa-times fa-3x'></span><br>Email Already used";
                    exit();
                }else{
                    $email = $_POST['email'];
                    $username = explode("@",$email)[0];
                }
                
            }
        }    
        
    
        if(filter_var($_POST['pass'], FILTER_SANITIZE_STRING)){
            $pass = md5($_POST['pass']);
        }else{
            echo "Error"."`"."Bad Password format";
            exit();
        }

        $userid = getuniqueid(5,4);
        
        $joindate = date("Y-m-d h:i:s",time());

        $joindateraw = time();

        $addedby = $_SESSION['logged-in'];
		
        if(isset($_POST['phone'])){
			if(filter_var($_POST['phone'], FILTER_SANITIZE_STRING)){
                $phone = $_POST['phone'];            
			}else{
                $phone = '';
            }
        }
        
        $query = "INSERT INTO users(fname,lname,email,uniqueid,username,password,phone,joindate,joindateraw,addedby,accttype) VALUES ('$fname','$lname','$email','$userid','$username','$pass','$phone','$joindate',$joindateraw,'$addedby',0)";
        
		$res = mysqli_query($con,$query);
        
        if($res){
            echo "Congratulations ".strtoupper($fname)." ".ucfirst($lname).".";
	//		$_SESSION['logged-in'] = $username;
        }else{
            echo "Error Not Created"."`<span class='fa fa-times fa-3x'></span><br>Some Error Occurred, Kindly try again!!!<br>";
            echo mysqli_error($con);
    //      echo "<br>".$result;
	//		echo mysqli_errno($result)." ".mysqli_error($result);
        }

    }else{
        echo "Error Not Created"."`";
        echo "<span class='err'><i class='fa fa-times fa-3x'></i></span><br>Kindly fill out missing fields"."`";
//      echo $query;
    }
    mysqli_close($con);
?>