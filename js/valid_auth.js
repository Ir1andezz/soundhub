function validateForm() {
    var emailInput = document.getElementById("emailField");
    var passwordInput = document.getElementById("passwordField");

    var email = emailInput.value.trim();
    var password = passwordInput.value.trim();

    var isValid = true;

    // Валидация почты
    if (email === "") {
        displayError("emailError", "Введите адрес электронной почты");
        isValid = false;
    } else {
        hideError("emailError");
    }

    // Валидация пароля
    if (password === "") {
        displayError("passwordError", "Введите пароль");
        isValid = false;
    } else {
        hideError("passwordError");
    }

    return isValid;
}

// Функция для отображения ошибки
function displayError(elementId, errorMessage) {
    var errorElement = document.getElementById(elementId);
    errorElement.textContent = errorMessage;
    errorElement.style.display = "block";
}

// Функция для скрытия ошибки
function hideError(elementId) {
    var errorElement = document.getElementById(elementId);
    errorElement.textContent = "";
    errorElement.style.display = "none";
}