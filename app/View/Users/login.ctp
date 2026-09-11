<?php echo $this->Html->css('loginPage.css?v=' . time()); ?>

<div class="login-wrapper">
    <div class="login-card">
        <h2>Faça seu login!</h2>
        <div class="divider"></div>

        <?php echo $this->Form->create('User'); ?>
            
            <div class="form-group">
                <?php echo $this->Form->input('nome', array('label' => 'Nome', 'class' => 'form-input')); ?>
            </div>

            <div class="form-group">
                <?php echo $this->Form->input('senha_hash', array('type' => 'password', 'label' => 'Senha', 'class' => 'form-input')); ?>
            </div>

            <div class="form-checkbox">
                <label>
                    <input type="checkbox" name="salvar_senha"> Salvar Senha
                </label>
            </div>

            <!-- Botões Estilizados -->
            <div class="login-actions">
                <?php echo $this->Html->link("Criar uma conta", array('action' => 'cadastro'), array('class' => 'btn-gold-link')); ?>
                <?php echo $this->Html->link("Acessar como guest", array('controller' => 'posts', 'action' => 'index'), array('class' => 'btn-guest-link')); ?>
                <?php echo $this->Form->submit('Entrar', array('class' => 'btn-gold-submit', 'div' => false)); ?>
            </div>

            <div class="login-footer">
                <small>Criado com &#129505; por ZamesINC</small>
            </div>

        <?php echo $this->Form->end(); ?>
    </div>
</div>