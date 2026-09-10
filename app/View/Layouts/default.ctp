<!DOCTYPE html>
<html>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css('homePage');
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	echo $this->Html->css('postsView');
	echo $this->Html->css('loginPage');
	?>
</head>

<body>

	<header class="blog-header">
		<div class="container-fluid" style="position: relative;">
			<?php
			// Lê o usuário autenticado diretamente da sessão global
			$userSession = $this->Session->read('Auth.User');

			// Verifica qual pagina é (olha o controller e a action acessada)
			$currentController = strtolower($this->params['controller']);
			$currentAction     = strtolower($this->params['action']);

			// Define se está na tela de login
			$isLoginPage = ($currentController === 'users' && $currentAction === 'login');

			$isCadastroPage = ($currentController === 'users' && $currentAction === 'cadastro');
			?>

			<?php //se o usuario estiver logado: 
			if (!empty($userSession)): ?>
				<div class="profile-container">
					<?php
					$userAvatar = !empty($userSession['foto']) ? $userSession['foto'] : 'perfilDefault.jpg';
					echo $this->Html->link(
						$this->Html->image($userAvatar, array('alt' => 'Foto de Perfil', 'class' => 'profile-avatar')) .
							' <span>' . h($userSession['nome'] ?? $userSession['username'] ?? 'Perfil') . '</span>',
						array('controller' => 'Users', 'action' => 'perfil'),
						array('class' => 'profile-link', 'escape' => false)
					);
					?>
				</div>

				<nav class="nav-actions">
					<p>
						<?php echo $this->Html->link("Add Post", array('controller' => 'Posts', 'action' => 'add')); ?>
						<?php echo $this->Html->link("Sair", array('controller' => 'Users', 'action' => 'sairDaConta')); ?>
					</p>
				</nav>

			<?php // Usuário não Logado: Só mostra o botão "login" se não estiver na página de login
			else: ?>
				<?php if (!$isLoginPage && !$isCadastroPage): ?>
					<nav class="nav-actions">
						<p><?php echo $this->Html->link("login", array('controller' => 'Users', 'action' => 'login')); ?></p>
					</nav>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</header>

	<main class="main-content">
		<?php echo $this->Flash->render(); ?>
		<?php echo $this->fetch('content'); ?>
	</main>

	<footer class="blog-footer">
    <div class="footer-container">
        
        <!-- Coluna 1: Links da Empresa / Sistema -->
        <div class="footer-col">
            <h4 class="footer-title">COMPANHIA</h4>
            <ul class="footer-links">
                <li><?php echo $this->Html->link("Sobre nós", array('controller' => 'pages', 'action' => 'about')); ?></li>
                <li><?php echo $this->Html->link("Qualidades e Serviços", '#'); ?></li>
                <li><?php echo $this->Html->link("Marcas", '#'); ?></li>
                <li><?php echo $this->Html->link("Contato", '#'); ?></li>
            </ul>
        </div>

        <!-- Coluna 2: Categoria de Posts / Conteúdo -->
        <div class="footer-col">
            <h4 class="footer-title">CATEGORIAS</h4>
            <ul class="footer-links">
                <li><?php echo $this->Html->link("Posts", array('controller' => 'posts', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link("Artigos", '#'); ?></li>
                <li><?php echo $this->Html->link("Noticias", '#'); ?></li>
                <li><?php echo $this->Html->link("Updates", '#'); ?></li>
            </ul>
        </div>

        <!-- Coluna 3: Localização e Contato -->
        <div class="footer-col">
            <div class="footer-tabs">
                <span class="tab active">NATAL</span>
            </div>
            <address class="footer-address">
                Av. Engenheiro Roberto Freire, 1000<br>
                Capim Macio - Natal/RN<br><br>
                <a href="tel:+5584999999999">+55 (84) 99178-1998</a><br>
                <a href="mailto:contact@stockorg.com">contact@stockorg.com</a>
            </address>
            <a href="#" class="all-contacts-link">Todos contatos</a>
        </div>

        <!-- Coluna 4: Copyright -->
        <div class="footer-col footer-copyright-col">
            <p>&copy; <?php echo date('Y'); ?> StockOrg.<br>All Rights Reserved.</p>
        </div>

    </div>
</footer>

</body>
</html>