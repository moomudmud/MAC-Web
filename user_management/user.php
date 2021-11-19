<?php
session_start();
include('../inc/connect.php');

echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

if (($_SESSION['role']<>'admin') OR empty($_SESSION['employee_id'])) {
    echo '<script>
                setTimeout(function() {
                swal({
                title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
                type: "error"
                }, function() {
                window.location = "/MAC-Web/index.php"; 
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
                <li ><a href="/MAC-Web/index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">ผู้ดูแลระบบ <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/MAC-Web/user_management/user.php">จัดการข้อมูลนักงาน</a></li>
                        <li><a href="#">Access Control</a></li>
                        <li><a href="/MAC-Web/user_management/visitor.php">ผู้มาเยือน</a></li>
                    </ul>
                </li>
                <li><a href="#">Page 2</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/MAC-Web/register/user_information.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $_SESSION["employee_id"];?></a></li>
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
                            <h3>บัญชีรายชื่อพนักงาน</h3>
                            <input type="search" name="q" class="form-control" placeholder="ใส่รหัสพนักงาน"> <br>
                            <button type="submit" class="btn btn-primary">ค้นหาข้อมูล</button></a> <br>
                </div>
                <div class="col-md-12"> <br></div>
                <tr>
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>อีเมล</th>
                    <th>
                        <center>สถานะ</center>
                    </th>
                    <th>
                        <center>Role</center>
                    </th>
                    <th>
                        <center>สิทธิการเข้าถึง</center>
                    </th>
                    <th>
                        <center>แก้ไข</center>
                    </th>
                    <th>
                        <center>ลบ</center>
                    </th>

                </tr>
                </thead>
                <tbody>
                    <?php


                    if (isset($_GET['q'])) {
                        $q = "%{$_GET['q']}%";
                        $stmt = $conn->prepare("SELECT*
                                                    FROM mas_employees as  me
                                                    LEFT JOIN  mas_status as s ON me.status = s.status_id
                                                    WHERE (employee_id LIKE ?) 
                                
                                                    ");
                        $stmt->execute([$q]);
                        $result = $stmt->fetchAll();
                    } else {
                        $stmt = $conn->prepare("SELECT*
                                                    FROM mas_employees as  me
                                                    LEFT JOIN  mas_status as s ON me.status = s.status_id 
                                                    ");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                    }


                    foreach ($result as $k) {
                    ?>
                        <tr>
                            <td><?= $k['employee_id']; ?></td>
                            <td><?= $k['name']; ?></td>
                            <td><?= $k['lastname']; ?></td>
                            <td><?= $k['phone']; ?></td>
                            <td><?= $k['email']; ?></td>
                            <td>
                                <center><?= $k['status_name']; ?></center>
                            </td>
                            <td>
                                <center><?= $k['role']; ?></center>
                            </td>
                            <td>
                                <center><a href="/MAC-Web/user_management/access.php?employee_id=<?= $k['employee_id']; ?>&is_visitor=0" class="btn btn-info btn-sm">กำหนด</a></center>
                            </td>
                            <td>
                                <center><a href="/MAC-Web/user_management/edit_employee.php?employee_id=<?= $k['employee_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a></center>
                            </td>
                            <td>
                                <center><a href="delete_employess.php?employee_id=<?= $k['employee_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล !!');">ลบ</a></center>
                            </td>
                        </tr>

                        </tr>
                    <?php } ?>
                </tbody>
                </table>
                <h3>สิทธิการเข้าถึง
                    <table class="table table-striped  table-hover table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>รหัสพนักงาน</th>
                                <th>ชั้น</th>
                                <th>ห้อง</th>
                                <th>สถานะ</th>
                                <th>
                                    <center>อนุญาติ/ยกเลิก</center>
                                </th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                if (isset($_GET['q'])) {
                                    $q = "%{$_GET['q']}%";
                                    $stmt = $conn->prepare("SELECT* 
                                                    FROM employees_access as e
                                                    LEFT JOIN  mas_status s ON e.status = s.status_id
                                                    LEFT JOIN  mas_access a ON e.access_id = a.access_id
                                                    LEFT JOIN  mas_group  g ON a.group_id = g.group_id
                                                    WHERE (employee_id LIKE ?)
                                                    AND  is_visitor = 0
                                                    ORDER BY a.group_id
                                                    ");
                                    $stmt->execute([$q]);
                                    $result = $stmt->fetchAll();
                                } else {
                                    $stmt = $conn->prepare("SELECT* 
                                                    FROM employees_access as e
                                                    LEFT JOIN  mas_status s ON e.status = s.status_id
                                                    LEFT JOIN  mas_access a ON e.access_id = a.access_id
                                                    LEFT JOIN  mas_group  g ON a.group_id = g.group_id
                                                    WHERE is_visitor = 0
                                                    ORDER BY a.group_id
                                                    ");
                                    $stmt->execute();
                                    $result = $stmt->fetchAll();
                                }

                                foreach ($result as $k) {
                                ?>
                            <tr>
                                <td><?= $k['employee_id']; ?></td>
                                <td><?= $k['group_name']; ?></td>
                                <td><?= $k['access_name']; ?></td>
                                <td><?= $k['status_name']; ?></td>
                                <td>
                                    <center><a href="/MAC-Web/user_management/access_status.php?employee_id=<?= $k['employee_id']; ?>&access_name=<?= $k['access_name']; ?>&access_id=<?= $k['access_id']; ?>" class="btn btn-info btn-sm">ตั้งค่า</a></center>
                                </td>

                            </tr>

                            </tr>
                        <?php } ?>

                        </tr>
                        </tbody>
                    </table>
            </div>
        </div>
        </div>

    </form>
</body>

</html>