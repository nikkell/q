<?php
if(!class_exists('R')) {
	require_once "db.php";
}
function ha() {
$query = R::findAll('users', 'ORDER BY price DESC');
foreach($query as $item): // * генерация модального окна для каждой строчки в таблиц
echo '
<div class="modal-dialog modal-reit-monolit profile-dialog'.$item['id'].' asdasd'.$item['id'].' disabled fade">'.
	'<div class="overlay"></div>'.
	'<content class="profile-menu" style="border-radius: 20px;">'.
		'<div class="overhapka"></div>'.
		'<header class="close-exit'.$item['id'].'">'. /* * кнопка закрытия модального окна */
			'<a style="background-color: white; padding: 0px 6px 0px 6px; font-size: 15px; border-radius: 50%; right: 10px; position: absolute; top: 10px;">'.
				'&times'.
			'</a>'.
		'</header>'.
		'<div class="profile-image-wrapper" style="margin-left: -20px; position: relative;">'. /* * блок с аватаркой пользователя и ссылками на его страницы соц. сетей */
			'<img class="profile-avatar" style="background-image: url("./'.$item['filename'].'");background-size: cover;background-repeat: no-repeat;background-position: center;" width="80" height="80"/>'.
			'<div class="profile-avatar2">'.
				'<i class="fa fa-pencil" aria-hidden="true"></i>'.
			'</div>'.
			'<ul class="profile-social">'.
				'<a href="'.$item['insta'].'" target="_block"><i class="fa fa-instagram" aria-hidden="true"></i></a>'.
				'<a href="'.$item['vk'].'" target="_block"><i class="fa fa-vk" aria-hidden="true"></i></a>'.
			'</ul>'.
		'</div>'.
		'<div class="profile-about">'. /* * блок с номеном, рейтингом и "стоимостью" пользователя */
			'<p class="profile-cost profile-bio fade" style="display: none;">Информация: '.$item['info'].'</p>'.
			'<h2 class="profile-login">Номен: '.$item['name'].'</h2>'.
			'<p class="profile-rating">'.
				'Рейтинг: <span  style="font-size: 20px;" class="profile-rating-span profile-rating-span'.$item['id'].'"></span>'.
			'</p>'.
			'<p class="profile-cost stionost">'.
				'Стоимость: <span style="font-size: 20px;">'.$item['price'].'</span>'.
				'<i style="font-size: 13px;" class="fa fa-rub" aria-hidden="true"></i>'.
			'</p>'.
		'</div>'.
	'</content>'.
'</div>'.
'<script>'.
	'$(".disable_block'.$item['id'].'").on("click", function() {'. // * открытия модального окна при нажатии на ссылку в таблице
		'document.querySelector(".profile-dialog").classList.remove("disabled'.$item['id'].'");'.
	'});'.
'</script>';
endforeach;
}
ha();
?>