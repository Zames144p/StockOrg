<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>Perfil - StockOrg</title>
    <?php
        echo $this->Html->css('profilePage');
        echo $this->fetch('css');
    ?>
</head>
<body class="dashboard-body">

    <?php echo $this->fetch('content'); ?>

</body>
</html>