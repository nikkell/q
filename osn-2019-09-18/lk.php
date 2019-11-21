<?php
require 'db.php';

$data = $_POST;
if ( isset($data['do_account']) )
{
    $id = $_SESSION['logged_user']->id;
    $user = R::load('users', $id);
    $user->name = $data['name'];
    $user->vk = $data['vk'];
    $user->insta = $data['insta'];
    $user->info = $data['info'];
    // $user->avatarka = $data['avatar'];



        R::store($user);
        header("Location: ".$_SERVER["REQUEST_URI"]);

}
?>
<script>
	
	window.location = "/";
		</script>