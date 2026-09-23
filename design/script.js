// Toggle sidebar on mobile
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }

    // Update date
    const dateEl = document.querySelector('.date-time span');
    if (dateEl) {
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        dateEl.textContent = new Date().toLocaleDateString('id-ID', options);
    }
});

// Modal functions
function openModal() {
    document.getElementById('modalOverlay').classList.add('active');
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('active');
}
