<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar with Logout Confirmation</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <!-- Left navbar links -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/new-page" class="nav-link">{{__('lang.Home')}}</a>
      </li>
    </ul>
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto">
      <!-- Language Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" id="language-dropdown">
          <i class="fas fa-globe"></i> Language
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <a href="{{ route('set.language', 'en') }}" class="dropdown-item">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQN6NjUzMsxiPYELyWrKg17MA4eLo47fkkM2w&s" alt="English" width="20"> English
          </a>
          <a href="{{ route('set.language', 'es') }}" class="dropdown-item">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/Bandera_de_Espa%C3%B1a.svg/300px-Bandera_de_Espa%C3%B1a.svg.png" alt="Spanish" width="20"> Spanish
          </a>
          <a href="{{ route('set.language', 'ef') }}" class="dropdown-item">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGSVvNybJkIV3yXBtARrC1z1qJ-Mw2mRjVZQ&s"alt="french" width="20"> french
          </a>
        </div>
      </li>
      
      <!-- Profile Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <!-- Profile Image -->
          <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class="img-circle" style="width: 30px; height: 30px; object-fit: cover;">
          <!-- User Name -->
          <span class="ml-2">{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <a href="admin-page" class="dropdown-item">
            Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" onclick="confirmLogout(event)">
            Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  
  <!-- Confirmation Modal for Logout -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to logout?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" onclick="handleLogout()">Yes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Logout Form -->
  <form id="logout-form" action="logout" method="POST" style="display: none;">
    @csrf
  </form>

  <!-- JavaScript to handle the logout confirmation -->
  <script>
    function confirmLogout(event) {
      event.preventDefault();
      $('#logoutModal').modal('show'); // Show modal when logout is clicked
    }

    function handleLogout() {
      // Perform the logout request using AJAX
      $.ajax({
        url: "logout", // Make sure this route is correctly set
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}"
        },
        success: function() {
          window.location.href = "login"; // Redirect to login page after successful logout
        },
        error: function(xhr) {
          alert('Logout failed, please try again.');
        }
      });
    }
  </script>

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
