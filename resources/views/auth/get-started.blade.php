<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Stellar Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="assets/vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex align-items-center">
          <h3 class="mb-0 font-weight-medium d-none d-lg-flex" style="color:aliceblue">GET STARTED!</h3>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
            <h5 class="mb-0 font-weight-medium d-none d-lg-flex">Store Inventory Management System</h5>
          <ul class="navbar-nav navbar-nav-right ml-auto">

          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-category">
              <span class="nav-link">Dashboard</span>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="#" onclick="showStoreAlert(event)">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item nav-category"><span class="nav-link">Manage</span></li>
            <li class="nav-item">
              <a class="nav-link"   href="#" onclick="showStoreAlert(event)">
                <span class="menu-title">Inventory</span>
                <i class="icon-layers menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"   href="#" onclick="showStoreAlert(event)">
                <span class="menu-title">Store Details</span>
                <i class="icon-book-open menu-icon"></i>
              </a>
            </li>
            <li class="nav-item nav-category"><span class="nav-link">Extras</span></li>
            <li class="nav-item">
              <a class="nav-link"   href="#" onclick="showStoreAlert(event)">
                <span class="menu-title">Transactions</span>
                <i class="icon-wallet menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="#" onclick="showStoreAlert(event)">
                <span class="menu-title">POS</span>
                <i class="icon-basket-loaded menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Get Started</h4>
                    <p class="card-description"> Before anything else, register your store here! </p>
                    <form class="forms-sample" method="POST" action="{{ route('store_info.submit') }}" enctype="multipart/form-data">
                     @csrf
                      <div class="form-group">
                        <label for="id">Store Reference Number</label>
                        <input type="text" class="form-control" value="{{Auth::user()->id}}" disabled>
                      </div>
                      <div class="form-group">
                        <label for="name">Store's Name</label>
                        <input type="text" class="form-control" name="store_name">
                      </div>
                      <div class="form-group">
                        <label for="email">Address</label>
                        <input type="text" class="form-control" name="address">
                      </div>
                      <div class="form-group">
                        <label>Store's Logo</label>
                        <input type="file" name="img[]" class="file-upload-default" accept=".jpg,.jpeg,.png" id="fileInput">
                        <div class="input-group col-xs-12">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" name="logo" type="button" onclick="document.getElementById('fileInput').click()">Upload</button>
                          </span>
                          <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image" id="fileName">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="7"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                      @if(session('error'))
                          <div class="alert alert-danger mt-2">{{ session('error') }}q324</div>
                      @endif
                    </form>
                  </div>
                </div>
              </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/moment/moment.min.js"></script>
    <script src="assets/vendors/daterangepicker/daterangepicker.js"></script>
    <script src="assets/vendors/chartist/chartist.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
    {{-- Inline JS --}}
    <script>
      // Update the file name in the input field when a file is selected
      document.getElementById('fileInput').addEventListener('change', function () {
        const fileName = this.files.length > 0 ? this.files[0].name : '';
        document.getElementById('fileName').value = fileName;
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      function showStoreAlert(event) {
        event.preventDefault();

        Swal.fire({
          title: 'Store Required',
          text: 'You need to create your store information before you proceed.',
          icon: 'warning',
          confirmButtonText: 'OK'
        });
      }
    </script>
    {{-- End Inline JS --}}
  </body>
</html>