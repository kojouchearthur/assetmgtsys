<?php
function getuniqueid(){
    if (!function_exists('getlett')){
    function getlett(){
        $getlet = '';
        while(strlen($getlet) < 4){
            $lett = range('A','Z');
            $getlet .= $lett[mt_rand(0,25)];
        }
        return $getlet;
    }

    function getnumm(){
        $getnum = '';
        while(strlen($getnum)< 8){
            $getnum .= mt_rand(1000,9999);
        }
        return $getnum;
    }
    }
    $uniqueid = getnumm().getlett();
    return $uniqueid;
}
echo getuniqueid();
?>