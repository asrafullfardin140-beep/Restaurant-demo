(() => {
  const googleReview = 'https://g.page/r/CR4nZdxkWzKJEAE/review';
  const ratingScreen = document.getElementById('rating-screen');
  const privateScreen = document.getElementById('private-screen');
  let rating = 0;
  document.querySelectorAll('[data-rating]').forEach(button => {
    button.addEventListener('click', () => {
      rating = Number(button.dataset.rating);
      if (rating >= 3) {
        window.location.assign(googleReview);
        return;
      }
      ratingScreen.hidden = true;
      privateScreen.hidden = false;
      document.getElementById('selected-rating').textContent = rating + (rating === 1 ? ' STAR' : ' STARS');
      document.getElementById('private-title').focus();
    });
  });
  document.getElementById('change-rating').addEventListener('click', () => {
    privateScreen.hidden = true;
    ratingScreen.hidden = false;
    document.querySelector('[data-rating="' + rating + '"]').focus();
  });
  document.getElementById('feedback-form').addEventListener('submit', event => {
    event.preventDefault();
    const name = document.getElementById('guest-name').value.trim();
    const feedback = document.getElementById('guest-feedback').value.trim();
    const body = 'Rating: ' + rating + '/5\nName: ' + (name || 'Not provided') + '\n\nFeedback:\n' + (feedback || 'Not provided');
    window.location.href = 'mailto:info@bambu.ie?subject=' + encodeURIComponent('Bambu visit feedback') + '&body=' + encodeURIComponent(body);
    document.getElementById('email-status').textContent = 'Please send the message from your email app. If it did not open, email info@bambu.ie directly.';
  });
})();
