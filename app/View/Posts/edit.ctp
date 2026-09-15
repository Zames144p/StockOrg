<?php echo $this->Html->css('globalApp.css?v=' . time()); ?>

<div class="container-fluid p-0">
    <!-- Cabeçalho da Página -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-gold-subtle">
        <div class="d-flex align-items-center gap-3">
            <?php echo $this->Html->link(
                '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-left text-gold" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/></svg>',
                array('action' => 'index'),
                array('class' => 'btn btn-icon-back rounded-circle p-2 d-flex align-items-center justify-content-center', 'escape' => false, 'title' => 'Voltar aos posts')
            ); ?>
            <h1 class="h3 text-gold fw-bold m-0">Editar Post</h1>
        </div>
        <span class="text-gold-light opacity-75 small">ID: #<?php echo h($this->request->data['Post']['id'] ?? ''); ?></span>
    </div>

    <!-- Form Card -->
    <div class="card x-feed-card p-4 rounded-4 shadow-lg">
        <?php echo $this->Form->create('Post', array('class' => 'x-form-post')); ?>
        
        <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>

        <!-- Campo Título -->
        <div class="mb-4">
            <label for="PostTitle" class="form-label text-gold fw-bold">Título da Publicação</label>
            <?php echo $this->Form->input('title', array(
                'label' => false,
                'class' => 'form-control x-input-custom',
                'placeholder' => 'Digite o título...',
                'required' => true
            )); ?>
        </div>

        <!-- Campo Conteúdo -->
        <div class="mb-4">
            <label for="PostBody" class="form-label text-gold fw-bold">Conteúdo</label>
            <?php echo $this->Form->input('body', array(
                'label' => false,
                'type' => 'textarea',
                'rows' => '6',
                'class' => 'form-control x-input-custom text-area-custom',
                'placeholder' => 'O que você quer atualizar nesta publicação?',
                'required' => true
            )); ?>
        </div>

        <!-- Botões de Ação -->
        <div class="d-flex align-items-center justify-content-end gap-3 pt-2 border-top border-gold-subtle">
            <?php echo $this->Html->link(
                'Cancelar',
                array('action' => 'index'),
                array('class' => 'btn x-btn-cancel fw-bold px-4 py-2')
            ); ?>

            <?php echo $this->Form->button('Salvar Alterações', array(
                'type' => 'submit',
                'class' => 'btn x-btn-post-lg px-4 py-2'
            )); ?>
        </div>

        <?php echo $this->Form->end(); ?>
    </div>
</div>