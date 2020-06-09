<!-- Login -->

<div class="container-login">
	<div class="login-box">
      <img src="img/logo/login.png" class="avatar" alt="Avatar Image">
      <h1>Inicio de Sesión</h1>
      <?php if (isset($error)): ?>
        <div class="red-text">Error: <?= $error ?></div>
    <?php endif; ?>
      <form method="POST" action="index.php" enctype="multipart/form-data" autocomplete="on">
        <!-- USERNAME INPUT -->
        <label for="usuario">Usuario: </label>
        <input type="text" name="usuario" placeholder="" required><br>
         <!-- PASSWORD INPUT -->
        <label for="password">Contraseña: </label>
        <input type="password" name="password" placeholder="" required><br><br>
        <input type="submit" name="enviar" value="Enviar">
      </form>
    </div>
</div>
<!-- Fin Login -->
