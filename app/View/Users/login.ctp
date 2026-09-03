<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Basico</title>
    <link rel="stylesheet" href="/app/">
</head>
<body>
    <header>
        <h1>Login tlgd</h1>
    </header>
    <section>
        <div id="layout" text-align="center">
            <p><input type="text" id="usuario" placeholder="Usuário" itemid="usuario"></p>
            <p><input type="password" id="senha" placeholder="Senha" itemid="senha"></p>
            <button onclick="login()">Login</button> <br>
            <p>ou <?php echo $this->Html->link('se cadastre', array('controller' => 'Users', 'action' => 'cadastro')); ?></p>
        </div>
    </section>
    <footer>
        <p>&copy; ZamesINC</p>
    </footer>
<script src="<?php echo $this->Html->script('scriptLogin'); ?>"></script>
</body>
</html>