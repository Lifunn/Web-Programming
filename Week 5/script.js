document.addEventListener('DOMContentLoaded', function() {
    const weddingDate = new Date('2023-12-25T16:00:00');
    const countdownElement = document.getElementById('countdown');
    const rsvpButton = document.getElementById('rsvp-button');

    function updateCountdown() {
        const now = new Date();
        const difference = weddingDate - now;

        if (difference > 0) {
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            countdownElement.innerHTML = `
                <div class="countdown-item">
                    <div class="countdown-number">${days}</div>
                    <div class="countdown-label">Days</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number">${hours}</div>
                    <div class="countdown-label">Hours</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number">${minutes}</div>
                    <div class="countdown-label">Minutes</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number">${seconds}</div>
                    <div class="countdown-label">Seconds</div>
                </div>
            `;
        }
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();

    rsvpButton.addEventListener('click', function() {
        alert('Thank you for your interest! RSVP form will be available soon.');
    });
});
