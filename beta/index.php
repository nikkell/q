<!-- * комментарий - комментарий не от автора кода -->
<?php
	require 'db.php'; // * файл для подключания базы данных и RedBeanPHP

	$data = $_POST;
	if ( isset($data['do_account']) ) { // * отправка формы для сохранения данных пользователя
		$id = $_SESSION['logged_user']->id;
		$user = R::load('users', $id);
		$user->vk = $data['vk']; // * ссылка на страницу пользователя в VK
		$user->insta = $data['insta']; // * ссылка на страницу пользователя в Instagram
		$user->info = $data['info']; // * "о себе" пользователя
		$user->name = $data['name']; // * номен пользователя

		R::store($user);
		header("Location: ".$_SERVER["REQUEST_URI"]); // * обновить страницу
	}

	$data = $_POST;
	if ( isset($data['do_account']) ) {
		$id = $_SESSION['logged_user']->id;
		$user = R::load('users', $id);
		$user->vk = $data['vk'];
		$user->insta = $data['insta'];
		$user->info = $data['info'];
		$user->name = $data['name'];

		R::store($user);
	}

	$data = $_POST;
	if ( isset($data['do_login']) ) { // * отправка формы авторизации пользователя
		$user = R::findOne('users', 'login = ?', array($data['login']));
		if ( $user ) {
			// логин существует
			if ( password_verify( $data['password'], $user->password ) ) { // * проверка пароля, ведённого в форме и зашифрованной строки из БД
				$_SESSION['logged_user'] = $user;
				header("Location: ".$_SERVER["REQUEST_URI"]);
			} else { // * вывод надписи "Не верно введен логин или пароль" в форме авторизации
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
		} else { // * вывод надписи "Не верно введен логин или пароль" в форме авторизации
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
	}

	// если кликнули на button
	if ( isset($data['do_signup']) ) { // * отправка формы регистрации пользователя
    // проверка формы на пустоту полей
		$errors = array();
		if ( trim($data['login']) == '' ) { // * поле ввода логина путсто
			$errors[] = 'Введите логин';
		}

		if ( $data['password'] == '' )	{ // * поле ввода пароля пусто
			$errors[] = 'Введите пароль';
		}

		if ( $data['password_2'] != $data['password'] ) { // * пароль и повторный пароль не совпадают
			$errors[] = 'Повторный пароль введен не верно!';
		}

		// проверка на существование одинакового логина
		if ( R::count('users', "login = ?", array($data['login'])) > 0) {
			$errors[] = 'Пользователь с таким логином уже существует!';
		}

		if ( empty($errors) ) { // * сохранить данные формы, если не возникло ошибок
			$user = R::dispense('users');
			$user->login = $data['login'];
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT); // пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6

			R::store($user);
			header("Location: ".$_SERVER["REQUEST_URI"]."#popup1");
		} else { // * вывод надписи "Такой логин уже существует, или вы ввели не верно повторный пароль" в форме регистрации
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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Qvinciy</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<meta name="interkassa-verification" content="df702bd4b5ab3496e9e072eca1817f02" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/reveal.css">
	<script src="js/search.js"></script>
	<!-- Yandex.Metrika counter -->
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
	<noscript>
		<div>
			<img src="https://mc.yandex.ru/watch/53092666" style="position:absolute; left:-9999px;" alt="" />
		</div>
	</noscript>
	<!-- /Yandex.Metrika counter -->
</head>
<style>

	body, html {
		margin: 0;
		padding: 0;
		width: 100%;
		background-color: #000;
		color: #fff;
	}

	.flex-container {
		font-family: 'Roboto Mono', monospace;
		font-size: 12px;
		display: -webkit-flex;
		display: flex;
		margin: 10px auto;
		height: 60vh;
	}

	.flex-line {
		font-family: 'Roboto Mono', monospace;
		width: 100%;
		height: 60vh;
		display: -webkit-inline-flex;
		display: inline-flex;
	}

	.flex-line:first-child {
		width: 15%;
		height: 60vh;
		padding-left: 0;
	}

	.flex-line:last-child {
		width: 120%;
		border-left: none none none;
	}

	#flex_line_2 {
		border-right: 1px solid #fff;
	}

	#flex_line_3 {
		border-right: none none none;
	}

	/* #chat_right, #chat_left */
	.chat {
		width: 100%;
		overflow-y: scroll;
		padding: 0 10px;
		height: 52vh;
	}

	#chat-right::-webkit-scrollbar-thumb {
		background-color: #000;
		width: 3px;
	}

	#chat-right::-webkit-scrollbar {
		width: 4px;
	}

	#chat-left::-webkit-scrollbar {
		width: 0;
	}

	#chat-left {
		height: 100%;
	}

	ul.chat-list {
		margin: 0 auto;
		padding: 10px;
		overflow-y: scroll;
	}

	ul.chat-list::-webkit-scrollbar-thumb {
		background-color: #000;
	}

	ul.chat-list::-webkit-scrollbar {
		width: 3px;
	}

	.chat-switcher img {
		display: list-item;
		width: 100%;
		margin: 10px 0;
		cursor: pointer;
	}

	.flex-line .input-line {
		width: 99%;
	}

	.flex-line form {
		width: 95%;
		margin: 0 auto;
	}

	.flex-line form input[type="text"] {
		width: 75%;
		background-color: #000;
		border: 0.5px solid #fff;
		color: #fff;
		padding: 5px;
		border-radius: 5px;
	}

	.flex-line form input[type="submit"] {
		cursor: pointer;
		width: 20%;
		float: right;
		background-color: #000;
		color: #fff;
		padding: 5px;
		border-radius: 5px;
	}

	ul.block-a {
		padding: 0;
		margin: 0;
		list-style: none;
	}

	ul.block-a li:last-child {
		margin-top: 10px;
	}

	.msg-box {
		font-size: 12px;
		width: 98%;
		margin: 20px auto;
	}

	.msg-box header {
		width: 100%;
	}

	.msg-box header * {
		display: inline-block;
		margin-left: 5px;
	}

	.msg-box header span {
		text-decoration: none;
		color: #fff;
		font-weight: 900;
	}

	.msg-box img {
		width: 5%;
	}

	.msg-box p {
		word-wrap: break-word;
		word-break: break-all;
	}

</style>

<style>
	.relative-element {
		position: relative;
		top: 0;
		left: 0;
	}

	header.main-container.fade {
		z-index: 1;
		/* display: none; */
	}

	.chat-block {
		z-index: 2;
		display: none;
	}
</style>

<body style="margin: 0; display: block; height: 100vh; width: 100vw; overflow: hidden; background: #000000; color:#fff">

<div class="double-scroll">
    <div class="login"></div>
	<?php
		$query = R::findAll('users', 'ORDER BY price DESC');
		foreach($query as $item): // * генерация модального окна для каждой строчки в таблице
	?>
		<div class="modal-dialog modal-reit-monolit profile-dialog<?=$item['id']?> asdasd<?=$item['id']?> disabled fade">
			<div class="overlay"></div>
			<content class="profile-menu" style="border-radius: 20px;">
				<div class="overhapka"></div>
				<header class="close-exit<?=$item['id']?>"> <!-- * кнопка закрытия модального окна -->
					<a style="background-color: white; padding: 0px 6px 0px 6px; font-size: 15px; border-radius: 50%; right: 10px; position: absolute; top: 10px;">
						&times
					</a>
				</header>

				<div class="profile-image-wrapper" style="margin-left: -20px; position: relative;"> <!-- * блок с аватаркой пользователя и ссылками на его страницы соц. сетей -->
					<img class="profile-avatar" style="background-image: url('./<?=$item['filename']?>');background-size: cover;background-repeat: no-repeat;background-position: center;" width="80" height="80"/>
					<div class="profile-avatar2">
						<i class="fa fa-pencil" aria-hidden="true"></i>
					</div>
					<ul class="profile-social">
						<a href="<?=$item['insta']?>" target="_block"><i class="fa fa-instagram" aria-hidden="true"></i></a>
						<a href="<?=$item['vk']?>" target="_block"><i class="fa fa-vk" aria-hidden="true"></i></a>
					</ul>
				</div>
				<div class="profile-about"> <!-- * блок с номеном, рейтингом и "стоимостью" пользователя -->
					<p class="profile-cost profile-bio fade" style="display: none;">Информация: <?=$item['info']?></p>
					<h2 class="profile-login">Номен: <?php echo $item['name'] ?></h2>
					<p class="profile-rating">
						Рейтинг: <span  style="font-size: 20px;" class="profile-rating-span profile-rating-span<?=$item['id']?>"></span>
					</p>
					<p class="profile-cost stionost">
						Стоимость: <span style="font-size: 20px;"><?=$item['price']?></span>
						<i style="font-size: 13px;" class="fa fa-rub" aria-hidden="true"></i>
					</p>
				</div>
			</content>
		</div>

		<script>
			$(".disable_block<?=$item['id']?>").on("click", function() { // * открытия модального окна при нажатии на ссылку в таблице
				document.querySelector('.profile-dialog').classList.remove('disabled<?=$item['id']?>');
			});
		</script>
	<?php
		endforeach;
	?>
</div>

<div class="chat-table-switcher">
	<header class="main-container fade relative-element"> <!-- * блок с таблицей рейтинга пользователей -->
		<div class="table-header header0tabla"> <!-- * описание столбцов таблицы -->
				<h3 id='header-cost' class="mob-reit-h3">Рейтинг</h3>
			<span class="header-res-up-mpdal">
				<div class="searg444 searg">
					<input class="input" id="search" type="text">
				</div>
				<h3 class="header-reit vd">Номен</h3>
				<h3 class="header-reit header-chert searg">&nbsp;&nbsp;Поиск</h3>
			</span>
				<h3 id='header-name' class="mob-price-h3">Стоимость</h3>
		</div>

		<div class="table-carousel">
			<ul id="colors" class="carousel-group ffsss fade enabled">
				<?php
					$query = R::findAll( 'users' , ' ORDER BY price DESC' );
					// а можно и так  $query = R::getAll( 'SELECT * FROM jobs' );
					foreach($query as $item):
				?>
					<li class="table-header table-comtent disable_block<?=$item['id']?>"> <!-- * добавление в таблицу ссылки на открытие модального окна и заполнение таблицы -->
						<p id='header-rating' class="mob-reit-h3"><?=$item['reiting']?></p>
						<p id='header-name'><?=$item['name']?></p>
						<p id='header-cost' class="mob-price-h3"><?=$item['price']?><i style="font-size: 14px;" class="fa fa-rub" aria-hidden="true"></i></p>
					</li>
					<script>

						$(".disable_block<?=$item['id']?>").on("click", function() { // * открытие модального окна при нажатии на ссылку в таблице
							document.querySelector('.profile-dialog<?=$item['id']?>').classList.remove('disabled');
						});

						$(".close-exit<?=$item['id']?>").on("click", function() {  // * закрытие модального окна при нажатии на кнопку закрытия в модальном окне
							document.querySelector('.asdasd<?=$item['id']?>').classList.add('disabled');
						});
					</script>
				<?php
					endforeach;
				?>
			</ul>
		</div>

		<a class="fade nno" style="display:none" id="prevCarousel">&#10094;</a> <!-- * кнопка прокручивания карусели влево  -->
		<a class="fade nno" style="display:none" id="nextCarousel">&#10095;</a> <!-- * кнопка прокручивания карусели вправо  -->
	</header>
	<div class="main-container chat-block relative-element fade">
		<!-- Контейнер для всех колонок (переключатель чата, чат старый, чат новый, доп.секция) -->
		<div class="flex-container">
			<!-- Переключатель чатов -->
			<div class="flex-line flex-border flex_line_1">
				<!-- Список для чатов -->
				<ul class="chat-list">
					<!--
						<div class="chat-switcher" id="k-ый_id">
							<img alt="Фото собеседника">
						</div>
					-->
				</ul>
			</div>
			<!-- Левый чат -->
			<div class="flex-line flex-border" id="flex_line_2">
				<div id="chat-left" class="chat">
					<!-- Сообщения
							! все сообщения добавляются одновременно в два чата
					-->
					<!--
						<div class="msg-text">
							<h5>Имя пользователя</h5>
							<p>Текст сообщения</p>
							<small>Время отправки сообщения</small>
						</div>
					-->
				</div>
			</div>
			<!-- Правый чат -->
			<div class="flex-line flex-border" id="flex_line_3">
				<ul class="block-a">
					<li>
						<div id="chat-right" class="chat">
							<!-- Сообщения
									! все сообщения добавляются одновременно в два чата
							-->
							<!--
								<div class="msg-text">
									<h5>Имя пользователя</h5>
									<p>Текст сообщения</p>
									<small>Время отправки сообщения</small>
								</div>
							-->
						</div>
					</li>

					<li>
						<div class="input-line">
							<form name="send_msg">
								<input type="text" name="msg_text" placeholder="Enter text...">
								<input type="submit" value="Send">
							</form>
						</div>
					</li>
				</ul>
			</div>
			<br>
			<!-- Доп. секция -->
			<div class="flex-line">
				<div class="block-3">
					Block C
				</div>
			</div>
		</div>
	</div>
</div>

<main class="accordion-container"> <!-- * блок после таблицы -->
	<div class="accordion-tab accordion-tab-ofset"> <!-- * блок с главным лого, меню пользователя и ссылкой на группу VK -->
		<input type="radio" name="accordion" id='main' checked />
		<label for="main">
			<article class="accordion-main">
				<div class="accordeon_target"></div> <!-- * блок с главным лого -->
				<content class="social-icons"> <!-- * блок с меню пользователя и ссылкой на группу VK -->
					<?php if ( isset ($_SESSION['logged_user']) ) : ?> <!-- * для авторизованного пользователя, ссылка на открытие меню пользователя -->
						<a href="#" class="social-account social-account-okay" id="showAccount" ;>
							<img width='35px' height='35px' src="svg/account.svg" alt="Аккаунт" />
						</a>
					<?php else : ?>
						<a class="social-account" href="#popup1"> <!-- * для неавторизованного пользователя, ссылка на открытия окна авторизации/регистрации -->
							<img width='35px' height='35px' src="svg/account.svg" alt="Аккаунт" />
						</a>
					<?php endif; ?>
					<a class='social-vk' id="chat_table_switcher"> <!-- * ссылка на группу VK -->
						<img width='35px' height='35px' src="svg/vk.svg" alt="Qvinciy в ВК!"/>
					</a>
				</content>
			</article>
		</label>
	</div>

	<div class="accordion-tab">
		<header class="close-exit close-acordeon-mob">
			<a class="close_podwal" style="color: white; font-size: 25px;">&times</a>
		</header>
		<input type="radio" name="accordion" id='about' />
		<label for="about">
			<h3 style="margin-bottom: 30px; width: 90%; margin-top: -1px; display: -webkit-inline-box;">
				Qvinciy | О проекте
			</h3>

			<ul  class="accordion" style="height: 250px;">
				<li class="slide-01">
					<div>
						<h4 style="margin-top: 0px;">Подробнее</h4>

						<p>
							<strong>Qvinciy</strong> - это рейтинг людей по всему миру, зависящий от цены купленного места.<br>
							В свою очередь, место - это показатель того, насколько
							Вы признаны в рейтинге за счет своих денежных средств среди остальных участников.
						</p>
						<p style="font-size: 20px;">
						</pre>
					</div>
				</li>

				<li class="slide-02 disable_block444as2">
					<div class="tooltip">
						<h4 class="tooltip-row-block" style="margin-top: 0px;">Договор публичный оферты</h4><span class="inner tooltip-row-block">Нажмите для продолжения</span>
                        <p href="" id="test">
							Настоящий договор между владельцем сайта в сети интернет Гаврилова Никиты Александровича и пользователем услуг сайта в сети интернет,  именуемым в дальнейшем «Покупатель» определяет условия приобретения услуги через сайт http://qvinciy.ru  Настоящий договор – оферта действует с 01 Августа 2019 года.</p>
							<br><br><br><br>
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
							<span class="mob-podskazka fade" style="display: none">(Продолжение в полной версии)</span>
						</p>
					</div>
				</li>

				<li class="slide-03 disable_block444as">
					<div class="tooltip1">
						<h4 class="tooltip-row-block" style="margin-top: 0px;">Пользовательское соглашение</h4><span class="inner tooltip-row-block">Нажмите для продолжения</span>
						<p href="" id="test1" style="margin-right: -6px;">
							Настоящее Пользовательское соглашение регулирует отношения между пользователем сети Интернет (далее - Пользователь) и владельцем сайта в сети интернет  http://qvinciy.ru, возникающие при использовании интернет-ресурса http://qvinciy.ru, на условиях,  указанных в Пользовательском соглашении.

							Безоговорочным и полным принятием Пользователем положений настоящего <br><br><br><br><br><br>Пользовательского соглашения является совершение действий Пользователем, которые направлены на использование Сайта, включая, но не ограничиваясь: подача, просмотр, оплата услуг, участие в рейтинге, направление сообщений Администрации сайта, и иные действия по использованию функциональности Сайта.

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
							<span class="mob-podskazka fade" style="display: none">(Продолжение в полной версии)</span>
						</p>
					</div>
				</li>
			</ul>
		</label>
	</div>
	<div class="ffaaxxxx" style="z-index: 9999; display: block; position: relative;">
		<p style="padding: 0; font-size: 18px;">Контакты</p>
		<a style="color:white; padding: 5px; font-size: 25px;" target="_black" href="mailto:qvinciy@mail.ru">
		<i class="fa fa-envelope-o" aria-hidden="true"></i></a> | <a  style="color:white; padding: 5px;font-size: 25px;" target="_black" href="http://vk.me/qvinciy">
		<i class="fa fa-vk" aria-hidden="true"></i></a>
		<p style="font-size: 16px; text-align: center;" class="asdfaa">@qvinciy права защищены</p>
	</div>
</main>

<div id="popup1" class="overlay overlay2">
	<div class="popup"> <!-- * окно авторизации/регистрации пользователя -->
		<a class="close close-reg" href="#">&times;</a> <!-- * кнопка с закрытием окна -->
		<div id="poopReglock" class="content">
			<form action="index.php" method="POST" id="modalform">
				<!-- Регистрация -->
				<!-- * надпись, высвечивающаяся при ошибки в отправки формы регистрации -->
				<p class="reg_alert" style="display: none; color: red;">Такой логин уже существует, или вы ввели не верно повторный пароль</p>
				<!-- Авторизация -->
				<!-- * надпись, высвечивающаяся при ошибки в отправки формы авторизации -->
				<p class="log_alert" style="display: none; color: red;">Не верно введен логин или пароль</p>

				<input class="login-input" checked="" id="signin" name="action" type="radio" value="signin">
				<label class="label-form" for="signin">Войти</label> <!-- * вкладка авторизации -->

				<input class="signup-input" id="signup" name="action" type="radio" value="signup">
				<label class="label-form" for="signup">Регистрация</label> <!-- * вкладка регистрации -->

				<div id="wrapper"> <!-- * блок с полями ввода -->
					<div id="arrow"></div> <!-- * значок, указывающий на открытую вкладку -->
					<input type="text" name="login" value="<?php echo @$data['login']; ?>" placeholder="Логин" required><br/>
					<input type="password" name="password" value="<?php echo @$data['password']; ?>" placeholder="Пароль" required><br/>
					<input type="password" name="password_2" id="two_pass" value="<?php echo @$data['password_2']; ?>" placeholder="Повтор пароля"><br/>
				</div>
				<!-- * кнопка отправки формы -->
				<button type="submit" id="button-form-modal" name="do_login">
					<span style="margin-top: 72px;">
					Войти
					<br>
					Регистрация
					</span>
				</button>
				<input type="checkbox" id="cbx" style="display: none;"> <!-- * чекбокс принятия "Пользовательского соглашения" -->
				<!-- * блок с ссылкой на открытие окна с "Пользовательским соглашением" -->
				<label for="cbx" class="check  check2" style="display:none;">
					<span class="disable_block444as">Cогласен с политикой</span>
					<svg width="25px" height="25px" viewBox="0 0 18 18"> <!-- * значок галочки в чекбоксе -->
						<path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
						<polyline points="1 9 7 14 15 4"></polyline>
					</svg>
				</label>
			</form>
		</div>
	</div>
</div>

<?php if ( isset ($_SESSION['logged_user']) ) : ?> <!-- * добавление меню пользователя для авторизированного пользователя -->
	<div class="showbackground">
		<nav class="nav">
			<a class="close close-nav" href="#">&times;</a>
			<h2>Профиль</h2>
			<hr>
			<div class="lk" id="block">
				<!-- * форма для загрузки аватарки пользователя -->
				<form action="avatar.php" method="post" enctype="multipart/form-data">
					<label for="pct" class="lla" style="background-image: url('<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->filename; ?>'); background-size: cover;background-repeat: no-repeat;"></label> <!-- * аватарка пользователя -->
					<input type="file" name="filename" id="pct" onchange="this.form.submit ()"><br>
				</form>
				<!-- * блок со "стоимостью", местом в рейтинге и ссылкой на сообщения с сообществом VK для пополнения баланса -->
				<div class="lk-info">
					<h3>
						<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->price; ?>
						<i class="fa fa-rub" aria-hidden="true"></i>
					</h3>
					<span>
						Место:
						<span class="reit-lv<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->id; ?>">
							12
						</span>
					</span>
					<br>
					<a href="https://vk.me/qvinciy" target="_blank"><button class="paymetod preview-block__btn custom-btn">Пополнить баланс</button></a>
				</div>
			</div>
<?php
	// файл 1.php
	$_SESSION['reason'] = array(1, 2, 3, 4, 5,6,7);
?>
			<!-- * форма заполнения данных пользователя (номен, ссылка на страницу VK, ссылка на Инстаграм и информация "О себе") -->
			<form action="index.php" method="POST" style="margin-top: 54px;" id="form_profile">
				<!-- * номен -->
				<div class="group">
					<input type="text" name="name" value="<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->name; ?>" >
					<span class="highlight"></span>
					<span class="bar"></span>
					<label>Номен</label>
				</div>
				<!-- * ссылка на VK -->
				<div class="group">
					<input type="text" name="vk" value="<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->vk; ?>" >
					<span class="highlight"></span>
					<span class="bar"></span>
					<label>Вконтакте</label>
				</div>
				<!-- * ссылка на Инстаграм -->
				<div class="group">
					<input type="text" name="insta" value="<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->insta; ?>" >
					<span class="highlight"></span>
					<span class="bar"></span>
					<label>Инстаграм</label>
				</div>
				<!-- * информация ("о себе") -->
				<div class="group group2">
					<label>Информация</label>
						<textarea name="info">
							<?php $id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->info; ?>
						</textarea>
					<span class="highlight"></span>
					<span class="bar"></span>
				</div>
				<button class="paymetod" style="margin-top: 40px;" name="do_account">Сохранить</button> <!-- * отправка формы -->
			</form>

			<a href="/logout.php">Выйти</a> <!-- * кнопкой с выходом из аккаунта -->
		</nav>
	</div>


<?php else : ?>
	<p>Без регистрации личного кабинета не будет!</p>
<?php endif; ?>

<!-- Правила -->
<div class="modal-dialog ofera profile-dialog444as asdasd444as disabled fade" style="z-index: 9999;">
	<div class="overlay"></div>
	<content class="profile-menu modal-info">
		<header class="close-exit444as">
			<a style="position: absolute;">&times</a>
			<h2 style="text-align: center; margin: 0;">Пользовательское соглашение</h2>
		</header>
		<div>
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
	</content>
</div>
<!-- Правила2 -->
<div class="modal-dialog ofera profile-dialog444as2 asdasd444as disabled fade" style="z-index: 9999;">
	<div class="overlay"></div>
	<content class="profile-menu modal-info">
		<header class="close-exit444as">
			<a style="position: absolute;">&times</a>
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
	</content>
</div>


<?php if ( isset ($_SESSION['logged_user']) ) : ?> <!-- * для авторизированного пользователя -->
	<script>
		// * в каждой строчке в таблице на месте рейтинга поставить число
		$('.carousel-group').each(function() {
			$('.table-header').each(function(i) {
				$('#header-rating', this).each(function() {
					$(this).html(i);
				});
			});
		});

		// * в каждое модальное окно, открывающееся по ссылке в таблице, поставить место в рейтинге пользователя
		$('.double-scroll').each(function() {
			$('.modal-reit-monolit').each(function(i) {
				$('.profile-rating-span', this).each(function() {
					$(this).html(i+1);
				});
			});
		});

		// * указанное место рейтинга в модальном окне, открывающееся по ссылке в таблице, с информацией авторизированного пользователя поставить в меню пользователя
		$('.profile-rating-span<?php
				$id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->id;
				?>').clone(true).unwrap().appendTo( $('.reit-lv<?php
				$id = $_SESSION['logged_user']->id; $cat = R::load('users', $id); echo $cat->id;
				?>').empty() );

		// * смена фонного изображения в форме изменения автарки
		document.querySelector("input").addEventListener("change", function () {
			if (this.files[0]) {
				var fr = new FileReader();
				fr.addEventListener("load", function() {
					document.querySelector("label").style.backgroundImage = "url(" + fr.result + ")";
				}, false);

				fr.readAsDataURL(this.files[0]);
			}
		});
	</script>
<?php else : ?> <!-- * для неавторизированного пользователя -->
	<script>
		// * в каждой строчке в таблице на месте рейтинга поставить число
		$('.carousel-group').each(function(){
			$('.table-header').each(function(i){
				$('#header-rating', this).each(function(){
					$(this).html(i+1 -1);
				});
			});
		});

		// * в каждое модальное окно, открывающееся по ссылке в таблице, поставить место в рейтинге пользователя
		$('.double-scroll').each(function(){
			$('.modal-reit-monolit').each(function(i){
				$('.profile-rating-span', this).each(function(){
					$(this).html(i+1);
				});
			});
		});
	</script>
<?php endif; ?>

<link rel="stylesheet" href="css/styles_index_php.css"> <!-- * стили, перенесённые отсюда в отдельный файл -->
<script type="text/javascript" src="js/script_index_php.js"></script> <!-- * скрипты, перенесённые отсюда в отдельный файл -->
<style>
	.flex-container {
		font-family: 'Roboto Mono', monospace!important;
	}
</style>
<script>
	// Заполнение информации

	// Класс Сообщения со всеми аттрибутами выводимыми в чат
	class Message {
		constructor(txt, user_name, date) {
			this.txt = txt;
			this.user_name = user_name;
			this.date = date;
		}
	}
	var u = 0;
	// Время отправки чч:мм
	function getTime() {
		var now = new Date();
		if(String(now.getMinutes()).length == 1)
			var minutes = `0${now.getMinutes()}`;
		else
			var minutes = now.getMinutes();
		u++;
		return `${new Date().getHours()}:${minutes + u}`;
	}

	// Тестовые тексты сообщений
	msg_txt_set = ['Earum, vel deserunt reprehenderit, laborum numquam modi voluptates temporibus nam atque explicabo aut.',
		'Dolorum quia, reiciendis ea ex illo nostrum totam cum tempore modi quis neque aliquid earum hic nemo minima libero consectetur ab ullam beatae voluptatem quibusdam maxime. ',
		'Eaque corrupti neque sed laboriosam tenetur corporis reprehenderit perferendis quas ea repellat odio, labore doloremque veniam nostrum ipsum illo voluptatum dignissimos eligendi eveniet inventore distinctio deleniti minima.',
		'Quos dicta debitis eos vel, aperiam doloribus nihil aut! Aspernatur animi, totam tenetur similique autem facere?',
		'Laboriosam alias aperiam pariatur harum id enim voluptatibus tempora, ipsum cum aut voluptas iusto ullam natus animi eveniet ea.',
		'Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum ad sed quos libero! Facilis iusto assumenda exercitationem dolores, cumque, ex, quos odio beatae architecto placeat inventore facere sunt accusantium quod!']
	// Текстовые имена пользователей ("User + users_chars[n]")
	var users_chars = ["B", "C", "D", "E", "F"];

	// Генерация сообщений для одного чата
	var n = 0;
	function getData(user_1_name, user_2_name) {
		if(n == 5)
			n = 0;
		var data = [];
		var j = 0;
		for(var i = 0; i < 30; i++) {
			if(j % 2 == 0)
				var user_name = user_1_name;
			else
				var user_name = user_2_name;
			data[i] = new Message(msg_txt_set[n], user_name, getTime(String(i)));
			j++
		}
		n++;
		return data.reverse();
	}

	// Добавления всех сообщений в чат
	function fillDataInChat(data) {
		data.forEach(function(element, i) {
			var new_msg_tag = document.createElement('div');
			new_msg_tag.id = i;
			new_msg_tag.className = "msg-box";

			var header_msg_box = document.createElement('header');
			var img_user = document.createElement('img');
			img_user.setAttribute('src', 'img_user.png');
			header_msg_box.appendChild(img_user);

			var user_name_tag = document.createElement('span');
			var link_user_name = document.createElement('a');
			link_user_name.setAttribute('href', '#');
			link_user_name.innerHTML = element.user_name;

			user_name_tag.append(link_user_name);
			header_msg_box.append(user_name_tag);

			var txt_msg_tag = document.createElement('p');
			txt_msg_tag.innerHTML = element.txt;


			var date_tag = document.createElement('small');
			date_tag.innerHTML = element.date;
			header_msg_box.append(date_tag);

			new_msg_tag.appendChild(header_msg_box);
			new_msg_tag.append(txt_msg_tag);
			$(".chat").prepend(new_msg_tag);

		});
	}

	// Обработка скролла

	var chat_left = document.getElementById("chat-left");
	var chat_right = document.getElementById("chat-right");
	active_scroll = 'n';

	$(chat_left).scroll(function() {
		var input_line_block_height = parseInt($('.flex-line#flex_line_3').css('height')) - parseInt($('#chat-right').css('height'));
		input_line_block_height *= 1.029;
		if(active_scroll == 'n') {
			active_scroll = 'l';
			// прокрутить правый скролл
			chat_right.scrollTop = chat_left.scrollTop + chat_right.clientHeight + input_line_block_height;

			if(chat_left.scrollTop > chat_right.scrollHeight - chat_right.clientHeight - chat_right.clientHeight - input_line_block_height) {
				chat_left.scrollTop = chat_right.scrollHeight - chat_right.clientHeight - chat_right.clientHeight - input_line_block_height;
			}
			active_scroll = 'pr';
		} else if(active_scroll == 'pl' || active_scroll == 'pr')
			active_scroll = 'n';

		if(chat_left.scrollTop > chat_left.scrollHeight - chat_right.clientHeight - chat_right.clientHeight - input_line_block_height) {
			active_chat = 'l';
			chat_left.scrollTop = chat_left.scrollHeight - chat_right.clientHeight - chat_right.clientHeight - input_line_block_height;
		}
	});

	$(chat_right).scroll(function() {
		var input_line_block_height = parseInt($('.flex-line#flex_line_3').css('height')) - parseInt($('#chat-right').css('height'));
		input_line_block_height *= 1.029;
		if(active_scroll == 'n') {
			active_scroll = 'r';
			// прокрутить левый скролл
			chat_left.scrollTop = chat_right.scrollTop - chat_right.clientHeight - input_line_block_height;
			active_scroll = 'pl';
		} else if(active_scroll == 'pr' || active_scroll == 'pl')
			active_scroll = 'n';

		if(chat_right.scrollTop < chat_right.clientHeight + input_line_block_height){
			chat_right.scrollTop = chat_right.clientHeight + input_line_block_height;
		}

		if(chat_left.scrollTop > chat_left.scrollHeight - chat_right.clientHeight - chat_right.clientHeight - input_line_block_height){
			chat_left.scrollTop = chat_left.scrollHeight - chat_right.clientHeight - chat_right.clientHeight - input_line_block_height;
		}
	});

	// Смена чатов

	// Класс Чата с именами юзеров и всеми сообщениями
	class Chat {
		constructor(user_1, user_2, msg_data) {
			this.user_1 = user_1;
			this.user_2 = user_2;
			this.chat_msg = msg_data;
		}
	}

	var chat_elements = []; // Переключатели чатов: HTML-элементы
	// Создание переключателя в списке чатов
	var k = 0;
	function createChatItem() {
		new_item_list = document.createElement("div");
		new_item_list.className = "chat-switcher";
		new_item_list.id = k;

		img_user = document.createElement("img");
		img_user.setAttribute("src", "img_user.png");
		new_item_list.append(img_user);

		document.getElementsByClassName("chat-list")[0].append(new_item_list);
		k++;
		return new_item_list;
	}

	// Заполнить массив HTML-элементами
	for(var i = 0; i < 5; i++)
		chat_elements[i] = createChatItem();

	// Создание чатов в виде объектов Chat
	var chats = []; // Все объекты Chat
	for(var i = 0; i < 5; i++) {
		chats[i] = new Chat("User A", `User ${users_chars[i]}`, getData("User A", `User ${users_chars[i]}`));
	}

	var active_chat = undefined; // Открытый чат на странице
	// Сменить активный чат, поменять содержимое чатов
	function switchChat(chat) {
		$(chat_left).empty();
		$(chat_right).empty();
		fillDataInChat(chat.chat_msg);
		chat_right.scrollTop = chat_right.scrollHeight;
		chat_left.scrollTop = chat_right.scrollTop - chat_right.clientHeight;
		active_chat = chat;
	}

	// К каждому HTML-элементу-переключателю привязать хендлер для смены активного чата
	chat_elements.forEach(function(element, i) {
		element.setAttribute("title", chats[i].user_2);
		element.onclick = function() {
			switchChat(chats[i]);
		}
	});

	// Отправка сообщения в активный чат
	document.forms['send_msg'].onsubmit = function(e) {
		e.preventDefault();
		if(document.forms['send_msg'].msg_text.value) {
			active_chat.chat_msg.unshift(new Message(document.forms['send_msg'].msg_text.value, "User A", getTime()));
			document.forms['send_msg'].msg_text.value = '';
			switchChat(active_chat);
		}
	}

	// Выбрать первый чат из списка
	switchChat(chats[0]);
</script>

<script>
	var active_window = 'table';
	$("#chat_table_switcher").click(function() {
		if(active_window == 'table') {
			$("header.main-container").css('display', 'none');
			$(".chat-block.main-container").css('display', 'block');
			$('.main-container').css('backgroundImage', 'none');
			switchChat(chats[0]);
			active_window = 'chat';
		} else if(active_window == 'chat') {
			$("header.main-container").css('display', 'block');
			$(".chat-block.main-container").css('display', 'none');
			$('.main-container').css('backgroundImage', 'url("img/carousel_bg.jpg")');
			active_window = 'table';
		}
	});
</script>

<script src="js/libs/sisyphus.min.js">
</script>

<script>
	$("form#form_profile").sisyphus();
	$('form#form_profile').sisyphus({timeout: 1});
</script>

<script>
	var form_profile = document.getElementById('form_profile');
	function saveProfileData() {
		$.ajax({
			type: "POST",
			url: "account_data.php",
			data: "vk="+ form_profile.vk.value + "&insta=" + form_profile.insta.value + "&info=" + form_profile.info.value + "&name=" + form_profile.name.value,

			success: function(data) {
			},

			error: function(jqXHR, exception) {
			}
		});
	}

	$(form_profile).on('input', function() {
		setTimeout(saveProfileData, 1000);
	});

</script>

<script src="js/libs/jquery.touchSwipe.min.js"></script>

<script>
	var swipe_is_active = false;

	$('.accordeon_target').click(function() {
		if(swipe_is_active)
			swipe_is_active = false;
		else
			swipe_is_active = true;
	});

	$('header.main-container').swipe( {
		swipeStatus:function(event, phase, direction, distance, duration, fingerCount, fingerData, currentDirection) {
			if(phase == 'end' && swipe_is_active) {
				if(direction == 'left') {
					$('#nextCarousel').click();
				}

				else if(direction == 'right') {
					$("#prevCarousel").click();
				}
			}
		}
	});
</script>

<script>
	$('label[for="about"]').hover(function() {
		$('.ffaaxxxx').css('backgroundColor', 'transparent');
	}, function() {
		$('.ffaaxxxx').css('backgroundColor', 'rgba(0,0,0,1)')
	});
</script>
</body>
</html>
