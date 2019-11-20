<?php require_once 'authController.php'; 

if(!isset($_SESSION['id'])){
	header('location: login.php');
	exit();
}

?>



<?php 
require_once 'authController.php';

if(isset($_SESSION['id'])){
	
$id = "";
$username = "";
$email = "";


function getPosts()
{
	$posts = array();
	$posts[0] = $_POST['id'];
	$posts[1] = $_POST['username'];
	$posts[2] = $_POST['email'];
	return $posts;
	
}

if(isset($_POST['search']))
{
	$data = getPosts();
	
	$search_Query = "select * from users where id=$data[0]";
	
	$search_Result = mysqli_query($conn, $search_Query);
	
	if($search_Result)
	{
		if(mysqli_num_rows($search_Result))
		{
			while($row = mysqli_fetch_array($search_Result))
			{
				$id = $row['id'];
				$username = $row['username'];
				$email = $row['email'];
			}
		}else{
			echo "No data for this ID";
		}
	}else{
		echo "result error";
	}
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    $delete_Query = "DELETE FROM `users` WHERE `id` = $data[0]";
    try{
        $delete_Result = mysqli_query($conn, $delete_Query);
        
        if($delete_Result)
        {
            if(mysqli_affected_rows($conn) > 0)
            {
                echo 'Data Deleted';
            }else{
                echo 'Data Not Deleted';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Delete '.$ex->getMessage();
    }
}

// Edit
if(isset($_POST['update']))
{
    $data = getPosts();
    $update_Query = "UPDATE `users` SET `username`='$data[1]',`email`='$data[2]' WHERE `id` = $data[0]";
    try{
        $update_Result = mysqli_query($conn, $update_Query);
        
        if($update_Result)
        {
            if(mysqli_affected_rows($conn) > 0)
            {
                echo 'Data Updated';
            }else{
                echo 'Data Not Updated';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Update '.$ex->getMessage();
    }
}
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<br />";
	


}

?>


<html lang="en">
	<head>
		<meta charset="UTF-8">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		
		<link rel="stylesheet" href="style.css">
		
		<title>Homepage</title>
	</head>
	
	<body>
		<div class="bs-header-base">
		  </div>
		  <div class="bs-header">
			<div id="img1" class="bs-header"><img src="vertex-logo.png" /></div>
		  </div>
		<?php  
			$sql = "select * from users";
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$idd = $row['id'];
					$sqlImg = "select * from profileimg where userid='$idd'";
					$resultImg = mysqli_query($conn,$sqlImg);
					
					while($rowImg = mysqli_fetch_assoc($resultImg)){
						echo "<div class='user-container'>";
						if($rowImg['status'] == 0){
							echo "<img src='profile".$idd.".png?'".mt_rand().">";
						}
						else{
							echo "<img src='default.png'>";
						}
					echo "</div>";
					} 
				}
			} 
			
			if(isset($_SESSION['id'])){
			
				echo "<form action='upload.php' method='POST' enctype='multipart/form-data'>
					<input type='file' name='file'>
					<button type='submit' name='submit'>UPLOAD</button>
				</form>";
			}
		?>
		<div class="container_1" >
			<div class="row">
				<form action="homepage.php" method="post">
					<input type="number" name="id" placeholder="id" value="<?php echo $id; ?>"><br><br>
					<input type="text" name="username" placeholder="username" value="<?php echo $username; ?>"><br><br>
					<input type="text" name="email" placeholder="email" value="<?php echo $email; ?>"><br><br>
					<div>
						<input type="submit" name="update" value="Add">
						<input type="submit" name="delete" value="Delete">
						<input type="submit" name="search" value="Find">
					</div>
				</form>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-4 offset-md-4 form-div login1">
					
					<?php if(isset($_SESSION['message'])): ?>
					
						<div class="alert <?php echo $_SESSION['alert-class']; ?> ">
							<?php echo ($_SESSION['message']);
								unset($_SESSION['message']);
								unset($_SESSION['alert-class']);
							?>
						</div>
					<?php endif; ?>
					
					<h3> welcome <?php echo $_SESSION['username']; ?> </h3>
					
					<a href="homepage.php?logout=1" class="logout">logout</a>
					
					<?php if(!$_SESSION['verified']): ?>
						<div class="alert alert-warning">
							you need to verify your account.
							sign in to your email and click on
							verification link mailed to you.
							<strong><?php echo $_SESSION['email']; ?></strong>
						</div>
					<?php endif; ?>
					<?php if($_SESSION['verified']): ?>
						<button class="btn btn-block btn-lg btn-primary">I am verified!</button>
					<?php endif; ?>
				</div>
			</div>
			<div class="bs-body-footer">
				<div id="bs-body-footer-base" class="fb-body-footer">English (UK)<br><hr>
				copyright all rights reserved</div>
			</div>
		</div>
		
	</body>
</html>