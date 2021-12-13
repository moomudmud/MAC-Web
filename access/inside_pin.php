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
          <div class="mb-3">
            <div class="col-sm-9">
              รหัสพนักผ่าน<br>
              <input type="password" pattern="[0-9]*" inputmode="numeric" name="pin" class="form-control" maxlength="6" required minlength="6">
            </div>
          </div>
          <div class="d-grid gap-2 col-sm-9 mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <center>ลืมรหัสผ่าน <a href="register.php" target="_blank"> คลิก </a> </center>
</body>

</html>

<?php
include('../inc/connect.php');
if (isset($_POST['pin'])) {
  // sweet alert 
  echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

  //ไฟล์เชื่อมต่อฐานข้อมูล

  //ประกาศตัวแปรรับค่าจากฟอร์ม
  $employee_id = $_SESSION['employee_id'];
  $pin = ($_POST['pin']); //เก็บรหัสผ่านในรูปแบบ sha1 
  $url = 'http://'.$_GET['ip_address'].'/MAC-Web/relay.php?access='.$_GET['access'].'&pin='.$_GET['pin'];
  
  //check employee_id  & password
  $stmt = $conn->prepare("SELECT * FROM mas_employees WHERE employee_id = :employee_id AND pin= :pin");
  $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_STR);
  $stmt->bindParam(':pin', $pin, PDO::PARAM_INT);
  $stmt->execute();

  //กรอก employee_id & password ถูกต้อง
  if ($stmt->rowCount() == 1) {
    //fetch เพื่อเรียกคอลัมภ์ที่ต้องการไปสร้างตัวแปร session
    echo $url;
    header( 'Location:'.$url );

    //header('Location: main.php'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ
  } else { //ถ้า employee_id or password ไม่ถูกต้อง

    echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                             text: "รหัสพนักงาน หรือ รหัสผ่าน ไม่ถูกต้อง ลองใหม่อีกครั้ง",
                            type: "warning"
                        }, );
                      }, 1000);
                  </script>';
    $conn = null; //close connect db
  } //else
} //isset 
//devbanban.com
?>