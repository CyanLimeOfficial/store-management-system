<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Store Details</title>
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
        use App\Models\User;
        $store = StoreInfo::where('user_id', auth()->id())->first();
        $products = [];
        $products = Product_Inventory::where('store_id', $store->id)->get();
        $user = Auth::user();
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
            <div class="row quick-action-toolbar">
              <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Store Details</h4>
                        <p class="card-description">Manage your store details and account settings.</p>

                        <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="store-details-tab" data-toggle="tab" href="#store-details" role="tab" aria-controls="store-details" aria-selected="true">Store Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="account-settings-tab" data-toggle="tab" href="#account-settings" role="tab" aria-controls="account-settings" aria-selected="false">Account Settings</a>
                            </li>
                        </ul>

                        <form class="forms-sample mt-4" action="{{ route('store-details.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="tab-content" id="settingsTabsContent">

                                <div class="tab-pane fade show active" id="store-details" role="tabpanel" aria-labelledby="store-details-tab">
                                    <div class="form-group">
                                        <label for="store_name">Store Name</label>
                                        <input type="text" class="form-control" name="store_name" placeholder="Store Name" value="{{ old('store_name', $store->store_name ?? '') }}">
                                        @error('store_name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address" placeholder="Address" value="{{ old('address', $store->address ?? '') }}">
                                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" rows="4">{{ old('description', $store->description ?? '') }}</textarea>
                                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Store Logo</label>
                                        <input type="file" name="logo" class="file-upload-default">
                                        <div class="input-group">
                                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload New Image">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                            </span>
                                        </div>
                                        @error('logo') <small class="text-danger">{{ $message }}</small> @enderror
                                        @if($store && $store->logo)
                                        <div class="mt-3">
                                            <p class="text-muted">Current Logo:</p>
                                            <img src="data:image/png;base64,{{ base64_encode($store->logo) }}" alt="Current Store Logo" style="max-height: 80px; border-radius: 8px;">
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="account-settings" role="tabpanel" aria-labelledby="account-settings-tab">
                                    <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name', $user->name) }}">
                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username', $user->username) }}">
                                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <hr>
                                    <p class="card-description">Update Password</p>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current password">
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm New Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <button type="submit" class="btn btn-primary mr-2">Update Settings</button>
                            <a href="{{ url('/home') }}" class="btn btn-light">Cancel</a>
                        </form>
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
        (function($) {
          'use strict';
          $(function() {
            $('.file-upload-browse').on('click', function() {
              var file = $(this).parent().parent().parent().find('.file-upload-default');
              file.trigger('click');
            });
            $('.file-upload-default').on('change', function() {
              $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
            });
          });
        })(jQuery);
      </script>
  </body>
</html>