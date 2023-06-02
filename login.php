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
      $error = "Usuario invalido.";
    } else {
      $user = $statement->fetch(PDO::FETCH_ASSOC);

      if ($_POST["password"] != $user["password"]) {
        $error = "Invalid credentials.";
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
  <h1>Iniciar sesión</h1>
  <div class="container">
    <?php if ($error) : ?>
      <p class="text-danger">
        <?= $error ?>
      </p>
    <?php endif ?>
    <form action="login.php" method="POST">
      <div class="form-group ">
        <label for="username">Correo:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group ">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-group ">
        <button type="submit">Iniciar sesión</button>
      </div>
    </form>
  </div>
  <?php require "./partials/header.php" ?>