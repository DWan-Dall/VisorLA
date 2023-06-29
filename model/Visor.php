<?php
include '../VisorLA/Application/core/Database.php';
//namespace model;

class Visor
{
//    public $conn;
    public $id;
    public $usuario;
    public $local;
    public $senha;
    public $n_chamado_normal;
    public $n_chamado_prioritario;
    public $ult_atualizacao;
    public $visor = array();

//    public function __construct($nova_conexao){
//        $this->conexao = $nova_conexao;
//    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }

    public function getLocal(){
        return $this->local;
    }

    public function setLocal($local){
        $this->local=$local;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha=$senha;
    }

    public function getN_chamado_normal(){
        return $this->n_chamado_normal;
    }

    public function setN_chamado_normal($n_chamado_normal){
        $this->n_chamado_normal=$n_chamado_normal;
    }

    public function getN_chamado_prioritario(){
        return $this->n_chamado_prioritario;
    }

    public function setN_chamado_prioritario($n_chamado_prioritario){
        $this->n_chamado_prioritario=$n_chamado_prioritario;
    }

    public function getUlt_atualizacao(){
        return $this->ult_atualizacao;
    }

    public function setUlt_atualizacao($ult_atualizacao){
        $this->ult_atualizacao=$ult_atualizacao;
    }

    public function buscar_visor($id) {
        $sqlBusca = 'SELECT * FROM visor-saude-la.acesso WHERE id = ' . $id;
        $result = mysqli_query($this->conn, $sqlBusca);

        $this->visor = mysqli_fetch_assoc($result);
    }


}