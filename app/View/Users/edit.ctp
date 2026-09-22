<?php echo $this->Html->css('editProfile.css?v=' . time()); ?>
<?php $userSession = $this->Session->read('Auth.User'); ?>

<div class="x-feed-container mx-auto p-3 p-md-4">

    <!-- Cabeçalho de Navegação -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-theme-subtle">
        <div class="d-flex align-items-center gap-3">
            <h1 class="h4 text-theme-primary fw-bold m-0">Editar Perfil</h1>
        </div>
    </div>

    <!-- Card Principal de Formulário -->
    <div class="card edit-profile-card p-3 p-md-4 rounded-4 shadow-lg">
        <?php echo $this->Form->create('User', array(
            'url' => array('controller' => 'users', 'action' => 'edit'),
            'type' => 'file',
            'class' => 'edit-profile-form'
        )); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>

        <!-- Seção de Avatar / Foto de Perfil -->
        <div class="avatar-upload-section text-center mb-4 pb-3 border-bottom border-theme-subtle">
            <div class="avatar-preview-wrapper mx-auto mb-3">
                <?php
                $avatar = !empty($this->request->data['User']['foto']) ? $this->request->data['User']['foto'] : 'perfilDefault.jpg';
                echo $this->Html->image($avatar, array('class' => 'profile-edit-avatar', 'id' => 'avatarPreview'));
                ?>
                <label for="UserFoto" class="avatar-upload-badge" title="Alterar foto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                        <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                    </svg>
                </label>
            </div>
            <div class="d-none">
                <?php echo $this->Form->input('foto', array('type' => 'file', 'label' => false, 'div' => false, 'id' => 'UserFoto', 'accept' => 'image/*')); ?>
            </div>
            <small class="text-theme-muted d-block">Clique no ícone de câmera para selecionar uma nova imagem</small>
        </div>

        <!-- Campos do Formulário -->
        <div class="row g-3">
            <div class="col-md-6 mb-1">
                <label for="UserNome" class="form-label text-theme-primary fw-bold">Nome</label>
                <?php echo $this->Form->input('nome', array(
                    'label' => false,
                    'div' => false,
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'Seu nome completo'
                )); ?>
            </div>

            <div class="col-md-6 mb-1">
                <label for="UserUsername" class="form-label text-theme-primary fw-bold">Nome de Usuário (@handle)</label>
                <?php echo $this->Form->input('username', array(
                    'label' => false,
                    'div' => false,
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'usuario'
                )); ?>
            </div>

            <div class="col-12 mb-1">
                <label for="UserEmail" class="form-label text-theme-primary fw-bold">Endereço de E-mail</label>
                <?php echo $this->Form->input('email', array(
                    'label' => false,
                    'div' => false,
                    'type' => 'email',
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'seu@email.com'
                )); ?>
            </div>

            <div class="col-12 mb-1">
                <label for="UserBio" class="form-label text-theme-primary fw-bold">Biografia / Apresentação</label>
                <?php echo $this->Form->input('bio', array(
                    'label' => false,
                    'div' => false,
                    'type' => 'textarea',
                    'rows' => '3',
                    'class' => 'form-control x-input-custom text-area-custom',
                    'placeholder' => 'Conte um pouco sobre você...'
                )); ?>
            </div>

            <div class="col-md-6 mb-1">
                <label for="UserSenhaHash" class="form-label text-theme-primary fw-bold">Nova senha</label>
                <?php echo $this->Form->input('senha_hash', array(
                    'label' => false,
                    'div' => false,
                    'type' => 'password',
                    'value' => '',
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'Deixe vazio para manter a atual'
                )); ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="UserConfirmarSenha" class="form-label text-theme-primary fw-bold">Confirmar nova senha</label>
                <?php echo $this->Form->input('confirmar_senha', array(
                    'label' => false,
                    'div' => false,
                    'type' => 'password',
                    'value' => '',
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'Repita a nova senha'
                )); ?>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="d-flex align-items-center justify-content-end gap-3 pt-3 mt-3 border-top border-theme-subtle">
            <?php echo $this->Html->link(
                'Cancelar',
                array('controller' => 'users', 'action' => 'perfil'),
                array('class' => 'btn x-btn-cancel fw-bold px-4 py-2')
            ); ?>

            <?php echo $this->Form->button('Salvar Alterações', array(
                'type' => 'submit',
                'class' => 'btn x-btn-post-lg px-4 py-2'
            )); ?>
        </div>

        <?php echo $this->Form->end(); ?>
    </div>

    <script>
        $(document).ready(function() {
            // Preview em tempo real da foto selecionada
            $('#UserFoto').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        $('#avatarPreview').attr('src', evt.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>