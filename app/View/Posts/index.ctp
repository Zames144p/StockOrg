<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8">
            
            <h1>Blog posts</h1>

            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
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
                            <td><?php echo $post['Post']['created']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>