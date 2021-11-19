<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <title>Basic Login PHP PDO by devbanban.com 2021</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-8"> <br>
        <h4>เข้าสู่ระบบ</h4>
        <form action="" method="post">
          <div class="mb-2">
            <div class="col-sm-9">
              รหัสพนักงาน<br>
              <input type="text" name="employee_id" class="form-control" required minlength="3">
            </div>
          </div>
          <div class="mb-3">
            <div class="col-sm-9">
              รหัสพนักผ่าน<br>
              <input type="password" name="password" class="form-control" required minlength="3" placeholder="password">
            </div>
          </div>
          <div class="d-grid gap-2 col-sm-9 mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <center>ลงทะเบียน <a href="register.php" target="_blank"> คลิก </a> </center>
</body>

</html>


<?php
include('../inc/connect.php');
if (isset($_POST['employee_id']) && isset($_POST['password'])) {
  // sweet alert 
  echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

  //ไฟล์เชื่อมต่อฐานข้อมูล

  //ประกาศตัวแปรรับค่าจากฟอร์ม
  $employee_id = $_POST['employee_id'];
  $password = sha1($_POST['password']); //เก็บรหัสผ่านในรูปแบบ sha1 

  //check employee_id  & password
  $stmt = $conn->prepare("SELECT employee_id, name, lastname, phone, email, password, status, role FROM mas_employees WHERE employee_id = :employee_id AND password = :password");
  $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_STR);
  $stmt->bindParam(':password', $password, PDO::PARAM_STR);
  $stmt->execute();

  //กรอก employee_id & password ถูกต้อง
  if ($stmt->rowCount() == 1) {
    //fetch เพื่อเรียกคอลัมภ์ที่ต้องการไปสร้างตัวแปร session
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //สร้างตัวแปร session
    $_SESSION['employee_id'] = $row['employee_id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['lastname'] = $row['lastname'];
    $_SESSION['phone'] = $row['phone'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['status'] = $row['status'];
    $_SESSION['role'] = $row['role'];
    echo ($_SESSION['role']);
    //เช็คว่ามีตัวแปร session อะไรบ้าง
    //print_r($_SESSION);

    // exit();
    header('Location: /MAC-Web/index.php'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ

    //header('Location: main.php'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ
  } else { //ถ้า employee_id or password ไม่ถูกต้อง

    echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                             text: "รหัสพนักงาน หรือ รหัสผ่าน ไม่ถูกต้อง ลองใหม่อีกครั้ง",
                            type: "warning"
                        }, function() {
                            window.location = "login.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                  </script>';
    $conn = null; //close connect db
  } //else
} //isset 
//devbanban.com
?>