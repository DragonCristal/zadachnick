<?php 
session_start();
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
		<div class="page-header">
			<h2>Создать задачу</h2>
		</div>
		<form method="POST">
			<input type="text" name="task_user_name" class="form-control" placeholder="Имя пользователя" maxlength="50">
			<input type="email" name="task_email" class="form-control" placeholder="E-mail" maxlength="50">
			<textarea name="task_text" class="form-control textarea_fix" placeholder="Текст задачи (не более 800 символов)" maxlength="800"></textarea>
			<button class="btn btn-lg btn-success" name="create_task_but" type="submit">Создать</button>
			<?php
				$task_user_name=htmlspecialchars($_POST['task_user_name']);
				$task_email=htmlspecialchars($_POST['task_email']);
				$task_text=htmlspecialchars($_POST['task_text']);
				include "db.php";
				if(isset($_POST["create_task_but"])) {
					if ($task_user_name!='' and $task_email!='' and $task_text!='') {
						mysqli_query($db_link,"INSERT INTO tasks(task_user_name, task_email, task_text) VALUES ('$task_user_name','$task_email','$task_text');");
						echo "<script type='text/javascript'>alert( 'Задача опубликована' );</script>";
						echo "<script type='text/javascript'>window.location = '../'</script>";
					}
					else{
						echo "<br><br><h3><span style='color: red;'>Заполните все поля!</span></h3>";
					}
				}
			?>
		</form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>