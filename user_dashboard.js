// Preview uploaded photo
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('profilePhoto').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Load external HTML files into iframe
function loadPage(page) {
    const iframe = document.getElementById('contentFrame');
    iframe.src = page;
    iframe.style.display = 'block';
}

// Logout functionality
function logout() {
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = 'user_logout.php';
    }
}
