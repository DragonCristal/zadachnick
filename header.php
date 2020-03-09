<?php 
session_start();
if (isset($_SESSION['user']['user_id'])) {
  $navbar_right='<li><a href="logout.php">Выйти из аккаунта</a></li>';
}
else{
  $navbar_right='<li><a href="signin.php">Авторизация</a></li>';
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Приложение - задачник</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="/">Главная</a></li>
        <li><a href="/task_add.php">Создать задачу</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php 
          echo "$navbar_right";
        ?>
      </ul>
    </div>
  </div>
</nav>