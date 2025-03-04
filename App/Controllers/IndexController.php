<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->render('index');
	}

	public function inscreverse() {
		$this->render('inscreverse');
	}

	// recupera as informacoes passado do formulario via post para nao mostrar na url
	public function registrar(){

		// Cria uma instância do modelo 'Usuario' usando o container do framework
		$usuario = Container::getModel('Usuario');

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);

		if($usuario->validaCadastro()){
			$usuario->save();
		}else{
			
		}

		//executa a query do banco de dados com as informacoes recuperadas 
	}
}


?>