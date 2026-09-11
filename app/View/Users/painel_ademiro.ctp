<?php echo $this->Html->css('perfilPage'); ?>
<?php
// Pega o Controller e a Action atuais acessados na URL
$currentController = strtolower($this->params['controller']);
$currentAction     = strtolower($this->params['action']);
?>
<?php 
/**
 * @var array $usuarios
 */
$userSession = $this->Session->read('Auth.User'); ?>

<div class="profile-dashboard">
    <!-- Sidebar / Topbar no Mobile -->
    <aside class="sidebar">
        <div class="brand-logo">
            <h2>StockOrg</h2>
        </div>
        <nav class="sidebar-menu">
            <ul>
                <!-- Home (Posts -> index) -->
                <li class="<?php echo ($currentController === 'posts' && $currentAction === 'index') ? 'active' : ''; ?>">
                    <?php echo $this->Html->link('Home', array('controller' => 'posts', 'action' => 'index')); ?>
                </li>

                <!-- Profile (Users -> perfil) -->
                <li class="<?php echo ($currentController === 'users' && $currentAction === 'perfil') ? 'active' : ''; ?>">
                    <?php echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'perfil')); ?>
                </li>

                <!-- Add Post (Posts -> add) -->
                <li class="<?php echo ($currentController === 'posts' && $currentAction === 'add') ? 'active' : ''; ?>">
                    <?php echo $this->Html->link('Add Post', array('controller' => 'posts', 'action' => 'add')); ?>
                </li>

                <!-- Settings (Ativa se estiver em edit, alterarSenha ou painelAdemiro) -->
                <?php
                $isSettingsActive = ($currentController === 'users' && in_array($currentAction, array('edit', 'alterarsenha', 'painelademiro')));
                ?>
                <li class="nav-item dropdown position-relative <?php echo $isSettingsActive ? 'active' : ''; ?>">
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
                        <?php if (!empty($userSession['cargo']) && $userSession['cargo'] === 'admin'): ?>
                            <li>
                                <hr class="dropdown-divider border-gold">
                            </li>
                            <li>
                                <?php echo $this->Html->link('Painel administrativo', array('controller' => 'users', 'action' => 'painelAdemiro'), array('class' => 'dropdown-item text-gold-light')); ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="dashboard-content">
        <!-- Topbar -->
        <header class="topbar">
            <h1 class="h4 text-gold fw-bold mb-0">Painel Administrativo</h1>
            <div class="user-badge">
                <span><?php echo h($userSession['nome'] ?? $userSession['username'] ?? 'Admin'); ?></span>
                <?php
                $avatar = !empty($userSession['foto']) ? $userSession['foto'] : 'perfilDefault.jpg';
                echo $this->Html->image($avatar, array('class' => 'topbar-avatar'));
                ?>
            </div>
        </header>

        <!-- Cards de Estatísticas Rápidas -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-wine border-gold p-3 text-center">
                    <small class="text-gold-light">Total de Usuários</small>
                    <h3 class="h2 text-gold fw-bold mb-0"><?php echo count($usuarios); ?></h3>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-wine border-gold p-3 text-center">
                    <small class="text-gold-light">Administradores</small>
                    <h3 class="h2 text-gold fw-bold mb-0">
                        <?php
                        $admins = array_filter($usuarios, function ($u) {
                            return ($u['User']['cargo'] ?? '') === 'admin';
                        });
                        echo count($admins);
                        ?>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Tabela Responsiva do Banco de Dados -->
        <section class="card bg-wine border-gold p-3 p-md-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h2 class="h5 text-gold fw-bold mb-0">Gerenciamento de Usuários</h2>
                <span class="badge bg-gold text-dark"><?php echo count($usuarios); ?> registros encontrados</span>
            </div>

            <div class="table-responsive">
                <table class="table table-dark-wine align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome / User</th>
                            <th>Senha (Hash)</th>
                            <th>Cargo</th>
                            <th>Data de Criação</th>
                            <th>Última Modificação</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $u): ?>
                                <tr>
                                    <td><strong>#<?php echo h($u['User']['id']); ?></strong></td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php
                                            $userFoto = !empty($u['User']['foto']) ? $u['User']['foto'] : 'perfilDefault.jpg';
                                            echo $this->Html->image($userFoto, array('class' => 'post-avatar rounded-circle'));
                                            ?>
                                            <div>
                                                <span class="fw-bold d-block text-gold-light"><?php echo h($u['User']['nome'] ?? $u['User']['username'] ?? 'Sem Nome'); ?></span>
                                                <small class="text-muted"><?php echo h($u['User']['email'] ?? 'Sem e-mail'); ?></small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Exibição resumida do Hash da Senha -->
                                    <td>
                                        <code class="hash-code" title="<?php echo h($u['User']['senha_hash']); ?>">
                                            <?php
                                            $hash = $u['User']['senha_hash'] ?? '';
                                            echo h(strlen($hash) > 15 ? substr($hash, 0, 12) . '...' : $hash);
                                            ?>
                                        </code>
                                    </td>

                                    <!-- Badge de Cargo -->
                                    <td>
                                        <?php if (($u['User']['cargo'] ?? '') === 'admin'): ?>
                                            <span class="badge bg-gold text-dark fw-bold">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary text-light">Autor</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Datas -->
                                    <td>
                                        <small class="text-gold-light">
                                            <?php echo !empty($u['User']['criado_em']) ? date('d/m/Y H:i', strtotime($u['User']['criado_em'])) : 'N/A'; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-gold-light">
                                            <?php echo !empty($u['User']['modificado_em']) ? date('d/m/Y H:i', strtotime($u['User']['modificado_em'])) : 'N/A'; ?>
                                        </small>
                                    </td>

                                    <!-- Botões de Ação -->
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <?php
                                            echo $this->Html->link(
                                                'Editar',
                                                array('action' => 'edit', $u['User']['id']),
                                                array('class' => 'btn btn-sm btn-outline-gold')
                                            );
                                            ?>
                                            <?php
                                            echo $this->Form->postLink(
                                                'Excluir',
                                                array('action' => 'delete', $u['User']['id']),
                                                array('class' => 'btn btn-sm btn-outline-danger', 'confirm' => 'Tem certeza que deseja excluir o usuário #' . $u['User']['id'] . '?')
                                            );
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gold-light">Nenhum usuário encontrado no banco de dados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>