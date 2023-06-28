<nav>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@0,400;1,700&display=swap" rel="stylesheet">
    <div class="icon-principal">
        <img src="img\logonav.png" style="width:45%;" />
        
    </div>
    <!-- si la sesion esta iniciada, mostrará el correo del Usuario -->
    <?php if (isset($_SESSION["user"])) : ?>
        <ul class="enlaces">
            <li><a href="index.php">Inicio</a></li>
            <li> <a href="">Productos</a></li>
            <li> <a href="listaDeseos.php">Favoritos</a></li>
            <li> <a href=""><i class="fa-sharp fa-solid fa-cart-shopping fa-xl"></i></a></li>
            <li> <a href=""><?= $_SESSION["user"]["email"] ?></a></li>
            <li> <a href="logout.php"><i class="fa-solid fa-right-to-bracket fa-xl" style="color: #ffffff;"></i></a></li>
        </ul>
        <!-- en caso contrario, le dará la opción de iniciar sesión -->
    <?php else : ?>
        <ul class="enlaces">
            <li><a href="index.php">Inicio</a></li>
            <li> <a href="">Productos</a></li>
            <li> <a href="listaDeseos.php">Favoritos</a></li>
            <li> <a href=""><i class="fa-sharp fa-solid fa-cart-shopping fa-xl"></i></a></li>
            <li> <a href="login.php"><i class="fa-solid fa-user fa-lg" style="color: #ffffff;"></i></a></a></li>
        </ul>
    <?php endif ?>
</nav>