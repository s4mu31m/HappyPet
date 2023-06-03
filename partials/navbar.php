<nav>
    <div class="icon-principal">
        <i class="fa-solid fa-bone fa-2xl" style="margin-top: 15px; margin-right: 5px;"></i>
        <span class="texto">Happy pet</span>
    </div>
    <!-- si la sesion esta iniciada, mostrará el correo del Usuario -->
    <?php if (isset($_SESSION["user"])): ?>
    <ul class="enlaces">
        <li><a href="">Inicio</a></li>
        <li> <a href="">Productos</a></li>
        <li> <a href="">Favoritos</a></li>
        <li> <a href=""><i class="fa-sharp fa-solid fa-cart-shopping fa-xl"></i></a></li>
        <li> <a href=""><?= $_SESSION["user"]["email"] ?></a></li>
        <li> <a href="logout.php"><i class="fa-solid fa-right-to-bracket fa-xl" style="color: #ffffff;"></i></a></li>
    </ul>
    <!-- en caso contrario, le dará la opción de iniciar sesión -->
    <?php else: ?>
        <ul class="enlaces">
        <li><a href="">Inicio</a></li>
        <li> <a href="">Productos</a></li>
        <li> <a href="">Favoritos</a></li>
        <li> <a href=""><i class="fa-sharp fa-solid fa-cart-shopping fa-xl"></i></a></li>
        <li> <a href="login.php"><i class="fa-solid fa-right-to-bracket fa-xl" style="color: #ffffff;"></i></a></li>
    </ul>
    <?php endif ?>
</nav>