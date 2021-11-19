<?php
//ถ้ามีค่าส่งมาจากฟอร์ม
echo '
 <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
include('../inc/connect.php');
//ประกาศตัวแปรรับค่าจากฟอร์ม
$employee_id = $_POST['employee_id'];
$access_id = $_POST['access_id'];
$is_visitor = $_POST['is_visitor'];
$status = 3;
$is_visitor_value = '';

if ($is_visitor == 0)
    $is_visitor_value = 0;
else $is_visitor_value = 1;




if (isset($_POST['employee_id']) && isset($_POST['access_id'])) {
    $stmt = $conn->prepare("SELECT employee_id FROM employees_access WHERE employee_id = :employee_id and access_id = $access_id");
    $stmt->execute(array(':employee_id' => $employee_id));



    if ($stmt->rowCount() > 0) {
        echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "มีผู้ใช้แล้วในระบบ",  
                      text: "กรุณาสมัครใหม่อีกครั้ง",
                      type: "warning"
                  }, function() {
                    window.history.go(-2);
                  });
                }, 1000);
          </script>';
    } else { //ถ้า employee_id ไม่ซ้ำ เก็บข้อมูลลงตาราง
        //sql insert
        $stmt = $conn->prepare("INSERT INTO employees_access (employee_id, access_id, status , is_visitor)
              VALUES (:employee_id, :access_id, :status, :is_visitor)");
        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_STR);
        $stmt->bindParam(':access_id', $access_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':is_visitor', $is_visitor_value, PDO::PARAM_INT);
        $result = $stmt->execute();
        if ($result) {
            echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "การทำรายการสำเร็จ",
                      text: "การทำรายการสำเร็จ",
                      type: "success"
                  }, function() {
                    window.history.go(-2);
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
                    window.history.go(-2);
                  });
                }, 1000);
            </script>';
        }
        $conn = null; //close connect db
    } //else chk dup
    //isset 
    //devbanban.com
}
