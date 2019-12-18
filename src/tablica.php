<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
try {
if(!class_exists('R')) {
	require_once "db.php";
}
function reload() {
	$query = R::findAll( 'users' , ' ORDER BY price DESC' ); // а можно и так  $query = R::getAll( 'SELECT * FROM jobs' );
	foreach($query as $item):
	echo '
		<li class="table-header table-comtent disable_block'.$item['id'].'"> <!-- * добавление в таблицу ссылки на открытие модального окна и заполнение таблицы -->
			<p id="header-rating" class="mob-reit-h3"'.$item['reiting'].'</p>
			<p id="header-name">'.$item['name'].'</p>
			<p id="header-cost" class="mob-price-h3">'.$item['price'].'<i style="font-size: 14px;" class="fa fa-rub" aria-hidden="true"></i></p>
		</li>
		<script>
			$(".disable_block'.$item['id'].'").on("click", function() { // * открытие модального окна при нажатии на ссылку в таблице
				document.querySelector(".profile-dialog'.$item['id'].'").classList.remove("disabled");
			});
			$(".close-exit'.$item['id'].'").on("click", function() {  // * закрытие модального окна при нажатии на кнопку закрытия в модальном окне
				document.querySelector(".asdasd'.$item['id'].'").classList.add("disabled");
			});
		</script>
		';
	endforeach;
}
reload();
}
catch (Exception $ex) {
	echo $ex->getMessage();
}
?>