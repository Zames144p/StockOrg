<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $this->fetch('title'); ?></title>
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    >
    <!-- Seus scripts e estilos customizados -->
    <?php echo $this->Html->css('bootstrap.min'); ?>
    <?php echo $this->Html->css('custom'); ?>
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