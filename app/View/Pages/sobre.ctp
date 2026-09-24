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

    <!-- Bloco de Conteúdo Textual -->
    <div class="card x-feed-card p-4 rounded-4 shadow-lg text-gold-light">
        
        <section class="mb-4">
            <h2 class="h5 text-gold fw-bold mb-3 border-bottom border-gold-subtle pb-2">O que é o StockOrg</h2>
            <p class="lh-base opacity-90 small">
                O <strong>StockOrg</strong> é uma plataforma voltada para a organização, gerenciamento e publicação de conteúdos sobre o mercado financeiro e a economia. Desenvolvido para oferecer um ambiente dinâmico, o sistema combina simplicidade na gestão de dados com uma navegação robusta e um design premium, refletindo a excelência da plataforma para os nossos usuários 🧡.
            </p>
            <p class="lh-base opacity-90 small mb-0">
                Inspirado em redes modernas de comunicação, o projeto prioriza a agilidade no fluxo de postagens, permitindo que leitores e administradores acompanhem atualizações com uma interface limpa, rápida e focada na melhor experiência de uso.
            </p>
        </section>

        <section class="mb-4">
            <h2 class="h5 text-gold fw-bold mb-3 border-bottom border-gold-subtle pb-2">Propósito e Arquitetura</h2>
            <p class="lh-base opacity-90 small">
                Construído sobre uma estrutura robusta em <strong>CakePHP 2.x</strong> e estilizado com uma paleta exclusiva em tons de <strong>vinho</strong> e <strong>ouro</strong>. O ambiente utiliza Docker e Docker Compose para padronizar e isolar o container da aplicação, além de incorporar Bootstrap 5 e JavaScript para garantir interatividade e responsividade completa.
            </p>
            <p class="lh-base opacity-90 small mb-0">
                O gerenciamento de dados é realizado através do banco de dados <strong>PostgreSQL</strong>, modelado e administrado via DBeaver. Cada módulo foi planejado para assegurar controle de acesso por níveis de privilégio (como Administradores e Autores), além da conversão automática de dados para manter a integridade das informações no banco.
            </p>
        </section>

        <section class="mb-4">
            <h2 class="h5 text-gold fw-bold mb-3 border-bottom border-gold-subtle pb-2">Principais Diretrizes</h2>
            <ul class="list-unstyled d-flex flex-column gap-2 opacity-90 small m-0">
                <li class="d-flex align-items-start gap-2">
                    <span class="text-gold fw-bold">•</span>
                    <span><strong>Organização Centralizada:</strong> Facilidade no cadastro, edição, moderação e consulta de publicações.</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                    <span class="text-gold fw-bold">•</span>
                    <span><strong>Design Responsivo:</strong> Experiência fluida em desktop e dispositivos móveis, com suporte a menu off-canvas e barra lateral intuitiva.</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                    <span class="text-gold fw-bold">•</span>
                    <span><strong>Desempenho e Segurança:</strong> Resposta rápida de carregamento e requisições protegidas via métodos POST e sanitização de dados.</span>
                </li>
            </ul>
        </section>

        <!-- DETALHE ADICIONADO: Tech Stack Badges no Rodapé -->
        <section class="pt-3 border-top border-gold-subtle">
            <small class="text-gold d-block fw-bold mb-2">STACK TECNOLÓGICA</small>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge border border-warning text-warning bg-transparent font-monospace">PHP 7.4</span>
                <span class="badge border border-warning text-warning bg-transparent font-monospace">CakePHP 2.x</span>
                <span class="badge border border-warning text-warning bg-transparent font-monospace">PostgreSQL 12</span>
                <span class="badge border border-warning text-warning bg-transparent font-monospace">Docker</span>
                <span class="badge border border-warning text-warning bg-transparent font-monospace">Bootstrap 5</span>
            </div>
        </section>

    </div>
</div>