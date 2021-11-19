<?php
session_start();

echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
//เช็คว่ามีตัวแปร session อะไรบ้าง
//print_r($_SESSION);
//exit();
//สร้างเงื่อนไขตรวจสอบสิทธิ์การเข้าใช้งานจาก session
if (empty($_SESSION['id']) && empty($_SESSION['name']) && empty($_SESSION['lastname'])) {
  echo '<script>
                setTimeout(function() {
                swal({
                title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
                type: "error"
                }, function() {
                window.location = "/Mac-Web/register/login.php"; //หน้าที่ต้องการให้กระโดดไป
                });
                }, 1000);
                </script>';
  exit();
}

include('../inc/connect.php');
if (isset($_GET['employee_id'])) {
  $stmt = $conn->prepare("SELECT* FROM mas_employees WHERE employee_id=?");
  $stmt->execute([$_GET['employee_id']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  //ถ้าคิวรี่ผิดพลาดให้กลับไปหน้า index
  if ($stmt->rowCount() < 1) {
    header('Location: user.php');
    exit();
  }
} //isset
else {
  header('Location: user.php');
  exit();
}
?>

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
        <h4>แก้ไขข้อมูลพนักงาน</h4>
        <form action="" method="post">
          <div class="mb-2">
            <div class="col-sm-9">
              รหัสพนักงาน<br>
              <input type="text" name="employee_id" class="form-control" required value="<?= $row['employee_id']; ?>" minlength="3">
            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              ชื่อ<br>
              <input type="text" name="name" class="form-control" required value="<?= $row['name']; ?>" minlength="3">
            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              นามสกุล<br>
              <input type="text" name="lastname" class="form-control" required value="<?= $row['lastname']; ?>" minlength="3">

            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              เบอร์โทรศัพท์<br>
              <input type="tel" id="tel" name="phone" class="form-control" required value="<?= $row['phone']; ?>" minlength="10">
            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              อีเมล<br>
              <input type="email" id="email" name="email" class="form-control" required value="<?= $row['email']; ?>" minlength="10">
            </div>
          </div>
          <div class="mb-3">
          </div>
          <div class="d-grid gap-2 col-sm-9 mb-3">
            <button type="submit" class="btn btn-primary">แก้ไข</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>

<?php
include('../inc/connect.php');
//ถ้ามีค่าส่งมาจากฟอร์ม
if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['employee_id'])) {
  // sweet alert 
  $employee_id = $_POST['employee_id'];
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $status = 1;
  $role = 'general';
  //sql update
  $stmt = $conn->prepare("UPDATE  mas_employees SET name=:name, lastname=:lastname , phone = :phone WHERE employee_id =:employee_id");
  $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_STR);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
  $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
  $stmt->execute();

  // sweet alert 
  echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

  if ($stmt->rowCount() > 0) {
    echo '<script>
             setTimeout(function() {
              swal({
                  title: "แก้ไขข้อมูลสำเร็จ",
                  type: "success"
              }, function() {
                window.location = "user.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
  } else {
    echo '<script>
             setTimeout(function() {
              swal({
                  title: "เกิดข้อผิดพลาด",
                  text: "รหัสผ่านซ่้ำกัน กรุณาตรวจสอบข้อมูล",
                  type: "error"
              }, function() {
                window.location = "user.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
  }
  $conn = null; //close connect db
} //isset
?>