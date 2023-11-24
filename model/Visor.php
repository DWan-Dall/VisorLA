<?php
include_once '../VisorLA/Application/core/Conexao.php';

class Visor
{
    public $id;
    public $email;
    public $setor;
    public $senha;
    public $nome_usuario;
    public $usuario_adm;
    public $n_chamado_normal;
    public $ult_atualizacao_normal;
    public $n_chamado_prioritario;
    public $ult_atualizacao_prioritario;
    public $conectar;

    public function __construct(){
        $this->conectar = Conexao::getInstance();
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email=$email;
    }

    public function getSetor(){
        return $this->setor;
    }

    public function setSetor($setor){
        $this->setor=$setor;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha=$senha;
    }

    public function getNome_usuario(){
        return $this->nome_usuario;
    }

    public function setNome_usuario($nome_usuario){
        $this->nome_usuario=$nome_usuario;
    }

    public function getUsuario_adm(){
        return $this->usuario_adm;
    }

    public function setUsuario_adm($usuario_adm){
        $this->usuario_adm=$usuario_adm;
    }

    public function getN_chamado_normal(){
        return $this->n_chamado_normal;
    }

    public function setN_chamado_normal($n_chamado_normal){
        $this->n_chamado_normal=$n_chamado_normal;
    }

    public function getUlt_atualizacao_normal(){
        return $this->ult_atualizacao_normal;
    }

    public function setUlt_atualizacao_normal($ult_atualizacao_normal){
        $this->ult_atualizacao_normal=$ult_atualizacao_normal;
    }

    public function getN_chamado_prioritario(){
        return $this->n_chamado_prioritario;
    }

    public function setN_chamado_prioritario($n_chamado_prioritario){
        $this->n_chamado_prioritario=$n_chamado_prioritario;
    }

    public function getUlt_atualizacao_prioritario(){
        return $this->ult_atualizacao_prioritario;
    }

    public function setUlt_atualizacao($ult_atualizacao_prioritario){
        $this->ult_atualizacao_prioritario=$ult_atualizacao_prioritario;
    }

    public function listarVisores(){
        $stmt = $this->conectar->prepare("SELECT * FROM acesso ORDER BY setor ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public function carregarVisores($id){
        $this->setId($id);
        $stmt = $this->conectar->prepare("SELECT * FROM acesso WHERE id = :ID");
        $stmt->execute(array(":ID" => $this->id));
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }

//    public function verificaMudanca() {
//
//    }

}