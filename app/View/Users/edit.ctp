<?php echo $this->Html->css('editProfile.css?v=' . time()); ?>
<?php $userSession = $this->Session->read('Auth.User'); ?>

<div class="x-feed-container mx-auto p-3 p-md-4">

    <!-- Cabeçalho de Navegação -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-theme-subtle">
        <div class="d-flex align-items-center gap-3">
            <!-- Logo StockOrg -->
            <?php echo $this->Html->link(
                $this->Html->image('LogoStockOrg.png', array(
                    'alt' => 'StockOrg',
                    'style' => 'width: 30px; height: 30px; object-fit: cover; border-radius: 50%; border: 1px solid var(--border-color);'
                )) .
                    '<span class="fs-4 fw-bold text-gold tracking-wide d-none d-xl-inline">StockOrg</span>',
                array('controller' => 'posts', 'action' => 'index'),
                array('class' => 'x-brand-header d-flex align-items-center gap-3 mb-4 text-decoration-none px-2 py-1', 'escape' => false)
            ); ?>
            <h1 class="h4 text-theme-primary fw-bold m-0">Editar Perfil</h1>
        </div>
    </div>

    <!-- Card Principal de Formulário -->
    <div class="card edit-profile-card p-4 rounded-4 shadow-lg">
        <?php echo $this->Form->create('User', array(
            'url' => array('controller' => 'users', 'action' => 'edit',),
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
                <?php echo $this->Form->input('foto', array('type' => 'file', 'label' => false, 'id' => 'UserFoto', 'accept' => 'image/*')); ?>
            </div>
            <small class="text-theme-muted d-block">Clique no ícone de câmera para selecionar uma nova imagem</small>
        </div>

        <!-- Campos do Formulário -->
        <div class="row g-3">
            <div class="col-md-6 mb-3">
                <label for="UserNome" class="form-label text-theme-primary fw-bold">Nome</label>
                <?php echo $this->Form->input('nome', array(
                    'label' => false,
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'Seu nome completo'
                )); ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="UserUsername" class="form-label text-theme-primary fw-bold">Nome de Usuário (@handle)</label>
                <?php echo $this->Form->input('username', array(
                    'label' => false,
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'usuario'
                )); ?>
            </div>

            <div class="col-12 mb-3">
                <label for="UserEmail" class="form-label text-theme-primary fw-bold">Endereço de E-mail</label>
                <?php echo $this->Form->input('email', array(
                    'label' => false,
                    'type' => 'email',
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'seu@email.com'
                )); ?>
            </div>

            <div class="col-12 mb-4">
                <label for="UserBio" class="form-label text-theme-primary fw-bold">Biografia / Apresentação</label>
                <?php echo $this->Form->input('bio', array(
                    'label' => false,
                    'type' => 'textarea',
                    'rows' => '3',
                    'class' => 'form-control x-input-custom text-area-custom',
                    'placeholder' => 'Conte um pouco sobre você...'
                )); ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="UserSenhaHash" class="form-label text-theme-primary fw-bold">Nova senha</label>
                <?php echo $this->Form->input('senha_hash', array(
                    'label' => false,
                    'type' => 'password',
                    'value' => '',
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'Deixe vazio para manter a atual'
                )); ?>
            </div>

            <div class="col-md-6 mb-4">
                <label for="UserConfirmarSenha" class="form-label text-theme-primary fw-bold">Confirmar nova senha</label>
                <?php echo $this->Form->input('confirmar_senha', array(
                    'label' => false,
                    'type' => 'password',
                    'value' => '',
                    'class' => 'form-control x-input-custom',
                    'placeholder' => 'Repita a nova senha'
                )); ?>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="d-flex align-items-center justify-content-end gap-3 pt-3 border-top border-theme-subtle">
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
    <!-- ... -->

   <!-- Caixa de Posts do Usuário no Final da Tela (Visível apenas para Admin) -->
<?php if (!empty($userSession['cargo']) && $userSession['cargo'] === 'admin'): ?>
    <div class="card feed-card mt-4 p-4 rounded-4 shadow-lg border border-theme-subtle">
        <div class="feed-tabs mb-3 pb-2 border-bottom border-theme-subtle d-flex align-items-center justify-content-between">
            <h3 class="m-0 fs-5 text-gold">
                Publicações de <?php echo h($targetUser['User']['nome'] ?? $targetUser['User']['username']); ?> (<?php echo count($userPosts); ?>)
            </h3>
            <span class="badge bg-gold text-dark">Visão de Administrador</span>
        </div>

        <div class="feed-posts d-flex flex-column gap-3">
            <?php if (!empty($userPosts)): ?>
                <?php foreach ($userPosts as $post): ?>
                    <div class="post-item p-3 border border-theme-subtle rounded-3">
                        <div class="post-header d-flex align-items-center gap-2 mb-2">
                            <?php 
                            $postAvatar = !empty($targetUser['User']['foto']) ? $targetUser['User']['foto'] : 'perfilDefault.jpg';
                            echo $this->Html->image($postAvatar, array('class' => 'post-avatar rounded-circle', 'style' => 'width: 36px; height: 36px; object-fit: cover;')); 
                            ?>
                            <div class="lh-sm">
                                <strong class="d-block text-gold"><?php echo h($targetUser['User']['nome'] ?? $targetUser['User']['username']); ?></strong>
                                <small class="text-muted"><?php echo h($post['Post']['created'] ?? $post['Post']['criado_em'] ?? ''); ?></small>
                            </div>
                        </div>

                        <!-- Título e Corpo do Post -->
                        <h4 class="h6 text-gold mb-1"><?php echo h($post['Post']['title'] ?? $post['Post']['titulo'] ?? ''); ?></h4>
                        <p class="post-text mb-3 opacity-90"><?php echo h($post['Post']['body'] ?? $post['Post']['conteudo'] ?? ''); ?></p>

                        <!-- Botões de Ação do Admin -->
                        <div class="d-flex justify-content-end gap-2 pt-2 border-top border-theme-subtle">
                            <?php echo $this->Html->link(
                                'Editar Post',
                                array('controller' => 'posts', 'action' => 'edit', $post['Post']['id']),
                                array('class' => 'btn btn-sm btn-outline-warning')
                            ); ?>
                            
                            <?php echo $this->Form->postLink(
                                'Excluir Post',
                                array('controller' => 'posts', 'action' => 'delete', $post['Post']['id']),
                                array('class' => 'btn btn-sm btn-outline-danger', 'confirm' => 'Tem certeza de que deseja apagar este post?')
                            ); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted my-2">Nenhum post encontrado para este usuário.</p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
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