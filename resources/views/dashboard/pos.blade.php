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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    {{-- Local CSS --}}
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --danger: #e63946;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .pos-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            border: none;
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }
        
        .search-box {
            position: relative;
            margin-bottom: 20px;
        }
        
        .search-box .form-control {
            border-radius: 50px;
            padding: 12px 20px 12px 45px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .search-box i {
            position: absolute;
            left: 20px;
            top: 14px;
            color: #9e9e9e;
            font-size: 18px;
        }
        
        .category-buttons {
            display: flex;
            overflow-x: auto;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .category-buttons::-webkit-scrollbar {
            height: 5px;
        }
        
        .category-buttons::-webkit-scrollbar-thumb {
            background: #d1d1d1;
            border-radius: 5px;
        }
        
        .category-btn {
            flex: 0 0 auto;
            margin-right: 10px;
            border-radius: 50px;
            background-color: #eef2ff;
            color: var(--primary);
            border: none;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
            white-space: nowrap;
        }
        
        .category-btn:hover, .category-btn.active {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
            max-height: 520px;
            overflow-y: auto;
            padding-right: 5px;
        }
        
        .product-grid::-webkit-scrollbar {
            width: 8px;
        }
        
        .product-grid::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 5px;
        }
        
        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            border: 1px solid #f0f0f0;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(67, 97, 238, 0.15);
            border-color: var(--primary);
        }
        
        .product-image {
            height: 120px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }
        
        .product-image img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
        
        .product-info {
            padding: 15px 10px 10px;
            border-top: 1px solid #f0f0f0;
        }
        
        .product-name {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 5px;
            color: var(--dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .product-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .product-stock {
            font-size: 12px;
            color: #6c757d;
        }
        
        .in-stock {
            color: #28a745;
        }
        
        .low-stock {
            color: #ffc107;
        }
        
        .out-of-stock {
            color: var(--danger);
        }
        
        .cart-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .cart-items {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 10px;
            background: white;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 12px 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .item-info {
            flex: 1;
            padding-right: 10px;
        }
        
        .item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .item-price {
            color: #6c757d;
            font-size: 14px;
        }
        
        .item-quantity {
            display: flex;
            align-items: center;
        }
        
        .quantity-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f0f0f0;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .quantity-btn:hover {
            background: var(--primary);
            color: white;
        }
        
        .quantity-value {
            min-width: 30px;
            text-align: center;
            font-weight: 500;
        }
        
        .remove-btn {
            margin-left: 15px;
            color: #dc3545;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        
        .remove-btn:hover {
            opacity: 1;
        }
        
        .cart-summary {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        
        .summary-total {
            font-weight: 700;
            font-size: 20px;
            color: var(--primary);
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 10px;
        }
        
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }


        .grid-col-span-2 {
            grid-column: span 2;
        }


        .action-buttons .btn {
            height: 100%;
            padding: 0.5rem 1rem; 
        }


 
        .action-buttons .btn {
            height: 100%;
            padding: 0.5rem 1rem; 
        }
        
        .btn-void {
            background: linear-gradient(120deg, #6c757d, #495057);
            color: white;
        }
        
        .btn-pay {
            background: linear-gradient(120deg, #28a745, #1e7e34);
            color: white;
        }
        
        .empty-cart {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 30px;
            color: #6c757d;
        }
        
        .empty-cart i {
            font-size: 60px;
            margin-bottom: 15px;
            opacity: 0.3;
        }
        
        .receipt-preview {
            background: white;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
        }
        
        .receipt-item {
            display: flex;
            margin-bottom: 5px;
        }
        
        .receipt-name {
            flex: 1;
        }
        
        .receipt-price {
            width: 70px;
            text-align: right;
        }
        
        .receipt-total {
            border-top: 1px dashed #ccc;
            padding-top: 10px;
            margin-top: 10px;
            font-weight: bold;
        }
        
        @media (max-width: 992px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .pos-container {
                padding: 10px;
            }
            
            .action-buttons {
                grid-template-columns: 1fr;
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
             <!-- Compact Table Version -->
            <div class="pos-container p-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-cash-register me-3"></i>
                            <h4 class="mb-0">Point of Sale v1.3</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="search-box">
                                            <i class="fas fa-search"></i>
                                            <input type="text" id="searchProduct" class="form-control" placeholder="Search products...">
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table id="productsTable" class="table table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Stock</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($products as $product)
                                                    <tr>
                                                        <td>{{ $product->id }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>₱{{ number_format($product->price, 2) }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $product->stock_status }}">
                                                                {{ $product->quantity }} in stock
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary add-to-cart" data-id="{{ $product->id }}">
                                                                <i class="fas fa-plus"></i> Add
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="cart-container">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="cart-header">
                                                <h5 class="mb-0">Current Sale</h5>
                                                <span id="itemCount">0 items</span>
                                            </div>
                                            
                                            <div class="cart-items" id="cartItems">
                                                <div class="empty-cart">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    <h5>Your cart is empty</h5>
                                                    <p class="text-center">Add products by clicking on them in the product grid</p>
                                                </div>
                                            </div>
                                            
                                            <div class="cart-summary">
                                                <label for="cashTendered" class="form-label fw-bold">Cash Received</label>             
                                                <div class="input-group">
                                                    <input type="number" id="cashTendered" class="form-control" placeholder="0.00" step="0.01" min="0">
                                                </div>

                                                <div class="summary-row summary-total">
                                                    <span>Total:</span>
                                                    <span id="total">₱0.00</span>
                                                </div>

                                                <div class="summary-row text-primary fw-bold mt-2" style="font-size: 1.1rem;">
                                                    <span>Change:</span>
                                                    <span id="changeDue">₱0.00</span>
                                                </div>
                                                <div class="action-buttons">
                                                    <button class="btn btn-danger btn-sm" id="voidBtn">
                                                        <i class="me-1"></i>Void
                                                    </button>
                                                    <button class="btn btn-warning btn-sm" id="debtBtn">
                                                        <i class="me-1"></i>Debt
                                                    </button>

                                                    <button class="btn btn-success btn-lg grid-col-span-2" id="payBtn">
                                                        <i class="me-1"></i>Pay
                                                    </button> 
                                                </div>
                                            </div>
                                        </div>
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
                // -----------------------------------------------------------------
                // INITIAL SETUP
                // -----------------------------------------------------------------

                // Initialize DataTable for products
                const productsTable = $('#productsTable').DataTable({
                    pageLength: 5,
                    lengthMenu: [5, 10, 25],
                    responsive: true,
                    order: [[1, 'asc']],
                    columnDefs: [
                        { targets: [0, 4], orderable: false, searchable: false },
                        { targets: [1, 2, 3], orderable: true, searchable: true }
                    ]
                });
                
                // Global cart array to hold the current sale's items
                let cart = [];

                // -----------------------------------------------------------------
                // CORE FUNCTIONS
                // -----------------------------------------------------------------

                /**
                 * Reusable function to calculate and display the change due in real-time.
                 */
                function updateChangeCalculation() {
                    const cashReceived = parseFloat($('#cashTendered').val()) || 0;
                    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    const change = (cashReceived > 0 && cashReceived >= total) ? cashReceived - total : 0;
                    $('#changeDue').text('₱' + change.toFixed(2));
                }

                /**
                 * Main function to update the entire cart display UI.
                 * This function is called whenever the cart changes.
                 */
                function updateCartDisplay() {
                    const cartItems = $('#cartItems');
                    const itemCount = $('#itemCount');
                    const subtotalEl = $('#subtotal');
                    const totalEl = $('#total');
                    
                    if (cart.length === 0) {
                        cartItems.html(`<div class="empty-cart"><i class="fas fa-shopping-cart"></i><h5>Your cart is empty</h5><p class="text-center">Add products by clicking 'Add'</p></div>`);
                        itemCount.text('0 items');
                        subtotalEl.text('₱0.00');
                        totalEl.text('₱0.00');
                    } else {
                        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                        itemCount.text(`${totalItems} ${totalItems === 1 ? 'item' : 'items'}`);
                        
                        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                        totalEl.text(`₱${subtotal.toFixed(2)}`);
                        subtotalEl.text(`₱${subtotal.toFixed(2)}`);

                        let cartHtml = '';
                        cart.forEach(item => {
                            cartHtml += `
                                <div class="cart-item">
                                    <div class="item-info">
                                        <div class="item-name fw-bold small">${item.name}</div>
                                        <div class="item-price text-muted small">₱${item.price.toFixed(2)}</div>
                                    </div>
                                    <div class="item-quantity">
                                        <button class="btn btn-sm btn-outline-secondary py-0 px-2 quantity-btn minus" data-id="${item.id}">-</button>
                                        <span class="quantity-value mx-2">${item.quantity}</span>
                                        <button class="btn btn-sm btn-outline-secondary py-0 px-2 quantity-btn plus" data-id="${item.id}">+</button>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger py-0 px-2 remove-btn ms-2" data-id="${item.id}"><i class="fas fa-times"></i></button>
                                </div>`;
                        });
                        cartItems.html(cartHtml);
                    }
                    
                    // After the cart and total are updated, always recalculate the change.
                    updateChangeCalculation();
                }

                /**
                * Final function to process the transaction via AJAX.
                * Builds and displays a detailed summary on success.
                */
                function processTransaction(transactionType, clickedButton, change = 0) {
                    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    const transactionData = {
                        items: cart,
                        orig_price: total,
                        orig_change: change,
                        transaction_class: transactionType
                    };

                    $('.action-buttons .btn').prop('disabled', true);
                    clickedButton.html('<i class="fas fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: '{{ route("transactions.store") }}',
                        type: 'POST',
                        data: JSON.stringify(transactionData),
                        contentType: 'application/json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(response) {
                            // Build the HTML for the transaction summary popup
                            let itemsHtml = '';
                            cart.forEach(item => {
                                const itemTotal = (item.price * item.quantity).toFixed(2);
                                itemsHtml += `
                                    <tr>
                                        <td>${item.quantity} x ${item.name}</td>
                                        <td style="text-align: right;">₱${itemTotal}</td>
                                    </tr>
                                `;
                            });

                            let totalsHtml = `
                                <tr class="summary-item">
                                    <td>Subtotal</td>
                                    <td style="text-align: right;">₱${total.toFixed(2)}</td>
                                </tr>
                            `;

                            if (transactionType === 'purchase') {
                                const cashReceived = total + change;
                                totalsHtml += `
                                    <tr>
                                        <td>Cash Tendered</td>
                                        <td style="text-align: right;">₱${cashReceived.toFixed(2)}</td>
                                    </tr>
                                    <tr class="summary-total">
                                        <td>Change Due</td>
                                        <td style="text-align: right;">₱${change.toFixed(2)}</td>
                                    </tr>
                                `;
                            } else { // 'debt'
                                totalsHtml += `
                                    <tr class="summary-total">
                                        <td>Total Debt</td>
                                        <td style="text-align: right;">₱${total.toFixed(2)}</td>
                                    </tr>
                                `;
                            }

                            const summaryHtml = `
                                <table class="transaction-summary-table">
                                    ${itemsHtml}
                                    ${totalsHtml}
                                </table>
                            `;
                            
                            // Show the success popup with the detailed summary
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaction Complete!',
                                html: summaryHtml,
                                confirmButtonText: 'Start New Sale',
                                width: '450px'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire("Transaction Failed", xhr.responseJSON.message || 'An unknown error occurred.', "error");
                            // Re-enable buttons on failure to allow user to try again
                            $('.action-buttons .btn').prop('disabled', false);
                            $('#payBtn').html('<i class="fas fa-credit-card me-1"></i>Pay');
                            $('#debtBtn').html('<i class="fas fa-file-invoice-dollar me-1"></i>Debt');
                            $('#voidBtn').html('<i class="fas fa-times-circle me-1"></i>Void');
                        }
                    });
                }

                // -----------------------------------------------------------------
                // EVENT LISTENERS
                // -----------------------------------------------------------------

                // Trigger change calculation when user types in the cash field.
                $('#cashTendered').on('keyup input', updateChangeCalculation);
                
                // Search products table
                $('#searchProduct').on('keyup', function() {
                    productsTable.search(this.value).draw();
                });

                // Add item to cart
                $(document).on('click', '.add-to-cart', function() {
                    const productId = $(this).data('id');
                    const row = $(this).closest('tr');
                    const productName = row.find('td:eq(1)').text().trim();
                    const productPrice = parseFloat(row.find('td:eq(2)').text().replace('₱', '').replace(',', ''));
                    const stock = parseInt(row.find('td:eq(3)').text().trim());
                    const existingItem = cart.find(item => item.id === productId);
                    
                    if (existingItem) {
                        if (existingItem.quantity < stock) {
                            existingItem.quantity++;
                        } else {
                            Swal.fire('Stock Limit', `Only ${stock} units available in stock!`, 'warning');
                            return;
                        }
                    } else {
                        if (stock > 0) {
                            cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
                        } else {
                            Swal.fire('Out of Stock', 'This product is currently unavailable.', 'error');
                            return;
                        }
                    }
                    updateCartDisplay();
                });
                
                // Adjust quantity from cart
                $(document).on('click', '.quantity-btn.plus', function() {
                    const item = cart.find(i => i.id === $(this).data('id'));
                    const stock = parseInt($(`#productsTable button[data-id="${item.id}"]`).closest('tr').find('td:eq(3)').text());
                    if(item.quantity < stock) {
                        item.quantity++;
                        updateCartDisplay();
                    }
                });
                $(document).on('click', '.quantity-btn.minus', function() {
                    const item = cart.find(i => i.id === $(this).data('id'));
                    if (item) {
                        item.quantity--;
                        if (item.quantity <= 0) cart = cart.filter(i => i.id !== item.id);
                        updateCartDisplay();
                    }
                });

                // Remove item from cart
                $(document).on('click', '.remove-btn', function() {
                    cart = cart.filter(i => i.id !== $(this).data('id'));
                    updateCartDisplay();
                });
                
                // Void sale button
                $('#voidBtn').on('click', function() {
                    if (cart.length > 0) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This will clear the entire cart.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, void it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                cart = [];
                                updateCartDisplay();
                                $('#cashTendered').val('');
                            }
                        });
                    }
                });

                // Pay button
                $('#payBtn').on('click', function() {
                    if (cart.length === 0) {
                        Swal.fire("Cart is Empty", "Please add products to the cart.", "warning");
                        return;
                    }
                    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    const cashReceived = parseFloat($('#cashTendered').val());

                    if (isNaN(cashReceived) || cashReceived < total) {
                        Swal.fire("Insufficient Cash", "Please enter a valid amount that is equal to or greater than the total.", "error");
                        return;
                    }
                    const change = cashReceived - total;
                    processTransaction('purchase', $(this), change);
                });

                // Debt button
                $('#debtBtn').on('click', function() {
                    if (cart.length === 0) {
                        Swal.fire("Cart is Empty", "Please add products to the cart.", "warning");
                        return;
                    }
                    processTransaction('debt', $(this));
                });
            });
        </script>
    
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>