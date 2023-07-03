function validateForm() {
    var nameInput = document.getElementById("nameField");
    var emailInput = document.getElementById("emailField");
    var phoneInput = document.getElementById("phoneField");
    var passwordInput = document.getElementById("passwordField");
    var confirmPasswordInput = document.getElementById("confirmPasswordField");

    var name = nameInput.value.trim();
    var email = emailInput.value.trim();
    var phone = phoneInput.value.trim();
    var password = passwordInput.value.trim();
    var confirmPassword = confirmPasswordInput.value.trim();

    var isValid = true;

    // Валидация имени
    if (name === "") {
        displayError("nameError", "Введите имя");
        isValid = false;
    } else {
        hideError("nameError");
    }

    // Валидация почты
    if (email === "") {
        displayError("emailError", "Введите адрес электронной почты");
        isValid = false;
    } else if (!validateEmail(email)) {
        displayError("emailError", "Введите корректный адрес электронной почты");
        isValid = false;
    } else {
        hideError("emailError");
    }

    // Валидация номера телефона
    if (phone === "") {
        displayError("phoneError", "Введите номер телефона");
        isValid = false;
    } else if (!validatePhone(phone)) {
        displayError("phoneError", "Введите корректный номер телефона (11 цифр)");
        isValid = false;
    } else {
        hideError("phoneError");
    }

    // Валидация пароля
    if (password === "") {
        displayError("passwordError", "Введите пароль");
        isValid = false;
    } else {
        hideError("passwordError");
    }

    // Подтверждение пароля
    if (confirmPassword === "") {
        displayError("confirmPasswordError", "Введите подтверждение пароля");
        isValid = false;
    } else if (password !== confirmPassword) {
        displayError("confirmPasswordError", "Пароли не совпадают");
        isValid = false;
    } else {
        hideError("confirmPasswordError");
    }

    return isValid;
}

// Функция для проверки формата почты
function validateEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Функция для проверки формата номера телефона
function validatePhone(phone) {
    var phoneRegex = /^\d{11}$/;
    return phoneRegex.test(phone);
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