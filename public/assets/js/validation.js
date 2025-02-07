
document.getElementById("registerForm").addEventListener("submit", function(event) {
    // Сначала очищаем предыдущие сообщения об ошибках
    document.getElementById("error-message").innerHTML = '';

    // Получаем значения полей
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let password = document.getElementById("password").value.trim();

    let errors = [];

    // Валидация имени
    if (name === "") {
        errors.push("Meno nemôže byť prázdne.");
    }

    // Валидация email (проверка на формат)
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        errors.push("Zadajte platný email.");
    }

    // Валидация телефона (проверка на формат)
    const phonePattern = /^[0-9]{10}$/; // Пример для телефонов из 10 цифр
    if (!phonePattern.test(phone)) {
        errors.push("Telefónne číslo musí obsahovať 10 číslic.");
    }

    // Валидация пароля
    if (password === "") {
        errors.push("Heslo nemôže byť prázdne.");
    }

    // Если есть ошибки, выводим их и прекращаем отправку формы
    if (errors.length > 0) {
        event.preventDefault(); // Останавливаем отправку формы
        let errorMessage = '<ul>';
        errors.forEach(function(error) {
            errorMessage += '<li>' + error + '</li>';
        });
        errorMessage += '</ul>';
        document.getElementById("error-message").innerHTML = errorMessage;
    }
});
