<?php
include_once '../VisorLA/Application/core/Conexao.php';


class Admin
{
    public $id;
    public $ativar_prioritario;
    public $nome_prioritario;
    public $nome_normal;
    public $usuario_alteracao;
    public $ult_atualizacao;
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

    public function getAtivar_prioritario(){
        return $this->ativar_prioritario;
    }

    public function setAtivar_prioritario($ativar_prioritario){
        $this->ativar_prioritario=$ativar_prioritario;
    }

    public function getNome_prioritario(){
        return $this->nome_prioritario;
    }

    public function setNome_prioritario($nome_prioritario){
        $this->nome_prioritario=$nome_prioritario;
    }

    public function getNome_normal(){
        return $this->nome_normal;
    }

    public function setNome_normal($nome_normal){
        $this->nome_normal=$nome_normal;
    }

    public function getUsuario_alteracao(){
        return $this->usuario_alteracao;
    }

    public function setUsuario_alteracao($usuario_alteracao){
        $this->usuario_alteracao=$usuario_alteracao;
    }

    public function getUlt_atualizacao(){
        return $this->ult_atualizacao;
    }

    public function setUlt_atualizacao($ult_atualizacao){
        $this->ult_atualizacao=$ult_atualizacao;
    }

    public function listarDados(){
        $stmt = $this->conectar->prepare("SELECT * FROM admin ORDER BY id");
//        $stmt = $this->conectar->prepare("SELECT * FROM `visor-saude-la`.admin");
        $stmt->execute();
    }

    public function carregarDados($id){
        $this->setId($id);
        $stmt = $this->conectar->prepare("SELECT * FROM admin WHERE id = :ID");
        $stmt->execute(array(":ID" => $this->id));
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }
}
