<?php echo $this->Html->css('globalApp.css?v=' . time()); ?>

<div class="x-feed-container mx-auto p-3 p-md-4">

    <!-- Cabeçalho de Navegação Alinhado -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-gold-subtle">
        <div class="d-flex align-items-center gap-3">
            <?php echo $this->Html->link(
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left text-gold" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/></svg>',
                array('controller' => 'posts', 'action' => 'index'),
                array('class' => 'btn btn-icon-back rounded-circle p-2 d-flex align-items-center justify-content-center', 'escape' => false, 'title' => 'Voltar ao feed')
            ); ?>
            <h1 class="h4 text-gold fw-bold m-0">Sobre o StockOrg</h1>
        </div>
    </div>

    <!-- Bloco de Conteúdo Textual com Limite de Largura -->
    <div class="card x-feed-card p-4 rounded-4 shadow-lg text-gold-light">
        
        <section class="mb-4">
            <h2 class="h5 text-gold fw-bold mb-3 border-bottom border-gold-subtle pb-2">O que é o StockOrg</h2>
            <p class="lh-base opacity-90 small">
                O <strong>StockOrg</strong> é uma plataforma voltada para a organização, gerenciamento e publicação de conteúdos e informações estratégicas. Desenvolvido para oferecer um ambiente dinâmico, o sistema combina simplicidade na gestão de dados com uma navegação rápida e intuitiva.
            </p>
            <p class="lh-base opacity-90 small mb-0">
                Inspirado em redes modernas de comunicação, o projeto prioriza a agilidade no fluxo de postagens, permitindo que usuários e administradores acompanhem atualizações em tempo real com uma interface limpa e focada na usabilidade.
            </p>
        </section>

        <section class="mb-4">
            <h2 class="h5 text-gold fw-bold mb-3 border-bottom border-gold-subtle pb-2">Propósito e Arquitetura</h2>
            <p class="lh-base opacity-90 small">
                Construído sob uma estrutura robusta em <strong>CakePHP</strong> e estilizado com uma paleta exclusiva em tons de <strong>vinho</strong> e <strong>ouro</strong>, o sistema busca unir estética marcante à eficiência técnica.
            </p>
            <p class="lh-base opacity-90 small mb-0">
                Cada módulo foi planejado para garantir segurança no controle de acessos, integridade das informações no banco de dados e total adaptabilidade a diferentes tamanhos de tela — desde monitores desktop até dispositivos móveis.
            </p>
        </section>

        <section class="mb-2">
            <h2 class="h5 text-gold fw-bold mb-3 border-bottom border-gold-subtle pb-2">Principais Diretrizes</h2>
            <ul class="list-unstyled d-flex flex-column gap-2 opacity-90 small m-0">
                <li class="d-flex align-items-start gap-2">
                    <span class="text-gold fw-bold">•</span>
                    <span><strong>Organização Centralizada:</strong> Facilidade no cadastro, edição e consulta de publicações.</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                    <span class="text-gold fw-bold">•</span>
                    <span><strong>Design Responsivo:</strong> Experiência de uso fluida com navegação por barra lateral e menus retráteis.</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                    <span class="text-gold fw-bold">•</span>
                    <span><strong>Desempenho:</strong> Carregamento otimizado de dados para suportar a rotina da aplicação sem interrupções.</span>
                </li>
            </ul>
        </section>
    </div>
</div>