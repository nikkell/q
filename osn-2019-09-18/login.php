<?php

require 'db.php';
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
            $errors[] = 'Неверно введен пароль!';
            echo '<style>
        .log_alert{
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
        </style>';
        
    }
    
    if (!empty($errors) )
    {
        //выводим ошибки авторизации
        // echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
        header("Location: /#popup1");
        echo '<style>
        .log_alert{
            display: block!important;
        }
        </style>';
    }

}

