<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('index');

	}

	public function inscreverse() {

		$this->view->usuario = array(
			'nome'=>'',
			'email'=>'',
			'senha'=>'',
		);

		$this->view->erroCadastro = false;
		$this->render('inscreverse');
	}

	// recupera as informacoes passado do formulario via post para nao mostrar na url
	public function registrar(){

		// Cria uma instância do modelo 'Usuario' usando o container do framework
		$usuario = Container::getModel('Usuario');

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);

		if($usuario->validaCadastro() && count($usuario->getUsuarioEmail()) == 0){
			
			$usuario->save();
			$this->render('cadastro');

		}else{

			$this->view->usuario = array(
				'nome'=>$_POST['nome'],
				'email'=>$_POST['email'],
				'senha'=>$_POST['senha']
			);

			$this->view->erroCadastro = true;
			$this->render('inscreverse');
		}

		return $this;
	}
}