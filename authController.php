<?php

session_start();

if (isset($_GET['logout'])){
			session_destroy();
			unset($_SESSION['id']);
			unset($_SESSION['username']);
			unset($_SESSION['email']);
			unset($_SESSION['verified']);
			header('location: login.php');
			exit();
		}

require 'db.php';

$errors = array();
$username="";
$email="";
//d
	if(isset($_POST['signups-btn']))
	{
		$username= $_POST['username'];
		$email= $_POST['email'];
		$password= $_POST['password'];
		$passwordConf= $_POST['passwordConf'];
		
		if (empty($username))
		{
			$errors['username'] = "Username Required";
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$errors['email']="Email address is invalid";
		}
		if (empty($email))
		{
			$errors['Email'] = "Email Required";
		}
		if (empty($password))
		{
			$errors['password'] = "Password Required";
		}
		if($password !== $passwordConf){
					$errors['password']= "password's Didn't Match";
					
				}
		$emailQuery="select * from users where email=? limit 1";
		$stmt = $conn->prepare($emailQuery);
		$stmt->bind_param('s',$email);
		$stmt->execute();
		$result=$stmt->get_result();
		$userCount = $result->num_rows;
		$stmt->close();
		
		if($userCount>0)
		{
			$errors['email']="email already exists";
		}
		if(count($errors) === 0)
		{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$token = bin2hex(random_bytes(50));
			$verified = 0;
			
			$sql = "insert into users(username,email,verified,token,password) values(?,?,?,?,?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('ssiss',$username,$email,$verified,$token,$password);
			if($stmt->execute())
			{
				$user_id = $conn->insert_id;
				$_SESSION['id']=$user_id;
				$_SESSION['username']=$username;
				$_SESSION['email']=$email;
				$_SESSION['verified']=$verified;
				
				$_SESSION['message'] = "you are now logged in";
				$_SESSION['alert-class'] = "alert-success";
				
				$sql = "select * from users where username='$username' AND email = '$email'";
				$result = mysqli_query($conn, $sql);
				
				if(mysqli_num_rows($result)>0){
					while($row = mysqli_fetch_assoc($result)){
						$userid = $row['id'];
						$sql = "insert into profileimg(userid,status)
						values ('$userid',1)";
						mysqli_query($conn,$sql);
					}
				}else{
					echo "you have an error";
				}
				
				header('location: homepage.php');
				exit();
			}
			else{
				// echo "\nPDOStatement::errorInfo():\n";
				// $arr = $stmt->errorInfo();
				// $errors['db_error'] = "Database error: failed to register";
				$errors['db_error'] =  $conn->error;
			}
			
		}

	}
	
	
	if(isset($_POST['login-btn']))
	{
		$username= $_POST['username'];
		$password= $_POST['password'];
		
		if (empty($username))
		{
			$errors['username'] = "Username Required";
		}
		if (empty($password))
		{
			$errors['password'] = "Password Required";
		}
		if(count($errors) ===0)
		{
			$sql = "select * from users where email=? or username=? limit 1";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ss',$username,$username);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();
		
		if (password_verify($password,$user['password']))
		{
			$_SESSION['id']=$user['id'];
			$_SESSION['username']=$user['username'];
			$_SESSION['email']=$user['email'];
			$_SESSION['verified']=$user['verified'];
			
			$_SESSION['message'] = "you are now logged in";
			$_SESSION['alert-class'] = "alert-success";
			
			
				
			
				$sql = "select * from users where username='$username'";
				$result = mysqli_query($conn, $sql);
				
				if(mysqli_num_rows($result)>0){
					while($row = mysqli_fetch_assoc($result)){
						$userid = $row['id'];
						$sql = "insert into profileimg(userid,status)
						values ('$userid',1)";
						mysqli_query($conn,$sql);
					}
				}else{
					echo "you have an error";
				}
			
			
			header('location:homepage.php');
			exit();
			
			}
			else{
				$errors['login_fail'] = "Wrong Credentials";
			}
			
		}
		
	}
?>
	