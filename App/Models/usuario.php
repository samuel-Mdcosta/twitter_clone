<?php
    namespace App\Models;

    use MF\Model\Model;
use PDO;

    class Usuario extends Model{

        private $id;
        private $nome;
        private $email;
        private $senha;

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        //salva
        public function save(){
            //insere as informacoes do cadastro no banco
            $query = "
            INSERT INTO usuarios (nome, email, senha) 
            VALUES (:nome, :email, :senha);
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();

            return $this;
        } 

        //valida o login
        public function validaCadastro(){
            $valido = true;

            if (strlen($this->__get('nome'))< 3){
                $valido = false;
            }
            if (strlen($this->__get('email'))< 3){
                $valido = false;
            }
            if (strlen($this->__get('senha'))< 3){
                $valido = false;
            }

            return $valido;
        }

        //recupera o usuario por e-mail;
        public function getUsuarioEmail(){
            $query = "
                SELECT 
                    nome, 
                    email 
                FROM 
                    usuarios 
                WHERE 
                    email = :email
            ";
            $stmt= $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            //gera um array assosciativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function autenticar(){
            $query = "
                select
                    id, nome, email
                from
                    usuarios
                where
                    email = :email and senha = :senha
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($usuario && $usuario['id'] != '' && $usuario['nome'] != ''){
                $this->__set('id', $usuario['id']);
                $this->__set('nome', $usuario['nome']);

            }

            return $this;
        }

    }