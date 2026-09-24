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
<?php $isSuperAdmin = (($userSession['cargo'] ?? '') === 'SuperAdmin'); ?>

<div class="profile-dashboard">

   <!-- Topbar Ajustada -->
    <header class="topbar-admin d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-gold-subtle">
        <div>
            <h1 class="h4 text-gold fw-bold mb-0">Painel Administrativo</h1>
            <small class="text-gold-light opacity-75" style="font-size: 12px;">Visão geral e gestão de usuários</small>
        </div>

        <!-- Badge do Admin na Direita -->
        <div class="user-badge-admin d-flex align-items-center gap-2 px-3 py-1 rounded-pill">
            <span class="fw-bold text-gold-light" style="font-size: 13px;">
                <?php echo h($userSession['nome'] ?? $userSession['username'] ?? 'Admin'); ?>
            </span>
            <?php
            $avatar = !empty($userSession['foto']) ? $userSession['foto'] : 'perfilDefault.jpg';
            echo $this->Html->image($avatar, array(
                'class' => 'topbar-avatar-admin',
                'alt' => 'Avatar Admin'
            ));
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
                            return in_array($u['User']['cargo'] ?? '', array('admin', 'SuperAdmin'), true);
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
                                                <!-- Nome + Badge de Superadmin -->
                                                <div class="d-inline-flex align-items-center gap-1">
                                                    <span class="fw-bold text-gold-light">
                                                        <?php echo h($u['User']['nome'] ?? $u['User']['username'] ?? 'Sem Nome'); ?>
                                                    </span>

                                                    <!-- Badge exibido dinamicamente apenas para cargos Superadmin -->
                                                    <?php if (!empty($u['User']['cargo']) && strtolower($u['User']['cargo']) === 'superadmin'): ?>
                                                        <?php
                                                        echo $this->Html->image('superadmin_badge.png', array(
                                                            'title' => 'Superadmin',
                                                            'alt'   => 'Superadmin Badge',
                                                            'style' => 'width: 16px; height: 16px; object-fit: contain; margin-left: 2px; background: transparent !important; border: none !important;'
                                                        ));
                                                        ?>
                                                    <?php endif; ?>
                                                </div>

                                                <small class="text-muted d-block"><?php echo h($u['User']['email'] ?? 'Sem e-mail'); ?></small>
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
                                        <?php if (($u['User']['cargo'] ?? '') === 'SuperAdmin'): ?>
                                            <span class="badge bg-gold text-dark fw-bold">SuperAdmin</span>
                                        <?php elseif (($u['User']['cargo'] ?? '') === 'admin'): ?>
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
                                        <?php
                                        $targetCargo = $u['User']['cargo'] ?? '';
                                        $canManageUser = $isSuperAdmin || $targetCargo === 'autor';
                                        $canPromoteUser = $isSuperAdmin && $targetCargo === 'autor';
                                        $canDemoteUser = $isSuperAdmin && $targetCargo === 'admin';
                                        ?>
                                        <?php if ($canManageUser): ?>
                                            <div class="d-flex gap-1 justify-content-end">
                                                <?php if ($canPromoteUser): ?>
                                                    <?php
                                                    echo $this->Form->postLink(
                                                        'Tornar Admin',
                                                        array('action' => 'poderAdemiro', $u['User']['id']),
                                                        array(
                                                            'class' => 'btn btn-sm btn-outline-gold',
                                                            'confirm' => 'Tem certeza que deseja promover este usuário a Administrador?', 
                                                            'escape' => false
                                                        )
                                                    );
                                                    ?>
                                                <?php endif; ?>
                                                <?php if ($canDemoteUser): ?>
                                                    <?php
                                                    echo $this->Form->postLink(
                                                        'Remover Admin',
                                                        array('action' => 'removerAdemiro', $u['User']['id']),
                                                        array(
                                                            'class' => 'btn btn-sm btn-outline-danger',
                                                            'confirm' => 'Tem certeza que deseja remover o cargo de administrador deste usuário?',
                                                            'escape' => false
                                                        )
                                                    );
                                                    ?>
                                                <?php endif; ?>
                                                <?php
                                                echo $this->Html->link(
                                                    'Editar',
                                                    array('action' => 'edit', $u['User']['id']),
                                                    array(
                                                        'class' => 'btn btn-sm btn-outline-gold',
                                                        'escape' => false
                                                    )
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
                                        <?php else: ?>
                                            <span class="text-muted">Protegido</span>
                                        <?php endif; ?>
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