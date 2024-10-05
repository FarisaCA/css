document.getElementById('profileForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Profile updated successfully!');
});

document.getElementById('redeemPointsBtn').addEventListener('click', function() {
    alert('Points redeemed successfully!');
});

document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', function() {
        const bookingItem = this.parentElement;
        bookingItem.remove();
        alert('Booking canceled successfully!');
    });
});
