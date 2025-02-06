document.addEventListener("DOMContentLoaded", function () {
    const reservationForm = document.querySelector("#reservation-form");

    if (reservationForm) {
        reservationForm.addEventListener("submit", function (event) {
            let isValid = true;

            // Получаем значения полей
            const user = document.querySelector("#user_id");
            const service = document.querySelector("#service_id");
            const date = document.querySelector("#reservation_date");
            const time = document.querySelector("#reservation_time");

            // Проверка на выбор пользователя
            if (!user || user.value.trim() === "") {
                alert("❌ Vyberte používateľa!");
                isValid = false;
            }

            // Проверка на выбор услуги
            if (!service || service.value.trim() === "") {
                alert("❌ Vyberte službu!");
                isValid = false;
            }

            // Проверка на дату (должна быть будущей)
            const selectedDate = new Date(date.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (!date.value || selectedDate < today) {
                alert("❌ Dátum rezervácie musí byť v budúcnosti!");
                isValid = false;
            }

            // Проверка на время
            if (!time.value) {
                alert("❌ Zadajte čas rezervácie!");
                isValid = false;
            }

            // Если есть ошибки, отменяем отправку формы
            if (!isValid) {
                event.preventDefault();
            }
        });
    }
});
