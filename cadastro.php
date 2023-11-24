<?php
include_once '../VisorLA/header.php';

?>
<body>
<div class="wrapper fadeInDown" style="padding-top: 7% 0 1% 0;">
    <div id="formContent">
        <div class="fadeIn first" style="padding-top: 5%;">
            <img src="public/images/logowd.jpg" id="icon" alt="Logo I.Wan-Dall"/>
        </div>
        <div style="text-align: center; padding: 5%;">
            <form action="cadastro.php" method="POST">
                <div class="form-group">
                    <label for="unidade">Informe a empresa cadastrada:</label>
                    <input type="text" class="form-control" name="empresa" id="empresa" placeholder="nome empresa">
                </div>
                <div class="form-group">
                    <label for="email">Informe o e-mail cadastrado:</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="nome@email.com">
                </div>
                <button class="btn btn-success g-recaptcha"
                        data-sitekey="reCAPTCHA_site_key"
                        data-callback='onSubmit'
                        data-action='submit'>Enviar</button>
                <button type="button" class="btn btn-primary">
                    <a href="index.php" style="text-decoration: none; color: white;">Voltar
                    </a>
                </button>
            </form>
        </div>
    </div>
</div>
<!--<script src="https://www.google.com/recaptcha/api.js"></script>-->
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }

    // function onClick(e) {
    // e.preventDefault();
    // grecaptcha.ready(function() {
    // grecaptcha.execute('reCAPTCHA_site_key', {action: 'submit'}).then(function(token) {
    // // Add your logic to submit to your backend server here.
    // });
    // });
    // }
</script>
<?php

include_once '../VisorLA/footer-externo.php';

?>


