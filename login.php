<?php require "./partials/header.php" ?>
<body>
  
  <div class="container">
    <h1 >Bienvenido</h1>
    
    <form action="validar.php" method="POST">
      <div class="form-group ">
        <label for="username">Correo:</label>
        <input type="text" id="username" name="username" pattern="[a-zA-Z0-9]+" oninput="validateUsername(this)" required>
      </div>
      <div class="form-group ">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group ">
        <button type="submit">Iniciar sesión</button>
        <link rel="stylesheet" href="./index.html">
      
        <a id ="crearcuenta" href="">Crea una cuenta</a>
        <a id ="recupera" href="">Recuperar Contraseña</a>
      </div>
    </form>
  </div> 
<?php require "./partials/header.php" ?>