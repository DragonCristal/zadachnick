<?php 
session_start();
?>
<?php
	include "db.php";
	@$login=$_POST['login'];
	@$password=$_POST['password'];
	if (isset($_SESSION['user_id'])) {
		echo "<script type='text/javascript'>window.location = '../'</script>";
	}
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Задачник</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
  </head>
  <body>
    <?php 
		include "header.php"
	?>
	<div class="container">
		<form class="form-signin" method="POST">
			<h2 class="form-signin-heading">Авторизация</h2>
			<input type="text" name="login" class="form-control" placeholder="Login" maxlength="50" required autofocus value="<?php echo("$login");?>">
			<input type="password" name="password" class="form-control" placeholder="Password" maxlength="50" required value="<?php echo("$password");?>">
			<button class="btn btn-lg btn-primary btn-block" name="login_but" type="submit">Вход</button>
			<?php
				if(isset($_POST['login_but'])){
				    $login=$_POST['login'];
				    $password=$_POST['password'];
					if($login!=="" and $password!==""){
						$out_table="SELECT * FROM users";
						$out=mysqli_query($db_link,$out_table);
						while ($out_arr=mysqli_fetch_array($out)){
							if($out_arr['user_login']==$login){
								if($out_arr['user_login']==$login and $out_arr['user_password']==$password){
									$_SESSION['user']=$out_arr;
									echo "<script type='text/javascript'>window.location = '../'</script>";
					 			}
								else{
									echo "<br><span style='color: red;'>Не верный пароль!</span>";
								}
								$login_exist="true";
							}
							else{
							    $login_exist="false";
							}
					 	}
					 	if($login_exist!=="true"){
							echo "<br><span style='color: orange;'>Проверьте правильность заполненных полей!</span>";
						}
					}
					else{
						echo "<br><span style='color: red;'>Заполните все поля!</span>";
					}
				}
			?>
		</form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>