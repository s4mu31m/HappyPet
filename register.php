<?php

require "database.php";

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"])) {
    $error = "Llena todos los campos";
  } else if (!str_contains($_POST["email"], "@")) {
    $error = "Formato de correo invalido";
  } else {
    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $statement->bindParam(":email", $_POST["email"]);
    $statement->execute();

    if ($statement->rowCount() > 0) {
      $error = "Ya tienes una cuenta";
      echo "<a id ='crearcuenta' href='login.php'>Iniciar sesión</a>";
    } else {
      $conn
        ->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)")
        ->execute([
          ":name" => $_POST["name"],
          ":email" => $_POST["email"],
          ":password" => password_hash($_POST["password"], PASSWORD_BCRYPT),
        ]);

      $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
      $statement->bindParam(":email", $_POST["email"]);
      $statement->execute();
      $user = $statement->fetch(PDO::FETCH_ASSOC);

      session_start();
      $_SESSION["user"] = $user;

      header("Location: index.php");
    }
  }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registra tu cuenta</title>
  <link rel="stylesheet" href="style\login.css" />
  <script src="ruta_del_archivo.js"></script>

</head>

<body>

  <div class="container">
    <h1>Bienvenido</h1>

    <form action="register.php" method="POST">
      <div class="form-group ">
        <label for="name">Usuario:</label>
        <input type="text" placeholder="Ingresa tu nombre de usuario" id="name" name="name" required>
      </div>
      <div class="form-group ">
        <label for="email">Correo:</label>
        <input type="email" placeholder="Ingresa tu correo" id="email" name="email" required>
      </div>
      <div class="form-group ">
        <label for="password">Contraseña:</label>
        <input type="password" placeholder="Ingresa contraseña" id="password" name="password" required>
      </div>
      <div class="form-group ">
        <button id="login-button" type="submit">Iniciar sesión</button>
      </div>
      <div class="tienes">
        <p style="display: inline-block;margin-right:15px;">Ya tienes una cuenta? </p><a style="text-decoration: none;" href="login.php">Inicia Sesion</a>

      </div>
    </form>
  </div>
  