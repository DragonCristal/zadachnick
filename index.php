<?php 
session_start();
if (isset($_GET['page'])) {
	$page=$_GET['page'];
}
else{
	$page=1;
}
// сортировка по убыванию / по возростанию
if ( $_SESSION['sort']['s1']=="ASC") {
	$_SESSION['sort']['s1c1']="checked";
	$_SESSION['sort']['s1c2']="";
}
elseif ( $_SESSION['sort']['s1']=="DESC") {
	$_SESSION['sort']['s1c2']="checked";
	$_SESSION['sort']['s1c1']="";
}
else{
	$_SESSION['sort']['s1c1']="checked";
	$_SESSION['sort']['s1c2']="";
	$_SESSION['sort']['s1']="ASC";
}
// сортировка по имени / по email / по статусу
if ( $_SESSION['sort']['s2']=="task_user_name") {
	$_SESSION['sort']['s2c1']="checked";
	$_SESSION['sort']['s2c2']="";
	$_SESSION['sort']['s2c3']="";
}
elseif ( $_SESSION['sort']['s2']=="task_email") {
	$_SESSION['sort']['s2c2']="checked";
	$_SESSION['sort']['s2c1']="";
	$_SESSION['sort']['s2c3']="";
}
elseif ( $_SESSION['sort']['s2']=="task_status") {
	$_SESSION['sort']['s2c3']="checked";
	$_SESSION['sort']['s2c1']="";
	$_SESSION['sort']['s2c2']="";
}
else{
	$_SESSION['sort']['s2c1']="checked";
	$_SESSION['sort']['s2c2']="";
	$_SESSION['sort']['s2c3']="";
	$_SESSION['sort']['s2']="task_user_name";
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
		include "header.php";
	?>
	<div class="container">
		<div class="page-header">
			<h2>Задачи</h2>
		</div>
		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Параметры сортировки</h3>
            </div>
            <div class="panel-body">
                <form method="POST">
                    <input type="radio" name="sort1" value="ASC" <?php echo ($_SESSION['sort']['s1c1']); ?>>В порядке возрастания
        			<input type="radio" name="sort1" value="DESC" <?php echo ($_SESSION['sort']['s1c2']); ?>>По убыванию
        			<br>
        			<input type="radio" name="sort2" value="task_user_name" <?php echo ($_SESSION['sort']['s2c1']); ?>>По имени
        			<input type="radio" name="sort2" value="task_email" <?php echo ($_SESSION['sort']['s2c2']); ?>>По email
        			<input type="radio" name="sort2" value="task_status" <?php echo ($_SESSION['sort']['s2c3']); ?>>По статусу
        			<br><br>
        			<button class="btn btn-sm btn-success" name="sort_but" type="submit">Отсортировать</button>
        			<?php
        			    if(isset($_POST['sort_but'])){
        			        $_SESSION['sort']['s1']=$_POST['sort1'];
        			        $_SESSION['sort']['s2']=$_POST['sort2'];
        			        echo "<script type='text/javascript'>window.location = '../'</script>";
        			    }
        			?>
                </form>
            </div>
        </div>
		<?php 
			include "db.php";
			$notes_on_page=3;
			$from=($page*$notes_on_page)-$notes_on_page;
			$s1=$_SESSION['sort']['s1'];
			$s2=$_SESSION['sort']['s2'];
			$out_table="SELECT * FROM tasks ORDER BY ".$s2." ".$s1." LIMIT $from,$notes_on_page";
			$out=mysqli_query($db_link,$out_table);
			while ($out_arr=mysqli_fetch_array($out)){
				if ($out_arr["task_status"]==1) {
					$status="<br><b>Статус:</b> <span style='color:#449d44;'>Выполнено</span>";
				}
				else{
					$status="";
				}
				if ($out_arr["task_edited_by_admin"]==1) {
					$status2="<p style='color:#337ab7;'>Отредактировано администратором</p>";
				}
				else{
					$status2="";
				}
				if (@$_SESSION['user']['user_role']==1){
					$edit='<li class="list-group-item"><b><a class="btn btn-sm btn-primary" href="/task_edit.php?edit_id='.$out_arr["task_id"].'">Редактировать</a></b></li>';
				}
				echo '
					<ul class="list-group">
						<li class="list-group-item">
							<b>Имя пользователя:</b> '.$out_arr["task_user_name"].'<br>
						</li>
						<li class="list-group-item"><b>E-mail:</b>'.$out_arr["task_email"].'</li>
						<li class="list-group-item">
							<b>Текст задания:</b> '.$out_arr["task_text"].'
							'.$status.'
							'.$status2.'
						</li>
						'.$edit.'

					</ul>
				';
			}
		?>
		<?php 
			include "db.php";
			$task_count=0;
			$page_count=1;
			echo '<a class="btn btn-sm btn-success page_fix" href="/?page='.$page_count.'">'.$page_count.'</a>';
			$out_table="SELECT * FROM tasks";
			$out=mysqli_query($db_link,$out_table);
			while ($out_arr=mysqli_fetch_array($out)){
				$task_count++;
				if ($task_count==4) {
					$page_count++;
					echo '<a class="btn btn-sm btn-success page_fix" href="/?page='.$page_count.'">'.$page_count.'</a>';
					$task_count=1;
				}
			}
		?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>