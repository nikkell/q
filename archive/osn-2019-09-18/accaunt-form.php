<?php 
	require 'db.php';

	$data = $_POST;
	if ( isset($data['do_account']) )
	{
		$id = $_SESSION['logged_user']->id;
		$user = R::load('users', $id);
		$user->vk = $data['vk'];
		$user->insta = $data['insta'];
		$user->info = $data['info'];
		R::store($user);
  

	}

?>

<!-- <form action="signup.php" method="POST">
	<strong>Ваш логин</strong>
	<input type="text" name="login" value="<?php //echo @$data['login']; ?>"><br/>

	<strong>Ваш Email</strong>
	<input type="email" name="email" value="<?php //echo @$data['email']; ?>"><br/>

	<strong>Ваш пароль</strong>
	<input type="password" name="password" value="<?php //echo @$data['password']; ?>"><br/>

	<strong>Повторите пароль</strong>
	<input type="password" name="password_2" value="<?php //echo @$data['password_2']; ?>"><br/>

	<strong><?php //captcha_show(); ?></strong>
	<input type="text" name="captcha" ><br/>

	<button type="submit" name="do_signup">Регистрация</button>
</form> -->