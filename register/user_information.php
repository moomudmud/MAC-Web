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

if (isset($_SESSION['employee_id'])) {
  $stmt = $conn->prepare("SELECT* FROM mas_employees WHERE employee_id=?");
  $stmt->execute([$_SESSION['employee_id']]);
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
                <li class="active"><a href="/MAC-Web/index.php">Home</a></li>
                <li><a href="/MAC-Web/register/user_information.php">ฉัน</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">ผู้ดูแลระบบ <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/MAC-Web/user_management/user.php">จัดการข้อมูลนักงาน</a></li>
                        <li><a href="#">Access Control</a></li>
                        <li><a href="/MAC-Web/management/visitor.php">ผู้มาเยือน</a></li>
                    </ul>
                </li>p
                <li><a href="#">Page 2</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/MAC-Web/register/user_information.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $_SESSION["employee_id"];?></a></li>
                <li><a href="/MAC-Web/register/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>
    </nav>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-8"> <br>
        <h4>แก้ไขข้อมูลพนักงาน</h4>
        <form action="" method="post">
          <div class="mb-2">
            <div class="col-sm-9">
              รหัสพนักงาน<br>
              <input type="text" name="employee_id" class="form-control" required value="<?= $row['employee_id']; ?>" minlength="3" readonly="readonly">
            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              ชื่อ<br>
              <input type="text" name="name" class="form-control" required value="<?= $row['name']; ?>" minlength="3" readonly="readonly">
            </div>
          </div>
          <div class="mb-2">
            <div class="col-sm-9">
              นามสกุล<br>
              <input type="text" name="lastname" class="form-control" required value="<?= $row['lastname']; ?>" minlength="3" readonly="readonly">

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
          <div class="mb-2">
            <div class="col-sm-9">
              PIN<br>
              <input type="pin" id="email" name="pin" pattern="[0-9]*" inputmode="numeric" class="form-control" required value="<?= $row['pin']; ?>" minlength="6"> <br>
            </div>
          </div>
          <div class="mb-3">
          </div>
          <div class="mb-2">
              <div class="col-sm-10">
                <center>
                  <table>
                    <td>
                      <button type="submit" class="btn btn-primary">บันทึก</button> &nbsp;&nbsp;
                    <td>
                      <a href="/MAC-Web/main.php" class="btn btn-primary">ยกเลิก</a>
                    </td>
                  </table>
                </center>

              </div>
            </div>
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
  $pin = $_POST['pin'];
  $status = 1;
  $role = 'general';
  //sql update
  $stmt = $conn->prepare("UPDATE  mas_employees SET name=:name, lastname=:lastname , phone = :phone, pin=:pin WHERE employee_id =:employee_id");
  $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_STR);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
  $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
  $stmt->bindParam(':pin', $pin, PDO::PARAM_INT);
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
                window.location = "/MAC-Web/index.php"; //หน้าที่ต้องการให้กระโดดไป
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
                window.location = "/MAC-Web/index.php" //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
  }
  $conn = null; //close connect db
} //isset
?>