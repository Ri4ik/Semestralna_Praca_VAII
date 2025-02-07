// // handleCSVDownload.js
// document.getElementById('downloadCSV').addEventListener('click', function() {
//     // Создаем запрос с использованием AJAX
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', '/Lash_reservation/public/export_reservations.php?download_csv=true', true);
//     xhr.responseType = 'blob'; // Указываем, что ответ будет бинарным файлом
//
//     // Когда файл готов, создаем ссылку для скачивания
//     xhr.onload = function() {
//         if (xhr.status === 200) {
//             var blob = xhr.response;
//             var link = document.createElement('a');
//             link.href = URL.createObjectURL(blob);
//             link.download = 'reservations.csv';
//             link.click();
//         }
//     };
//
//     // Отправляем запрос
//     xhr.send();
// });
