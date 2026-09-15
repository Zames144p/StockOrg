<?php echo $this->Html->css('homePage.css?v=' . time()); ?>

<?php
$userSession       = $this->Session->read('Auth.User') ?: array();
$posts             = isset($posts) && is_array($posts) ? $posts : array();
$busca             = isset($busca) ? $busca : '';
$dataInicio        = isset($dataInicio) ? $dataInicio : '';
$dataFim           = isset($dataFim) ? $dataFim : '';
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
                <?php echo $this->Html->link('Entrar', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn x-btn-gold-sm fw-bold')); ?>
            <?php endif; ?>
        </div>

        <!-- CARD DE FILTROS COMBINADOS (FORMULÁRIO ÚNICO) -->
        <div class="card p-3 mb-4 rounded-4 shadow-sm border border-theme-subtle">
            <h5 class="h6 text-gold mb-3 d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z" />
                </svg>
                Filtrar Postagens
            </h5>

            <?php echo $this->Form->create(null, array(
                'type'  => 'get',
                'url'   => array('controller' => 'posts', 'action' => 'index'),
                'class' => 'row g-3 align-items-end'
            )); ?>

            <!-- 1. Campo de Busca (Título, Conteúdo ou ID) -->
            <div class="col-12 col-md-4">
                <label class="form-label small text-gold mb-1">Buscar por Título / Conteúdo / ID</label>
                <?php echo $this->Form->input('busca', array(
                    'label'       => false,
                    'class'       => 'form-control x-input-custom',
                    'placeholder' => 'ID ou nome do post...',
                    'value'       => h($busca),
                    'div'         => false
                )); ?>
            </div>

            <!-- 2. Data Inicial -->
            <div class="col-6 col-md-2">
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

            <!-- 3. Data Final -->
            <div class="col-6 col-md-2">
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

            <!-- 4. Botões de Ação -->
            <div class="col-12 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center gap-1">
                    🔍 Filtrar
                </button>
                <?php if ($busca !== '' || $dataInicio !== '' || $dataFim !== ''): ?>
                    <?php echo $this->Html->link('Limpar', array('controller' => 'posts', 'action' => 'index'), array('class' => 'btn btn-outline-secondary py-2 px-3')); ?>
                <?php endif; ?>
            </div>

            <?php echo $this->Form->end(); ?>
        </div>

        <!-- Tabela Responsiva com o Seu Layout Original -->
        <div class="x-feed-card p-3 rounded-4">
            <div class="table-responsive">
                <table class="table table-dark-wine align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Title</th>
                            <th class="text-end">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($posts)): ?>
                            <?php foreach ($posts as $postIndex => $post): ?>
                                <tr>
                                    <td><strong class="text-gold">#<?php echo $postIndex + 1; ?></strong></td>
                                    <td>
                                        <?php
                                        echo $this->Html->link(
                                            $post['Post']['title'],
                                            array('action' => 'view', $post['Post']['id']),
                                            array('class' => 'post-title-link fw-bold text-decoration-none')
                                        );
                                        ?>
                                    </td>
                                    <td class="text-end">
                                        <small class="text-gold-light opacity-75">
                                            <?php echo !empty($post['Post']['created']) ? date('d/m/Y H:i', strtotime($post['Post']['created'])) : 'N/A'; ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    Nenhuma postagem encontrada com os filtros selecionados.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>