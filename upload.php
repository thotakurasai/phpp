<?php 

include_once 'authController.php';
$id = $_SESSION['id'];

if (isset($_POST['submit'])){
	$file = $_FILES['file'];
	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileError = $file['error'];
	$fileType = $file['type'];
	
	$fileExt = explode('.',$fileName);
	$fileActualExt = strtolower(end($fileExt));
	
	$allowed = array('jpg', 'jpeg', 'png');
	
	if(in_array($fileActualExt, $allowed)){
		if($fileError === 0){
			if($fileSize < 1000000){
				$fileNameNew = "profile".$id.".".$fileActualExt;
				$fileDestination = $fileNameNew;
				move_uploaded_file($fileTmpName,$fileDestination);
				$sql = "update profileimg set status=0 where userid = '$id';";
				$result = mysqli_query($conn,$sql);
				header("Location: homepage.php?uploadsuccess");
			}else{
				echo "your file is too big";
			}
		}else{
			echo "there was an error uploading";
		}
	}else{
		echo "you cannot upload files of this type";
	}
}