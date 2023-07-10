<?php
session_start();
ob_start();
include_once '../VisorLA/Application/core/Database.php';

//Exemplo criptografia de senha
// echo password_hash('vila1234', PASSWORD_DEFAULT);

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['SendLogin'])) {
//    var_dump($dados);
    $query_usuario = "SELECT id, usuario, local, senha, n_chamado_normal, n_chamado_prioritario
                            FROM acesso
                            WHERE usuario =:usuario
                            LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':usuario', $dados['usuario'], PDO::PARAM_STR);
    $result_usuario->execute();

    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
//        var_dump($row_usuario);
        if(password_verify($dados['senha'], $row_usuario['senha'])) {
            $_SESSION['id'] = $row_usuario['id'];
            $_SESSION['local'] = $row_usuario['local'];
            $_SESSION['n_chamado_normal'] = $row_usuario['n_chamado_normal'];
            $_SESSION['n_chamado_prioritario'] = $row_usuario['n_chamado_prioritario'];
            header("Location: dashboard.php");

        } else {
            $_SESSION['msg'] = "<p style='color: #ff0000'>Usuário ou senha inválidos!</p>";
        }
    } else {
        $_SESSION['msg'] = "<p style='color: #ff0000'>Usuário inválido!</p>";
    }
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<!DOCTYPE html>
<html lang="br">
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <title>Login de Usuário</title>
</head>
<body>
<div class="wrapper fadeInDown" style="padding-top: 7% 0 1% 0;">
    <div id="formContent">
        <div class="fadeIn first" style="text-align: center; padding: 5%;">
            <img src="public/images/BRASAO_REDIMENSIONADO.jpg" id="icon" alt="Brasão Luiz Alves"/>
        </div>
        <div style="text-align: center; padding: 2%;">
            <form action="" method="POST">
                <input type="text" id="login" class="fadeIn second" name="usuario" placeholder="login" value="<?php if(isset($dados['usuario'])){echo $dados['usuario']; } ?>">
                <br>
                <input type="password" id="password" class="fadeIn third" name="senha" placeholder="senha" value="<?php if(isset($dados['senha'])){echo $dados['senha']; } ?>">
                <br>
                <input type="submit" class="fadeIn fourth" value="Acessar" name="SendLogin">
                <br>
                <a class="underlineHover" href="cadastro.php">Esqueceu sua senha?</a>
            </form>
            <a class="underlineHover" href="visor.php">Acessar Visor</a>
        </div>
    </div>
</div>
<footer>
    <div class="col-12 col-md text-center">
        <small class="d-block mb text-muted" style="font-size: 10px; margin-top: 0;">
            &copy; <?php echo (new DateTime('now'))->format('Y'); ?> - Desenvolvido por Irmãos Wan-Dall
        </small>
    </div>
</footer>
</body>
</html>