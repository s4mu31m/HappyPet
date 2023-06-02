<?php require "./partials/header.php" ?>
<body>
  <h1>Iniciar sesión</h1>
  <div class="container">
    <form action="validar.php" method="POST">
      <div class="form-group ">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" pattern="[a-zA-Z0-9]+" oninput="validateUsername(this)" required>
      </div>
      <div class="form-group ">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group ">
        <button type="submit">Iniciar sesión</button>
        <link rel="stylesheet" href="./index.html">
      </div>
    </form>
  </div>
<?php require "./partials/header.php" ?>