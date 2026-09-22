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

$eMeuPerfil = !empty($userSession['id']) && !empty($userData['id']) && ($userSession['id'] == $userData['id']); //verificar se é a propria pessoa
?>

<div class="dashboard-content">

    <!-- CARD DE CAPA E HEADER DO PERFIL -->
    <div class="profile-header-card">
        <div class="cover-photo"></div>
        <div class="profile-info-bar">

            <div class="avatar-wrapper">
                <?php
                $foto = !empty($userData['foto']) ? $userData['foto'] : 'perfilDefault.jpg';
                echo $this->Html->image($foto, array('class' => 'profile-main-avatar'));
                ?>
            </div>

            <div class="user-titles me-auto ms-3">
                <div class="d-flex align-items-center gap-1">
                    <h2 class="m-0"><?php echo h($userData['nome'] ?? $userData['username']); ?></h2>

                    <!-- Badge de Superadmin do usuário consultado -->
                    <?php if (!empty($userData['cargo']) && strtolower($userData['cargo']) === 'superadmin'): ?>
                        <?php
                        echo $this->Html->image('superadmin_badge.png', array(
                            'title' => 'Superadmin',
                            'alt'   => 'Superadmin Badge',
                            'style' => 'width: 20px; height: 20px; object-fit: contain; margin-left: 3px; background: transparent !important; border: none !important;'
                        ));
                        ?>
                    <?php endif; ?>
                </div>
                <p class="m-0 mt-1">Blogger / Content Creator</p>
            </div>

            <div class="header-actions ms-auto">
                <?php if ($eMeuPerfil): ?>
                    <?php echo $this->Html->link(
                        'Editar Perfil',
                        array('controller' => 'users', 'action' => 'edit'),
                        array('class' => 'btn btn-outline-warning fw-bold px-3 py-1')
                    ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- GRID TRÊS COLUNAS LADO A LADO (ESQUERDA / CENTRO / DIREITA) -->
    <div class="content-grid">

        <!-- 1. COLUNA INFORMAÇÕES (ESQUERDA - 200px) -->
        <div class="card">
            <h3>Informações</h3>
            <ul class="info-list">
                <li><strong style="color: #d4af37;">Email:</strong><br> <?php echo h($userData['email'] ?? 'N/A'); ?></li>
                <li><strong style="color: #d4af37;">Entrou:</strong><br> <?php echo !empty($userData['criado_em']) ? date('Y-m-d H:i', strtotime($userData['criado_em'])) : (!empty($userData['created']) ? date('Y-m-d H:i', strtotime($userData['created'])) : 'N/A'); ?></li>
                <li><strong style="color: #d4af37;">Localização:</strong><br> Natal, RN</li>
            </ul>
        </div>

        <!-- 2. COLUNA CENTRAL (POSTS E RASCUNHOS COM ABAS SEPARADAS - 1fr) -->
        <div class="card">

            <!-- ABAS SEPARADAS POSTS / RASCUNHO -->
            <div class="feed-tabs">
                <span class="active" id="tabPostsBtn" style="cursor: pointer;">Posts</span>
                <?php if ($eMeuPerfil): ?>
                    <span id="tabDraftsBtn" style="cursor: pointer; color: #a0a0a0;">Rascunho (<?php echo count($rascunhos); ?>)</span>
                <?php endif; ?>
            </div>

            <!-- CONTEÚDO DOS POSTS PUBLICADOS -->
            <div id="postsContent" class="d-flex flex-column gap-3">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="post-item" style="background-color: #1a0000; border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 8px; padding: 12px;">

                            <!-- Header do Autor com Badge de Superadmin -->
                            <div class="post-header mb-2 pb-2 d-flex align-items-center gap-2" style="border-bottom: 1px solid rgba(212, 175, 55, 0.15);">
                                <?php echo $this->Html->image($foto, array('class' => 'post-avatar')); ?>

                                <div class="d-inline-flex align-items-center gap-1">
                                    <strong style="color: #d4af37;"><?php echo h($post['User']['nome'] ?? $post['User']['username'] ?? $userSession['nome'] ?? $userSession['username']); ?></strong>

                                    <!-- Badge de Superadmin do Autor do Post -->
                                    <?php
                                    $cargoAutor = $post['User']['cargo'] ?? $userSession['cargo'] ?? '';
                                    if (!empty($cargoAutor) && strtolower($cargoAutor) === 'superadmin'):
                                    ?>
                                        <?php
                                        echo $this->Html->image('superadmin_badge.png', array(
                                            'title' => 'Superadmin',
                                            'alt'   => 'Superadmin Badge',
                                            'style' => 'width: 16px; height: 16px; object-fit: contain; margin-left: 2px; background: transparent !important; border: none !important;'
                                        ));
                                        ?>
                                    <?php endif; ?>
                                </div>

                                <span class="small-text">• <?php echo !empty($post['Post']['criado_em']) ? date('d/m/Y', strtotime($post['Post']['criado_em'])) : 'Recently'; ?></span>
                            </div>

                            <!-- Imagem do Post se houver -->
                            <?php if (!empty($post['Post']['imagem'])): ?>
                                <div class="mb-2" style="max-height: 180px; overflow: hidden; border-radius: 6px;">
                                    <?php echo $this->Html->image($post['Post']['imagem'], array(
                                        'style' => 'width: 100%; height: 100%; object-fit: cover; display: block;'
                                    )); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Título Clicável -->
                            <h4 style="margin: 0 0 6px 0; font-size: 15px;">
                                <?php echo $this->Html->link(
                                    h($post['Post']['title'] ?? $post['Post']['titulo'] ?? 'Sem título'),
                                    array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),
                                    array('style' => 'color: #d4af37; text-decoration: none; font-weight: bold;')
                                ); ?>
                            </h4>

                            <!-- Conteúdo do Post -->
                            <p style="color: #a0a0a0; margin: 0 0 10px 0; font-size: 12px;">
                                <?php
                                $texto = h($post['Post']['body'] ?? $post['Post']['conteudo'] ?? '');
                                echo strlen($texto) > 110 ? substr($texto, 0, 110) . '...' : $texto;
                                ?>
                            </p>

                            <!-- Botão para Abrir o Post -->
                            <div style="text-align: right; border-top: 1px solid rgba(212, 175, 55, 0.15); padding-top: 8px;">
                                <?php echo $this->Html->link(
                                    'Ver post completo →',
                                    array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),
                                    array('class' => 'btn-outline', 'style' => 'font-size: 11px; padding: 4px 10px; text-decoration: none; display: inline-block;')
                                ); ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="small-text" style="text-align: center; padding: 15px 0;">Nenhum post publicado.</p>
                <?php endif; ?>
            </div>

            <!-- CONTEÚDO DOS RASCUNHOS (INICIALMENTE OCULTO) -->
            <div id="draftsContent" class="d-flex flex-column gap-3" style="display: none !important;">
                <?php if (!empty($rascunhos)): ?>
                    <?php foreach ($rascunhos as $rascunho): ?>
                        <div class="post-item" style="background-color: #1a0000; border: 1px dashed #d4af37; border-radius: 8px; padding: 12px;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="hash-code">Rascunho</span>
                                <span class="small-text"><?php echo !empty($rascunho['Post']['criado_em']) ? date('d/m/Y', strtotime($rascunho['Post']['criado_em'])) : ''; ?></span>
                            </div>
                            <h4 style="margin: 0 0 6px 0; font-size: 15px;">
                                <?php echo $this->Html->link(
                                    h($rascunho['Post']['title'] ?? $rascunho['Post']['titulo'] ?? 'Rascunho sem título'),
                                    array('controller' => 'posts', 'action' => 'edit', $rascunho['Post']['id']),
                                    array('style' => 'color: #d4af37; text-decoration: none; font-weight: bold;')
                                ); ?>
                            </h4>
                            <p style="color: #a0a0a0; margin: 0 0 10px 0; font-size: 12px;">
                                <?php echo h($rascunho['Post']['body'] ?? $rascunho['Post']['conteudo']); ?>
                            </p>
                            <div style="text-align: right;">
                                <?php echo $this->Html->link(
                                    'Editar rascunho',
                                    array('controller' => 'posts', 'action' => 'edit', $rascunho['Post']['id']),
                                    array('class' => 'btn-primary', 'style' => 'font-size: 11px; padding: 4px 10px; text-decoration: none; display: inline-block;')
                                ); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="small-text" style="text-align: center; padding: 15px 0;">Nenhum rascunho salvo.</p>
                <?php endif; ?>
            </div>

        </div>

        <!-- 3. COLUNA BIO (DIREITA - 180px) -->
        <div class="card">
            <h3>Bio</h3>
            <p style="font-size: 12px; color: #f0d98a; line-height: 1.5; margin: 0;">
                <?php echo nl2br(h($userData['bio'] ?? 'Nenhuma bio informada.')); ?>
            </p>
        </div>

    </div>

</div>

<!-- SCRIPT SIMPLES PARA ALTERNAR AS ABAS POSTS E RASCUNHO -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabPosts = document.getElementById('tabPostsBtn');
        const tabDrafts = document.getElementById('tabDraftsBtn');
        const postsBox = document.getElementById('postsContent');
        const draftsBox = document.getElementById('draftsContent');

        if (tabPosts && tabDrafts) {
            tabPosts.addEventListener('click', function() {
                tabPosts.classList.add('active');
                tabPosts.style.color = '#d4af37';

                tabDrafts.classList.remove('active');
                tabDrafts.style.color = '#a0a0a0';

                postsBox.style.setProperty('display', 'flex', 'important');
                draftsBox.style.setProperty('display', 'none', 'important');
            });

            tabDrafts.addEventListener('click', function() {
                tabDrafts.classList.add('active');
                tabDrafts.style.color = '#d4af37';

                tabPosts.classList.remove('active');
                tabPosts.style.color = '#a0a0a0';

                draftsBox.style.setProperty('display', 'flex', 'important');
                postsBox.style.setProperty('display', 'none', 'important');
            });
        }
    });
</script>