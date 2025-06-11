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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
              <a class="nav-link" href="/home">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item nav-category"><span class="nav-link">Manage</span></li>
            <li class="nav-item">
              <a class="nav-link" href="/inventory">
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
                <span class="menu-title">Transactions</span>
                <i class="icon-wallet menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/pos">
                <span class="menu-title">POS</span>
                <i class="icon-basket-loaded menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
              @if(session('success') || session('error'))
                  <div class="row purchace-popup">
                      <div class="col-12 stretch-card grid-margin">
                          <div class="card card-{{ session('error') ? 'danger' : 'secondary' }}">
                              <span class="card-body d-lg-flex align-items-center">
                                  <p class="mb-lg-0">
                                      @if(session('success'))
                                          {{ session('success') }}
                                      @elseif(session('error'))
                                          {{ session('error') }}
                                      @endif
                                  </p>
                                  <button class="close popup-dismiss ml-2" onclick="this.closest('.purchace-popup').style.display='none'">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </span>
                          </div>
                      </div>
                  </div>
              @endif
              <div class="container-fluid my-4">
                  <div class="row">
                      <div class="col-lg-4">
                          <div class="card">
                              <div class="card-body">
                                  <h4 class="card-title">Transaction Details</h4>
                                  <hr>
                                  <div id="transaction-details">
                                      <p class="text-muted text-center mt-5">Click on a transaction to see its details.</p>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="col-lg-8">
                          <div class="card">
                              <div class="card-body">
                                  <h4 class="card-title">Transaction Log</h4>
                                  <div class="table-responsive">
                                      <table id="transactions-table" class="table table-hover" style="width:100%">
                                          <thead>
                                              <tr>
                                                  <th>ID</th>
                                                  <th>Total Price</th>
                                                  <th>Type</th>
                                                  <th>Date</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                      </table>
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
              // 1. INITIALIZE THE DATATABLE WITH AJAX
              const table = $('#transactions-table').DataTable({
                  // Tells DataTables to fetch its data from this URL
                  "ajax": {
                      "url": "{{ route('transactions.list') }}",
                      "dataSrc": "data" // The key in the JSON response that contains the array of data
                  },
                  // Defines how the data from the AJAX response maps to the table columns
                  "columns": [
                      { "data": "id" },
                      { 
                          "data": "orig_price",
                          // Custom renderer to format the price as currency
                          "render": function(data, type, row) {
                              return `₱${parseFloat(data).toFixed(2)}`;
                          }
                      },
                      { 
                          "data": "transaction_class",
                          // Custom renderer to create the Bootstrap badge
                          "render": function(data, type, row) {
                              const badgeClass = data === 'debt' ? 'badge-warning' : 'badge-success';
                              // Capitalize the first letter
                              const statusText = data.charAt(0).toUpperCase() + data.slice(1);
                              return `<span class="badge ${badgeClass}">${statusText}</span>`;
                          }
                      },
                      { 
                          "data": "created_at",
                          // Custom renderer to format the date
                          "render": function(data, type, row) {
                              return new Date(data).toLocaleString('en-US', { 
                                  month: 'short', 
                                  day: 'numeric', 
                                  year: 'numeric', 
                                  hour: 'numeric', 
                                  minute: '2-digit',
                                  hour12: true 
                              });
                          }
                      }
                  ],
                  // Adds the 'data-id' attribute to each <tr> for the click event
                  "createdRow": function(row, data, dataIndex) {
                      $(row).attr('data-id', data.id);
                  },
                  // Ensures the newest transactions are shown first
                  "order": [[ 0, "desc" ]] 
              });

              // 2. CREATE THE CLICK EVENT LISTENER ON TABLE ROWS (No changes needed here)
              $('#transactions-table tbody').on('click', 'tr', function() {
                  const transactionId = $(this).data('id');
                  const detailsContainer = $('#transaction-details');

                  if ($(this).hasClass('table-primary')) {
                      return; // Do nothing if the row is already selected
                  }

                  table.$('tr.table-primary').removeClass('table-primary');
                  $(this).addClass('table-primary');

                  detailsContainer.html('<p class="text-muted text-center mt-5">Loading...</p>');

                  if (transactionId) {
                      $.ajax({
                          // Use the route helper for consistency
                          url: `/transactions/${transactionId}`, 
                          method: 'GET',
                          success: function(response) {
                              // Your existing success logic for showing details is perfect
                              let detailsHtml = `
                                  <div class="text-center">
                                      <h5>Receipt</h5>
                                      <h6>Transaction #${response.id}</h6>
                                      <p class="text-muted small">${new Date(response.created_at).toLocaleString()}</p>
                                  </div>
                                  <hr>
                                  <ul class="list-unstyled receipt-items my-3 py-3">`;
                              
                              response.items.forEach(item => {
                                  detailsHtml += `
                                      <li class="d-flex justify-content-between">
                                          <span>
                                              ${item.quantity}x ${item.product ? item.product.product_name : 'N/A'}
                                          </span>
                                          <strong>₱${(item.price).toFixed(2)}</strong>
                                      </li>`;
                              });

                              detailsHtml += `</ul>
                                  <div class="font-weight-bold">
                                      <div class="d-flex justify-content-between">
                                          <span>Total:</span>
                                          <span>₱${parseFloat(response.orig_price).toFixed(2)}</span>
                                      </div>
                                      <div class="d-flex justify-content-between">
                                          <span>Change:</span>
                                          <span>₱${parseFloat(response.orig_change).toFixed(2)}</span>
                                      </div>
                                  </div>`;
                              detailsContainer.html(detailsHtml);
                          },
                          error: function() {
                              detailsContainer.html('<p class="text-danger text-center mt-5">Could not load transaction details.</p>');
                          }
                      });
                  }
              });
          });
      </script>
  </body>
</html>