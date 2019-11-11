<?php    
    require "../assets/conf.php";
    require "../assets/assetmgtconf.php";
    require "../assets/reuse.php";
    require "../lib/plug.php";

    $query = "SELECT * FROM assets WHERE assigned=1";
    $result = mysqli_query($con,$query);
echo "
        <table class='table table-responsive table-hover table-striped'>
            <thead>
            <tr class='tab-col-hd' style='text-align:center;'>
                <th>S/No</th>
                <th>Name &amp; Model</th>                                    
                <th>Device Type</th>
                <th>Description</th>                
                <th>Asset Number</th>
                <th>Date Purchased</th>
                <th>Current User</th>
                <th>User Location</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody style='font-size:11px; text-align:center;'>";
                
                    if(!$result){
                        echo "
                            <tr><td>No Data</td></tr>
                            ";
                    }else{
                        $sn = 1;
                    //    $asst = mysqli_fetch_assoc($result);
                        while(($assts = mysqli_fetch_assoc($result)) !== null){
                            if(count(explode("::",$assts['deviceuserrecord'])) < 2){
                                $curdevuserrecord = explode(":",$assts['deviceuserrecord']);
                            }else{
                                $devuserrecord = explode("::",$assts['deviceuserrecord']);
                                $curdevuserrecord = explode(":",$devuserrecord[count($devuserrecord) - 1]);
                            }
                        
                            $purchasedate = $assts['purchasedateraw'];
                            echo "
                            <tr class='devitem'>
                                <td>".$sn."</td>";
                            if(($assts['model'] == 'N/A')||($assts['model'] == '') || ($assts['model']==' ')){
                                echo "<td class='devitemname'>".$assts['brand']."</td>";
                            }else{
                                echo "<td class='devitemname'>".$assts['brand']." ".$assts['model']."</td>";
                            }
                            echo "
                            <td class='devitemtype'>".$assts['devicetype']."</td>";
                            if(($assts['processor']=='N/A')||($assts['processor']=='')){
                                echo "<td>".$assts['otherdesc']."</td>"; 
                            }else{
                                echo "<td>".$assts['processor'].", <br>".$assts['otherdesc']."</td>";
                            }
                            echo "
                                <td class='devitemasstnum'>".$assts['assetnum']."</td>
                                <td>".date('D, d-M-Y',$purchasedate)."</td>
                                <td>".$curdevuserrecord[0]."</td>
                                <td>".$curdevuserrecord[4]."</td>
                                <td><span id='' class='devinfo info'><i class='fa fa-info-circle' title='Device Info'></i></span>&nbsp;<span id='' class='mgset mgdev'><i class='fa fa-cog' title='Manage Device'></i></span>&nbsp;<span id='' class='del devdel'><i class='fa fa-trash' title='Delete Device' style='color:orangered;'></i></span></td>
                            </tr>
                            ";
                            $sn++;
                        }
                        
                    }
    echo "                                               
            </tbody>                                
        </table>
        ";
?>