<?php

require "../database.php";

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
  <link rel="stylesheet" href="style\login.css" />
  <script src="ruta_del_archivo.js"></script>

</head>

<body>


  <div class="container">
    <h1>Bienvenido</h1>
    <form action="login.php" method="POST">
      <div class="form-group ">
        <label for="email">Correo:</label>
        <input type="email" placeholder="Correo" id="email" name="email" required>
      </div>
      <div class="form-group ">
        <label for="password">Contraseña:</label>
        <input type="password" placeholder="Contraseña" id="password" name="password" required>
      </div>
      <div class="form-group ">
        <button id="login-button" type="submit">Iniciar sesión</button>
        <?php if ($error) : ?>
          <p class="text-danger"><?= $error ?></p>
        <?php endif ?>
      </div>
      <div class="tienes">
        <p style="display: inline-block;margin-right:15px;">No tienes una cuenta? </p><a style="text-decoration: none;" href="/register.php">Crea una cuenta</a>

      </div>
    </form>
  </div>