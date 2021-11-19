<?php
include('../inc/connect.php');
if (isset($_GET['employee_id'])) {
    //ประกาศตัวแปรรับค่าจาก param method get
    $employee_id = $_GET['employee_id'];
    $stmt = $conn->prepare('DELETE FROM mas_employees WHERE employee_id=:employee_id');
    $stmt2 = $conn->prepare('DELETE FROM employees_access WHERE employee_id=:employee_id');
    $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_STR);
    $stmt2->bindParam(':employee_id', $employee_id, PDO::PARAM_STR);
    $stmt->execute();
    $stmt2->execute();

    //  sweet alert 
    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    if ($stmt->rowCount() > 0 && $stmt2->rowCount() > 0) {
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "ลบข้อมูลสำเร็จ",
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
                  type: "error"
              }, function() {
                  window.location = "user.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    }
    $conn = null;
} //isset