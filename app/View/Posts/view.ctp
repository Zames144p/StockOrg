<?php echo $this->Html->css('postsView.css?v=' . time()); ?>

<?php
$userSession = $this->Session->read('Auth.User') ?: array();
$currentUserId = $userSession['id'] ?? null;
$currentUserCargo = $userSession['cargo'] ?? null;

// Dados do Post e Autor
$postData   = $post['Post'] ?? array();
$userData   = $post['User'] ?? array();
$postAuthorId = $postData['user_id'] ?? null;

// Checa se quem está vendo pode editar/deletar (Se for o próprio autor ou Admin)
$canManage = ($currentUserId && ($currentUserId == $postAuthorId || in_array($currentUserCargo, array('admin', 'SuperAdmin'), true)));
?>

<div class="x-feed-container mx-auto p-3 p-md-4" style="max-width: 850px; width: 100%;">

    <!-- Topo / Botão Voltar -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-gold-subtle">
        <?php echo $this->Html->link(
            '← Voltar para os posts',
            array('controller' => 'posts', 'action' => 'index'),
            array('class' => 'btn btn-outline-warning rounded-pill px-3 py-1 fw-bold text-decoration-none')
        ); ?>

        <?php if ($canManage): ?>
            <div class="d-flex gap-2">
                <?php echo $this->Html->link(
                    'Editar',
                    array('controller' => 'posts', 'action' => 'edit', $postData['id']),
                    array('class' => 'btn btn-sm btn-outline-warning rounded-pill px-3')
                ); ?>

                <?php echo $this->Form->postLink(
                    'Excluir',
                    array('controller' => 'posts', 'action' => 'delete', $postData['id']),
                    array('class' => 'btn btn-sm btn-outline-danger rounded-pill px-3', 'confirm' => 'Tem certeza que deseja apagar esta publicação?')
                ); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- CARD DO POST COMPLETO -->
    <article class="card rounded-4 shadow-lg overflow-hidden border border-theme-subtle bg-dark-card">
        
        <!-- 1. IMAGEM DO POST (Renderizada APENAS se existir imagem) -->
        <?php if (!empty($postData['imagem'])): ?>
            <div class="post-cover-wrapper w-100 overflow-hidden" style="max-height: 400px; background-color: rgba(0, 0, 0, 0.2);">
                <?php echo $this->Html->image($postData['imagem'], array(
                    'class' => 'img-fluid rounded-3',
                    'style' => 'object-fit: cover;',
                    'alt'   => h($postData['title'] ?? $postData['titulo'] ?? 'Imagem do post')
                )); ?>
            </div>
        <?php endif; ?>

        <div class="card-body p-4 p-md-5">

            <!-- Cabeçalho do Conteúdo: Título + Dados do Autor -->
            <header class="mb-4 pb-3 border-bottom border-theme-subtle">
                <h1 class="h2 text-gold fw-bold mb-3">
                    <?php echo h($postData['title'] ?? $postData['titulo'] ?? 'Sem título'); ?>
                </h1>

                <div class="d-flex align-items-center gap-3">
                    <!-- Avatar do Autor -->
                    <?php 
                    $userAvatar = !empty($userData['foto']) ? $userData['foto'] : 'perfilDefault.jpg';
                    echo $this->Html->image($userAvatar, array(
                        'class' => 'rounded-circle border border-gold-subtle',
                        'style' => 'width: 45px; height: 45px; object-fit: cover;'
                    )); 
                    ?>

                    <div class="lh-sm">
                        <strong class="d-block text-gold fs-6">
                            <?php echo h($userData['nome'] ?? $userData['username'] ?? 'Autor Desconhecido'); ?>
                        </strong>
                        <small class="text-gold-light opacity-75">
                            Publicado em <?php 
                            $dataPost = $postData['criado_em'] ?? $postData['created'] ?? null;
                            echo !empty($dataPost) ? date('d/m/Y \à\s H:i', strtotime($dataPost)) : 'Data não informada'; 
                            ?>
                        </small>
                    </div>
                </div>
            </header>

            <!-- 2. CORPO DO TEXTO / CONTEÚDO -->
            <div class="post-content-body text-light opacity-90 fs-5 lh-lg mb-4">
                <?php 
                $textoPost = $postData['body'] ?? $postData['conteudo'] ?? '';
                // nl2br garante que os parágrafos e quebras de linha digitados no textarea sejam mantidos no HTML
                echo nl2br(h($textoPost)); 
                ?>
            </div>

            <!-- Rodapé do Card -->
            <footer class="pt-3 border-top border-theme-subtle d-flex align-items-center justify-content-between">
                <span class="badge bg-dark border border-gold-subtle text-gold">
                    Post #<?php echo h($postData['id']); ?>
                </span>

                <small class="text-muted">StockOrg Blog</small>
            </footer>

        </div>
    </article>

</div>