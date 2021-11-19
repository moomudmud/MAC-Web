<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <title>Resgister</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-8"> <br>
        <h4>ระบบลงทะเบียน Mobile Access Control</h4>
        <form action="" method="post">
          <div class="mb-2">
            <div class="col-sm-9">
              รหัสพนักงาน<br>
              <input type="text" name="employee_id" class="form-control" required minlength="3">
            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              ชื่อ<br>
              <input type="text" name="name" class="form-control" required minlength="3">
            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              นามสกุล<br>
              <input type="text" name="lastname" class="form-control" required minlength="3">

            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              เบอร์โทรศัพท์<br>
              <input type="tel" id="tel" name="phone" class="form-control" required minlength="10">
            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              อีเมล<br>
              <input type="email" id="email" name="email" class="form-control" required minlength="10">
            </div>
          </div>
          <div class="mb-3">
            <div class="col-sm-9">
              รหัสผ่าน
              <input type="password" name="password" class="form-control" required minlength="3">
            </div>
          </div>
          <div class="d-grid gap-2 col-sm-9 mb-3">
            <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>


<?php
include('../inc/connect.php');

//print_r($_POST); //ตรวจสอบมี input อะไรบ้าง และส่งอะไรมาบ้าง 
//ถ้ามีค่าส่งมาจากฟอร์ม
if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['employee_id']) && isset($_POST['password'])) {
  // sweet alert 
  echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

  //ไฟล์เชื่อมต่อฐานข้อมูล
  //ประกาศตัวแปรรับค่าจากฟอร์ม
  $employee_id = $_POST['employee_id'];
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = sha1($_POST['password']); //เก็บรหัสผ่านในรูปแบบ sha1 
  $status = 1;
  $role = 'general';
  $pin='';

  //check duplicat
  $stmt = $conn->prepare("SELECT employee_id FROM mas_employees WHERE employee_id = :employee_id");
  $stmt->execute(array(':employee_id' => $employee_id));
  //ถ้า employee_id ซ้ำ ให้เด้งกลับไปหน้าสมัครสมาชิก ปล.ข้อความใน sweetalert ปรับแต่งได้ตามความเหมาะสม
  if ($stmt->rowCount() > 0) {
    echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "มีผู้ใช้แล้วในระบบ",  
                            text: "กรุณาสมัครใหม่อีกครั้ง",
                            type: "warning"
                        }, function() {
                            window.location = "register.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                </script>';
  } else { //ถ้า employee_id ไม่ซ้ำ เก็บข้อมูลลงตาราง
    //sql insert
    echo 'ins';
    $stmt = $conn->prepare("INSERT INTO mas_employees(employee_id, name, lastname, phone, email, password ,status, role, pin) VALUES (:employee_id,:name,:lastname,:phone,:email,:password,:status,:role,:pin)");
    $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':pin', $pin, PDO::PARAM_STR);
    $result = $stmt->execute();
    if ($result) {
      echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "สมัครสมาชิกสำเร็จ",
                            text: "กรุณารอระบบ Login ใน Workshop ต่อไป",
                            type: "success"
                        }, function() {
                            window.location = "login.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                  </script>';
    } else {
      echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            type: "error"
                        }, function() {
                            window.location = "formRegister.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                  </script>';
    }
    $conn = null; //close connect db
  } //else chk dup
} //isset 
//devbanban.com
?>