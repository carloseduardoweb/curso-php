<?php 
require_once "logica-usuario.php";
require_once "cabecalho.php"; ?>
<?php 
if (isUsuarioLogado()) : ?>
    <h1>Olá, <?=getUsuarioLogado()->getNome(); ?>!</h1>
    <p class="text-success">Você está logado(a) como <?=getUsuarioLogado()->getEmail(); ?> <a href="logout.php">Sair</a></p>
<?php
else : ?>
            <h1>Bem vindo!</h1>
            <h2>Login</h2>
            <form action="login.php" method="post">
                <table class="table">
                    <tr>
                        <td><label for="email" >E-mail</label></td>
                        <td><input id="email" type="email" name="email" placeholder="Digite seu e-mail" class="form-control"/></td>
                    </tr>
                    <tr>
                        <td><label for="senha">Senha</label></td>
                        <td><input id="senha" type="password" name="senha" placeholder="Digite sua senha" class="form-control"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button class="btn btn-primary">Login</button></td>
                    </tr>
                </table>
            </form>
<?php 
endif;
require_once("rodape.php"); ?>
