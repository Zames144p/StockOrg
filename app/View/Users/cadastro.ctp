<?php echo $this->Html->css('loginPage'); ?>

<div class="cadastro-card">
    <h2>Faça seu cadastro!</h2>
    <div class="line-divider"></div>

    <?php echo $this->Form->create('User'); //ai ele vai acessar o model e corresponder os campos ?>
    
        <div class="form-group">
            <?php echo $this->Form->input('nome', array('label' => 'Nome', 'div' => false)); ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('senha_hash', array('label' => 'Senha', 'type' => 'password', 'div' => false)); ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('confirmar_senha', array('label' => 'Confirmar Senha', 'type' => 'password', 'div' => false)); ?>
        </div>


        <!-- Checkbox alinhado corretamente -->
        <div class="form-checkbox">
            <input type="checkbox" id="remember_me" name="data[User][remember_me]">
            <label for="remember_me">Salvar Senha</label>
        </div>

        <!-- Botões alinhados lado a lado -->
        <div class="form-actions">
            <?php echo $this->Form->submit('Cadastrar', array('class' => 'btn-cadastro', 'div' => false)); ?>

            <?php echo $this->Html->link(
                'Já tenho uma conta',
                array('controller' => 'Users', 'action' => 'login'),
                array('class' => 'btn-cadastro')
            ); ?>
        </div>

    <?php echo $this->Form->end(); ?>

    <p class="footer-credits">Criado com 🧡 por ZamesINC</p>
</div>