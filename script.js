// Auto-refresh countdown
let countdown = 20;
const countdownElement = document.getElementById('countdown');

const countdownInterval = setInterval(() => {
    countdown--;
    countdownElement.textContent = countdown;
    
    if (countdown <= 0) {
        clearInterval(countdownInterval);
        location.reload();
    }
}, 1000);

// Add animation to table rows
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('.status-table tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
        row.classList.add('fade-in');
    });
    
    // Manual refresh button (if added later)
    const refreshButtons = document.querySelectorAll('[data-refresh]');
    refreshButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memperbarui...';
            setTimeout(() => {
                location.reload();
            }, 500);
        });
    });
});

// Hover effect for cards
const cards = document.querySelectorAll('.room-status-card, .summary-card');
cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Touch support for mobile devices
if ('ontouchstart' in window) {
    cards.forEach(card => {
        card.addEventListener('touchstart', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('touchend', function() {
            setTimeout(() => {
                this.style.transform = 'translateY(0)';
            }, 150);
        });
    });
}