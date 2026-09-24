<!DOCTYPE html>
<html lang="pt-br">

<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title><?php echo $this->fetch('title'); ?> - StockOrg</title>

	<!-- Bootstrap 5 CSS CDN -->
	<?php echo $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'); ?>

	<!-- CSS Unificado Global -->
	<?php echo $this->Html->css('globalApp.css?v=' . time()); ?>

	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
</head>

<body class="bg-dark-wine">

	<?php
	$userSession       = $this->Session->read('Auth.User');
	$currentController = strtolower($this->params['controller']);
	$currentAction     = strtolower($this->params['action']);

	$isAboutPage = ($currentController === 'pages' && $currentAction === 'sobre');
	$isEditPage  = ($currentController === 'users' && $currentAction === 'edit');
	$isAdminPage = ($currentController === 'users' && $currentAction === 'painelademiro');
	$isMoreActive = ($isAboutPage || $isEditPage || $isAdminPage);
	?>

	<div class="main-layout-container d-flex">
        <?php if (!empty($userSession)): ?>

            <!-- NAVBAR SUPERIOR MOBILE (Aparece apenas em telas menores que XL) -->
            <header class="d-xl-none d-flex align-items-center justify-content-between p-3 position-fixed top-0 start-0 w-100" style="background-color: #120202; border-bottom: 1px solid var(--border-color); z-index: 1040; height: 60px;">
                <!-- Botão Hambúrguer -->
                <button class="btn text-gold p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile" aria-controls="sidebarMobile" style="background: var(--bg-card-color); border: 1px solid var(--border-color); line-height: 1;">
                    <svg xmlns="http://w3.org" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                    </svg>
                </button>

                <!-- Título StockOrg -->
                <span class="fs-4 fw-bold text-gold tracking-wide mb-0">StockOrg</span>

                <!-- Espaçador invisível para equilibrar o flexbox -->
                <div style="width: 42px;"></div>
            </header>

            <!-- SIDEBAR GLOBLAL -->
            <aside id="sidebarMobile" class="x-sidebar offcanvas-xl offcanvas-start d-flex flex-column justify-content-between p-3 h-100" tabindex="-1">

                <!-- Botão de fechar (X) interno -->
                <div class="d-xl-none text-end w-100 mb-3">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMobile" aria-label="Close"></button>
                </div>

                <div class="d-flex flex-column align-items-start w-100">
                    <!-- Logo StockOrg Interno -->
                    <div class="x-brand-header d-flex align-items-center gap-3 mb-4 px-2 py-1">
                        <?php echo $this->Html->image('LogoStockOrg.png', array(
                            'alt' => 'StockOrg',
                            'style' => 'width: 30px; height: 30px; object-fit: cover; border-radius: 50%; border: 1px solid var(--border-color);'
                        )); ?>
                        <span class="fs-4 fw-bold text-gold tracking-wide">StockOrg</span>
                    </div>

                    <!-- Navegação Principal -->
                    <nav class="x-nav w-100 mb-3">
                        <ul class="nav flex-column gap-2">
                            <!-- Home -->
                            <li class="nav-item">
                                <?php
                                $active = ($currentController === 'posts' && $currentAction === 'index') ? 'active' : '';
                                echo $this->Html->link(
                                    '<svg xmlns="http://w3.org" width="24" height="24" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16"><path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.505a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146A.5.5 0 0 0 .5 8.5v7a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5"/></svg><span class="ms-3">Página Inicial</span>',
                                    array('controller' => 'posts', 'action' => 'index'),
                                    array('class' => 'x-nav-link d-flex align-items-center ' . $active, 'escape' => false)
                                ); ?>
                            </li>

                            <!-- Perfil -->
                            <?php if (!empty($userSession)): ?>
                                <li class="nav-item">
                                    <?php
                                    $active = ($currentController === 'users' && $currentAction === 'perfil') ? 'active' : '';
                                    echo $this->Html->link(
                                        '<svg xmlns="http://w3.org" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/></svg><span class="ms-3">Perfil</span>',
                                        array('controller' => 'users', 'action' => 'perfil'),
                                        array('class' => 'x-nav-link d-flex align-items-center ' . $active, 'escape' => false)
                                    ); ?>
                                </li>
                            <?php endif; ?>

                            <!-- Submenu Mais -->
                            <li class="nav-item x-accordion-container <?php echo $isMoreActive ? 'active' : ''; ?>">
                                <a class="x-nav-link d-flex align-items-center <?php echo $isMoreActive ? 'active' : ''; ?>" href="javascript:void(0);" id="xAccordionTrigger">
                                    <svg xmlns="http://w3.org" width="24" height="24" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                    </svg>
                                    <span class="ms-3">Mais</span>
                                    <svg xmlns="http://w3.org" width="16" height="16" fill="currentColor" class="bi bi-chevron-down ms-auto x-chevron-icon" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </a>

                                <div class="x-accordion-menu" id="xAccordionMenu">
                                    <ul class="list-unstyled m-0 p-2 d-flex flex-column gap-1">
                                        <li><?php echo $this->Html->link('Sobre Nós', array('controller' => 'pages', 'action' => 'sobre'), array('class' => 'x-sub-item ' . ($isAboutPage ? 'active' : ''))); ?></li>
                                        <?php if (!empty($userSession)): ?>
                                            <li><?php echo $this->Html->link('Editar Perfil', array('controller' => 'users', 'action' => 'edit'), array('class' => 'x-sub-item ' . ($isEditPage ? 'active' : ''))); ?></li>
                                            <?php if (!empty($userSession['cargo']) && in_array($userSession['cargo'], array('admin', 'SuperAdmin'), true)): ?>
                                                <li>
                                                    <hr class="x-sub-divider">
                                                </li>
                                                <li><?php echo $this->Html->link('Painel Administrativo', array('controller' => 'users', 'action' => 'painelAdemiro'), array('class' => 'x-sub-item ' . ($isAdminPage ? 'active' : ''))); ?></li>
                                            <?php endif; ?>
											<li><?php echo $this->Html->link('Sair da Conta', array('controller' => 'users', 'action' => 'sairDaConta'), array('class' => 'x-sub-item text-danger')); ?></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>

                            <!-- Botão Postar -->
                            <?php if (!empty($userSession)): ?>
                                <?php echo $this->Html->link(
                                    '<svg xmlns="http://w3.org" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/></svg><span class="ms-2">Postar</span>',
                                    array('controller' => 'posts', 'action' => 'add'),
                                    array('class' => 'btn x-btn-post-lg w-100 mt-3 d-flex align-items-center justify-content-center', 'escape' => false)
                                ); ?>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>

                <!-- Rodapé com Card de Usuário e Botão de Sair -->
                <?php if (!empty($userSession)): ?>
                    <div class="x-user-card-footer d-flex align-items-center justify-content-between w-100 mt-auto pt-3 border-top" style="border-color: var(--border-color) !important;">
                        <div class="d-flex align-items-center gap-2 overflow-hidden">
                            <?php
                            $avatar = !empty($userSession['foto']) ? $userSession['foto'] : 'perfilDefault.jpg';
                            echo $this->Html->image($avatar, array(
                                'class' => 'rounded-circle flex-shrink-0',
                                'style' => 'width: 40px; height: 40px; object-fit: cover; border: 1px solid #d4af37;'
                            ));
                            ?>
                            <div class="lh-sm text-truncate">
                                <div class="d-flex align-items-center gap-1 text-truncate">
                                    <strong class="d-block text-gold-light fs-6 mb-0 text-truncate"><?php echo h($userSession['nome'] ?? $userSession['username']); ?></strong>
                                    <?php if (!empty($userSession['cargo']) && strtolower($userSession['cargo']) === 'superadmin'): ?>
                                        <?php echo $this->Html->image('superadmin_badge.png', array('title' => 'Superadmin', 'alt' => 'Superadmin Badge', 'style' => 'width: 18px; height: 18px; object-fit: contain;', 'class' => 'flex-shrink-0')); ?>
                                    <?php endif; ?>
                                </div>
                                <!-- @username com cor mais clara e visível -->
                                <small class="d-block text-truncate fw-medium" style="font-size: 13px; color: #e6c667;">
                                    @<?php echo h($userSession['username'] ?? 'user'); ?>
                                </small>
                            </div>
                        </div>

                        <!-- Botão de Sair em Destaque no Rodapé -->
                        <?php echo $this->Html->link(
                            '<svg xmlns="http://w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 10 1H2a1.5 1.5 0 0 0-1.5 1.5v9A1.5 1.5 0 0 0 2 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/></svg>',
                            array('controller' => 'users', 'action' => 'sairDaConta'),
                            array(
                                'class' => 'btn btn-sm text-danger p-2 rounded-circle hover-bg-danger d-flex align-items-center justify-content-center flex-shrink-0 ms-1',
                                'title' => 'Sair da Conta',
                                'escape' => false
                            )
                        ); ?>
                    </div>
                <?php endif; ?>
            </aside>
        <?php endif; ?>

		<!-- ÁREA PRINCIPAL DO CONTEÚDO (CHAMA AS VIEWS) -->
		<main class="dashboard-content flex-grow-1 p-3 p-md-4">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</main>

	</div>

	<!-- Bootstrap 5 JS Bundle -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		// Função para alterar e persistir o tema
		function setAppTheme(themeName) {
			document.documentElement.setAttribute('data-theme', themeName);
			localStorage.setItem('stockorg_theme', themeName);
		}

		// Executa assim que o DOM estiver pronto
		document.addEventListener('DOMContentLoaded', function() {
			// 1. Restaura o tema salvo no localStorage (padrão: amarelo e preto)
			var savedTheme = localStorage.getItem('stockorg_theme') || 'yellow-black';
			document.documentElement.setAttribute('data-theme', savedTheme);

			// 2. Controla o clique para abrir/fechar o submenu acordeão do "Mais"
			var accordionTrigger = document.getElementById('xAccordionTrigger');
			if (accordionTrigger) {
				accordionTrigger.addEventListener('click', function(e) {
					e.preventDefault();
					accordionTrigger.closest('.x-accordion-container').classList.toggle('active');
				});
			}
		});
	</script>
</body>

</html>