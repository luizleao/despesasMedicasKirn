<?php
$config = parse_ini_file("classes/core/config.ini", true);
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once ("includes/headerLogin.php");?>
</head>
<body>
<?php require_once("includes/modalResposta.php");?>
    <div id="wrap">
        <div class="container">
            <form class="form-signin" onsubmit="return false;">
                <img src="img/logo_peq.jpg" />
                <h4 class="form-signin-heading">SUDAM RH</h4>
                <h6>Sistema de Gestão de Recursos Humanos</h6>
                <input type="text" class="input-block-level" id="login" name="login" autofocus="autofocus" placeholder="Login" />
                <input type="password" class="input-block-level" id="senha" name="senha" placeholder="Senha" />
                <button class="btn btn-success btn-small" data-loading-text="loading..." name="btnLogar" id="btnLogar" type="submit">Entrar</button>
            </form>
        </div>
        <div class="push"></div>
    </div>
    <?php require_once("includes/footer.php");?>
</body>
</html>