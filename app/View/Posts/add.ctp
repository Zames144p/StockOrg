<?php echo $this->Html->css('globalApp.css?v=' . time()); ?>

<!-- Adicionado wrapper x-container-post para limitar a largura no desktop -->
<div class="container-fluid x-container-post mx-auto p-3 p-md-4">
    <!-- Cabeçalho da Página -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-gold-subtle">
        <div class="d-flex align-items-center gap-3">
            <?php echo $this->Html->link(
                '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-left text-gold" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/></svg>',
                array('action' => 'index'),
                array('class' => 'btn btn-icon-back rounded-circle p-2 d-flex align-items-center justify-content-center', 'escape' => false, 'title' => 'Voltar aos posts')
            ); ?>
            <h1 class="h3 text-gold fw-bold m-0">Publicar Post</h1>
        </div>
        <span class="text-gold-light opacity-75 small">ID: #<?php echo h($this->request->data['Post']['id'] ?? ''); ?></span>
    </div>

    <!-- Form Card -->
    <div class="card x-feed-card p-3 p-md-4 rounded-4 shadow-lg" style="background-color: var(--bg-card-color, #120202); border: 1px solid var(--border-color, rgba(212, 175, 55, 0.3));">
        <?php echo $this->Form->create('Post', array('class' => 'x-form-post', 'type' => 'file')); ?>

        <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>

        <!-- Campo Título -->
        <div class="mb-4">
            <label for="PostTitle" class="form-label text-gold fw-bold">Título da Publicação</label>
            <?php echo $this->Form->input('title', array(
                'label' => false,
                'div' => false, /* Remove o wrapper automático do Cake */
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
                'div' => false, /* Remove o wrapper automático do Cake */
                'type' => 'textarea',
                'rows' => '6',
                'class' => 'form-control x-input-custom text-area-custom',
                'placeholder' => 'O que você quer atualizar nesta publicação?',
                'required' => true
            )); ?>
        </div>

        <!-- Campo Imagem -->
        <div class="mb-4">
            <label class="form-label text-gold fw-bold mb-2">Imagem de Capa (Opcional)</label>

            <!-- Input oculto sem wrapper de div do CakePHP -->
            <?php echo $this->Form->input('imagem', array(
                'type'   => 'file',
                'label'  => false,
                'div'    => false,
                'id'     => 'inputCapaPost',
                'accept' => 'image/*',
                'style'  => 'display: none !important;'
            )); ?>

            <!-- Card Clicável -->
            <label for="inputCapaPost" class="upload-custom-zone p-4 text-center rounded-4 border border-gold-subtle d-block style-upload-label">
                <div class="py-2" id="boxUploadInstructions">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-cloud-arrow-up text-gold mb-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z" />
                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056a.5.5 0 0 1-.5.5C1.988 6.655 1 7.828 1 9.318 1 10.817 2.243 12 3.78 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5a.5.5 0 0 1-.5-.5C11.687 4.732 9.92 3 8 3c-1.63 0-3.072 1.222-3.594 2.871a.5.5 0 0 1-.402.378c-.707.127-1.32.483-1.745.95-.425.467-.625 1.056-.625 1.638z" />
                    </svg>
                    <p class="text-gold opacity-90 m-0 fw-semibold">Clique para escolher uma imagem de capa</p>
                    <small class="text-muted d-block mt-1">Formatos suportados: JPG, PNG, WEBP</small>
                </div>
                <!-- Div oculta que guardará o preview da foto se selecionada -->
                <img id="imgPostPreview" src="#" alt="Preview" class="img-fluid rounded-3 d-none mt-2mx-auto" style="max-height: 250px; object-fit: cover;">
            </label>
        </div>

        <!-- Botões de Ação (Ajustado flexbox para colapsar em telas super pequenas) -->
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 gap-sm-3 pt-3 border-top border-gold-subtle">
            <?php echo $this->Html->link(
                'Cancelar',
                array('action' => 'index'),
                array('class' => 'btn x-btn-cancel fw-bold px-4 py-2 order-3 order-sm-1 w-100 w-sm-auto')
            ); ?>

            <?php echo $this->Form->button('Salvar rascunho', array(
                'type' => 'submit',
                'name' => 'data[Post][status]',
                'value' => 'draft',
                'class' => 'btn x-btn-cancel fw-bold px-4 py-2 order-2 order-sm-2 w-100 w-sm-auto'
            )); ?>

            <?php echo $this->Form->button('Publicar', array(
                'type' => 'submit',
                'name' => 'data[Post][status]',
                'value' => 'published',
                'class' => 'btn x-btn-post-lg px-4 py-2 order-1 order-sm-3 w-100 w-sm-auto'
            )); ?>
        </div>

        <?php echo $this->Form->end(); ?>
    </div>
</div>

<!-- Script estruturado para criar um preview da imagem de capa antes do upload -->
<script>
document.getElementById('inputCapaPost').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const preview = document.getElementById('imgPostPreview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
});
</script>