<?php 
session_start();
if ($_SESSION['user']['user_role']==1){
	echo "";
}
else{
	echo "<script type='text/javascript'>window.location = '../'</script>";
}
$task_id_edit=$_GET['edit_id'];
include "db.php";
$out_table="SELECT * FROM tasks WHERE task_id=$task_id_edit";
$out=mysqli_query($db_link,$out_table);
$out_arr=mysqli_fetch_array($out);
if ($out_arr['task_status']==1) {
	$chk="checked";
}
else{
	$chk="";
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
		<div class="page-header">
			<h2>Редактирование задачи</h2>
		</div>
		<form method="POST">
			<input type="text" name="task_user_name" class="form-control" placeholder="Имя пользователя" maxlength="50" value="<?php echo $out_arr['task_user_name']; ?>">
			<input type="email" name="task_email" class="form-control" placeholder="E-mail" maxlength="50" value="<?php echo $out_arr['task_email']; ?>">
			<textarea name="task_text" class="form-control textarea_fix" placeholder="Текст задачи (не более 800 символов)" maxlength="800"><?php echo $out_arr['task_text']; ?></textarea>
			<input type="checkbox" name="task_status" value="true" <?php echo $chk; ?>>Выполненно
			<button class="btn btn-lg btn-success" name="edit_task_but" type="submit">Внести поправки</button>
			<?php
				$task_user_name=htmlspecialchars($_POST['task_user_name']);
				$task_email=htmlspecialchars($_POST['task_email']);
				$task_text=htmlspecialchars($_POST['task_text']);
				if ($_POST['task_status']=='true') {
					$task_status=1;
				}
				else{
					$task_status=0;
				}
				include "db.php";
				if ($_SESSION['user']['user_role']==1){
					if(isset($_POST["edit_task_but"])) {
						if ($task_user_name!='' and $task_email!='' and $task_text!='') {
							if ($out_arr['task_edited_by_admin']==1 or $task_user_name!=$out_arr['task_user_name'] or $task_email!=$out_arr['task_email'] or $task_text!=$out_arr['task_text']) {
								$task_edited_by_admin=1;
							}
							else{
								$task_edited_by_admin=0;
							}
							mysqli_query($db_link,"UPDATE tasks SET task_user_name='$task_user_name', task_email='$task_email', task_text='$task_text', task_status='$task_status',task_edited_by_admin='$task_edited_by_admin' WHERE task_id = $task_id_edit");
							echo "<script type='text/javascript'>alert( 'Задача отредактированна' );</script>";
							echo "<script type='text/javascript'>window.location = '../'</script>";
						}
						else{
							echo "<br><br><h3><span style='color: red;'>Заполните все поля!</span></h3>";
						}
					}
				}
				else{
					echo "<script type='text/javascript'>window.location = '../'</script>";
				}
			?>
		</form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>