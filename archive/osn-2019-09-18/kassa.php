<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Касса</title>
</head>
<body>
<?php 
// require 'db.php';

// $data = $_POST;
// if ( isset($data['oplata_baza']) )
// {
    // $id = $_SESSION['logged_user']->id;
    // $user = R::load('users', $id);
    // $user->price = $data['ik_am'];
        // R::store($user);

// }
?>
<?php 
// unset($dataSet['ik_sign']); //..удаляем из данных строку подписи
// ksort($dataSet, SORT_STRING); // сортируем по ключам в алфавитном порядке элементы массива
// array_push($dataSet, $key); // добавляем в конец массива "секретный ключ"
// $signString = implode(':', $dataSet); // конкатенируем значения через символ ":"
// $sign = base64_encode(md5($signString, true)); // берем MD5 хэш в бинарном виде по
// //сформированной строке и кодируем в BASE64
// return $sign; // возвращаем результат
// echo $sign;
?>
<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";
?>
    
<?php
$ik_co_rfn = isset($_POST['ik_co_rfn']) && is_array($_POST['ik_co_rfn']) ? array_pop(array_keys($_POST['ik_co_rfn'])) : 0;
echo $ik_co_rfn;
?>

</body>
</html>
