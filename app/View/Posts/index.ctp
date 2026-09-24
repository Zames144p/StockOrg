<?php echo $this->Html->css('globalApp.css?v=' . time()); ?>

<?php
$userSession       = $this->Session->read('Auth.User') ?: array();
$posts             = isset($posts) && is_array($posts) ? $posts : array();
$busca             = isset($busca) ? $busca : '';
$dataInicio        = isset($dataInicio) ? $dataInicio : '';
$dataFim           = isset($dataFim) ? $dataFim : '';
$status            = isset($status) ? $status : '';
$usuariosEncontrados = isset($usuariosEncontrados) && is_array($usuariosEncontrados)
    ? $usuariosEncontrados
    : array();
$currentController = strtolower($this->params['controller']);
$currentAction     = strtolower($this->params['action']);
?>

<div class="main-layout-container d-flex">

    <!-- CONTEÚDO PRINCIPAL (FEED DE POSTS) -->
    <main class="feed-container flex-grow-1 p-3 p-md-4">

        <!-- Cabeçalho -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-gold-subtle">
            <h1 class="h3 text-gold fw-bold m-0">Blog posts</h1>
            <?php if (empty($userSession)): ?>
                <?php echo $this->Html->link('Entrar', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-sm btn-outline-gold')); ?>
            <?php endif; ?>
        </div>

        <!-- BARRA DE PESQUISA RESPONSIVA -->
        <div class="search-section-wrapper mb-4">
            <?php echo $this->Form->create(null, array(
                'type'  => 'post',
                'url'   => array('controller' => 'posts', 'action' => 'index'),
                'class' => 'd-flex flex-column flex-sm-row gap-2 align-items-stretch align-items-sm-center'
            )); ?>

            <!-- Input de Busca Principal -->
            <div class="flex-grow-1">
                <?php echo $this->Form->input('busca', array(
                    'label'       => false,
                    'class'       => 'form-control x-input-custom py-2 w-100',
                    'placeholder' => 'Buscar por post, conteúdo ou autor...',
                    'value'       => h($busca),
                    'div'         => false
                )); ?>
            </div>

            <!-- Grupo de Botões (Lado a Lado no Mobile) -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1 flex-sm-grow-0 px-4 py-2 fw-bold d-flex align-items-center justify-content-center">
                    Buscar
                </button>

                <!-- Dropdown de Filtros -->
                <div class="dropdown flex-grow-1 flex-sm-grow-0">
                    <button class="btn btn-outline-warning w-100 py-2 px-3 d-flex align-items-center justify-content-center gap-2 rounded-3"
                        type="button"
                        id="dropdownMenuFiltros"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="false"
                        aria-expanded="false">
                        <span>Filtros</span>
                        <?php if (!empty($dataInicio) || !empty($dataFim) || !empty($status)): ?>
                            <span class="badge bg-gold text-dark rounded-circle p-1"></span>
                        <?php endif; ?>
                    </button>

                    <!-- Card Flutuante de Filtros -->
                    <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg border border-theme-subtle rounded-4 bg-dark-card mt-2"
                        aria-labelledby="dropdownMenuFiltros"
                        style="width: min(320px, 90vw); background-color: #2a0000;">

                        <h6 class="text-gold fw-bold mb-3 border-bottom border-theme-subtle pb-2">
                            Filtros Avançados
                        </h6>

                        <div class="mb-3">
                            <label class="form-label small text-gold mb-1">Data Inicial</label>
                            <?php echo $this->Form->input('data_inicio', array(
                                'type'        => 'text',
                                'label'       => false,
                                'class'       => 'form-control x-input-custom',
                                'placeholder' => 'DD/MM/AAAA',
                                'value'       => is_string($dataInicio) ? h($dataInicio) : '',
                                'div'         => false
                            )); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-gold mb-1">Data Final</label>
                            <?php echo $this->Form->input('data_fim', array(
                                'type'        => 'text',
                                'label'       => false,
                                'class'       => 'form-control x-input-custom',
                                'placeholder' => 'DD/MM/AAAA',
                                'value'       => is_string($dataFim) ? h($dataFim) : '',
                                'div'         => false
                            )); ?>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-2 border-top border-theme-subtle">
                            <?php if (!empty($busca) || !empty($dataInicio) || !empty($dataFim) || !empty($status)): ?>
                                <?php echo $this->Html->link('Limpar', array('controller' => 'posts', 'action' => 'clearFilters'), array('class' => 'btn btn-sm btn-outline-secondary')); ?>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-sm btn-primary px-3 fw-bold ms-auto">
                                Aplicar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo $this->Form->end(); ?>
        </div>

        <?php if (!empty($usuariosEncontrados)): ?>
            <section class="mb-4">
                <h2 class="h6 text-gold fw-bold mb-3 d-flex align-items-center gap-2">
                    <span>Usuários encontrados</span>
                    <span class="badge bg-warning text-dark rounded-pill fs-7"><?php echo count($usuariosEncontrados); ?></span>
                </h2>

                <div class="row g-3">
                    <?php foreach ($usuariosEncontrados as $usuario): ?>
                        <?php $userId = $usuario['User']['id']; ?>

                        <div class="col-12 col-sm-6 col-md-4">
                            <!-- Card Clicável com Link Direto para o Perfil do Usuário -->
                            <?php echo $this->Html->link(
                                '
                        <div class="d-flex align-items-center gap-3">
                            ' . $this->Html->image(
                                    !empty($usuario['User']['foto']) ? $usuario['User']['foto'] : 'perfilDefault.jpg',
                                    array(
                                        'class' => 'rounded-circle border border-gold-subtle flex-shrink-0',
                                        'style' => 'width: 44px; height: 44px; object-fit: cover;'
                                    )
                                ) . '
                            
                            <div class="overflow-hidden flex-grow-1">
                                <div class="d-flex align-items-center gap-1">
                                    <strong class="text-gold text-truncate d-block small fs-6 m-0">
                                        ' . h($usuario['User']['nome'] ?? $usuario['User']['username']) . '
                                    </strong>
                                    
                                    ' . ((!empty($usuario['User']['cargo']) && strtolower($usuario['User']['cargo']) === 'superadmin') ?
                                    $this->Html->image('superadmin_badge.png', array(
                                        'title' => 'Superadmin',
                                        'alt'   => 'Superadmin Badge',
                                        'style' => 'width: 15px; height: 15px; object-fit: contain; vertical-align: middle; flex-shrink: 0;'
                                    )) : '') . '
                                </div>
                                
                                <small class="text-gold-light opacity-75 d-block text-truncate fs-7">
                                    @' . h($usuario['User']['username']) . '
                                </small>
                            </div>
                        </div>
                        ',
                                array('controller' => 'users', 'action' => 'perfil', $userId),
                                array(
                                    'class'  => 'user-search-card d-block p-2 px-3 rounded-4 border border-theme-subtle text-decoration-none transition-hover',
                                    'style'  => 'background-color: #2a0000; border: 1px solid rgba(212, 175, 55, 0.3) !important;',
                                    'escape' => false
                                )
                            ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Tabela Responsiva com o Seu Layout Original -->
        <div class="row g-4">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card h-100 shadow-sm rounded-4 overflow-hidden border border-theme-subtle">

                            <!-- Exibe a imagem APENAS se o post tiver um arquivo anexado -->
                            <?php if (!empty($post['Post']['imagem'])): ?>
                                <div class="card-img-wrapper" style="height: 180px; background-color: rgba(255, 255, 255, 0.05);">
                                    <?php echo $this->Html->image($post['Post']['imagem'], array(
                                        'class' => 'card-img-top w-100 h-100',
                                        'style' => 'object-fit: cover;',
                                        'alt'   => h($post['Post']['title'] ?? $post['Post']['titulo'] ?? 'Post')
                                    )); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Corpo do Card -->
                            <div class="card-body d-flex flex-column justify-content-between p-3">
                                <div>
                                    <!-- Título -->
                                    <h5 class="card-title h6 text-gold fw-bold mb-2">
                                        <?php echo h($post['Post']['title'] ?? $post['Post']['titulo'] ?? 'Sem título'); ?>
                                    </h5>

                                    <!-- Autor e Data com Badge de Superadmin -->
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <small class="text-gold-light opacity-75">
                                                <?php echo h($post['User']['nome'] ?? $post['User']['username'] ?? 'Autor Desconhecido'); ?>
                                            </small>

                                            <!-- Exibe o Badge se o autor do post for Superadmin -->
                                            <?php if (!empty($post['User']['cargo']) && strtolower($post['User']['cargo']) === 'superadmin'): ?>
                                                <?php
                                                echo $this->Html->image('superadmin_badge.png', array(
                                                    'title' => 'Superadmin',
                                                    'alt'   => 'Superadmin Badge',
                                                    'style' => 'width: 15px; height: 15px; object-fit: contain; margin-left: 2px; background: transparent !important; border: none !important;'
                                                ));
                                                ?>
                                            <?php endif; ?>
                                        </div>

                                        <span class="text-muted">•</span>
                                        <small class="text-gold-light opacity-75">
                                            <?php echo !empty($post['Post']['criado_em']) ? date('d/m/Y', strtotime($post['Post']['criado_em'])) : (!empty($post['Post']['created']) ? date('d/m/Y', strtotime($post['Post']['created'])) : 'N/A'); ?>
                                        </small>
                                    </div>

                                    <!-- Resumo do Conteúdo -->
                                    <p class="card-text text-secondary small opacity-90 mb-3">
                                        <?php
                                        $conteudo = h($post['Post']['body'] ?? $post['Post']['conteudo'] ?? '');
                                        echo strlen($conteudo) > 120 ? substr($conteudo, 0, 120) . '...' : $conteudo;
                                        ?>
                                    </p>
                                </div>

                                <!-- Botão Ler Post -->
                                <div class="pt-2 border-top border-theme-subtle">
                                    <?php echo $this->Form->create(null, array(
                                        'url' => array('controller' => 'posts', 'action' => 'view'),
                                        'type' => 'post',
                                        'class' => 'm-0'
                                    )); ?>
                                    <?php echo $this->Form->hidden('Post.id', array('value' => $post['Post']['id'])); ?>
                                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3">Ver mais</button>
                                    <?php echo $this->Form->end(); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="card p-4 text-center text-muted rounded-4 border border-theme-subtle">
                        Nenhum post encontrado.
                    </div>
                </div>
            <?php endif; ?>
        </div>