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

<?php require "./partials/header.php" ?>

<body>
  
  <div class="container">
    <h1 >Bienvenido</h1>
    
    <form action="register.php" method="POST">
      <div class="form-group ">
        <label for="name">Nombre Usuario:</label>
        <input type="text" id="name" name="name" required>
      </div>
      <div class="form-group ">
        <label for="email">Correo:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group ">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group ">
        <button type="submit">Iniciar sesión</button>
        <link rel="stylesheet" href="./index.html">
      
        <p class="crearcuenta">Ya tienes una cuenta?</p><a id ="crearcuenta" href="login.php">Iniciar sesión</a>
      </div>
    </form>
  </div> 
  <?php require "./partials/header.php" ?>