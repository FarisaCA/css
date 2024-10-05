document.getElementById('loginBtn').onclick = function() {
    document.getElementById('loginModal').style.display = 'block';
}

document.getElementById('closeBtn').onclick = function() {
    document.getElementById('loginModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target === document.getElementById('loginModal')) {
        document.getElementById('loginModal').style.display = 'none';
    }
}

document.getElementById('customerBtn').onclick = function() {
    alert('Customer login clicked');
    // Add your logic here for customer login
}

document.getElementById('adminBtn').onclick = function() {
    alert('Admin login clicked');
    // Add your logic here for admin login
}
