<?php echo $this->Html->css('perfilPage.css?v=' . time()); ?>
<?php $userSession = $this->Session->read('Auth.User'); ?>

<div class="profile-dashboard">
    <!-- Sidebar / Topbar no Mobile -->
    <aside class="sidebar">
        <div class="brand-logo">
            <h2>StockOrg</h2>
        </div>
        <nav class="sidebar-menu">
            <ul>
                <li><?php echo $this->Html->link('Home', array('controller' => 'posts', 'action' => 'index')); ?></li>
                <li class="active"><?php echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'perfil')); ?></li>
                <li><?php echo $this->Html->link('Add Post', array('controller' => 'posts', 'action' => 'add')); ?></li>
                <li class="nav-item dropdown position-relative">
                    <a class="nav-link dropdown-toggle text-gold-light" href="#" id="settingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Settings
                    </a>
                    <ul class="dropdown-menu bg-wine border-gold" aria-labelledby="settingsDropdown">
                        <li>
                            <?php echo $this->Html->link('Editar Perfil', array('controller' => 'users', 'action' => 'edit'), array('class' => 'dropdown-item text-gold-light')); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link('Alterar Senha', array('controller' => 'users', 'action' => 'alterarSenha'), array('class' => 'dropdown-item text-gold-light')); ?>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-gold">
                        </li>
                        <li>
                            <?php echo $this->Html->link('Sair da Conta', array('controller' => 'users', 'action' => 'sairDaConta'), array('class' => 'dropdown-item text-danger fw-bold')); ?>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-gold">
                        </li>
                        <li>
                            <?php if (!empty($userSession['cargo']) && $userSession['cargo'] === 'admin'): ?>
                                <?php echo $this->Html->link('Painel administrativo', array('controller' => 'users', 'action' => 'painelAdemiro'), array('class' => 'dropdown-item text-gold-light')); ?>
                            <?php endif; ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="dashboard-content">
        <!-- Topbar -->
        <header class="topbar">
            <input type="text" placeholder="Search..." class="search-input">
            <div class="user-badge">
                <span><?php echo h($userSession['nome'] ?? $userSession['username'] ?? 'User'); ?></span>
                <?php
                $avatar = !empty($user['foto']) ? $user['foto'] : 'perfilDefault.jpg';
                echo $this->Html->image($avatar, array('class' => 'topbar-avatar'));
                ?>
            </div>
        </header>

        <!-- Banner de Capa + Foto de Perfil -->
        <div class="profile-header-card">
            <div class="cover-photo"></div>
            <div class="profile-info-bar">
                <div class="avatar-wrapper">
                    <?php echo $this->Html->image($avatar, array('class' => 'profile-main-avatar')); ?>
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