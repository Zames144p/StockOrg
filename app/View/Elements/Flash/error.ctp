<?php
// filepath: app/View/Elements/Flash/error.ctp
?>
<div class="alert alert-danger flash-message">
    <?php echo h(isset($message) ? $message : ''); ?>
</div>