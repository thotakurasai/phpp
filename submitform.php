<?php

	$host='localhost';
	$dbuser='root';
	$pass='';
	$dbname="student";
	$conn=mysqli_connect($host,$dbuser,$pass,$dbname);
	if(mysqli_connect_errno())
	{
		die("connection Failed" .mysqli_connect_error());
	}

$sql = "insert into ajax(name,email,contact,details) values('".$_POST['name']."','".$_POST['email']."','".$_POST['contact']."','".$_POST['details']."')";

$res = mysqli_query($conn,$sql);

if(mysqli_affected_rows($conn)>0){
	echo 1;
}else{
	echo "something went wrong";
}
?>
