<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Bahan Baku PT Multi Instrumentasi</title>
  <link rel="icon" href="/images/Logo.png" type="image/x-icon">

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<!-- AdminLTE CSS -->
<link rel="stylesheet" href="{{ asset('templates/dist/css/adminlte.min.css') }}">
@vite('resources/css/app.css')  <!-- Tailwind and custom styles -->
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Your custom styles should come after AdminLTE -->

<link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- Custom styles (ensure this is last) -->
<style>
  /* Ensure hover effect is removed for all nav links inside sidebar */
  .main-sidebar .nav-item .nav-link:hover {
      background-color: transparent !important;
      color: inherit !important;
  }
  .custom tbody tr:nth-of-type(odd) {
    background-color: #CCE4F4; /* Your custom striped color */
    color: black; /* Optional: Change text color for better contrast */
}
.custom tbody tr:nth-of-type(even) {
    background-color: white; /* Keep other rows white */
    color: black; /* Optional: Default text color */
}


/* Style for the main logo */
.brand-image {
    max-height: 50px; /* Limit logo height */
    max-width: 100%;
    object-fit: contain; /* Maintain aspect ratio */
}

/* Style for the text logo */
/* Ensure the text logo is visible by default */
.text-image {
    display: block !important;
    max-height: 40px;
    max-width: 100%;
    object-fit: contain;
    margin-left: 0.75rem; /* Add spacing between logos */
}

/* Hide the text logo when sidebar is minimized */
.sidebar-mini .text-image {
    display: none;
}



</style>

 
</head>
<body class="hold-transition sidebar-mini" style="background-color: #CCE4F4;">
<div class="wrapper">
  <!-- Navbar -->
  @include('layouts.components.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.components.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-[#CCE4F4]">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        @yield('header')
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content" >
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn back-to-top" role="button" aria-label="Scroll to top" style="background-color: #0078C8; color: white;">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('/templates/plugins/jquery/jquery.min.js') }}"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

<!-- AdminLTE App -->
<script src="{{ asset('/templates/dist/js/adminlte.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Optional: Demo script -->
<script src="{{ asset('/templates/dist/js/demo.js') }}"></script>
</body>
</html>
