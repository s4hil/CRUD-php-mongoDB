<?php
	// ALert and redirect
	function alert($msg)
	{
		?>
			<script>
				alert("<?php echo $msg ?>");
				window.location = 'index.php';
			</script>
		<?php
	}

	// Saving Record
	if (isset($_POST['save'])) {

		$id = rand(1000, 9999);
		$username = $_POST['username'];
		$password = $_POST['password'];

		require_once 'assets/mongo/vendor/autoload.php'; 
		$table = (new MongoDB\Client)->alpha_corp->users;

		$res = $table->insertOne([
			'_id' => $id,
			'username' => $username,
			'password' => $password,
		]);

		if ($res->getInsertedCount() > 0) {
			alert('Saved');

		}
		else {
			alert('Not Saved');
		}
	}

	// Deleting Record
	if (isset($_GET['del'])) {
		$id = intval($_GET['id']);
		require_once 'assets/mongo/vendor/autoload.php'; 
		$table = (new MongoDB\Client)->alpha_corp->users;
		$res = $table->deleteOne([
			'_id' => $id
		]);
		if ($res->getDeletedCount() > 0) {
			alert("Deleted!");
		}
		else{
			alert("Not Deleted");
		}
	}

	// Updating Record
	if (isset($_POST['update'])) {
		$id = intval($_POST['id']);
		$username = $_POST['username'];
		$password = $_POST['password'];

		require_once 'assets/mongo/vendor/autoload.php'; 
		$table = (new MongoDB\Client)->alpha_corp->users;

		$res = $table->updateOne(
		    ['_id' => $id],
		    ['$set' => [
		    	'username' => $username,
		    	'password' => $password
		    ]]
		);

		if ($res->getModifiedCount() > 0) {
			alert("Updated");
		}
		else {
			alert("Not Updated");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CRUD - php + mongo</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body>
	<h2 class="alert alert-success text-center mt-5">CRUD - PHP - MONGODB</h2>
	<div class="container-fluid row d-flex justify-content-center mt-5">
		<div class="col-lg-4 col-md-4 col-sm-12">
			<h3 class="alert alert-info text-center">Add User</h3>

			<form method="POST" action="?" class="form">
				<input type="number" hidden name="id" class="form-control">
				<fieldset class="form-group">
					<label>Username</label>
					<input type="text" name="username" class="form-control">
				</fieldset>
				<fieldset class="form-group">
					<label>Password</label>
					<input type="text" name="password" class="form-control">
				</fieldset>
				<fieldset class="form-group">
					<input type="submit" name="save" class="form-control btn btn-success">
				</fieldset>
				<fieldset class="form-group">
					<input value="Update" type="submit" name="update" class="form-control btn btn-success" style="display: none;">
				</fieldset>
			</form>
		</div>
		<div class="col col-sm-12 col-md-8 col-lg-8">
			<h3 class="alert alert-info text-center">Users</h3>
			<table class="table table-striped">
				<thead class="table-dark text-white">
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="table-body">
					<?php

						require_once 'assets/mongo/vendor/autoload.php';
						$tbl = (new MongoDB\Client)->alpha_corp->users;
						$row = $tbl->find();
						foreach ($row as $key => $user) {
							?>
								<tr class="table-row">
									<td class="id"><?php echo $user['_id']; ?></td>
									<td class="un"><?php echo $user['username']; ?></td>
									<td class="pw"><?php echo $user['password']; ?></td>
									<td>
										<a href="#" class="btn btn-info p-1 edit-btn">Edit</a>
										<a href="index.php?del&id=<?php echo $user['_id']; ?>" class="btn btn-danger p-1">Delete</a>
									</td>
								</tr>
							<?php
						}

					?>
				</tbody>
			</table>
		</div>
	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</body>
</html>