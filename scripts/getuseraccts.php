<?php  
    session_start();    
    require "../assets/conf.php";
    require "../assets/assetmgtconf.php";
    require "../assets/reuse.php";
    require "../lib/plug.php";

    if(!isset($_SESSION['logged-in'])){
        header("Location:index.php");
    }

    $query = "SELECT * FROM users where accttype<10 and blocked=0";
    $query1 = "SELECT * FROM users where accttype<10 and blocked=1";
    $result = mysqli_query($con,$query);
    $result1 = mysqli_query($con,$query1);
    echo "
        <table class='table table-responsive table-hover table-striped'>
            <thead>
            <tr class='tab-col-hd' style='text-align:center;'>
                <th>S/No</th>
                <th>Name</th>                                    
                <th>Email</th>
                <th>Phone</th>
                <th>Account Type</th>
                <th>Date Added</th>               
                <th>Actions</th>
            </tr>
            </thead>
            <tbody style='font-size:11px; text-align:center;'>";
                
                if(!$result){
                    echo "
                        <tr><td colspan=8>No Data</td></tr>
                        ";
                }else{                
                    $sn = 1;                
                    while(($accts = mysqli_fetch_assoc($result)) !== null){
                        $joindate = $accts['joindateraw'];                        
                        echo "
                        <tr class='devitem'>
                            <td>".$sn."</td>
                            <td class='itemname devitemname'>".ucfirst($accts['fname'])." ".ucfirst($accts['lname'])."</td>
                            <td class='devitemtype'><span>".$accts['email']."</span><span class=''><input class='acctuniquenum' id='' type='hidden' value='".$accts['uniqueid']."' /></span></td>
                            <td>".$accts['phone']."</td>
                            <td>";
                            if($accts['accttype']==0){
                                echo "Standard";
                            }else{
                                echo "Administrator";
                            }
                            echo "</td>
                            <td>".date('D, d-M-Y',$joindate)."</td>
                            <td><span id='' class='acctinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='' class='mgset mgacct'>
                            <i class='fa fa-cog'></i></span>&nbsp;";if($_SESSION['logged-in']=='admin' || $_SESSION['logged-in']=='superadmin'){echo "<span id='' class='del acctdel'><i class='fa fa-trash' title='Delete Account' style='color:orangered;'></i></span>";}echo"</td>
                        </tr>
                        ";
                        $sn++;                        
                    }

                    echo "<tr><td colspan=8 style='text-align:center;'><br></td></tr>";
                    echo "<tr><td colspan=8 style='text-align:center;font-weight:bold;font-size:14px;'>Blocked Accounts</td></tr>";
                    if(mysqli_num_rows($result1)==0){
                        echo "<tr><td colspan=8>No Blocked accounts</td></tr>";
                    }

                    $snb = 1;

                    while(($acctsb = mysqli_fetch_assoc($result1)) !== null){
                        $joindate = $acctsb['joindateraw'];                        
                        echo "
                        <tr class='devitem'>
                            <td>".$snb."</td>
                            <td class='itemname devitemname'>".ucfirst($acctsb['fname'])." ".ucfirst($acctsb['lname'])."</td>
                            <td class='devitemtype'><span>".$acctsb['email']."</span><span class=''><input class='acctuniquenum' id='' type='hidden' value='".$acctsb['uniqueid']."' /></span></td>
                            <td>".$acctsb['phone']."</td>
                            <td>";
                            if($acctsb['accttype']==0){
                                echo "Standard";
                            }else{
                                echo "Administrator";
                            }
                            echo "</td>
                            <td>".date('D, d-M-Y',$joindate)."</td>
                            <td><span id='' class='acctinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='' class='mgset mgacct'>
                            <i class='fa fa-cog'></i></span>&nbsp;";if($_SESSION['logged-in']=='admin' || $_SESSION['logged-in']=='superadmin'){echo "<span id='' class='del acctdel'><i class='fa fa-trash' style='color:orangered;'></i></span>";}echo"</td>
                        </tr>
                        ";
                        $snb++;                        
                    }
                }
    echo "                                               
            </tbody>                                
        </table>
        ";
?>