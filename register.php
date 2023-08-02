<?php

@include 'config.php';

if(isset($_POST['add_product'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($username) || empty($email) || empty($password)){
        echo 'please fill all the fields';
    }else{
        $insert = "INSERT INTO accounts(username, email, password) VALUES('$username', '$email', '$password')";
        $upload = mysqli_query($conn,$insert);
        if($upload){
        
            echo 'account added successfully';
            header('Location: index.php');
        }else{
            echo 'account not added';
        }
        }
    }
    
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="login">
			<h1>Register</h1>
			<form action="" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" required name="username" placeholder="Username" id="username" required>
                <label for="email">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" required name="email" placeholder="email" id="email" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" required name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Register1" name="add_product">
			</form>
		</div>

		
	</body>
</html>