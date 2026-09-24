<?php echo $this->Html->css('perfilPage.css?v=' . time()); ?>

<?php
$userSession = $this->Session->read('Auth.User') ?: array();

if (!empty($user['User'])) {
    $userData = $user['User'];
} else {
    $userData = $userSession;
}

$posts       = isset($posts) ? $posts : array();
$rascunhos   = isset($rascunhos) ? $rascunhos : array();

$eMeuPerfil = !empty($userSession['id']) && !empty($userData['id']) && ($userSession['id'] == $userData['id']);

$cargoAutor = $post['User']['cargo'] ?? $userSession['cargo'] ?? '';
?>

<div class="dashboard-content">

    <!-- CARD DE CAPA E HEADER DO PERFIL -->
    <div class="profile-header-card mb-4">
        <div class="cover-photo"></div>
        <div class="profile-info-bar px-4 pb-3 pt-0 d-flex align-items-end justify-content-between">

            <div class="d-flex align-items-end gap-3">
                <div class="avatar-wrapper">
                    <?php
                    $foto = !empty($userData['foto']) ? $userData['foto'] : 'perfilDefault.jpg';
                    echo $this->Html->image($foto, array('class' => 'profile-main-avatar'));
                    ?>
                </div>

                <div class="user-titles mb-1">
                    <div class="d-flex align-items-center gap-2">
                        <h2 class="m-0 text-gold fw-bold fs-4"><?php echo h($userData['nome'] ?? $userData['username']); ?></h2>

                        <!-- Badge de Superadmin -->
                        <?php if (!empty($userData['cargo']) && strtolower($userData['cargo']) === 'superadmin'): ?>
                            <?php
                            echo $this->Html->image('superadmin_badge.png', array(
                                'title' => 'Superadmin',
                                'alt'   => 'Superadmin Badge',
                                'style' => 'width: 20px; height: 20px; object-fit: contain;'
                            ));
                            ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Exibe o Cargo do Banco de Dados -->
                    <span class="badge-role mt-1">
                         <?php echo h(!empty($userData['cargo']) ? ucfirst($userData['cargo']) : 'Autor'); ?>
                    </span>
                </div>
            </div>

            <div class="header-actions mb-2">
                <?php if ($eMeuPerfil): ?>
                    <?php echo $this->Html->link(
                        'Editar Perfil',
                        array('controller' => 'users', 'action' => 'edit'),
                        array('class' => 'btn btn-outline-gold btn-sm px-3 fw-bold')
                    ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- GRID TRÊS COLUNAS (ESQUERDA / CENTRO / DIREITA) -->
    <div class="content-grid">

        <!-- 1. COLUNA INFORMAÇÕES (ESQUERDA) -->
        <div class="card profile-side-card">
            <h3 class="card-title-gold">Informações</h3>
            <ul class="info-list list-unstyled m-0">
                <li>
                    <small class="text-gold-subtle d-block">E-mail</small>
                    <span><?php echo h($userData['email'] ?? 'N/A'); ?></span>
                </li>
                <li>
                    <small class="text-gold-subtle d-block">Membro desde</small>
                    <span><?php echo !empty($userData['criado_em']) ? date('d/m/Y', strtotime($userData['criado_em'])) : (!empty($userData['created']) ? date('d/m/Y', strtotime($userData['created'])) : 'N/A'); ?></span>
                </li>
                <li>
                    <small class="text-gold-subtle d-block">Localização</small>
                    <span>Natal, RN</span>
                </li>
            </ul>
        </div>

        <!-- 2. COLUNA CENTRAL (POSTS E RASCUNHOS) -->
        <div class="card profile-feed-card">

            <!-- ABAS SEPARADAS POSTS / RASCUNHO CORRIGIDAS -->
            <div class="feed-tabs d-flex gap-4 border-bottom border-gold-subtle pb-2 mb-3">
                <span class="tab-item active" id="tabPostsBtn">Posts (<?php echo count($posts); ?>)</span>
                <?php if ($eMeuPerfil): ?>
                    <span class="tab-item" id="tabDraftsBtn">Rascunhos (<?php echo count($rascunhos); ?>)</span>
                <?php endif; ?>
            </div>

            <!-- CONTEÚDO DOS POSTS PUBLICADOS -->
            <div id="postsContent" class="d-flex flex-column gap-3">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="post-item">

                            <div class="post-header mb-2 pb-2 d-flex align-items-center gap-2">
                                <?php echo $this->Html->image($foto, array('class' => 'post-avatar rounded-circle')); ?>

                                <div class="d-inline-flex align-items-center gap-1">
                                    <strong class="text-gold-light"><?php echo h($post['User']['nome'] ?? $post['User']['username'] ?? $userSession['nome'] ?? $userSession['username']); ?></strong>

                                    <?php
                                    if (!empty($cargoAutor) && strtolower($cargoAutor) === 'superadmin'):
                                    ?>
                                        <?php
                                        echo $this->Html->image('superadmin_badge.png', array(
                                            'title' => 'Superadmin',
                                            'alt'   => 'Superadmin Badge',
                                            'style' => 'width: 16px; height: 16px; object-fit: contain;'
                                        ));
                                        ?>
                                    <?php endif; ?>
                                </div>

                                <span class="small-text text-muted-custom ms-auto">• <?php echo !empty($post['Post']['criado_em']) ? date('d/m/Y', strtotime($post['Post']['criado_em'])) : 'Recente'; ?></span>
                            </div>

                            <!-- Imagem do Post -->
                            <?php if (!empty($post['Post']['imagem'])): ?>
                                <div class="post-image-container mb-2">
                                    <?php echo $this->Html->image($post['Post']['imagem'], array(
                                        'class' => 'img-fluid w-100 rounded'
                                    )); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Título Clicável -->
                            <h4 class="post-title m-0 mb-1">
                                <?php echo $this->Form->create(null, array(
                                    'url' => array('controller' => 'posts', 'action' => 'view'),
                                    'type' => 'post',
                                    'class' => 'd-inline'
                                )); ?>
                                <?php echo $this->Form->hidden('Post.id', array('value' => $post['Post']['id'])); ?>
                                <button type="submit" class="btn-link-title">
                                    <?php echo h($post['Post']['title'] ?? $post['Post']['titulo'] ?? 'Sem título'); ?>
                                </button>
                                <?php echo $this->Form->end(); ?>
                            </h4>

                            <!-- Conteúdo do Post -->
                            <p class="post-excerpt m-0 mb-2">
                                <?php
                                $texto = h($post['Post']['body'] ?? $post['Post']['conteudo'] ?? '');
                                echo strlen($texto) > 120 ? substr($texto, 0, 120) . '...' : $texto;
                                ?>
                            </p>

                            <!-- Footer do Card com Botão -->
                            <div class="post-footer text-end pt-2">
                                <?php echo $this->Form->create(null, array(
                                    'url' => array('controller' => 'posts', 'action' => 'view'),
                                    'type' => 'post',
                                    'class' => 'd-inline'
                                )); ?>
                                <?php echo $this->Form->hidden('Post.id', array('value' => $post['Post']['id'])); ?>
                                <button type="submit" class="btn-read-more">Ver post completo →</button>
                                <?php echo $this->Form->end(); ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state text-center py-4">
                        <p class="m-0 empty-text">Nenhum post publicado até o momento.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- CONTEÚDO DOS RASCUNHOS -->
            <div id="draftsContent" class="d-flex flex-column gap-3" style="display: none !important;">
                <?php if (!empty($rascunhos)): ?>
                    <?php foreach ($rascunhos as $rascunho): ?>
                        <div class="post-item draft-item">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-warning text-dark">Rascunho</span>
                                <span class="small-text text-muted-custom"><?php echo !empty($rascunho['Post']['criado_em']) ? date('d/m/Y', strtotime($rascunho['Post']['criado_em'])) : ''; ?></span>
                            </div>
                            <h4 class="post-title m-0 mb-1">
                                <?php echo $this->Html->link(
                                    h($rascunho['Post']['title'] ?? $rascunho['Post']['titulo'] ?? 'Rascunho sem título'),
                                    array('controller' => 'posts', 'action' => 'edit', $rascunho['Post']['id']),
                                    array('class' => 'btn-link-title')
                                ); ?>
                            </h4>
                            <p class="post-excerpt m-0 mb-2">
                                <?php echo h($rascunho['Post']['body'] ?? $rascunho['Post']['conteudo']); ?>
                            </p>
                            <div class="text-end pt-2 border-top border-secondary">
                                <?php echo $this->Html->link(
                                    'Editar rascunho',
                                    array('controller' => 'posts', 'action' => 'edit', $rascunho['Post']['id']),
                                    array('class' => 'btn btn-sm btn-outline-warning')
                                ); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state text-center py-4">
                        <p class="m-0 empty-text">Nenhum rascunho salvo.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- 3. COLUNA BIO (DIREITA) -->
        <div class="card profile-side-card">
            <h3 class="card-title-gold">Bio</h3>
            <p class="bio-text m-0">
                <?php echo nl2br(h($userData['bio'] ?? 'Nenhuma bio informada.')); ?>
            </p>
        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabPosts = document.getElementById('tabPostsBtn');
        const tabDrafts = document.getElementById('tabDraftsBtn');
        const postsBox = document.getElementById('postsContent');
        const draftsBox = document.getElementById('draftsContent');

        if (tabPosts && tabDrafts) {
            tabPosts.addEventListener('click', function() {
                tabPosts.classList.add('active');
                tabDrafts.classList.remove('active');

                postsBox.style.setProperty('display', 'flex', 'important');
                draftsBox.style.setProperty('display', 'none', 'important');
            });

            tabDrafts.addEventListener('click', function() {
                tabDrafts.classList.add('active');
                tabPosts.classList.remove('active');

                draftsBox.style.setProperty('display', 'flex', 'important');
                postsBox.style.setProperty('display', 'none', 'important');
            });
        }
    });
</script>