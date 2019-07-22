<?php
require "../lib/plug.php";

function getuniqueid(int $nm=4,int $lt=0){
    $getnum = ''; //variable to hold digits generated
    while(strlen($getnum)< $nm){
        $getnum .= mt_rand(1,10);
    }
    
    $getlet = ''; //variable to hold letters generated
    while(strlen($getlet) < $lt){
        $lett = range('A','Z');
        $getlet .= $lett[mt_rand(0,25)];
    }
    
    $uniqueid = $getnum.$getlet; //combining digits and letters to form alphanumeric unique id
    return $uniqueid;
}

function testInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function itExists($col,$tbl,$data){
    global $con;
    $qry = "SELECT $col FROM $tbl WHERE $col='$data'";
    $res = mysqli_query($con,$qry);
    if($res){
        $num = mysqli_num_rows($res);
        return $num;
    }    
}

function cleanValidate($data,string $datatype){
    switch ($datatype){
        case 'email':
            if(filter_var($data,FILTER_SANITIZE_EMAIL)){
                if(filter_var($data,FILTER_VALIDATE_EMAIL)){
                    return $data;
                }
            }
            break;

        case 'boolean':
            if(filter_var($data,FILTER_SANITIZE_NUMBER_INT)){
                if(filter_var($data,FILTER_VALIDATE_BOOLEAN)){
                    return $data;
                }
            }
            break;

        case 'url':
            if(filter_var($data, FILTER_SANITIZE_URL)){
                if(filter_var($data,FILTER_VALIDATE_URL)){
                    return $data;
                }
            }
            break;
        
        case 'int':
            if(filter_var($data,FILTER_SANITIZE_NUMBER_INT)){
                if(filter_var($data,FILTER_VALIDATE_INT)){
                    return $data;
                }
            }
            break;
        
        case 'float':
            if(filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT)){
                if(filter_var($data,FILTER_VALIDATE_FLOAT)){
                    return $data;
                }
            }
            break;
        
        default:
            if(filter_var($data,FILTER_SANITIZE_STRING)){
                return $data;
            }
    }
    
}


?>