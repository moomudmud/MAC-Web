<?php session_start(); ?>
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
				<form action="edit_status.php" method="post">
					<h3>รหัสพนักงาน</h3>
					<div class="col-sm-9">
						<input type="" name="employee_id" class="form-control" value="<?php echo $_GET['employee_id']; ?> " readonly="readonly">
						<h3>ห้อง</h3>
						<input type="" name="access_name" class="form-control" value="<?php echo $_GET['access_name']; ?> " readonly="readonly">

						<div class="mb-2">
							<div class="col-sm-9">

							</div>
						</div>

						<select name="status_id" class="form-control" required minlength="1">
							<option value="">
								<-- เลือกรายการ -->
							</option>
							<?php


							include('../inc/connect.php');
							//คิวรี่ข้อมูลมาแสดงในตาราง
							if (isset($_GET['employee_id'])) {

								$stmt = $conn->prepare("SELECT* FROM mas_status WHERE status_id in(3,4)");
								$stmt->execute();
								$result = $stmt->fetchAll();
								foreach ($result as $k) {
							?>
									<option value="<?= $k['status_id']; ?>"><?= $k['status_name']; ?></option>
							<?php }
							}  ?>
						</select> <br>


						<input type="hidden" name="employee_id" value="<?php echo $_GET['employee_id']; ?>">
						<input type="hidden" name="access_id" value="<?php echo $_GET['access_id']; ?>">
						<button type="submit" class="btn btn-primary">บันทึก</button>
				</form>
			</div>
		</div>
	</diV>

</body>

</html>
