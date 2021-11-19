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
$status_id = $_POST['status_id'];

if (isset($_POST['employee_id']) && isset($_POST['status_id'])) {
    
        $stmt = $conn->prepare("UPDATE employees_access SET status = $status_id  WHERE access_id = $access_id AND employee_id = :employee_id " );
        $stmt->bindParam(':employee_id', $employee_id , PDO::PARAM_STR);
       // $stmt->bindParam(':access_id', $access_id, PDO::PARAM_INT);
       // $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $result = $stmt->execute();

        if($result){
            echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "การทำรายการสำเร็จ",
                      text: "การทำรายการสำเร็จ",
                      type: "success"
                  }, function() {
                      window.location = "user.php"; //หน้าที่ต้องการให้กระโดดไป
                  });
                }, 1000);
            </script>';
        }
        $conn = null; //close connect db
  } //else chk dup
 //isset 
//devbanban.com
?>
