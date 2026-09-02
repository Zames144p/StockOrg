<!-- File: /app/View/Posts/view.ctp -->


<h1><?php
/**
 * @var array $post
 */
echo ($post['Post']['title']); 
?></h1>

<p><small>Created: <?php echo $post['Post']['created']; ?></small></p>

<p><?php echo h($post['Post']['body']); ?></p>