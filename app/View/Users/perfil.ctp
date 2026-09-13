<?php echo $this->Html->css('perfilPage.css?v=' . time()); ?>
<?php
	$userSession       = $this->Session->read('Auth.User');
	$currentController = strtolower($this->params['controller']);
	$currentAction     = strtolower($this->params['action']);
	?>

<div class="profile-dashboard">

    <!-- Conteúdo Principal -->
    <main class="dashboard-content">
        <!-- Topbar -->
        <header class="topbar">
            <input type="text" placeholder="Search..." class="search-input">
        </header>

        <!-- Banner de Capa + Foto de Perfil -->
        <div class="profile-header-card">
            <div class="cover-photo"></div>
            <div class="profile-info-bar">
                <div class="avatar-wrapper">
                    <?php $avatar = !empty($user['foto']) ? $user['foto'] : 'perfilDefault.jpg';
                echo $this->Html->image($avatar, array('class' => 'profile-main-avatar'));
                 ?>
                </div>
                <div class="user-titles">
                    <h2><?php echo h($userSession['nome'] ?? $userSession['username'] ?? 'User'); ?></h2>
                    <p>Blogger / Content Creator</p>
                </div>
                <div class="header-actions">
                    <button class="btn-primary">Follow</button>
                    <button class="btn-outline">Contact</button>
                </div>
            </div>
        </div>

        <!-- Grid de Conteúdo Inferior -->
        <div class="content-grid">
            <!-- About -->
            <section class="card about-card">
                <h3>About</h3>
                <ul class="info-list">
                    <li><strong>Email:</strong> <?php echo h($user['email'] ?? 'contact@stockorg.com'); ?></li>
                    <li><strong>Joined:</strong> <?php echo h($user['created'] ?? 'Sep 2026'); ?></li>
                    <li><strong>Location:</strong> Natal, RN</li>
                </ul>
            </section>

            <!-- Feed -->
            <section class="card feed-card">
                <div class="feed-tabs">
                    <span class="active">Posts</span>
                    <span>Saved</span>
                </div>
                <div class="feed-posts">
                    <div class="post-item">
                        <div class="post-header">
                            <?php echo $this->Html->image($avatar, array('class' => 'post-avatar')); ?>
                            <div>
                                <strong><?php echo h($userSession['nome'] ?? $userSession['username'] ?? 'User'); ?></strong>
                                <small>Recently</small>
                            </div>
                        </div>
                        <p class="post-text">Organizando o painel de perfil do StockOrg com cores personalizadas e integração com PostgreSQL no Docker!</p>
                    </div>
                </div>
            </section>

            <!-- Activity -->
            <section class="card side-card">
                <h3>Activity</h3>
                <p class="small-text">No recent activity detected.</p>
            </section>
        </div>
    </main>
</div>