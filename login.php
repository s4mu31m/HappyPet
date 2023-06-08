<<<<<<< Updated upstream
<?php require "./partials/header.php" ?>
=======
<?php

require "database.php";

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["email"]) || empty($_POST["password"])) {
    $error = "Llena todos los campos";
  } else if (!str_contains($_POST["email"], "@")) {
    $error = "Formato de correo invalido";
  } else {
    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $statement->bindParam(":email", $_POST["email"]);
    $statement->execute();

    if ($statement->rowCount() == 0) {
      $error = "Credenciales invalidas.";
    } else {
      $user = $statement->fetch(PDO::FETCH_ASSOC);

      if (!password_verify($_POST["password"], $user["password"])) {
        $error = "Credenciales invalidas.";
      } else {
        session_start();

        unset($user["password"]);

        $_SESSION["user"] = $user;

        header("Location: index.php");
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresa a tu cuenta</title>
    <link rel="stylesheet" href = "style\login.css" />
    <script src="ruta_del_archivo.js"></script>

</head>

>>>>>>> Stashed changes
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