// JavaScript для поиска по автору и дате
document.getElementById('search-author').addEventListener('input', function () {
    searchReviews();
});

document.getElementById('search-date').addEventListener('input', function () {
    searchReviews();
});

// Функция для отправки запроса и отображения результатов
function searchReviews() {
    const author = document.getElementById('search-author').value;
    const date = document.getElementById('search-date').value;

    const formData = new FormData();
    if (author) formData.append('author', author);
    if (date) formData.append('date', date);

    fetch('/Lash_reservation/public/search_reviews.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const reviewsList = document.getElementById('reviews-list');
            reviewsList.innerHTML = ''; // Очистить старые отзывы

            data.reviews.forEach(review => {
                const reviewItem = document.createElement('div');
                reviewItem.classList.add('review-item');
                reviewItem.innerHTML = `
                    <p>${review.comment || 'Bez textu'}</p>
                    <p class="review-author">${review.name}</p>
                    <p class="review-time">${review.created_at}</p>
                `;
                reviewsList.appendChild(reviewItem);
            });
        })
        .catch(error => console.error('Error:', error));
}
