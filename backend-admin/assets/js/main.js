document.getElementById('togglePassword').addEventListener('click', function (e) {
    // Mendapatkan elemen input password
    var passwordField = document.getElementById('floatingPassword');
    
    // Mengecek tipe input, dan mengubahnya antara 'password' dan 'text'
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      this.classList.remove('fa-eye');
      this.classList.add('fa-eye-slash');
    } else {
      passwordField.type = 'password';
      this.classList.remove('fa-eye-slash');
      this.classList.add('fa-eye');
    }
  });
  