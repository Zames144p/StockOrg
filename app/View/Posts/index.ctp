<?php echo $this->Html->css('homePage.css?v=' . time()); ?>

<?php 
/**
* @var array $posts 
*/

$userSession       = $this->Session->read('Auth.User');
$currentController = strtolower($this->params['controller']);
$currentAction     = strtolower($this->params['action']);
?>

<div class="main-layout-container d-flex">

    <!-- CONTEÚDO PRINCIPAL (FEED DE POSTS) -->
    <main class="feed-container flex-grow-1 p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-gold-subtle">
            <h1 class="h3 text-gold fw-bold m-0">Blog posts</h1>
            <?php if (!empty($userSession)): ?>
                <?php echo $this->Html->link('Novo Post', array('action' => 'add'), array('class' => 'btn x-btn-gold-sm fw-bold')); ?>
            <?php endif; ?>
        </div>

        <!-- Tabela Responsiva Sem Fundo Branco -->
        <div class="x-feed-card p-3 rounded-4">
            <div class="table-responsive">
                <table class="table table-dark-wine align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th class="text-end">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><strong class="text-gold">#<?php echo $post['Post']['id']; ?></strong></td>
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
                                        <?php echo !empty($post['Post']['criado_em']) ? date('d/m/Y H:i', strtotime($post['Post']['criado_em'])) : 'N/A'; ?>
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</div>