<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php echo $this->Html->charset(); ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Perfil - StockOrg</title>

    <?php
    // Injeta o Bootstrap 5 e o CSS
    echo $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    echo $this->Html->css('perfilPage');
    
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
</head>
<body class="dashboard-body">

    <?php echo $this->fetch('content'); ?>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>