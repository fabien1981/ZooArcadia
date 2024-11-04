
<?php require_once 'templates/head.php'?>
<?php require_once 'config/session.php'; ?>


<body>
<?php require_once 'templates/header.php'?>
<?php if (isset($_SESSION['message'])): ?>
  <div class="alert alert-success" role="alert">
    <?php echo $_SESSION['message']; ?>
    <?php unset($_SESSION['message']); ?>
  </div>
  <?php endif; ?>
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success_message']; ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
<main>
<h1>Zoo arcadia</h1>
</main>



<?php require_once 'templates/footer.php'?>


</body>
</html>