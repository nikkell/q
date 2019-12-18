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
		$user->name = $data['name'];
		// $user->avatarka = $data['avatar'];

	

			R::store($user);
			header("Location: ".$_SERVER["REQUEST_URI"]);

	}
$data = $_POST;
	if ( isset($data['do_account']) )
	{
		$id = $_SESSION['logged_user']->id;
		$user = R::load('users', $id);
		$user->vk = $data['vk'];
		$user->insta = $data['insta'];
		$user->info = $data['info'];
		$user->name = $data['name'];
		// $user->avatarka = $data['avatar'];

	

			R::store($user);
			header("Location: ".$_SERVER["REQUEST_URI"]);

	}

	
	$data = $_POST;
	if ( isset($data['do_login']) )
	{
		$user = R::findOne('users', 'login = ?', array($data['login']));
		if ( $user )
		{
			//логин существует
			if ($data['password'] == $user->password )
			// if (md5($data['password']) == $user->password )
			{
		
				//если пароль совпадает, то нужно авторизовать пользователя
				$_SESSION['logged_user'] = $user;
				header("Location: ".$_SERVER["REQUEST_URI"]);
			}else
			{
				// 		echo '<pre>';
		// 		var_dump($user->password);
		// var_dump($data['password']);
		
		// echo '</pre>';
				$errors[] = 'Неверно введен пароль!';
				echo '<style>
			.log_alert{
				display: block!important;
			}
			.overlay2{
				display: block!important;
			}
			</style>';
			
		
			}

		}else
		{
			$errors[] = 'Пользователь с таким логином не найден!';
			echo '<style>
			.log_alert{
				display: block!important;
			}
			.overlay2{
				display: block!important;
			}
			</style>';
			
		}
		
		if (!empty($errors) )
		{
			//выводим ошибки авторизации
			// echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
			// echo '<style>
			// .log_alert{
			// 	display: block!important;
			// }
			// </style>';
		}

	}





	// $data = $_POST;

	// function captcha_show(){
	// 	$questions = array(
	// 		1 => 'Столица России',
	// 		2 => 'Столица США',
	// 		3 => '2 + 3',
	// 		4 => '15 + 14',
	// 		5 => '45 - 10',
	// 		6 => '33 - 3'
	// 	);
	// 	$num = mt_rand( 1, count($questions) );
	// 	$_SESSION['captcha'] = $num;
	// 	echo $questions[$num];
	// }

	//если кликнули на button
	if ( isset($data['do_signup']) )
	{
    // проверка формы на пустоту полей
		$errors = array();
		if ( trim($data['login']) == '' )
		{
			$errors[] = 'Введите логин';
		}

		// if ( trim($data['email']) == '' )
		// {
		// 	$errors[] = 'Введите Email';
		// }

		if ( $data['password'] == '' )
		{
			$errors[] = 'Введите пароль';
		}

		if ( $data['password_2'] != $data['password'] )
		{
			$errors[] = 'Повторный пароль введен не верно!';
		}

		//проверка на существование одинакового логина
		if ( R::count('users', "login = ?", array($data['login'])) > 0)
		{
			$errors[] = 'Пользователь с таким логином уже существует!';
		}
    
    //проверка на существование одинакового email
		// if ( R::count('users', "email = ?", array($data['email'])) > 0)
		// {
		// 	$errors[] = 'Пользователь с таким Email уже существует!';
		// }

		//проверка капчи
		// $answers = array(
		// 	1 => 'москва',
		// 	2 => 'вашингтон',
		// 	3 => '5',
		// 	4 => '29',
		// 	5 => '35',
		// 	6 => '30'
		// );
		// if ( $_SESSION['captcha'] != array_search( mb_strtolower($_POST['captcha']), $answers ) )
		// {
		// 	$errors[] = 'Ответ на вопрос указан не верно!';
		// }


		if ( empty($errors) )
		{
			//ошибок нет, теперь регистрируем
			$user = R::dispense('users');
			$user->login = $data['login'];
			// $user->email = $data['email'];
			// $user->password = md5($data['password']); //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
			$user->password = $data['password']; //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
			R::store($user);
			echo '';
			header("Location: ".$_SERVER["REQUEST_URI"]."#popup1");
		}else
		{
			// echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
			// header("Location: ".$_SERVER["REQUEST_URI"]."#popup1");
			
			echo '<style>
			.reg_alert{
				display: block!important;
			}
			.overlay2{
				display: block!important;
			}
			</style>';
		}

	}


// session_start();
//       if (isset($_SESSION['login']))
//       {
//   $log=$_SESSION['login'];
//       }
//       else{
//       $log= "вы не вошли как пользователь";

//   }
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Qvinciy</title>
 	<!-- <link rel="shortcut icon" href="24x24.png" type="image/png"> -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<meta name="interkassa-verification" content="df702bd4b5ab3496e9e072eca1817f02" />
<!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
		<script type="text/javascript" src="js/jquery.reveal.js"></script> -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  	<link rel="stylesheet" href="css/reveal.css">	

		<!-- <script src="https://rawgit.com/Marak/faker.js/master/examples/browser/js/faker.js"></script> -->
	<!-- <script src="js/script.js"></script> -->
	<script src="js/search.js"></script>
	<!— Yandex.Metrika counter —> 
<script type="text/javascript" > 
(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; 
m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) 
(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); 

ym(53092666, "init", { 
clickmap:true, 
trackLinks:true, 
accurateTrackBounce:true, 
webvisor:true 
}); 
</script> 
<noscript><div><img src="https://mc.yandex.ru/watch/53092666" style="position:absolute; left:-9999px;" alt="" /></div></noscript> 
<!— /Yandex.Metrika counter —>
</head>

<body style="margin: 0; height: 100vh; width: 100vw; overflow: hidden; background: #000000; color:#fff">
		
<div class="double-scroll">
    <div class="login">
<?php //echo $_SESSION['logged_user']->login; ?>
    </div>

	<?php
	/*
		// $pn=1;

		// $pp=10;
		// $all=R::findAll('users','ORDER BY login DESC LIMIT ' . (($pn-1)*$pp) .', ' . $pp );
		
		// //Передача страницы и разбивка на страницы по лимиту:
		
		// $userses=R::findAll('users', 'ORDER BY login');
		
		// $all=array_slice($userses,(($pn-1)*$pp),$pp,true);
		
		// //Поиск всех страниц:
		
		// $userses=R::count('users');
		// $pc=ceil($userses/$pp);
		
		// $range = $pc-1;
		
		// $first=$pn-1-($pn-2)%$range;
		// $last=$first+$range<$pc?$first+$range:$pc;
		
		
		
		 <div class="nav-links">
		<?php if ($pn>1): ?>
			<a class="prev page-numbers" href="<?= pagelink($pn-1) ?>">Newer</a>
		<?php endif; for ($i=$first; $i<=$last; $i++): if ($i==$pn): ?>
			<span class="page-numbers current"><?= $i ?></span>
		<?php else: ?>
			<a class="page-numbers" href="<?= pagelink($i) ?>"><?= $i ?></a>
		<?php endif; endfor; if ($pn<$pc): ?>
			<a class="next page-numbers" href="<?= pagelink($pn+1) ?>">Older</a>
		<?php endif; ?>
		  </div>
		
		 */ ?>

<!-- <div class="inf" id="inf">
    <div class="vh"></div>
</div> -->

<?php
		// require_once 'db.php';  // библиотека redbeanphp
		$query = R::findAll( 'users' , ' ORDER BY price DESC' );
		// а можно и так  $query = R::getAll( 'SELECT * FROM jobs' ); 
		// echo($query);
		// echo '<pre>';
		// var_dump($query->login);
		// echo '</pre>';
		foreach($query as $item):
?>
		<div class="modal-dialog modal-reit-monolit profile-dialog<?=$item['id']?> asdasd<?=$item['id']?> disabled fade">
		<div class="overlay"></div>
		<content class="profile-menu" style="border-radius: 20px;">
		<div class="overhapka"></div>
			<header class="close-exit<?=$item['id']?>">
				<a style="
    background-color: white;
    padding: 0px 6px 0px 6px;
    font-size: 15px;
    border-radius: 50%;
	right: 10px;
    position: absolute;
    top: 10px;">&times</a>
			</header>
			
			<div class="profile-image-wrapper" style="
    margin-left: -20px; position: relative;">
			<img class="profile-avatar" style="background-image: url('<?=$item['filename']?>');background-size: cover;background-repeat: no-repeat;background-position: center;" width="80" height="80"/>
				<div class="profile-avatar2">
					<i class="fa fa-pencil" aria-hidden="true"></i>	
				</div>
				<ul class="profile-social">
				<a href="<?=$item['insta']?>" target="_block"><i class="fa fa-instagram" aria-hidden="true"></i></a>
				<a href="<?=$item['vk']?>" target="_block"><i class="fa fa-vk" aria-hidden="true"></i></a>
			</ul>
			</div>
			<div class="profile-about">
				<p class="profile-cost profile-bio fade" style="display: none;">Информация: <?=$item['info']?></p>
				<h2 class="profile-login">Номен: <?=$item['name']?></h2>
				<p class="profile-rating">
				Рейтинг: <span  style="font-size: 20px;" class="profile-rating-span profile-rating-span<?=$item['id']?>"></span>
					
				</p>
				<p class="profile-cost stionost">Стоимость: <span style="font-size: 20px;"><?=$item['price']?></span><i style="
    font-size: 13px;" class="fa fa-rub" aria-hidden="true"></i></p>
			</div>
		</content>
	</div>
		<script>
$(".disable_block<?=$item['id']?>").on("click", function(){   
			document.querySelector('.profile-dialog').classList.remove('disabled<?=$item['id']?>');
			
		});
		</script>
		<?php
            endforeach;
        ?>
	
	<!-- <div class="modal-dialog auth-dialog fade disabled">
		<div class="overlay"></div>
		<div class="auth-menu">
			<form class="auth-form" action="#">

				<h3>Авторизация</h3>

				<label for="authLogin">Введите свой логин:</label>
				<input id="authLogin" type="text" placeholder="Введите логин..." />

				<label for="authPassword">Введите свой пароль:</label>
				<input id="authPassword" type="password" placeholder="Введите пароль..." />

				<button class="submit-btn" id="authSubmit" type="submit">Войти</button>

			</form> 
		</div>
		<div class="reg-menu">
			<form class="reg-form" action="#">

				<h3>Регистрация</h3>

				<label for="regLogin">Придумайте себе логин:</label>
				<input id="regLogin" type="text" placeholder="Введите логин..." />

				<label for="regPassword">Придумайте пароль:</label>
				<input id="regPassword" type="password" min="6" max="16" placeholder="Введите пароль..." />

				<button class="submit-btn" id="regSubmit" type="submit">Зарегистрироваться</button>
			
			</form> 
		</div>
	</div> -->


	<header class="main-container fade">

		<div class="table-header header0tabla">
			<h3 id='header-cost' class="mob-reit-h3">Рейтинг</h3>
		<span class="header-res-up-mpdal">
			<div class="searg444 searg">
			<!-- <input class="searg" type="text" id="search" placeholder="Поиск по таблице"> -->
			
			<input class="input" id="search" type="text">
			
            <!-- <svg viewBox="0 0 700 100" class="magnifying-glass">
              <path
                    class="magnifying-glass-path"
                    d="m 59.123035,59.123035 c -10.561361,10.56136 -27.684709,10.56136 -38.24607,0 -10.56136,-10.561361 -10.56136,-27.684709 0,-38.24607 10.561361,-10.56136 27.684709,-10.56136 38.24607,0 10.56136,10.561361 10.56136,27.684709 0,38.24607 l 28.876965,28.876965 c 6.304625,7.101523 5.754679,-0.187815 13.07143,-0.5 h 582.04101" />
              <path
                    class="x"
                    d="m 673.46803,25.714286 -37.17876,38.816532 c 0,0 -5.08857,5.60515 -5.68529,11.841734 -1.06622,11.143538 13.02902,11.127448 13.02902,11.127448" />
              <path
                    class="x"
                    d="m 635.08021,25.714286 37.17876,38.816532 c 0,0 5.08857,5.60515 5.68529,11.841734 1.06622,11.143538 -13.02902,11.127448 -13.02902,11.127448" />
            </svg> -->
            <!-- <div class="overlay_Monolit overlay_Monolit-1"></div>
            <div class="overlay_Monolit overlay_Monolit-2"></div> -->
        
		</div>
			<h3 class="header-reit vd">Номен</h3>
			<h3 class="header-reit header-chert searg">Поиск</h3>
		</span>
			<h3 id='header-name' class="mob-price-h3">Стоимость</h3>
		</div>

		
		<?php /*
		// require_once 'db.php';  // библиотека redbeanphp
		$query = R::findAll( 'users' );
		// а можно и так  $query = R::getAll( 'SELECT * FROM jobs' ); 
		// echo($query);
		// echo '<pre>';
		// var_dump($query->login);
		// echo '</pre>';
        foreach($query as $item):
?>
<div class="table-header table-comtent disable_block<?=$item['id']?>">
			<p id='header-name'><?=$item['login']?></p>
			<p id='header-rating'><?=$item['id']?></p>
			<p id='header-cost'>Отправлено</p>
		</div>
		<script>
$(".disable_block<?=$item['id']?>").on("click", function(){   
			document.querySelector('.profile-dialog<?=$item['id']?>').classList.remove('disabled');
			
		});
		$(".close-exit<?=$item['id']?>").on("click", function(){   
			document.querySelector('.asdasd<?=$item['id']?>').classList.add('disabled');
			
		});
		</script>
		<?php
			endforeach;
			*/
		?>

<div class="table-carousel">

<ul id="colors" class="carousel-group ffsss fade enabled">
		<?php
		// require_once 'db.php';  // библиотека redbeanphp
		$query = R::findAll( 'users' , ' ORDER BY price DESC' );
		// а можно и так  $query = R::getAll( 'SELECT * FROM jobs' ); 
		// echo($query);
		// echo '<pre>';
		// var_dump($query->login);
		// echo '</pre>';
        foreach($query as $item):
?>
<li class="table-header table-comtent disable_block<?=$item['id']?>">
			<p id='header-rating' class="mob-reit-h3"><?=$item['reiting']?></p>
			<p id='header-name'><?=$item['name']?></p>
			<p id='header-cost' class="mob-price-h3"><?=$item['price']?><i style="font-size: 14px;" class="fa fa-rub" aria-hidden="true"></i></p>
		</li>
		<script>
$(".disable_block<?=$item['id']?>").on("click", function(){   
			document.querySelector('.profile-dialog<?=$item['id']?>').classList.remove('disabled');
			
		});
		$(".close-exit<?=$item['id']?>").on("click", function(){   
			document.querySelector('.asdasd<?=$item['id']?>').classList.add('disabled');
			
		});
		</script>
		<?php
            endforeach;
        ?>
		</ul>
		</div>
		<a class="fade nno" style="display:none" id="prevCarousel">&#10094;</a>
		<a class="fade nno" style="display:none" id="nextCarousel">&#10095;</a>

	</header>

	<main class="accordion-container">

		<div class="accordion-tab accordion-tab-ofset">

			<input type="radio" name="accordion" id='main' checked />
			<label for="main">
				<article class="accordion-main">
				<div class="accordeon_target"></div>
					<content class="social-icons">
						
<?php if ( isset ($_SESSION['logged_user']) ) : ?>

<a href="#" class="social-account social-account-okay" id="showAccount" ;>
							<img width='35px' height='35px' src="account.svg" alt="Аккаунт" />
					    
						</a>
<?php else : ?>
	<a class="social-account" href="#popup1"><img width='35px' height='35px' src="account.svg" alt="Аккаунт" /></a>
<!-- <a href="#" class="social-account" id="showAccount" data-reveal-id="myModal" data-animation="fade">
							<img width='35px' height='35px' src="account.svg" alt="Аккаунт" />
						</a> -->
<?php endif; ?>
						
<!-- <a href="#" class="social-account" id="showAccount" data-reveal-id="myModal" data-animation="fade">
							<img width='35px' height='35px' src="account.svg" alt="Аккаунт" />
						</a> -->
							<!-- <a href="reg.php" class="social-account" id="showAccount" ;>
							<img width='35px' height='35px' src="account.svg" alt="Аккаунт" />
					
						</a> -->

						<a class='social-vk' href="https://vk.com/qvinciy">
							<img width='35px' height='35px' src="vk.svg" alt="Qvinciy в ВК!"/>
						</a>
						
					</content>
				</article>
			</label>

		</div>

		<div class="accordion-tab">
		<header class="close-exit close-acordeon-mob">
				<a class="close_podwal" style="
    /* margin-top: -6px; */
	/* padding: 0px 6px 0px 6px; */
	color: white;
    font-size: 25px;
    /* right: 10px; */
    /* position: absolute; */
	/* top: 20px; */
	">&times</a>
			</header>
			<input type="radio" name="accordion" id='about' />
			<label for="about"><h3 style="
	margin-bottom: 30px;
	width: 90%;
	margin-top: -1px;
    display: -webkit-inline-box;" >Qvinciy | О проекте</h3>
	
			<ul  class="accordion" style="
    height: 250px;
">
		
		<li class="slide-01">
			
			<div>
				
				<h4 style="
    margin-top: 0px;">Подробнее</h4>
				
				<p><strong>Qvinciy</strong> - это рейтинг людей по всему миру, зависящий от цены купленного места.<br>
					В свою очередь, место - это показатель того, насколько 
					Вы признаны в рейтинге за счет своих денежных средств среди остальных участников.</p> 
				 <p style="
    
    font-size: 20px;
	">
	<!-- <a style="color:white; padding: 5px;" target="_black" href="mailto:qvinciy@mail.ru"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> | <a  style="color:white; padding: 5px;" target="_black" href="http://vk.me/qvinciy"><i class="fa fa-vk" aria-hidden="true"></i></a>
--></pre> 
			</div>
			
		</li>
		
		<li class="slide-02 disable_block444as2">
			
		<div  data-tooltip="Нажмите для продолжение" class="tooltip">
				
				<h4 style="
    margin-top: 0px;">Договор публичный оферты</h4>
				
				<p>Настоящий договор между владельцем сайта в сети интернет
Гаврилова Никиты Александровича и пользователем услуг сайта в сети
интернет, именуемым в дальнейшем «Покупатель» определяет условия
приобретения услуги через сайт http://qvinciy.ru Настоящий договор –
оферта действует с 01 Августа 2019 года.<span class="mob-podskazka" style="display: none">(Продолжение в полной версии)</span></p>
				
			</div>
			
		</li>
		
		<li class="slide-03 disable_block444as">
			<div  data-tooltip="Нажмите для продолжение" class="tooltip">
				
				<h4 style="
    margin-top: 0px;">Пользовательское соглашение</h4>
				
				<p style="    margin-right: -6px;">Настоящее Пользовательское соглашение регулирует отношения
между пользователем сети Интернет (далее - Пользователь) и владельцем
сайта в сети интернет http://qvinciy.ru, возникающие при использовании
интернет-ресурса http://qvinciy.ru,
Пользовательском соглашении.<span class="mob-podskazka" style="display: none">(Продолжение в полной версии)</span></p>
				<!-- <a style="color:white;" href="#">Кликните для продолжения</a> -->
		
		
			</div>
		</li>
		
		
		
	</ul>
			</label>
			

		</div>
<div class="ffaaxxxx" style="    z-index: 9999;
    display: block;
    position: relative;"><p style="padding: 0; font-size: 18px;">Контакты</p><a style="color:white; padding: 5px; font-size: 25px;" target="_black" href="mailto:qvinciy@mail.ru"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> | <a  style="color:white; padding: 5px;font-size: 25px;" target="_black" href="http://vk.me/qvinciy"><i class="fa fa-vk" aria-hidden="true"></i></a>
<p style="
    font-size: 16px;
    text-align: center;" class="asdfaa">@qvinciy права защищены</p>
</div>
		
	</main>
	<div id="popup1" class="overlay overlay2">
	<div class="popup">
		<a class="close close-reg" href="#">&times;</a>
		<div id="poopReglock" class="content">
		<!-- <div id="poopReglock" class="content" style="height: 320px;"> -->
		
		<form action="index.php" method="POST" id="modalform">
			<!-- Регистрация -->
			<p class="reg_alert" style="display: none; color: red;">Такой логин уже существует, или вы ввели не верно повторный пароль</p>
			<!-- Авторизация -->
			<p class="log_alert" style="display: none; color: red;">Не верно введен логин или пароль</p>
			
  <input class="login-input" checked="" id="signin" name="action" type="radio" value="signin">
  <label class="label-form" for="signin">Войти</label>
  <input class="signup-input" id="signup" name="action" type="radio" value="signup">
  <label class="label-form" for="signup">Регистрация</label>
  <!-- <input id="reset" name="action" type="radio" value="reset">
  <label class="label-form" for="reset">Reset</label> -->
  <div id="wrapper">
	<div id="arrow"></div>
	<input type="text" name="login" value="<?php echo @$data['login']; ?>" placeholder="Логин" required><br/>
	<input type="password" name="password" value="<?php echo @$data['password']; ?>" placeholder="Пароль" required><br/>
	<input type="password" name="password_2" id="two_pass" value="<?php echo @$data['password_2']; ?>" placeholder="Повтор пароля"><br/>
    <!-- <input id="email" placeholder="Email" type="text"> -->
    <!-- <input id="pass" placeholder="Password" type="password"> -->
    <!-- <input id="repass" placeholder="Repeat password" type="password"> -->
  </div>
  
  <button type="submit" id="button-form-modal" name="do_login">
    <span style="margin-top: 72px;">
      <!-- Reset password
      <br> -->
      Войти
      <br>
      Регистрация
    </span>
  </button> 
  <!-- <span class="disable_block444as33 disable_block444as">Cогласен с политикой</span> -->
  <input type="checkbox" id="cbx" style="display: none;">
<label for="cbx" class="check  check2" style="display:none;"> <span class="disable_block444as">Cогласен с политикой</span>
  <svg width="25px" height="25px" viewBox="0 0 18 18">
    <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
    <polyline points="1 9 7 14 15 4"></polyline>
  </svg>
</label>
</form>
		</div>
	</div>
</div>
<!-- position: absolute;
    top: 68px;
    display: block;
    right: 8%;
    z-index: 999999;? -->
		<!-- <input type="checkbox" id="nav-toggle" hidden> -->
   
		<?php if ( isset ($_SESSION['logged_user']) ) : ?>
	<div class="showbackground">
    <nav class="nav">
		<a class="close close-nav" href="#">&times;</a>
	 <h2>Профиль</h2>
	 <hr>
	 

   		<div class="lk" id="block">
	 <form action="avatar.php" method="post" enctype="multipart/form-data">
	 
		 <label for="pct" class="lla" style="background-image: url('<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->filename; ?>');background-size: cover;background-repeat: no-repeat;"></label>
		 
	  <input type="file" name="filename" id="pct" onchange="this.form.submit ()"><br> 
	  
	  </form>
	 <div class="lk-info">
	 <h3><?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->price; ?> <i class="fa fa-rub" aria-hidden="true"></i></h3>
	 <span>Место: <span class="reit-lv<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->id; ?>">12</span></span><br>
	 <!-- <a href="//www.free-kassa.ru/"><img src="//www.free-kassa.ru/img/fk_btn/14.png" title="Прием платежей на сайте"></a> -->
	 <a href="https://vk.me/qvinciy" target="_blank"><button class="paymetod preview-block__btn custom-btn">Пополнить баланс</button></a>
	 <!-- <form style="width: 100%;" id="payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8">
	<input type="hidden" name="ik_co_id" value="5d6d4d0a1ae1bdfab68b456e" />
	<input type="hidden" name="ik_pm_no" value="ID_4233" />
	<input type="hidden" name="ik_cur" value="RUB" />
	<input type="hidden" name="ik_desc" value="Новый платеж!" />
	<button style="color: white;" class="paymetod preview-block__btn custom-btn" type="submit" value="Pay">Пополнить баланс</button>
	<input style="width: 80%;
    border: 0px;
    
    border-bottom: 1px solid #757575;
    margin-top: 8px;" type="text" name="ik_am" value="100.00" />
</form> -->

	 </div>
</div>
<?php
// файл 1.php
$_SESSION['reason'] = array(1, 2, 3, 4, 5,6,7);
 
?>
	 <form action="index.php" method="POST" style="
    margin-top: 54px;">
<div class="group">      
      <input type="text" name="name" value="<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->name; ?>" >
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Номен</label>
    </div>

	 <div class="group">      
      <input type="text" name="vk" value="<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->vk; ?>" >
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Вконтакте</label>
    </div>
      
    <div class="group">      
      <input type="text" name="insta" value="<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->insta; ?>" >
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Инстаграм</label>
	</div>  
	
    <div class="group group2">
      <label>Информация</label>
		<textarea name="info"><?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->info; ?></textarea>     
      <span class="highlight"></span>
      <span class="bar"></span>
    </div>
    
		 <!-- <label>О себе:</label> -->
		 <!-- <textarea rows="3" name="info"><?php // $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->info; ?></textarea><br/> -->
	 <button class="paymetod" style="margin-top: 40px;" name="do_account">Сохранить</button>
	 </form>
	 
	<a href="logout.php">Выйти</a>
	</nav>
		</div>
			

<?php else : ?>
	<p>Без регистрации личного кабинета не будет!</p>
<?php endif; ?>
		
		<!-- Правила -->
		<div class="modal-dialog ofera profile-dialog444as asdasd444as disabled fade" style="
    z-index: 9999;">
		<div class="overlay"></div>
		<content class="profile-menu modal-info">
			<header class="close-exit444as">
				<a style="
    position: absolute;">&times</a>
			<h2 style="text-align: center; margin: 0;">Пользовательское соглашение</h2>
			</header>
			<div class="">
			 

Настоящее Пользовательское соглашение регулирует отношения между пользователем сети Интернет (далее - Пользователь) и владельцем сайта в сети интернет  http://qvinciy.ru, возникающие при использовании интернет-ресурса http://qvinciy.ru, на условиях,  указанных в Пользовательском соглашении. 

Безоговорочным и полным принятием Пользователем положений настоящего Пользовательского соглашения является совершение действий Пользователем, которые направлены на использование Сайта, включая, но не ограничиваясь: подача, просмотр, оплата услуг, участие в рейтинге, направление сообщений Администрации сайта, и иные действия по использованию функциональности Сайта. 

Владелец сайта в сети интеренет имеет право в любое время в одностороннем порядке вносить изменения в Пользовательское соглашения без какого-либо специального уведомления об этом Пользователя. Новая редакция Пользовательского соглашения вступает в силу с момента ее размещения на Сайте, если в нем не указано иное. 

С момента вступления в силу новой редакции Пользовательского соглашения использование Пользователем Сайта означает его согласие с ней и применение к Пользователю в полном объеме положений новой редакции Пользовательского соглашения. 

<br><br>

1. Определения и термины 

<br><br>
В настоящем Пользовательском соглашении нижеуказанные термины имеют следующее значение: 

Сайт - Интернет ресурс, представляющий собой совокупность содержащихся в информационной системе информации и объектов интеллектуальной собственности (в том числе, программа для ЭВМ, база данных, графическое оформление интерфейса (дизайн) и др.), доступ к которому обеспечивается с различных пользовательских устройств, подключенных к сети Интернет, посредством специального программного обеспечения для просмотра веб-страниц (браузер) по адресу http://qvinciy.ru (включая домены следующих уровней, относящихся к данным адресам). 

Владелец сайта в сети интернет – Гаврилов Никита Александрович. 

Сервисы - службы, услуги, функциональные возможности, инструменты, доступные для Пользователей на Сайте. 

Пользователь - посетитель ресурсов сети Интернет, в том числе Сайта. 

Пользовательское соглашение - настоящее соглашение и иные правила и документы, размещенные на Сайте, регламентирующие работу Сайта и/или определяющие порядок использования Сервисов. 

Услуга - регистрация и размещения Покупателя в публичном рейтинге «Qvinciy», место в котором зависит от суммы затрат Покупателя и носит соревновательный характер с другими Покупателями (смотри публичный договор оферты) 

Сведения - любые материалы и информация, предоставляемые Пользователем в связи с использованием Сайта. 

Покупатель - Пользователь, осуществляющий взаимодействие с Продавцом в отношении Товара и/или заключающий сделку с Продавцом. 

<br><br>

2. Обязательства Пользователя 
<br><br>
2.1. Пользователь обязуется действовать исключительно в соответствии с действующим законодательством Российской Федерации и Пользовательским соглашением, а также нести в соответствии с законодательством Российской Федерации полную ответственность за собственные действия/бездействие на Сайте и при использовании Сервисов. 
<br><br>
2.2. Пользователь обязуется не использовать автоматические и иные программы для получения доступа на Сайт без письменного разрешения владельца сайта в сети интернет. Без разрешения владельца сайта в сети интернет также не допускается распространение, использование, копирование и/или извлечение с Сайта ручным или автоматическим способом (с использованием программных средств) любых материалов или информации.  
<br><br>
2.3. Доступные Пользователю Сервисы могут быть использованы исключительно в целях, для которых такие Сервисы предназначены. Пользователю запрещается использовать Сервисы, а также любую полученную на Сайте информацию не по назначению. 
<br><br>
2.4. В целях пресечения или предотвращения нарушения Пользовательского соглашения и/или причинения ущерба владелец сайта в сети интернет имеет безусловное право ограничивать доступ Пользователей или третьих лиц к Сайту путем блокирования доступа к Сайту соответствующего ip-адреса или диапазона ip-адресов. 
<br><br>
2.5. Осуществляя доступ к Сайту, Пользователь выражает свое согласие на получение рекламной информации, размещенной на Сайте третьими лицами. Пользователь понимает и соглашается, что владелец сайта в сети интернет  не определяет содержание и не несет ответственности за такую информацию, включая сайты, ссылки на которые могут содержаться в соответствующих материалах. 
<br><br>
 

3. Сведения, предоставляемые Пользователями 
<br><br>
3.1. В рамках использования Сайта Пользователь обязуется предоставлять только достоверные Сведения и несет ответственность за предоставленную им информацию.  
<br><br>
3.2. В процессе пользования Сервисами Пользователь самостоятельно и добровольно принимает решение о предоставлении владельцу сайта в сети интернет персональных и иных сведений о Пользователе. 
<br><br>
3.3. Владелец сайта в сети интернет не обязан осуществлять предварительную проверку Сведений любого вида, предоставляемых Пользователем. 

 
<br><br>
4. Права и обязанности 
<br><br>
4.1. Владелец сайта в сети интернет имеет право рассылать Пользователям сообщения информационного или технического характера, связанного с использованием Сайта. 
<br><br>
4.2. Владелец сайта в сети интернет осуществляет текущее управление Сайтом, определяет его внешний вид и структуру, разрешает или ограничивает доступ Пользователя к Сайту и осуществляет иные действия, необходимые для нормального функционирования Сайта. 
<br><br>
4.3. Владелец сайта в сети интернет имеет право управлять Сайтом исключительно по своему усмотрению, приостанавливать либо изменять условия работы Сайта без предварительного уведомления Пользователя, в том числе для проведения необходимых плановых профилактических и ремонтных работ на технических ресурсах. 
<br><br>
4.4. Владелец сайта в сети интернет имеет право в целях сбора статистических данных и идентификации Пользователя устанавливать, сохранять личные данные и иную информацию о Пользователях. 
<br><br>
4.5. Владелец сайта в сети интернет, на условиях, изложенных в настоящем Соглашении, обязуется предоставить Пользователю возможность использовать Сайт. 
<br><br>
4.6. Владелец сайта в сети интернет имеет право в любое время прекратить доступ Пользователя к Сайта на условиях настоящего Соглашения, без возможности последующего возобновления предоставления доступа к Сайту. 
<br><br>
4.7. Владелец сайта в сети интернет не занимается рассмотрением и разрешением споров и конфликтных ситуаций, возникающих между Пользователями Сайта, однако оставляет за собой право заблокировать страницу Пользователя в случае получения от других Пользователей мотивированных жалоб на некорректное поведение данного Пользователя. 
<br><br>
4.8. Владелец сайта в сети интернет имеет право использовать информацию о действиях Пользователя в целях улучшения работы Сайта. 
<br><br>
4.9. Владелец сайта в сети интернет не несёт ответственности за раскрытие Пользователем своих Личных данных и персональной информации. 
<br><br>
4.10. Владелец сайта в сети интернет оставляет за собой право вводить любые ограничения в отношении пользования Сайтом как в целом, так и для отдельных Пользователей без уведомления или без объяснения причин. 
<br><br>
4.11. В случае нарушения Пользователем условий данного Соглашения, владелец сайта в сети интернет имеет безусловное право удалить Учетную запись Пользователя. 

 
<br><br>
5. Обмен информацией при использовании Сайта 
<br><br>
5.1. Сообщения Владельца сайта в сети интернет, предназначенные для Пользователей, публикуются для всеобщего доступа на Сайте и/или рассылаются индивидуально по электронным адресам. 
<br><br>
5.2. Осуществляя доступ к Сайту, Пользователь выражает свое согласие с тем, что владелец сайта в сети интернет http://qvinciy.ru,   может направлять Пользователю электронные письма qvinciy@mail.ru и сообщения. 

<br><br>

6. Ответственность 
<br><br>
6.1. Пользователь несет ответственность за действия, совершаемые на Сайте, в соответствии с действующим законодательством Российской Федерации. 
<br><br>
6.2. Пользователь согласен, что владелец сайта в сети интернет не несет ответственности за возможные убытки, причиненные Пользователю в связи с принятием мер пресечения или предотвращения нарушений на Сайте, связанных с ограничением/блокировкой доступа Пользователей к Сайту, а также IP-адресов согласно настоящего Пользовательского соглашения. 
<br><br>
6.3. Учитывая принципы построения и функционирования сети Интернет, владелец сайта в сети интернет не предоставляет каких-либо гарантий в отношении Сервисов, в частности, не гарантирует Пользователю, что: 
<br>
-Сервисы будут предоставляться непрерывно, надежно и без ошибок; 
<br>
-Сервисы, их прямой или косвенный эффект и качество будут соответствовать требованиям и целям Пользователя; 
<br>
-Результаты, которые будут получены посредством использования Сервисов, будут точными, надежными и соответствовать ожиданиям Пользователя. 

 
<br><br>
7. Интеллектуальные права 
<br><br>
7.1. Обладателем исключительных прав на Сайте, включая, но не ограничиваясь на доменное имя, размещенный на Сайте логотип, товарный знак, базы данных, все технические разработки, позволяющие осуществлять использование Сайта является владелец сайта в сети интернет. Пользователь или иное лицо не имеет право использовать Сайт, Сервисы способами, не предусмотренными настоящим Пользовательским соглашением без письменного разрешения, в том числе извлекать Сведения в любой форме не предусмотренными Пользовательским соглашением способами. 

 
<br><br>
8. Срок действия Пользовательского соглашения 
<br><br>
8.1. Настоящее Пользовательское соглашение вступает в силу с момента начала пользования Пользователем Сервисами Сайта, независимо от факта Регистрации Пользователя, и действуют бессрочно. 
<br><br>
8.2. Владелец сайта в сети интернет оставляет за собой право по собственному усмотрению прекратить доступ Пользователя, нарушающего настоящее Пользовательское соглашение, а также условия любого из Сервисов, иных правил, регламентирующих функционирование Сайта, к Сервисам как в целом, так и в части, в том числе прекратить или временно приостановить доступ Пользователя в Личный кабинет. 

 
<br><br>
9. Передача прав 
<br><br>
9.1. Владелец сайта в сети интернет имеет безусловное право, а Пользователь настоящим дает свое согласие на это, передать свои права и/или обязанности по настоящему Пользовательскому соглашению, как в целом, так и в части, третьей стороне. В случае передачи прав и/или обязанностей, как в целом, так и в части, по настоящему Пользовательскому соглашению третьей стороне, третья сторона имеет право предоставлять аналогичные или похожие услуги на другом сайте. 

 
<br><br>
10. Споры и действующее законодательство 
<br><br>
10.1. При разрешении всех споров по настоящему Пользовательскому соглашению применяется действующее законодательство Российской Федерации. 
<br><br>
10.2. Все споры, возникшие в рамках настоящего Соглашения, должны быть переданы на рассмотрение в суд в соответствии с территориальной подсудностью по месту нахождения владельца сайта в сети интернет. 
<br><br>
10.3. Признание отдельных частей настоящего Пользовательского соглашения недействительными не отменяет действие других положений настоящего Пользовательского соглашения. 

Нарушение правил, а также поступление многочисленных жалоб пользователей на объявления могут привести к блокировке, как объявлений, так и учетных записей их владельцев.  

Соглашаясь с данными правилами, Вы также подтверждаете, что ознакомились и согласны со следующими разделами «условий и правил» данного сайта.  

 
			</div>
			
                      <script></script>
                      <style>
        
                            </style>
          

		</content>
	</div>
<!-- Правила2 -->
<div class="modal-dialog ofera profile-dialog444as2 asdasd444as disabled fade" style="
    z-index: 9999;">
		<div class="overlay"></div>
		<content class="profile-menu modal-info">
			<header class="close-exit444as">
				<a style="
    position: absolute;">&times</a>
			<h2 style="text-align: center; margin: 0;">Договор оферты</h2>
			</header>
			<div class="">
			
Настоящий договор между владельцем сайта в сети интернет Гаврилова Никиты Александровича и пользователем услуг сайта в сети интернет,  именуемым в дальнейшем «Покупатель» определяет условия приобретения услуги через сайт http://qvinciy.ru  Настоящий договор – оферта действует с 01 Августа 2019 года.  

  
<br><br>
1. ОБЩИЕ ПОЛОЖЕНИЯ 

<br><br>

1.1. Владелец сайта в сети интернет публикует настоящий договор, являющийся публичным договором - офертой (предложением) в адрес физических и юридических лиц в соответствии со ст. 435 и пунктом 2 статьи 437 Гражданского Кодекса Российской Федерации (далее - ГК РФ).   
<br><br>
1.2. Настоящая публичная оферта (именуемая в дальнейшем «Оферта») определяет все существенные условия договора между владельцем сайта в сети интернет и лицом, акцептовавшим Оферту.   
<br><br>
1.3. Настоящий договор заключается между Покупателем и владельцем сайта в сети интернет в момент осуществления оплаты за предоставляемые услуги, что так же считается полным принятием условий настоящего договора.   
<br><br>
1.4. Оферта может быть акцептована (принята) любым физическим или юридическим лицом на территории Российской Федерации, имеющим намерение приобрести услуги, реализуемые/предоставляемые владельцем сайта в сети интернет http://qvinciy.ru 
<br><br>
1.5. Покупатель безоговорочно принимает все условия, содержащиеся в оферте в целом (т.е. в полном объеме и без исключений).   
<br><br>
1.6. В случае принятия условий настоящего договора (т.е. публичной оферты), физическое или юридическое лицо, производящее акцепт оферты, становится Покупателем.   
<br><br>
1.7. Акцептом является получение владельцем сайта в сети интернет денежных средств от Покупателя.  
<br><br>
1.8. Оферта, все приложения к ней, а также вся информация о услугах ООО, опубликована на сайте http://qvinciy.ru 

<br><br>

2. СТАТУС ИНТЕРНЕТ - САЙТА http://qvinciy.ru 

<br><br>

2.1. Интернет-сайт является собственностью владельца сайта в сети интернет и предназначен для организации дистанционного способа продажи услуг через сеть интернет.  
<br><br>
2.2. Интернет-сайт не требует от Покупателя специальных действий для использования ресурса интернет-сайта для просмотра статуса и расчета, таких как заключение договора на пользование ресурсом интернет-сайта.   
<br><br>
2.3. Интернет-сайт не несет ответственности за содержание и достоверность информации, предоставленной Покупателем при приобретении услуги.   

<br><br>

3. СТАТУС ПОКУПАТЕЛЯ 

<br><br>

3.1. Покупатель несет ответственность за достоверность предоставленной при приобретении услуги информации, и ее чистоту от претензий третьих лиц.  
<br><br>
3.2. Покупатель подтверждает свое согласие с условиями, установленными настоящим Договором, путем проставления отметки в графе «Я принимаю условия публичного договора-оферты» при приобретении услуги. До заключения Договора условия Договора Покупателем прочитаны полностью, все условия Договора понятны, со всеми условиями Договора Покупатель согласен.  
<br><br>
3.3. Использование ресурса интернет-сайта для просмотра статуса и оплаты услуги, является для Покупателя безвозмездным.  
<br><br>
3.4. Услуги приобретаются Покупателем исключительно для личных целей.  
<br><br>
4. ПРЕДМЕТ ОФЕРТЫ 

  
<br><br>
4.1. Владелец сайта в сети интернет, на основании действий Покупателя, выраженных в оплате услуги, продаёт Покупателю услуг по регистрации и размещению Покупателя в публичном рейтинге «Qvinciy», место в котором зависит от суммы затрат Покупателя и носит соревновательный характер с другими Покупателями.  

Сумма покупки каждого места должна быть больше предыдущего владельца. Ротация в рейтинге зависит от суммы вложения Покупателя, а при равных вложениях учитывается время оплаты услуги – преимущество по занятию более высокого места, получает Покупатель, который произвел оплату раньше.  

Оплаченные Покупателем суммы  не пропадают, и суммируются со всеми оплатами Покупателя. 
<br><br>
4.2.Рейтинг «Qvinciy» мест занимаемых Покупателем размещается на сайте  http://qvinciy.ru 
<br><br>
4.3. К отношениям между Покупателем и владельцем сайта в сети интернет применяются положения ГК РФ, Закон РФ «О защите прав потребителей» от 07.02.1992 №2300-1, а также иные нормативные правовые акты, принятые в соответствии с ними.   
<br><br>
4.4. Физическое или юридическое лицо считается принявшим все условия оферты (акцепт оферты) в полном объеме и без исключений с момента получения владельцем сайта в сети интернет денежных средств от Покупателя. В случае акцепта оферты физическое или юридическое лицо считается заключившим с владельцем сайта в сети интернет договор купли-продажи услуги и приобретает статус Покупателя.  

<br><br>

5. ОПРЕДЕЛЕНИЯ 

<br><br>

5.1. Покупатель - физическое или юридическое лицо, принявшее в полном объеме и без исключений условия оферты (совершившее акцепт оферты) в соответствии с п. 4.4. оферты.  
<br><br>
5.2. Владелец сайта в сети интернет – Гаврилов Никита Александрович.  
<br><br>
5.3. Интернет-сайт - сайт, имеющий адрес в сети интернет http://qvinciy.ru принадлежащий Владельцу сайта в сети интернет и предназначенный для продажи услуги Покупателям на основании оферты.  
<br><br>
5.4. Услуга – информация о предоставляемой услуги приведена в п. 4.1. настоящего договора.   
<br><br>
5.5. Оплата – перечисление Покупателем денежных средств на счет владельца сайта в сети интернет.  
<br><br>
5.8. Время оказания услуги – момент появления на сайте http://qvinciy.ru сведений о внесении Покупателем денежных средств.  
<br><br>
5.9. Стороны - совместно Покупатель и Владелец сайта в сети интернет.  

<br><br>

6. ПОРЯДОК ЗАКЛЮЧЕНИЯ ДОГОВОРА  

<br><br>

6.1. Покупатель оформляет покупку услуги самостоятельно на интернет-сайте, на условиях Договора публичной оферты интернет-сайта.  
<br><br>
6.2. При покупке услуги на интеренет-сайте, Покупатель обязан предоставить о себе информацию:  • Номен (для физических лиц).   
<br><br>
6.3. Волеизъявление Покупателя осуществляется посредством внесения последним соответствующих данных в форму приобретения услуги на интернет-сайте.  

<br><br>

7. ЦЕНА УСЛУГИ 

  
<br><br>
7.1. Цена услуги на интернет-сайте выбирается самим Покупателем и  указывается в рублях РФ.  

<br><br>

8. ОПЛАТА УСЛУГИ 

<br><br>

8.1. Оплата услуги покупателем производится в безналичной форме.  
<br><br>
8.2. Оплата производится на счет владельца сайта в сети интернет который указан  на сайте http://qvinciy.ru 
<br><br>
8.3. Возврат оплаченных Покупателем сумм, за выполненную владельцем сайта в сети интернет услугу по внесению сведений о Покупателе услуг в рейтинг «Qvinciy» на сайте http://qvinciy.ru , не производится. 

<br><br>

9. ПРОЧИЕ УСЛОВИЯ 

  
<br><br>
9.1. К отношениям между Сторонами применяется законодательство Российской Федерации.   
<br><br>
9.2. В случае возникновения вопросов и претензий со стороны Покупателя, он должен обратиться в Центр обслуживания клиентов по e-mail: qvinciy@mail.ru . Заявления и обращения Покупателей рассматриваются в течении 20 календарных дней. 
<br><br>
 9.3. Настоящий договор вступает в силу с даты акцепта Покупателем настоящей оферты и действует до полного исполнения обязательств Сторонами.  
 <br><br>
9.4. Владелец сайта в сети интернет оставляет за собой право расширять и(или) сокращать предложение услуг на сайте, регулировать доступ к покупке услуг, а также приостанавливать или прекращать продажу услуг по своему собственному усмотрению.  

 

 
			</div>
			
                      <script></script>
                      <style>
        
                            </style>
          

		</content>
	</div>
		<style>
.upload_avatar{
	font-size: 25px;
    position: absolute;
    left: 50%;
    z-index: 9;
	display:none;
    margin-left: -15px;
	transition: .3s;
}
.lla:hover .upload_avatar{
	display:block;
	transition: .3s;
}
.lla:hover{
	background-image: url('https://i.imgur.com/6qUrAqc.png')!important;
}
.lla{
	display: inline-block;
  	width: 4em;
	transition: .3s;
	height: 4em;
	
	border: 1px solid black;
	background-size: contain;
	background-repeat: no-repeat;
	background-position: center;
	border-radius: 50%;
}
#pct{
	display: none;
}
		</style>
		<?php if ( isset ($_SESSION['logged_user']) ) : ?>

		<script>
$('.carousel-group').each(function(){
	$('.table-header').each(function(i){
		$('#header-rating', this).each(function(){
			$(this).html(i+1 -1);
		})
		// $(".your-div").text("your text");
	})
})
$('.double-scroll').each(function(){
	$('.modal-reit-monolit').each(function(i){
		$('.profile-rating-span', this).each(function(){
			$(this).html(i+1);
		})
		// $(".your-div").text("your text");
	})
})

$('.profile-rating-span<?php 
		$id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->id; 
		?>').clone(true).unwrap().appendTo( $('.reit-lv<?php 
		$id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->id; 
		?>').empty() );

document.querySelector("input").addEventListener("change", function () {
  if (this.files[0]) {
    var fr = new FileReader();

    fr.addEventListener("load", function () {
      document.querySelector("label").style.backgroundImage = "url(" + fr.result + ")";
    }, false);

    fr.readAsDataURL(this.files[0]);
  }
});
		</script>
<?php else : ?>
<script>
$('.carousel-group').each(function(){
	$('.table-header').each(function(i){
		$('#header-rating', this).each(function(){
			$(this).html(i+1 -1);
		})
		// $(".your-div").text("your text");
	})
})
$('.double-scroll').each(function(){
	$('.modal-reit-monolit').each(function(i){
		$('.profile-rating-span', this).each(function(){
			$(this).html(i+1);
		})
		// $(".your-div").text("your text");
	})
})

		</script>
<?php endif; ?>
	
<script >
if(/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)){

	$(".accordion-container").on("click", function(){  
  if($('#about').prop('checked')){
	document.querySelectorAll(".social-icons").forEach(elem => elem.style.display = "none");
	// $('.social-icons').fadeOut(1000);
  }else{

	// $('.social-icons').fadeIn(1000);
	document.querySelectorAll(".social-icons").forEach(elem => elem.style.display = "block");
  }
});

$('nav input,.nav textarea').focus(function(){
	$('#block').hide();
	
	}).blur(function(){
	$('#block').show();
			  
});
}
</script>
<style>
#block {
 transition: 2s;
}
</style>
		<script>
		$(".close-reg").on("click", function(){   
			document.querySelector('.overlay2').classList.remove('overlay2');
		});
		$(".disable_block444as").on("click", function(){   
			document.querySelector('.profile-dialog444as').classList.remove('disabled');
		});
		$(".close-exit444as").on("click", function(){   
			document.querySelector('.profile-dialog444as').classList.add('disabled');
		});
		</script>
		<script>
		$(".disable_block444as2").on("click", function(){   
			document.querySelector('.profile-dialog444as2').classList.remove('disabled');
		});
		$(".close-exit444as").on("click", function(){   
			document.querySelector('.profile-dialog444as2').classList.add('disabled');
		});






$(".accordion-container").on("click", function(){  
  if($('#about').prop('checked')){
	document.querySelectorAll(".accordion-tab header").forEach(elem => elem.style.display = "block");
	$('.accordion-tab header a').fadeIn(1000);
  }else{

	document.querySelectorAll(".accordion-tab header").forEach(elem => elem.style.display = "none");
	$('.accordion-tab header a').fadeOut(1000);
  }
});
		</script>
		<script>
// $(".accordion-container").mouseout( function(){      
// 	$("#about").attr("checked", "checked");
// });


$(".close-acordeon-mob a").on("click", function(){      
	$("#main").prop("checked", true);
	$("#about").prop("checked", false);
});
$(".main-container").mouseout( function(){      
	$("#main").prop("checked", true);
	$("#about").prop("checked", false);
});
$(".accordion-tab-ofset").mouseout( function(){      
	$("#main").prop("checked", true);
	$("#about").prop("checked", false);
});



$(".login-input").on("click", function(){      
	$("#modalform").attr("action", "index.php");
	$("#button-form-modal").attr("name", "do_login");
	$("#two_pass").removeAttr("required","");
	$("#cbx").removeAttr("required","");
	document.querySelectorAll(".check").forEach(elem => elem.style.display = "none");
	document.querySelectorAll(".disable_block444as33").forEach(elem => elem.style.display = "none");
	// document.querySelectorAll("#poopReglock").forEach(elem => elem.style.height = "320px");
	// $(".popup .content").attr("style", "height: 400px;");
});
$(".signup-input").on("click", function(){      
	$("#modalform").attr("action", "index.php");
	$("#button-form-modal").attr("name", "do_signup");
	$("#two_pass").attr("required","");
	$("#cbx").attr("required","");
	document.querySelectorAll(".check").forEach(elem => elem.style.display = "block");
	document.querySelectorAll(".disable_block444as33").forEach(elem => elem.style.display = "block");
	// document.querySelectorAll("#poopReglock").forEach(elem => elem.style.height = "500px");
	// $(".popup .content").attr("style", "height: 500px;");
});
$(".social-account-okay").on("click", function(){      
	document.querySelectorAll(".nav").forEach(elem => elem.style.right = "0");
	document.querySelectorAll(".nav").forEach(elem => elem.style.boxShadow = "0 0 2px black");
});
$(".inf,.close-nav").on("click", function(){      
	$('.nav').attr('style', '');
});
$('.accordeon_target').click(function(){
  if (!$(this).data('status')) {
	$('.table-carousel').attr('style', 'overflow-y: hidden;');
	$('.nno').attr('style', 'display: block;');
    $(this).data('status', true);
  }
  else {
	$('.table-carousel').attr('style', 'overflow-y: auto;');
	$('.nno').attr('style', 'display: none;');
    $(this).data('status', false);
  }
});





$(".header-chert").on("click", function(){      
	$('.input').attr('style', 'display: block');
	$('.header-chert').attr('style', 'display: none');
});
$(".table-carousel").mouseover(function(){      
	$('.input').attr('style', '');
	$('.header-chert').attr('style', '');
});

// Акордион в модуле
$('.profile-avatar').click(function(){
  if (!$(this).data('status')) {
	$('.profile-bio').attr('style', 'display: block;');
	// $('.profile-avatar2').attr('style', 'margin-left: 0px!important;background-image: url("https://image.flaticon.com/icons/png/512/52/52851.png");background-size: cover;background-repeat: no-repeat;background-position: center;');   
    $(this).data('status', true);
  }
  else {
	$('.profile-bio').attr('style', 'display: none;');
	// $('.profile-avatar2').attr('style', 'margin-left: 20px!important;background-image: url("https://image.flaticon.com/icons/png/512/52/52851.png");background-size: cover;background-repeat: no-repeat;background-position: center;');    
    $(this).data('status', false);
  }
});
// //Акордион в модуле


$("#nextCarousel").click(function(){
	$(".main-container .table-carousel").animate({
    	scrollTop: $('.main-container .table-carousel').scrollTop() + 480
	}, 0);
	$('.main-container .table-carousel').fadeOut(0);
	$('.main-container .table-carousel').fadeIn(200);
});

$("#prevCarousel").click(function(){
	$(".main-container .table-carousel").animate({
    	scrollTop: $('.main-container .table-carousel').scrollTop() - 480
	}, 0);
	$('.main-container .table-carousel').fadeOut(0);
	$('.main-container .table-carousel').fadeIn(200);
});


$('.js-open-modal').click(function(event) {
   event.preventDefault();
   
   var modalName = $(this).attr('data-modal');
   var modal = $('.js-modal[data-modal="' + modalName + '"]');
   
   modal.addClass('is-show');
   $('.js-modal-overlay').addClass('is-show')
});

$('.js-modal-close').click(function() {
   $(this).parent('.js-modal').removeClass('is-show');
   $('.js-modal-overlay').removeClass('is-show');
});
   
$('.js-modal-overlay').click(function() {
   $('.js-modal.is-show').removeClass('is-show');
   $(this).removeClass('is-show');
})

// Фильтр
document.addEventListener('animationstart', function (e) {
  if (e.animationName === 'fade-in') {
      e.target.classList.add('did-fade-in');   
  }
});

document.addEventListener('animationend', function (e) {
  if (e.animationName === 'fade-out') {
      e.target.classList.remove('did-fade-in');
   }
});
// https://github.com/joshaven/string_score
String.prototype.score = function (word, fuzziness) {
  'use strict';

  // If the string is equal to the word, perfect match.
  if (this === word) { return 1; }

  //if it not a perfect match and is empty return 0
  if (word === "") { return 0; }

  var runningScore = 0,
      charScore,
      finalScore,
      string = this,
      lString = string.toLowerCase(),
      strLength = string.length,
      lWord = word.toLowerCase(),
      wordLength = word.length,
      idxOf,
      startAt = 0,
      fuzzies = 1,
      fuzzyFactor,
      i;

  // Cache fuzzyFactor for speed increase
  if (fuzziness) { fuzzyFactor = 1 - fuzziness; }

  // Walk through word and add up scores.
  // Code duplication occurs to prevent checking fuzziness inside for loop
  if (fuzziness) {
    for (i = 0; i < wordLength; i+=1) {

      // Find next first case-insensitive match of a character.
      idxOf = lString.indexOf(lWord[i], startAt);

      if (idxOf === -1) {
        fuzzies += fuzzyFactor;
      } else {
        if (startAt === idxOf) {
          // Consecutive letter & start-of-string Bonus
          charScore = 0.7;
        } else {
          charScore = 0.1;

          // Acronym Bonus
          // Weighing Logic: Typing the first character of an acronym is as if you
          // preceded it with two perfect character matches.
          if (string[idxOf - 1] === ' ') { charScore += 0.8; }
        }

        // Same case bonus.
        if (string[idxOf] === word[i]) { charScore += 0.1; }

        // Update scores and startAt position for next round of indexOf
        runningScore += charScore;
        startAt = idxOf + 1;
      }
    }
  } else {
    for (i = 0; i < wordLength; i+=1) {
      idxOf = lString.indexOf(lWord[i], startAt);
      if (-1 === idxOf) { return 0; }

      if (startAt === idxOf) {
        charScore = 0.7;
      } else {
        charScore = 0.1;
        if (string[idxOf - 1] === ' ') { charScore += 0.8; }
      }
      if (string[idxOf] === word[i]) { charScore += 0.1; }
      runningScore += charScore;
      startAt = idxOf + 1;
    }
  }

  // Reduce penalty for longer strings.
  finalScore = 0.5 * (runningScore / strLength    + runningScore / wordLength) / fuzzies;

  if ((lWord[0] === lString[0]) && (finalScore < 0.85)) {
    finalScore += 0.15;
  }

  return finalScore;
};

// http://ejohn.org/apps/livesearch/jquery.livesearch.js
jQuery.fn.liveUpdate = function(list) {
  list = jQuery(list);

  if (list.length) {
    var rows = list.children('li'),
      cache = rows.map(function() {
        return this.innerHTML.toLowerCase();
      });

    this
      .keyup(filter).keyup()
      .parents('form').submit(function() {
        return false;
      });
  }

  return this;

  function filter() {
    var term = jQuery.trim(jQuery(this).val().toLowerCase()),
      scores = [];

    if (!term) {
      rows.show();
    } else {
      rows.hide();

      cache.each(function(i) {
        var score = this.score(term);
        if (score > 0) {
          scores.push([score, i]);
        }
      });

      jQuery.each(scores.sort(function(a, b) {
        return b[0] - a[0];
      }), function() {
        jQuery(rows[this[1]]).show();
      });
    }
  }
};

$("#search").liveUpdate("#colors");

// Подсказка

var $info = $('.tooltip');
$info.each( function () {
  var dataInfo = $(this).data("tooltip");
  $( this ).append('<span class="inner" >' + dataInfo + '</span>');
});

// Поиск

const overlay_Monolit1 = document.querySelector('.overlay_Monolit-1');
                      const overlay_Monolit2 = document.querySelector('.overlay_Monolit-2');
                      const searchadffff = document.querySelector('.searchadffff');
                      const input = document.querySelector('.input');
                      overlay_Monolit1.addEventListener('click', () => {
                        searchadffff.classList.toggle('active');
                        if (searchadffff.classList.contains('active')) {
                          setTimeout(() => {
                            input.focus();
                          }, 200)
                        }
                      })
                      searchadffff.addEventListener('click', () => {
                        if (searchadffff.classList.contains('active')) {
                          setTimeout(() => {
                            input.focus();
                          }, 200)
                        }
                      })
                      overlay_Monolit2.addEventListener('click', (e) => {
                        input.value = '';
                        input.focus();
                        searchadffff.classList.remove('searchadffffing')
                      })
                      document.body.addEventListener('click', (e) => {
                        if (!searchadffff.contains(e.target) && input.value.length === 0) {
                          searchadffff.classList.remove('active');
                          searchadffff.classList.remove('searchadffffing');
                          input.value = '';
                        }
                      })
                      input.addEventListener('keyup', (e) => {
                        if (e.keyCode === 13) {
                          input.blur();
                        }
                      })
                      input.addEventListener('input', () => {
                        if (input.value.length > 0) {
                          searchadffff.classList.add('searchadffffing')
                        } else {
                          searchadffff.classList.remove('searchadffffing')
                        }
                      })
                      input.value = '';
                      input.blur();
</script>
	<style>
	/* form starting stylings ------------------------------- */
.group 			  { 
  position:relative; 
  margin-bottom:45px; 
}
.group 	input,.group textarea{
  font-size:13px;
  padding:10px 10px 10px 5px;
  display:block;
    width: 100%;
  border:none;
  border-bottom:1px solid #757575;
}
.group 	input:focus 		{ outline:none; }

/* LABEL ======================================= */
.group 	label 				 {
  color:#999; 
  font-size:13px;
  font-weight:normal;
  position:absolute;
  pointer-events:none;
  left:5px;
  top:10px;
  transition:0.2s ease all; 
  -moz-transition:0.2s ease all; 
  -webkit-transition:0.2s ease all;
}
.group2 label{
  color:#000; 
  font-size:14px;
  font-weight:normal;
  position:absolute;
  pointer-events:none;
  left:5px;
  top:-20px;
  transition:0.2s ease all; 
  -moz-transition:0.2s ease all; 
  -webkit-transition:0.2s ease all;
}
/* active state */
.group 	input:focus ~ label, .group input:valid ~ label 		{
  top:-20px;
  font-size:14px;
  color:#000;
}

/* BOTTOM BARS ================================= */
.bar 	{ position:relative; display:block; width:300px; }
/* .bar:before, .bar:after 	{
  content:'';
  height:2px; 
  width:0;
  bottom:1px; 
  position:absolute;
  background:#000; 
  transition:0.2s ease all; 
  -moz-transition:0.2s ease all; 
  -webkit-transition:0.2s ease all;
}
.bar:before {
  left:50%;
}
.bar:after {
  right:50%; 
} */

/* active state */
/* .group 	input:focus ~ .bar:before, .group 	input:focus ~ .bar:after {
  width:50%;
} */

/* HIGHLIGHTER ================================== */
.highlight {
  position:absolute;
  height:60%; 
  width:100px; 
  top:25%; 
  left:0;
  pointer-events:none;
  opacity:0.5;
}

/* active state */
/* .group 	input:focus ~ .highlight {
  -webkit-animation:inputHighlighter 0.3s ease;
  -moz-animation:inputHighlighter 0.3s ease;
  animation:inputHighlighter 0.3s ease;
} */

/* ANIMATIONS ================ */
@-webkit-keyframes inputHighlighter {
	from { background:#000; }
  to 	{ width:0; background:transparent; }
}
@-moz-keyframes inputHighlighter {
	from { background:#000; }
  to 	{ width:0; background:transparent; }
}
@keyframes inputHighlighter {
	from { background:#000; }
  to 	{ width:0; background:transparent; }
}
	</style>
	
</body>

</html>