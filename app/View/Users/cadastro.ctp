<?php echo $this->Html->css('loginPage'); ?>


<div class="container">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-12 col-md-8">
            <div class="login-card">
                <h2>Faça seu cadastro!</h2>
                <div class="line-divider"></div>

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

                <div class="form-actions">
                    <?php echo $this->Form->submit('Cadastrar', ['class' => 'btn-login', 'div' => false]); ?>
                    <?php echo $this->Html->link('Já tenho uma conta', ['controller' => 'Users', 'action' => 'login'], ['class' => 'btn-cadastro']); ?>
                </div>

                <?php echo $this->Form->end(); ?>

                <p class="footer-credits">Criado com 🧡 por ZamesINC</p>
            </div>
        </div>
    </div>
</div>