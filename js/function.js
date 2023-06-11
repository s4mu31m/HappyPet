function shakeButton() {
    var button = document.getElementById("login-button");
    var errorMessage = document.getElementById("error-message");
    
    // Agrega la clase shake al botón y muestra el mensaje de error
    button.classList.add("shake");
    errorMessage.style.display = "block";

    // Quita la clase shake después de 1 segundo
    setTimeout(function(){ button.classList.remove("shake"); }, 1000);
}
