<?php

session_start();
include('../inc/connect.php');

echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

if (empty($_SESSION['employee_id']) && empty($_SESSION['name']) && empty($_SESSION['lastname'])) {
    echo '<script>
                setTimeout(function() {
                swal({
                title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
                type: "error"
                }, function() {
                window.open("/MAC-Web/register/login.php"); 
                });
                }, 1000);
                </script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Access inside</title>
</head>

<body>
    <form action="" method="post">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Mobile Access Control</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="/MAC-Web/index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                    <li><a href="/MAC-Web/register/user_information.php">ฉัน</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">ผู้ดูแลระบบ <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li><a href="/MAC-Web/user_management/user.php">จัดการข้อมูลนักงาน</a></li>
                        <li><a href="#">Access Control</a></li>
                        <li><a href="/MAC-Web/user_management/visitor.php">ผู้มาเยือน</a></li>
                        <li><a href="/MAC-Web/user_management/history.php">ประวัติการเข้า</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Page 2</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/MAC-Web/register/user_information.php"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["employee_id"]; ?></a></li>
                    <li><a href="/MAC-Web/register/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12"> <br>
                    <table class="table table-striped  table-hover table-responsive table-bordered">
                        <thead>
                </div>
                <div class="col-md-12"> <br></div>
                <tr>
                    <th>ชั้น</th>
                    <th>ห้อง</th>
                    <th>
                        <center>เข้าห้อง</center>
                    </th>


                </tr>
                </thead>
                <tbody>
                    <?php
                    $employee_id = $_SESSION['employee_id'];
                    if (isset($_GET['q'])) {
                        $q = "%{$_GET['q']}%";
                        $stmt = $conn->prepare("SELECT*  , case when CURDATE() > end_date then 'หมดอายุ' else 'ใช้งานได้' end as status
                                                FROM mas_visitors");
                        $stmt->execute([$q]);
                        $result = $stmt->fetchAll();
                    } else {
                        $stmt = $conn->prepare("SELECT*  
                                                FROM employees_access as e
                                                    LEFT JOIN  mas_status s ON e.status = s.status_id
                                                    LEFT JOIN  mas_access a ON e.access_id = a.access_id
                                                    LEFT JOIN  mas_group  g ON a.group_id = g.group_id
                                                    WHERE employee_id LIKE ?
                                                    AND status = 3 ");
                        $stmt->execute([$employee_id]);
                        $result = $stmt->fetchAll();
                    }


                    foreach ($result as $k) {
                    ?>
                        <tr>
                            <td><?= $k['group_name']; ?></td>
                            <td><?= $k['access_name']; ?></td>


                            <td>
                                <center><button type="submit" name="on_click" value="<?= $k['security_level']; ?>,<?= $k['ip_address']; ?>,<?= $k['pin']; ?>,<?= $k['access_name']; ?>" class="btn btn-warning btn-sm">ACCESS</button></center>

                            </td>




                        </tr>

                        </tr>
                    <?php } ?>
                </tbody>
                </table>

            </div>
        </div>
        </div>

    </form>
</body>

</html>

<?php

if (isset($_POST['on_click'])) {

    $value= $_POST['on_click'];
    $myArray = explode(',',$value);
    $security_level = $myArray[0];
    $ip_address = $myArray[1];
    $pin = $myArray[2];
    $access_name = $myArray[3];

    $url1 = 'http://'.$ip_address.'/MAC-Web/relay.php?access='.$access_name.'&pin='.$pin;
    $url2 = '/MAC-Web/access/inside_pin.php?access='.$access_name.'&ip_address='.$ip_address.'&pin='.$pin;

    if ($security_level == 1) {

        #echo($url1);
        
        echo '<script> window.location = "'.$url1.'";</script>';
    }
    elseif($security_level == 2){
        //echo($access_name);
        //echo ($myArray);
        echo '<script> window.location = "'.$url2.'";</script>';
    }
    
    
    else {
        echo "NO";
      
        $colors  = "red,blue,green,orange";
        $colorsArray = explode(",", $colors);
    }
} else { //ถ้า employee_id ไม่ซ้ำ เก็บข้อมูลลงตาราง
    //sql insert

 
    //else chk dup
    //isset 
    //devbanban.com
}
?>

