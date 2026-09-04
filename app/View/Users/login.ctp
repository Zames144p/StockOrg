<?php echo $this->Html->css('loginPage'); ?>

<div class="login-card">
    <h2>Faça seu login!</h2>
    <div class="line-divider"></div>

    <?php echo $this->Form->create('User'); ?>
    
        <div class="form-group">
            <?php echo $this->Form->input('username', array('label' => 'NOME', 'div' => false)); ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('password', array('label' => 'SENHA', 'div' => false)); ?>
        </div>

        <!-- Checkbox alinhado corretamente -->
        <div class="form-checkbox">
            <input type="checkbox" id="remember_me" name="data[User][remember_me]">
            <label for="remember_me">Salvar Senha</label>
        </div>

        <!-- Botões alinhados lado a lado -->
        <div class="form-actions">
            <?php echo $this->Html->link(
                'Criar uma conta',
                array('controller' => 'Users', 'action' => 'cadastro'),
                array('class' => 'btn-cadastro')
            ); ?>

            <?php echo $this->Form->submit('Entrar', array('class' => 'btn-login', 'div' => false)); ?>
        </div>

    <?php echo $this->Form->end(); ?>

    <p class="footer-credits">Criado com 🧡 por ZamesINC</p>
</div>