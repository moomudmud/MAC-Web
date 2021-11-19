<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <title>ACCESS</title>
    </head>

<body>
	
	<div class="container">
    <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-8"> <br> 
	<form action="add_permission.php" method="post">
	<h3>รหัสพนักงาน/เบอร์โทร Visitor</h3>
	<div class="mb-2">
          <div class="col-sm-9">
	<input type="" name="employee_id" class="form-control" value = "<?php echo $_GET['employee_id'];?> " readonly = "readonly">
	<input type="hidden" name="is_visitor" class="form-control" value = "<?php echo $_GET['is_visitor'];?> " readonly = "readonly">
</div></div>
	<h3>เลือกห้อง</h3>
		  <div class="mb-2">
          <div class="col-sm-9">
		  <select name="access_id" class="form-control" required minlength="1" >
			<option value=""><-- กรุณาเลือกห้อง --></option>
			<?php
			
				
							include('../inc/connect.php');
                            //คิวรี่ข้อมูลมาแสดงในตาราง
							if(isset($_GET['employee_id'])){
								
                            $stmt = $conn->prepare("SELECT* FROM mas_access WHERE is_active =1");
                            $stmt->execute();
                            $result = $stmt->fetchAll();
                            foreach($result as $k) {	
                            ?>
							<option value="<?= $k['access_id'];?>"><?= $k['access_name'];?></option>
							<?php }}  ?>
		  </select>
		  
							</div>
							</div>

							
						
							<input type="hidden" name="employee_id" value = "<?php echo $_GET['employee_id']; ?>">			
		                    <button type="submit" class="btn btn-primary">บันทึก</button>
	</form>
	</div>
	</div>
	</diV>
						
</body>
</html>
