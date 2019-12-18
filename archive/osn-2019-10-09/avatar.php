<?php 
	require 'db.php';
	// $data = $_POST;
	  
	if($_FILES["filename"]["size"] > 1024*3*1024)
	{
	  echo ("Размер файла превышает три мегабайта");
	  exit;
	}
	// Проверяем загружен ли файл
	if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
	{
	  // Если файл загружен успешно, перемещаем его
	  // из временной директории в конечную
	  move_uploaded_file($_FILES["filename"]["tmp_name"], "chown -R www-data:www-data avatar/".$_FILES["filename"]["name"]);
	  $id = $_SESSION['logged_user']->id;
	  $user = R::load('users', $id);
	  $user->filename = "avatar/".$_FILES["filename"]["name"];
	  R::store($user);
	  
	} else {
	   echo("Ошибка загрузки файла");
	}

?>
<script>
	
	// window.location = "/q";
		</script>
<!-- <form action="login.php" method="POST">
	<strong>Логин</strong>
	<input type="text" name="login" value="<?php // echo @$data['login']; ?>"><br/>

	<strong>Пароль</strong>
	<input type="password" name="password" value="<?php // echo @$data['password']; ?>"><br/>

	<button type="submit" name="do_login">Войти</button>
</form> -->