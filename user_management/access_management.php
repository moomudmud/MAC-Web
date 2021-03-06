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
                <h3>จัดการข้อมูล Access control</h3>
                    <table class="table table-striped  table-hover table-responsive table-bordered">
                        <thead>
                </div>
                <div class="col-md-12"> <br></div>
                <tr>
                    <th>ชั้น</th>
                    <th>ห้อง</th>
                    <th>
                        <center>Security Level</center>
                    </th>


                </tr>
                </thead>
                <tbody>
                    <?php

                    $stmt = $conn->prepare("SELECT*  
                                                FROM  mas_access a 
                                                    LEFT JOIN  mas_group  g ON a.group_id = g.group_id
                                                    ORDER BY a.group_id
                                                    ");
                    $stmt->execute();
                    $result = $stmt->fetchAll();



                    foreach ($result as $k) {
                    ?>
                        <tr>
                            <td><?= $k['group_name']; ?></td>
                            <td><?= $k['access_name']; ?></td>
                            <td><center><?= $k['security_level']; ?></center></td>

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

