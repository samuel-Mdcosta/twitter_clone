<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class authController extends Action{
        public function autenticar(){

            $usuario = Container::getModel('usuario');

            $usuario->__set('email', $_POST['email']);
            $usuario->__set('senha', $_POST['senha']);

           $usuario->autenticar();

            if(!empty($usuario->__get('id')) && !empty($usuario->__get('nome'))){
                echo 'deu certo';
            }else{
                header('location: /?login=erro');
            }

        }
    }