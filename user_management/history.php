<?php
session_start();
include('../inc/connect.php');

echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

if (empty($_SESSION['id']) && empty($_SESSION['name']) && empty($_SESSION['lastname'])) {
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
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Mobile Access Control</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="/MAC-Web/register/inside.php">Home</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">ผู้ดูแลระบบ <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="/MAC-Web/user_management/user.php">จัดการข้อมูลนักงาน</a></li>
                        <li><a href="#">Access Control</a></li>
                        <li><a href="/MAC-Web/user_management/visitor.php">ผู้มาเยือน</a></li>
                        <li><a href="/MAC-Web/user_management/history.php">ประวัติศาสตร์การเข้า</a></li>
                    </ul>
                </li>p
                <li><a href="#">Page 2</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="/MAC-Web/register/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>
    </nav>
    <form action="" method="get">
    <form action="" method="get">
        <div class="container">
            <div class="row">
                <div class="col-md-12"> <br>
                    <table class="table table-striped  table-hover table-responsive table-bordered">
                        <thead>
                            <h3>History log</h3>
                            <input type="search" name="q" class="form-control" placeholder="ใส่รหัสพนักงาน"> <br>
                            <button type="submit" class="btn btn-primary">ค้นหาข้อมูล</button></a> <br>
                </div>
                <div class="col-md-12"> <br></div>
                <tr>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>Access Control</th>
                    <th>
                        <center>Date</center>
                    </th>
                    <th>
                        <center>Time</center>
                    </th>
                    <th>
                        <center>Activity</center>
                    </th>
    

                </tr>
                </thead>
                <tbody>
                    <?php


                    if (isset($_GET['q'])) {
                        $q = "%{$_GET['q']}%";
                        $stmt = $conn->prepare("SELECT*
                                                    FROM history_log
                                                    WHERE (phone LIKE ?) 
                                
                                                    ");
                        $stmt->execute([$q]);
                        $result = $stmt->fetchAll();
                    } else {
                        $stmt = $conn->prepare("SELECT* 
                                                    FROM history_log
                                                    ORDER BY date desc
                                                    
                                                    ");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                    }


                    foreach ($result as $k) {
                    ?>
                        <tr>
                            <td><?= $k['name']; ?></td>
                            <td><?= $k['lastname']; ?></td>
                            <td><?= $k['phone']; ?></td>
                            <td><?= $k['access']; ?></td>
                            <td><center><?= $k['date']; ?></center></td>  
                            
                            <td><center><?= $k['time']; ?></center></td>
                            <td><center><?= $k['activity']; ?></center></td>
                            <td><center><?date_format($k['date'],"Y/m/d");?></center></td> 
                         
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