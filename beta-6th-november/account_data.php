<?php
    require 'db.php';

    $data = $_POST;
    
    $id = $_SESSION['logged_user']->id;
    $user = R::load('users', $id);
    $user->vk = $data['vk'];
    $user->insta = $data['insta'];
    $user->info = $data['info'];
    $user->name = $data['name'];

    R::store($user);