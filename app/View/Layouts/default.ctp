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
	?>

	<!--	HEADER MOBILE SUPERIOR (Apenas telas pequenas) -->
	<header class="mobile-top-header d-flex d-md-none align-items-center justify-content-between px-3 py-2 border-bottom border-warning">
		<?php echo $this->Html->link(
			$this->Html->image('LogoStockOrg.png', array('style' => 'width: 32px; height: 32px; border-radius: 50%;')) .
				'<span class="fs-5 fw-bold text-gold ms-2">StockOrg</span>',
			array('controller' => 'posts', 'action' => 'index'),
			array('class' => 'text-decoration-none d-flex align-items-center', 'escape' => false)
		); ?>

		<!-- Botão de Engrenagem / Menu Extra -->
		<button class="btn p-1 text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileAppDrawer" aria-controls="mobileAppDrawer">
			<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
				<path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
			</svg>
		</button>
	</header>

	<div class="main-layout-container d-flex">
		<?php if (!empty($userSession)): ?>
			<!-- SIDEBAR GLOBLAL -->
			<aside class="x-sidebar d-flex flex-column justify-content-between p-3">
				<div class="d-flex flex-column align-items-start w-100">

					<!-- Logo StockOrg -->
					<?php echo $this->Html->link(
						$this->Html->image('LogoStockOrg.png', array(
							'alt' => 'StockOrg',
							'style' => 'width: 30px; height: 30px; object-fit: cover; border-radius: 50%; border: 1px solid var(--border-color);'
						)) .
							'<span class="fs-4 fw-bold text-gold tracking-wide d-none d-xl-inline">StockOrg</span>',
						array('controller' => 'posts', 'action' => 'index'),
						array('class' => 'x-brand-header d-flex align-items-center gap-3 mb-4 text-decoration-none px-2 py-1', 'escape' => false)
					); ?>

					<!-- Navegação Principal -->
					<nav class="x-nav w-100 mb-3">
						<ul class="nav flex-column gap-2">
							<!-- Home -->
							<li class="nav-item">
								<?php
								$active = ($currentController === 'posts' && $currentAction === 'index') ? 'active' : '';
								echo $this->Html->link(
									'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16"><path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.505a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146A.5.5 0 0 0 .5 8.5v7a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5"/></svg><span class="d-none d-xl-inline">Página Inicial</span>',
									array('controller' => 'posts', 'action' => 'index'),
									array('class' => 'x-nav-link d-flex align-items-center gap-3 ' . $active, 'escape' => false)
								); ?>
							</li>

							<!-- Perfil -->
							<?php if (!empty($userSession)): ?>
								<li class="nav-item">
									<?php
									$active = ($currentController === 'users' && $currentAction === 'perfil') ? 'active' : '';
									echo $this->Html->link(
										'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/></svg><span class="d-none d-xl-inline">Perfil</span>',
										array('controller' => 'users', 'action' => 'perfil'),
										array('class' => 'x-nav-link d-flex align-items-center gap-3 ' . $active, 'escape' => false)
									); ?>
								</li>
							<?php endif; ?>

							<!-- Dropdown Mais -->
							<?php
							// Padroniza a action para minúsculas para evitar problemas de case sensitivity
							$actionClean = strtolower($currentAction);

							// Lógica de verificação das páginas ativas do submenu
							$isAboutPage = ($currentController === 'pages' && $actionClean === 'sobre');
							$isEditPage  = ($currentController === 'users' && $actionClean === 'edit');
							$isAdminPage = ($currentController === 'users' && $actionClean === 'painelademiro');

							// Define se o menu "Mais" deve iniciar expandido
							$isMoreActive = ($isAboutPage || $isEditPage || $isAdminPage);
							?>

							<!-- Acordeão / Submenu Mais -->
							<li class="nav-item x-accordion-container <?php echo $isMoreActive ? 'active' : ''; ?>">
								<a class="x-nav-link d-flex align-items-center gap-3 <?php echo $isMoreActive ? 'active' : ''; ?>" href="javascript:void(0);" id="xAccordionTrigger">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
										<path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
									</svg>
									<span class="d-none d-xl-inline">Mais</span>
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down ms-auto x-chevron-icon d-none d-xl-inline" viewBox="0 0 16 16">
										<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
									</svg>
								</a>

								<!-- Submenu Expansível -->
								<div class="x-accordion-menu" id="xAccordionMenu">
									<ul class="list-unstyled m-0 p-2 d-flex flex-column gap-1">
										<!-- Link Sobre Nós ajustado para a action 'sobre' -->
										<li>
											<?php echo $this->Html->link('Sobre Nós', array('controller' => 'pages', 'action' => 'sobre'), array('class' => 'x-sub-item ' . ($isAboutPage ? 'active' : ''))); ?>
										</li>

										<?php if (!empty($userSession)): ?>
											<li>
												<?php echo $this->Html->link('Editar Perfil', array('controller' => 'users', 'action' => 'edit'), array('class' => 'x-sub-item ' . ($isEditPage ? 'active' : ''))); ?>
											</li>

											<?php if (!empty($userSession['cargo']) && in_array($userSession['cargo'], array('admin', 'SuperAdmin'), true)): ?>
												<li>
													<hr class="x-sub-divider">
												</li>
												<li>
													<?php echo $this->Html->link('Painel Administrativo', array('controller' => 'users', 'action' => 'painelAdemiro'), array('class' => 'x-sub-item ' . ($isAdminPage ? 'active' : ''))); ?>
												</li>
											<?php endif; ?>

											<li>
												<hr class="x-sub-divider">
											</li>
											<li>
												<?php echo $this->Html->link('Sair da Conta', array('controller' => 'users', 'action' => 'sairDaConta'), array('class' => 'x-sub-item text-danger')); ?>
											</li>
										<?php endif; ?>
									</ul>
								</div>
							</li>

							<!-- Botão Postar (Fica logo abaixo do Acordeão) -->
							<?php if (!empty($userSession)): ?>
								<?php echo $this->Html->link(
									'<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg d-xl-none" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/></svg><span class="d-none d-xl-inline">Postar</span>',
									array('controller' => 'posts', 'action' => 'add'),
									array('class' => 'btn x-btn-post-lg w-100 mt-3 d-flex align-items-center justify-content-center gap-2', 'escape' => false)
								); ?>
							<?php endif; ?>
						</ul>
					</nav>
				</div>

				<!-- Card do Usuário Logado no Rodapé da Sidebar -->
				<?php if (!empty($userSession)): ?>
					<div class="x-user-card-footer d-flex align-items-center justify-content-between w-100 mt-auto">
						<div class="d-flex align-items-center gap-3">
							<?php
							$avatar = !empty($userSession['foto']) ? $userSession['foto'] : 'perfilDefault.jpg';
							echo $this->Html->image($avatar, array(
								'class' => 'rounded-circle',
								'style' => 'width: 42px; height: 42px; object-fit: cover; border: 1px solid #d4af37;'
							));
							?>
							<div class="lh-sm d-none d-xl-block">

								<!-- Nome + Badge de Superadmin -->
								<div class="d-flex align-items-center gap-1">
									<strong class="d-block text-gold-light fs-6 mb-0">
										<?php echo h($userSession['nome'] ?? $userSession['username']); ?>
									</strong>

									<!-- Badge de Superadmin sem Fundo -->
									<?php if (!empty($userSession['cargo']) && strtolower($userSession['cargo']) === 'superadmin'): ?>
										<?php
										echo $this->Html->image('superadmin_badge.png', array(
											'title' => 'Superadmin',
											'alt'   => 'Superadmin Badge',
											'style' => 'width: 20px; height: 20px; object-fit: contain; vertical-align: middle; display: inline-block;'
										));
										?>
									<?php endif; ?>
								</div>

								<small class="text-muted" style="font-size: 12px;">@<?php echo h($userSession['username'] ?? 'user'); ?></small>
							</div>
						</div>
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