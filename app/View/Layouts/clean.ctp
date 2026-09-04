<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $this->fetch('title'); ?></title>
    <!-- Seus scripts e estilos customizados -->
    <?php echo $this->fetch('css'); ?>
    <?php echo $this->fetch('script'); ?>
</head>
<body>
    <main>
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->fetch('content'); ?>
    </main>
</body>
</html>