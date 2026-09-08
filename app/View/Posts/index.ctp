<!-- File: /app/View/Posts/index.ctp  (edit links added) -->
<?php echo $this->Html->css('homePage'); ?>

<div class="container">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-12 col-md-8">
            <h1>Blog posts</h1>
            <?php
            /**
             * @var array $isAuthenticated
             */
            if ($isAuthenticated): ?>
                <p><?php echo $this->Html->link("Add Post", array('action' => 'add')); ?></p>
                <p><?php echo $this->Html->link("Sair", array('controller' => 'Users', 'action' => 'sairDaConta')); ?></p>
            <?php endif; ?>

            <?php if (!$isAuthenticated): ?>
                <p><?php echo $this->Html->link("login", array('controller' => 'Users', 'action' => 'login')); ?></p>
            <?php endif; ?>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <?php if ($isAuthenticated): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                    <th>Created</th>
                </tr>

                <?php
                /**
                 * @var array $posts
                 */
                foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo $post['Post']['id']; ?></td>
                        <td>
                            <?php
                            echo $this->Html->link(
                                $post['Post']['title'],
                                array('action' => 'view', $post['Post']['id'])
                            );
                            ?>
                        </td>
                        <?php if ($isAuthenticated): ?>
                            <td>
                                <?php
                                echo $this->Html->link(
                                    'Edit',
                                    array('action' => 'edit', $post['Post']['id'])
                                );
                                echo ' | ';
                                echo $this->Form->postLink(
                                    'Delete',
                                    array('action' => 'delete', $post['Post']['id']),
                                    array('confirm' => 'Are you sure?')
                                );
                                ?>
                            </td>
                        <?php endif; ?>
                        <td>
                            <?php echo $post['Post']['created']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </div>
</div>