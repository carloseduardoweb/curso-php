<?php 
require_once "logica-usuario.php";
require_once "cabecalho.php"; ?>
<h2>Formulário de Contato</h2>
<br />
<form action="envia-contato.php" method="post">
    <table class="table">
        <?php
            $usuario = null;
            if (!($usuario = getUsuarioLogado())) : ?>
        <tr>
            <td><label for="nome">Nome</label></td>
            <td><input id="nome" name="nome" type="text" class="form-control" placeholder="Como podemos chamá-lo?"/></td>
        </tr>
        <tr>
            <td><label for="email">Email</label></td>
            <td><input id="email" name="email" type="email" class="form-control" placeholder="Seu email"/></td>
        </tr>
        <?php else : ?>
            <input name="nome" type="hidden" value="<?=$usuario->getNome(); ?>"/>
            <input name="email" type="hidden" value="<?=$usuario->getEmail(); ?>"/>
        <?php endif; ?>
        <tr>
            <td><label for="assunto">Assunto</label></td>
            <td><input id="assunto" name="assunto" type="text" class="form-control" placeholder="Sobre o que gostaria de falar?"/></td>
        </tr>
        <tr>
            <td><label for="msg">Mensagem</label></td>
            <td><textarea id="msg" name="msg" class="form-control" placeholder="O que gostaria de nos contar?"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button class="btn btn-primary">Enviar</button>
            </td>
        </tr>
    </table>
</form>
<?php require_once("rodape.php"); ?>
