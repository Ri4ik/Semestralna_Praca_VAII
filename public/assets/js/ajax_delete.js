function deleteReview(event, reviewId) {
    event.preventDefault(); // Останавливаем отправку формы по умолчанию

    if (confirm('Naozaj chcete odstrániť tento recenziu?')) {
        fetch('/Lash_reservation/public/delete_review.php', {
            method: 'POST',
            body: new URLSearchParams({
                review_id: reviewId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Recenzia bola odstránená!');
                    document.getElementById('review-' + reviewId).remove();
                } else {
                    alert('Chyba pri odstraňovaní recenzie!');
                }
            })
            .catch(error => console.error('Error:', error));
    }
}
