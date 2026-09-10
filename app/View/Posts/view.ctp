<!-- File: /app/View/Posts/view.ctp -->
<?php echo $this->Html->css('postsView'); ?>

<div class="container">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-12 col-md-8">
            <div class="post-container">
                <h1><?php
                    /**
                     * @var array $post
                     */
                    echo $post['Post']['title']; ?></h1>
                <p><small>Created: <?php echo $post['Post']['created']; ?></small></p>
                <p><?php echo h($post['Post']['body']); ?></p>
                <?php
                /**
                 * @var bool $isAuthenticated
                 */
                if ($isAuthenticated): ?>
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
            </div>
        </div>
    </div>
</div>