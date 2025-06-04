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
<!-- Add these right before your closing </body> tag or in your scripts section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    {{-- PHP LOGICS --}}
      @php
        use App\Models\StoreInfo;
        use App\Models\Product_Inventory;
        $store = StoreInfo::where('user_id', auth()->id())->first();
        $products = [];
        $products = Product_Inventory::where('store_id', $store->id)->get();
      @endphp

  </head>
  <body>
    <div class="container-scroller">
      
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex align-items-center">
          <a class="navbar-brand" href="{{ url('/home') }}">
            @if($store && $store->store_name)
              <h6 class="nav-links" style="color:aliceblue">{{ $store->store_name }}</h6>
            @endif
          </a>
        </div>

        <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
          <h5 class="mb-0 font-weight-medium d-none d-lg-flex">Store Inventory Management System</h5>
          <ul class="navbar-nav navbar-nav-right ml-auto">
            <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                @if($store && $store->logo)
                  <img class="img-xs rounded-circle ml-2" src="data:image/png;base64,{{ base64_encode($store->logo) }}" alt="Store Logo">
                @endif
                <span class="font-weight-normal"> {{ Auth::user()->name }} </span>
                </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  @if($store && $store->logo)
                    <img class="img-md rounded-circle" width="100" height="100" src="data:image/png;base64,{{ base64_encode($store->logo) }}" alt="Store Logo">
                  @else
                    <img class="img-md rounded-circle" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image">
                  @endif
                  <p class="mb-1 mt-3">{{ Auth::user()->name }}</p>
                </div>

                <a class="dropdown-item"><i class="dropdown-item-icon icon-user text-primary"></i> My Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="dropdown-item-icon icon-power text-primary"></i>Sign Out
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

              </div>
            </li>
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
              <a class="nav-link" href="index.html">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item nav-category"><span class="nav-link">Manage</span></li>
            <li class="nav-item">
              <a class="nav-link" href="">
                <span class="menu-title">Inventory</span>
                <i class="icon-layers menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/forms/basic_elements.html">
                <span class="menu-title">Store Details</span>
                <i class="icon-book-open menu-icon"></i>
              </a>
            </li>
            <li class="nav-item nav-category"><span class="nav-link">Extras</span></li>
            <li class="nav-item">
              <a class="nav-link" href="pages/icons/simple-line-icons.html">
                <span class="menu-title">Debts</span>
                <i class="icon-wallet menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/icons/simple-line-icons.html">
                <span class="menu-title">POS</span>
                <i class="icon-basket-loaded menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            @if(session('success'))
            <div class="row purchace-popup">
              <div class="col-12 stretch-card grid-margin">
                <div class="card card-secondary">
                  <span class="card-body d-lg-flex align-items-center">
                    <p class="mb-lg-0">Store Information has been recorded.</p>
                    <button class="close popup-dismiss ml-2" onclick="this.closest('.purchace-popup').style.display='none'">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </span>
                </div>
              </div>
            </div>
            @endif
            <div class="row quick-action-toolbar">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Quick Actions</h5>
                    <p class="ml-auto mb-0">Use this easy?<i class="icon-bulb"></i></p>
                  </div>
                  <div class="d-md-flex row m-0 quick-action-btns" role="group" aria-label="Quick action buttons">
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                      <a href="/inventory/add-products" class="btn px-0">
                        <i class="icon-magnifier-add mr-2"></i> Add Product
                      </a>
                    </div>
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                      <button type="button" class="btn px-0" data-toggle="modal" data-target="#productModal">
                        <i class="icon-eye mr-2"></i> See products
                      </button>
                    </div>
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                      <button type="button" class="btn px-0"><i class="icon-folder mr-2"></i>Add Debitor</button>
                    </div>
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                      <button type="button" class="btn px-0"><i class="icon-book-open mr-2"></i>Change Store Name</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 justify-content-center grid-margin align-items-center stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Status</h4>
                    <p>As of {{now()->format('F Y')}}</p>
                    <div class="aligner-wrapper">
                      <canvas id="earningChart" height="90"></canvas>
                      <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
                        <h2 class="text-center mb-0 font-weight-bold">300</h2>
                        <small class="d-block text-center text-muted  font-weight-semibold mb-0">Total Earning</small>
                      </div>
                    </div>
                    <div class="wrapper mt-4 d-flex flex-wrap align-items-center">
                      <div class="d-flex">
                        <span class="square-indicator bg-danger ml-2"></span>
                        <p class="mb-0 ml-2">Sold</p>
                      </div>
                      <div class="d-flex">
                        <span class="square-indicator bg-success ml-2"></span>
                        <p class="mb-0 ml-2">Debts</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Quick Action Toolbar Starts-->

            <!-- Quick Action Toolbar Ends-->
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-sm-flex align-items-baseline report-summary-header">
                          <h5 class="font-weight-semibold">Report Summary</h5> <span class="ml-auto">Updated Report</span> <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="row report-inner-cards-wrapper">
                      <div class=" col-md -6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">DEBT</span>
                          <h4>$32123</h4>
                          <span class="report-count"> 2 Reports</span>
                        </div>
                        <div class="inner-card-icon bg-success">
                          <i class="icon-rocket"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">PURCHASE</span>
                          <h4>95,458</h4>
                          <span class="report-count"> 3 Reports</span>
                        </div>
                        <div class="inner-card-icon bg-danger">
                          <i class="icon-briefcase"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">QUANTITY</span>
                          <h4>2650</h4>
                          <span class="report-count"> 5 Reports</span>
                        </div>
                        <div class="inner-card-icon bg-warning">
                          <i class="icon-globe-alt"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">TRANSACTION</span>
                          <h4>.</h4>
                          <span class="report-count"> 9 Reports </span>
                        </div>
                        <div class="inner-card-icon bg-primary">
                          <i class="icon-diamond"></i>
                        </div>
                      </div>
                    </div>
                  </div>
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
    {{-- Modal Panel --}}
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped" id="productTable">
                <thead class="thead-light">
                  <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($products as $product)
                  <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    {{-- JS Custom Inline --}}
    <script>
      $(document).ready(function() {
        $('#productTable').DataTable({
          paging: true,       // Enable pagination
          searching: true,    // Enable search box
          ordering: true,     // Enable sorting
          info: true,         // Show table information
          responsive: true    // Enable responsive mode
        });
      });
    </script>
  </body>
</html>