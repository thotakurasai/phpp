<html>
	<head>
		<title> My first Script</title>
		
		<meta charset="UTF-8">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
	
		
		
		
		<form action="submitform.php" method="POST" class="form" onsubmit="return submitform(this)">
			<div class="col-md-4 offset-md-4 form-div">
				<h2> Form</h2>
				<p class="name">
					<input type="text" name="name" id="name" placeholder="Name"/>
					<label for="name">Name</label>
				</p>
				
				<p class="email">
					<input type="text" name="email" id="email" placeholder="example@abc.com"/>
					<label for="email">Email</label>
				</p>
				
				<p class="contact">
					<input type="number" name="contact" id="contact" placeholder="0123456789"/>
					<label for="contact">Contact</label>
				</p>
				
				<p class="text">
					<textarea name="details" id="details" placeholder="write somrthing"/></textarea>
				</p>
				
				<p>
				
					<span class="error"></span>
				</p>
				
				<p class="submit">
					<input type="submit" value="send" />
				</p>
			</div>
		</form>
			
	</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<script>
	function submitform(obj)
	{
		var name = $('#name').val();
		var email = $('#email').val();
		var contact = $('#contact').val();
		var details = $('#details').val();
		
		if(name==''){
			alert("name is missing");
		}
		else if(email == ''){
			alert("email is missing");
		}
		else if(contact == ''){
			alert("contact is missing");
		}
		else if(details == ''){
			alert("details are missing");
		}
		else{
			$(obj).ajaxSubmit({
				success:successForm
			});
		}
		
		return false;
	}
	
	function successForm(result){
		if(result==1){
			$('.form')[0].reset();
			$('.error').html('<i style="color:green">Succesfully Submitted.</i>');
		}else{
			$('.error').html('<i style="color:red">'+result+'</i>');
		}
	}
</script>