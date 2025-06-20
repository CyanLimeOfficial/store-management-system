<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Homepage</title>
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
        $products = Product_Inventory::where('store_id', $store->id)->get();
      @endphp
    {{-- CSS --}}
    <style>
      #refresh-dashboard-button .icon-refresh.spinning {
        animation: spin 1s linear infinite !important;
      }

      @keyframes spin {
        from {
          transform: rotate(0deg);
        }
        to {
          transform: rotate(360deg);
        }
      }
    </style>
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
              <a class="nav-link" href="/store-details">
                <span class="menu-title">Store Details</span>
                <i class="icon-book-open menu-icon"></i>
              </a>
            </li>
            <li class="nav-item nav-category"><span class="nav-link">Extras</span></li>
            <li class="nav-item">
              <a class="nav-link" href="/transactions">
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
            <div class="row quick-action-toolbar">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-header d-block d-md-flex">
                    <h5 class="mb-0">Quick Actions</h5>
                    <p class="ml-auto mb-0">Use this easy?<i class="icon-bulb"></i></p>
                  </div>
                  <div class="d-md-flex row m-0 quick-action-btns" role="group" aria-label="Quick action buttons">
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                        <button type="button" class="btn px-0" data-toggle="modal" data-target="#addProductModal">
                            <i class="icon-magnifier-add mr-2"></i> Add Product
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                      <button type="button" class="btn px-0" data-toggle="modal" data-target="#productModal">
                        <i class="icon-eye mr-2"></i> See products
                      </button>
                    </div>
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                        <button type="button" id="see-debts-button" class="btn px-0" data-toggle="modal" data-target="#debtsModal">
                            <i class="icon-folder mr-2"></i>See Debts
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
                      <button type="button" class="btn px-0" data-toggle="modal" data-target="#changeStoreNameModal">
                        <i class="icon-book-open mr-2"></i>Change Store Name
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 justify-content-center grid-margin align-items-center stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">Status</h4>
                            <p class="text-muted">As of {{ now()->format('F Y') }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="text-muted mr-2">Updated Report</span>
                            <button id="refresh-dashboard-button" class="btn btn-icons border-0 p-2" style="width: 40px; height: 40px;">
                                <span class="icon-wrapper">
                                    <i class="icon-refresh"></i>
                                </span>

                                <span class="spinner-wrapper d-none">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="aligner-wrapper">
                      <canvas id="earningChart" height="90"></canvas>
                      <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
                        {{-- ID added for AJAX --}}
                        <h2 class="text-center mb-0 font-weight-bold" id="total-earning">${{ number_format($totalEarning, 2) }}</h2>
                        <small class="d-block text-center text-muted font-weight-semibold mb-0">Total Earning</small>
                      </div>
                    </div>
                    <div class="wrapper mt-4 d-flex flex-wrap align-items-center">
                      <div class="d-flex">
                        <span class="square-indicator bg-danger ml-2"></span>
                        <p class="mb-0 ml-2">Sold</p>
                      </div>
                      <div class="d-flex">
                        {{-- Note: Your legend says "Debts" but the color is green (success) --}}
                        <span class="square-indicator bg-success ml-2"></span>
                        <p class="mb-0 ml-2">Debts</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-sm-flex align-items-baseline report-summary-header">
                          <h5 class="font-weight-semibold">Report Summary</h5> 
                        </div>
                      </div>
                    </div>
                    <div class="row report-inner-cards-wrapper">
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">DEBT</span>
                          {{-- ID added for AJAX --}}
                          <h4 id="debt-total">${{ number_format($debtTotal, 2) }}</h4>
                          <span class="report-count" id="debt-count">{{ $debtCount }} Reports</span>
                        </div>
                        <div class="inner-card-icon bg-success">
                          <i class="icon-rocket"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">PURCHASE</span>
                          {{-- ID added for AJAX --}}
                          <h4 id="purchase-total">${{ number_format($purchaseTotal, 2) }}</h4>
                          <span class="report-count" id="purchase-count">{{ $purchaseCount }} Reports</span>
                        </div>
                        <div class="inner-card-icon bg-danger">
                          <i class="icon-briefcase"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">QUANTITY</span>
                          {{-- ID added for AJAX --}}
                          <h4 id="total-quantity">{{ number_format($totalQuantity) }}</h4>
                          <span class="report-count">In Stock</span>
                        </div>
                        <div class="inner-card-icon bg-warning">
                          <i class="icon-globe-alt"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <span class="report-title">TRANSACTION</span>
                          {{-- ID added for AJAX --}}
                          <h4 id="transaction-count">{{ number_format($transactionCount) }}</h4>
                          <span class="report-count">Total</span>
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
      {{-- See Products --}}
      <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Search Products</h5>
            </div>
            <div class="modal-body">
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
                      <td>₱{{ number_format($product->price, 2) }}</td>
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
      <!-- Change Store Name Modal -->
      <div class="modal fade" id="changeStoreNameModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Change Store Name</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="storeNameForm">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="currentStoreName">Current Store Name</label>
                  <input type="text" class="form-control" value="{{ $store->store_name }}" id="currentStoreName" readonly>
                </div>
                <div class="form-group">
                  <label for="newStoreName">New Store Name</label>
                  <input type="text" class="form-control" id="newStoreName" name="new_store_name" required minlength="3" maxlength="255">
                  <small class="form-text text-muted">Minimum 3 characters</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      {{-- See Debts --}}
      <div class="modal fade" id="debtsModal" tabindex="-1" role="dialog" aria-labelledby="debtsModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="debtsModalLabel">Recent Debt Transactions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="debts-datatable">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Store</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th style="width: 35%;">Items in Transaction</th>
                                </tr>
                            </thead>
                            <tbody id="debts-table-body">
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>
      </div>
      {{-- Add Products Modal --}}
      <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="addProductModalLabel">Add products to your store!</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <form class="forms-sample" method="POST" action="{{ route('add.product') }}" enctype="multipart/form-data" id="addProductForm">
                          @csrf
                          <div class="form-group">
                              <label for="store_id">Store Reference Number</label>
                              <input type="text" class="form-control" name="store_id" value="{{ $store->id }}" readonly>
                          </div>
                          <div class="form-group">
                              <label for="product_name">Product's Name</label>
                              <input type="text" class="form-control" name="product_name" required>
                          </div>
                          <div class="form-group">
                              <label for="price">Price</label>
                              <input type="number" class="form-control" name="price" required>
                          </div>
                          <div class="form-group">
                              <label for="category">Category</label>
                              <select class="form-control" name="category" required>
                                  <option value="Snacks">Snacks</option>
                                  <option value="Beverages">Beverages</option>
                              </select>
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" form="addProductForm">Submit</button>
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
              // Initialize the first DataTable
              $('#productTable').DataTable({
                  paging: true,       // Enable pagination
                  searching: true,    // Enable search box
                  ordering: true,     // Enable sorting
                  info: true,         // Show table information
                  responsive: true    // Enable responsive mode
              });
          });
      </script>
      {{-- Change store name --}}
      <script>
        $(document).ready(function() {
            $('#storeNameForm').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to change your store name?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('store.updateName') }}",
                            method: 'POST',
                            data: $('#storeNameForm').serialize(),
                            success: function(response) {
                                if (response.success) {
                                    $('#changeStoreNameModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Notice',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Something went wrong'
                                });
                            }
                        });
                    }
                });
            });
        });
      </script>
      {{-- See Debts --}}
      <script>
        $(document).ready(function() {
            // This variable will hold our DataTable instance
            let debtsDataTable;

            // Listen for a click on the "See Debts" button
            $('#see-debts-button').on('click', function() {
                const tableId = '#debts-datatable';
                const url = "{{ route('debts.list') }}"; // Make sure this route name matches your route file

                // Check if the DataTable has already been initialized
                if ($.fn.DataTable.isDataTable(tableId)) {
                    // If yes, just reload the data from the server
                    debtsDataTable.ajax.reload();
                } else {
                    // If not, initialize it for the first time
                    debtsDataTable = $(tableId).DataTable({
                        // --- DataTables Configuration ---
                        responsive: true,
                        processing: true, // Shows a "Processing..." message while loading
                        
                        // --- Data Source ---
                        ajax: {
                            url: url, // The URL to fetch data from
                            dataSrc: 'data' // Tells DataTables to look for the 'data' key in the JSON
                        },

                        // --- Column Definitions ---
                        // This maps your JSON data to the table columns
                        columns: [
                            { data: 'id' },
                            { data: 'customer_name' },
                            { 
                                data: 'total_amount',
                                // Use a render function to format the currency
                                render: function(data, type, row) {
                                    return '₱' + parseFloat(data).toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            },
                            { 
                                data: 'transaction_date',
                                render: function(data, type, row) {
                                    // Format the date nicely
                                    return new Date(data).toLocaleDateString('en-US', {
                                        month: 'short', day: 'numeric', year: 'numeric'
                                    });
                                }
                            },
                            { 
                                data: 'items',
                                orderable: false, // Disable sorting for this complex column
                                // Use a render function to build the nested list of items
                                render: function(data, type, row) {
                                    if (!data || data.length === 0) {
                                        return 'No items';
                                    }
                                    
                                    let itemsHtml = '<ul class="list-unstyled mb-0">';
                                    data.forEach(item => {
                                        itemsHtml += `<li>${item.quantity} x ${item.product_name}</li>`;
                                    });
                                    itemsHtml += '</ul>';
                                    
                                    return itemsHtml;
                                }
                            }
                        ]
                    });
                }
            });
        });
      </script>
      {{-- Add Product Modal --}}
      <script>
          $(document).ready(function() {
              // Handle form submission
              $('#addProductForm').on('submit', function(e) {
                  e.preventDefault();
                  
                  $.ajax({
                      url: $(this).attr('action'),
                      method: 'POST',
                      data: $(this).serialize(),
                      success: function(response) {
                          // Close the modal
                          $('#addProductModal').modal('hide');
                          
                          // Show success message (you can use toast or alert)
                          alert('Product added successfully!');
                          
                          // Optionally refresh the page or update the product list
                          location.reload();
                      },
                      error: function(xhr) {
                          // Show error message
                          alert('Error: ' + xhr.responseJSON.message || 'Something went wrong');
                      }
                  });
              });
              
              // Reset form when modal is closed
              $('#addProductModal').on('hidden.bs.modal', function () {
                  $('#addProductForm')[0].reset();
              });
          });
      </script>
      {{-- earnings js --}}
      <script>
          $(function() {
              // --- 1. INITIAL CHART SETUP ---
              var doughnutChartCanvas = $("#earningChart").get(0).getContext("2d");
              var doughnutPieData = {
                  datasets: [{
                      data: [{{ $purchaseTotal ?? 0 }}, {{ $debtTotal ?? 0 }}],
                      backgroundColor: ['#ffca00', '#38ce3c'],
                      borderColor: ['#ffca00', '#38ce3c'],
                  }],
                  labels: ['Sold', 'Debt']
              };
              var doughnutPieOptions = {
                  cutoutPercentage: 75,
                  animationEasing: "easeOutBounce",
                  animateRotate: true,
                  animateScale: false,
                  responsive: true,
                  maintainAspectRatio: true,
                  showScale: true,
                  legend: { display: false },
                  layout: { padding: { left: 0, right: 0, top: 0, bottom: 0 } }
              };
              var earningChart = new Chart(doughnutChartCanvas, {
                  type: 'doughnut',
                  data: doughnutPieData,
                  options: doughnutPieOptions
              });

              // --- 2. EVENT LISTENER FOR THE MANUAL REFRESH BUTTON ---
              $('#refresh-dashboard-button').on('click', function() {
                  // Call the reload function and tell it this is a MANUAL refresh
                  reloadDashboardData(true);
              });

              // --- 3. AJAX RELOAD FUNCTION ---
              function reloadDashboardData(isManualRefresh = false) {
                  // --- NEW SPINNER LOGIC (START) ---
                  const refreshButton = $('#refresh-dashboard-button');
                  const iconWrapper = refreshButton.find('.icon-wrapper');
                  const spinnerWrapper = refreshButton.find('.spinner-wrapper');

                  // Show loading state
                  refreshButton.prop('disabled', true);
                  iconWrapper.addClass('d-none');
                  spinnerWrapper.removeClass('d-none');
                  // --- NEW SPINNER LOGIC (END) ---

                  fetch("{{ route('dashboard.data') }}")
                      .then(response => response.json())
                      .then(data => {
                          // Helper functions for formatting numbers
                          const formatCurrency = (num) => '$' + parseFloat(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                          const formatInt = (num) => parseInt(num).toLocaleString('en-US');

                          // Update all dashboard cards with new data
                          $('#total-earning').text(formatCurrency(data.totalEarning));
                          $('#debt-total').text(formatCurrency(data.debtTotal));
                          $('#debt-count').text(formatInt(data.debtCount) + ' Reports');
                          $('#purchase-total').text(formatCurrency(data.purchaseTotal));
                          $('#purchase-count').text(formatInt(data.purchaseCount) + ' Reports');
                          $('#total-quantity').text(formatInt(data.totalQuantity));
                          $('#transaction-count').text(formatInt(data.transactionCount));

                          // Update Doughnut Chart data
                          earningChart.data.datasets[0].data[0] = data.purchaseTotal;
                          earningChart.data.datasets[0].data[1] = data.debtTotal;
                          earningChart.update();

                          // Show SweetAlert only on manual refresh
                          if (isManualRefresh) {
                              Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'Dashboard refreshed',
                                  showConfirmButton: false,
                                  timer: 3000,
                                  timerProgressBar: true
                              });
                          }
                      })
                      .catch(error => {
                          console.error('Error reloading dashboard data:', error);
                          if (isManualRefresh) {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'Could not refresh data!'
                              });
                          }
                      })
                      .finally(() => {
                          // --- NEW SPINNER LOGIC (START) ---
                          // Hide loading state
                          refreshButton.prop('disabled', false);
                          spinnerWrapper.addClass('d-none');
                          iconWrapper.removeClass('d-none');
                          // --- NEW SPINNER LOGIC (END) ---
                      });
              }
          });
      </script>
  </body>
</html>