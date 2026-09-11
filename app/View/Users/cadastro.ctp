<?php echo $this->Html->css('loginPage'); ?>

<div class="login-wrapper">
<div class="login-card">
    <h2>Faça seu cadastro!</h2>
    <div class="divider"></div>

    <?php echo $this->Form->create('User'); ?>

    <div class="form-group">
        <?php echo $this->Form->input('nome', ['label' => 'Nome', 'div' => false, 'class' => 'form-control']); ?>
    </div>

    <div class="form-group">
        <?php echo $this->Form->input('senha_hash', ['label' => 'Senha', 'type' => 'password', 'div' => false, 'class' => 'form-control']); ?>
    </div>

    <div class="form-group">
        <?php echo $this->Form->input('confirmar_senha', ['label' => 'Confirmar Senha', 'type' => 'password', 'div' => false, 'class' => 'form-control']); ?>
    </div>

    <div class="form-checkbox">
        <input type="checkbox" id="remember_me" name="data[User][remember_me]">
        <label for="remember_me">Salvar Senha</label>
    </div>

    <div class="login-actions">
        <?php echo $this->Html->link("Entrar", array('action' => 'login'), array('class' => 'btn-gold-link')); ?>
        <?php echo $this->Form->submit('Cadastrar', array('action' => 'cadastro', 'class' => 'btn-gold-submit')); ?>
    </div>

    <?php echo $this->Form->end(); ?>

    <p class="footer-credits">Criado com 🧡 por ZamesINC</p>
</div>
</div>