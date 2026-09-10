<?php echo $this->Html->css('perfilPage'); ?>

<div class="container">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-12 col-md-8">
            <div class="profile-dashboard">
                <!-- Sidebar Lateral -->
                <aside class="sidebar">
                    <div class="brand-logo">
                        <h2>StockOrg</h2>
                    </div>
                    <nav class="sidebar-menu">
                        <ul>
                            <li><?php echo $this->Html->link('Home', array('controller' => 'posts', 'action' => 'index')); ?></li>
                            <li class="active"><?php echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'perfil')); ?></li>
                            <li><?php echo $this->Html->link('Add Post', array('controller' => 'posts', 'action' => 'add')); ?></li>
                            <li><?php echo $this->Html->link('Settings', '#'); ?></li>
                        </ul>
                    </nav>
                </aside>

                <!-- Conteúdo Principal -->
                <main class="dashboard-content">
                    <!-- Topbar -->
                    <header class="topbar">
                        <input type="text" placeholder="Search..." class="search-input">
                        <div class="user-badge">
                            <span><?php echo h($user['nome'] ?? $user['username']); ?></span>
                            <?php
                            $avatar = !empty($user['foto']) ? $user['foto'] : 'default-avatar.png';
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
                                <h2><?php echo h($user['nome'] ?? $user['username']); ?></h2>
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
                        <!-- Coluna Esquerda: Sobre/Informações -->
                        <section class="card about-card">
                            <h3>About</h3>
                            <ul class="info-list">
                                <li><strong>Email:</strong> <?php echo h($user['email'] ?? 'contact@stockorg.com'); ?></li>
                                <li><strong>Joined:</strong> <?php echo h($user['created'] ?? 'Sep 2026'); ?></li>
                                <li><strong>Location:</strong> Natal, RN</li>
                            </ul>
                        </section>

                        <!-- Coluna Central: Feed de Posts -->
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
                                            <strong><?php echo h($user['nome'] ?? $user['username']); ?></strong>
                                            <small>Recently</small>
                                        </div>
                                    </div>
                                    <p class="post-text">Organizando o painel de perfil do StockOrg com cores personalizadas e integração com PostgreSQL no Docker!</p>
                                </div>
                            </div>
                        </section>

                        <!-- Coluna Direita: Sugestões / Atividades -->
                        <section class="card side-card">
                            <h3>Activity</h3>
                            <p class="small-text">No recent activity detected.</p>
                        </section>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>