<?php
//ถ้ามีค่าส่งมาจากฟอร์ม
echo '
 <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
session_start();
include('../inc/connect.php');
//ประกาศตัวแปรรับค่าจากฟอร์ม
$name = $_SESSION['name'];
$lastname = $_SESSION['lastname'];
$phone = $_SESSION['phone'];
$access = $_GET['access'];
$date = date("Y/m/d");
date_default_timezone_set('Asia/Bangkok');
$time = date("h:i:s");
$activity = 'mobile';
$url = 'http://192.168.1.100/MAC-Web/';

if (isset($name) && isset($lastname) && isset($phone) && isset($access) && isset($access) && isset($date) && isset($time) && isset($activity)) {
    $stmt = $conn->prepare("SELECT * FROM history_log");
    $result = $stmt->execute();
    if ($stmt->rowCount() < 1) {
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
    }else{
        $stmt = $conn->prepare("INSERT INTO history_log (name, lastname, phone, access, date, time, activity) VALUES (:name, :lastname, :phone, :access, :date ,:times,:activity)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':access', $access, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':times', $time, PDO::PARAM_STR);
        $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
        $result = $stmt->execute();
        if ($result) {
            echo '<script>window.location="'.$url.'";</script>';
         
        }
    }
    //isset 
    //devbanban.com
}
$conn = null; //close connect db