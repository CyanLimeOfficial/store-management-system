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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    {{-- CSS --}}
      <style>
        .action-bar {
            transition: all 0.3s ease;
        }

        .action-bar:hover {
            background-color: #f0f0f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .action-bar i:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* Tooltip customization */
        .tooltip-inner {
            background-color: #333;
            font-size: 0.85rem;
            padding: 5px 10px;
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
              <table class="table table-bordered table-hover table-striped" id="inventory">
                  <thead>
                      <tr>
                          <th>Product Name</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Category</th>
                          <th>Status</th>
                          <th>Action</th> <!-- Added Action column -->
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($products as $product)
                      <tr class="product-row" data-id="{{ $product->id }}">
                          <td>{{ $product->product_name }}</td>
                          <td>₱{{ number_format($product->price, 2) }}</td>
                          <td class="{{ $product->quantity > 0 ? 'text-success' : 'text-danger' }}">
                              {{ $product->quantity }}
                              @if($product->quantity > 0)
                                  <i class="icon-arrow-up-circle"></i>
                              @else
                                  <i class="icon-arrow-down-circle"></i>
                              @endif
                          </td>
                          <td>{{ ucfirst($product->category) }}</td>
                          <td>
                              @if($product->quantity > 10)
                                  <label class="badge badge-success">In Stock</label>
                              @elseif($product->quantity > 0)
                                  <label class="badge badge-warning">Low Stock</label>
                              @else
                                  <label class="badge badge-danger">Out of Stock</label>
                              @endif
                          </td>
                          <td></td> <!-- Empty cell for Action dropdown -->
                      </tr>
                      @endforeach
                  </tbody>
              </table>
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
      <!-- Modal for editing stock -->
      <div class="modal fade" id="editStockModal" tabindex="-1" role="dialog" aria-labelledby="editStockModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="editStockModalLabel">Update Product Details</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form id="editStockForm" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="modal-body">
                          <input type="hidden" name="product_id" id="editProductId">
                          <div class="form-group">
                              <label>Product Name</label>
                              <input type="text" class="form-control" id="editProductName" readonly>
                          </div>
                          <div class="form-group">
                              <label for="editPrice">Price (₱)</label>
                              <input type="number" class="form-control" id="editPrice" name="price" min="0" step="0.01" required>
                          </div>
                          <div class="form-group">
                              <label for="editQuantity">Quantity</label>
                              <input type="number" class="form-control" id="editQuantity" name="quantity" min="0" required>
                          </div>
                          <div class="form-group">
                              <label for="editCategory">Category</label>
                              <select class="form-control" id="editCategory" name="category" required>
                                  <option value="Snacks">Snacks</option>
                                  <option value="Beverages">Beverages</option>
                                  <option value="Alcohol">Alcohol</option>
                                  <option value="Tobacco">Tobacco</option>
                                  <option value="Canned Goods">Canned Goods</option>
                                  <option value="Condiments">Condiments</option>
                                  <option value="Dairy">Dairy</option>
                                  <option value="Bread">Bread</option>
                                  <option value="Frozen Food">Frozen Food</option>
                                  <option value="Personal Care">Personal Care</option>
                                  <option value="Household Items">Household Items</option>
                                  <option value="Others">Others</option>
                              </select>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Update Product</button>
                      </div>
                  </form>
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
      var table = $('#inventory').DataTable({
          paging: true,
          searching: true,
          ordering: true,
          info: true,
          responsive: true,
            initComplete: function() {
                this.api().rows().every(function() {
                    var row = this.node();
                    var productId = $(row).data('id');
                    var productName = $(row).find('td:eq(0)').text().trim();

                    var actionsHtml = `
                        <div class="d-flex justify-content-center">
                            <div class="action-bar shadow-sm border rounded-pill px-3 py-1 bg-light">
                                <a href="#" class="edit-product text-decoration-none" data-id="${productId}" data-bs-toggle="tooltip" title="Update ${productName}">
                                    <i class="icon-pencil text-primary mx-2 fs-5"></i>
                                </a>
                                <a href="#" class="delete-product text-decoration-none" data-id="${productId}" data-name="${productName}" data-bs-toggle="tooltip" title="Delete ${productName}">
                                    <i class="icon-trash text-danger mx-2 fs-5"></i>
                                </a>
                            </div>
                        </div>
                    `;

                    $(row).find('td:last').html(actionsHtml);
                });

                // Initialize Bootstrap tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();
            }

      });
        
      // Edit product button
      $(document).on('click', '.edit-product', function(e) {
          e.stopPropagation();
          var productId = $(this).data('id');
          
          $.get('/inventory/' + productId + '/edit', function(product) {
              $('#editProductId').val(product.id);
              $('#editProductName').val(product.product_name);
              $('#editPrice').val(product.price);
              $('#editQuantity').val(product.quantity);
              $('#editCategory').val(product.category);
              $('#editStockModalLabel').text('Update Product: ' + product.product_name);
              $('#editStockForm').attr('action', '/inventory/' + productId + '/update');
              
              $('#editStockModal').modal('show');
          }).fail(function() {
              alert('Error fetching product details');
          });
      });

      // Delete product button
      $(document).on('click', '.delete-product', function(e) {
          e.stopPropagation();
          var productId = $(this).data('id');
          var productName = $(this).data('name');
          
          Swal.fire({
              title: 'Confirm Deletion',
              html: `<p>You are about to delete <strong>${productName}</strong>. This action cannot be undone.</p>
                    <p><strong>Warning:</strong> Deleting this product will affect all transactions that include it.</p>
                    <p>Type <strong>CONFIRM</strong> to proceed with deletion.</p>
                    <input type="text" id="confirmDelete" class="swal2-input" placeholder="Type CONFIRM here">`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Delete',
              preConfirm: () => {
                  const confirmValue = document.getElementById('confirmDelete').value;
                  if (confirmValue !== 'CONFIRM') {
                      Swal.showValidationMessage('You must type CONFIRM to delete');
                  }
                  return confirmValue === 'CONFIRM';
              }
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '/inventory/' + productId + '/delete',
                      type: 'DELETE',
                      data: {
                          _token: $('meta[name="csrf-token"]').attr('content')
                      },
                      success: function(response) {
                          Swal.fire(
                              'Deleted!',
                              'The product has been deleted.',
                              'success'
                          ).then(() => {
                              location.reload();
                          });
                      },
                      error: function(xhr) {
                          Swal.fire(
                              'Error!',
                              'Failed to delete product: ' + (xhr.responseJSON?.message || 'Unknown error'),
                              'error'
                          );
                      }
                  });
              }
          });
      });

      // Handle form submission
      $('#editStockForm').on('submit', function(e) {
          e.preventDefault();
          
          $.ajax({
              url: $(this).attr('action'),
              type: 'PUT',
              data: $(this).serialize(),
              success: function(response) {
                  $('#editStockModal').modal('hide');
                  Swal.fire(
                      'Updated!',
                      'Product has been updated.',
                      'success'
                  ).then(() => {
                      location.reload();
                  });
              },
              error: function(xhr) {
                  Swal.fire(
                      'Error!',
                      'Failed to update product: ' + (xhr.responseJSON?.message || 'Unknown error'),
                      'error'
                  );
              }
          });
      });
    });
  </script>
      {{-- Change store name --}}
  </body>
</html>