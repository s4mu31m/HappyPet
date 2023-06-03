<?php

require "./database.php";

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

<?php require "./partials/header.php" ?>

<body>

  <div class="container">
    <h1>Bienvenido</h1>
    <form action="login.php" method="POST">
      <div class="form-group ">
        <label for="email">Correo:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group ">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group ">
        <button id="login-button" type="submit">Iniciar sesión</button>
        <?php if ($error) : ?>
          <p class="text-danger"><?= $error ?></p>
        <?php endif ?>
      </div>
      <p class="crearcuenta">No tienes una cuenta?</p><a id="crearcuenta" href="register.php">Crea una cuenta</a>
    </form>
  </div>
  <script src="js\function.js"></script>
  <?php require "./partials/header.php" ?>