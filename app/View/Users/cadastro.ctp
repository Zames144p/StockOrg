<?php echo $this->Html->css('login'); ?>
<?php echo $this->Html->script('scriptLogin'); ?>


<h1>Cadastro tlgd</h1>
        <div id="layout" text-align="center">
            <p><input type="text" id="usuario" placeholder="Usuário" itemid="usuario"></p>
            <p><input type="password" id="senha" placeholder="Senha"itemid="senha"></p>
            <p><input type="password" id="confirmacaoSenha" placeholder="Confirmar Senha"></p>
            <button onclick="cadastrar()">Cadastrar</button> <br>
            <p>Caso ja tenha cadastro, faça o <?php echo $this->Html->link('login', array('controller' => 'Users', 'action' => 'login')); ?></p>
        </div>
<p>&copy; ZamesINC</p>