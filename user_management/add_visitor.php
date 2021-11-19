<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <title>Resgister</title>
  <script>
    function getRndInteger(min, max) {
      document.getElementById("password").value = Math.floor(Math.random() * (max - min)) + min;
    }
  </script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-8"> <br>
        <h4>Visitor Add</h4>
        <form action="" method="post">
          <div class="mb-2">
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
                เบอร์โทรศัพท์
                <input type="tel" id="phone" name="phone" class="form-control" required minlength="10">

              </div>
            </div>
            <div class="mb-2">
              <div class="col-sm-9">
                Proximity
                <input type="text" name="password" class="form-control" id="password" required minlength="6">
              </div>
            </div>
            <div class="mb-2">
              <div class="col-sm-10">
                กำหนดวันเข้าใช้งาน<br>
                <table>
                  <td>
                    <input type="date" id="start_date" name="start_date" class="form-control" required minlength="10" placeholder="password">
                  </td>
                  <td> &nbsp;ถึงวันที่&nbsp;</td>
                  <td>
                    <input type="date" id="end_date" name="end_date" class="form-control" required minlength="10" placeholder="password">
                  </td>
                </table>
                <br>
              </div>
            </div>

            <div class="mb-2">
              <div class="col-sm-10">
                <center>
                  <table>
                    <td>

                      <button type="submit" class="btn btn-primary">บันทึก</button> &nbsp;&nbsp;
                    <td>
                      <a href="/MAC-Web/user_management/visitor.php" class="btn btn-primary">ยกเลิก</a>
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

//print_r($_POST); //ตรวจสอบมี input อะไรบ้าง และส่งอะไรมาบ้าง 
//ถ้ามีค่าส่งมาจากฟอร์ม
if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['phone']) && isset($_POST['password'])) {
  // sweet alert 
  echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

  //ไฟล์เชื่อมต่อฐานข้อมูล
  //ประกาศตัวแปรรับค่าจากฟอร์ม
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $phone = $_POST['phone'];
  $password = $_POST['password']; //เก็บรหัสผ่านในรูปแบบ sha1 
  $start_date = date($_POST['start_date']);
  $end_date = date($_POST['end_date']);

  //check duplicat
  $stmt = $conn->prepare("SELECT phone FROM mas_visitors WHERE phone = :phone");
  $stmt->execute(array(':phone' => $phone));
  //ถ้า employee_id ซ้ำ ให้เด้งกลับไปหน้าสมัครสมาชิก ปล.ข้อความใน sweetalert ปรับแต่งได้ตามความเหมาะสม
  if ($stmt->rowCount() > 0) {
    echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "มีผู้ใช้แล้วในระบบ",  
                            text: "กรุณาสมัครใหม่อีกครั้ง",
                            type: "warning"
                        }, function() {
                            window.location = "visitor.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                </script>';
  } else { //ถ้า employee_id ไม่ซ้ำ เก็บข้อมูลลงตาราง
    //sql insert
    $stmt = $conn->prepare("INSERT INTO mas_visitors (name, lastname, phone, prox_id, start_date, end_date)
              VALUES (:name, :lastname, :phone, :password, :start_date, :end_date)");
   
    if ($result) {
      echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "สมัครสมาชิกสำเร็จ",
                            text: "กรุณารอระบบ Login ใน Workshop ต่อไป",
                            type: "success"
                        }, function() {
                            window.location = "visitor.php"; //หน้าที่ต้องการให้กระโดดไป
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