<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Product Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap 5 theme for Select2 -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .search-container {
            margin-bottom: 20px;
        }

        .modal-header {
            background-color: #f8f9fa;
            padding: 1rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 0.2rem;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>

<style>
    .nav-link {
        color: rgba(255, 255, 255, 0.75);
    }
    
    .nav-link:hover {
        color: #fff;
    }
    
    .nav-link.active {
        color: #fff !important;
        font-weight: 500;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-top: 20px;
    }

    .search-container {
        margin-bottom: 20px;
    }

    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        margin: 0 0.2rem;
    }
</style>

<style>
    /* Navbar Styling */
    .navbar {
        background: linear-gradient(135deg, #1a73e8 0%, #185abc 100%) !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 0.8rem 1rem;
    }
    
    .navbar-brand {
        font-weight: 600;
        font-size: 1.3rem;
    }
    
    .nav-link {
        position: relative;
        padding: 0.5rem 1rem !important;
        transition: all 0.3s ease;
    }
    
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }
    
    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: #fff;
        border-radius: 2px;
    }
    
    /* Card & Table Styling */
    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .card-header {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-bottom: 1px solid #edf2f7;
        padding: 1.2rem 1.5rem;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        background-color: #f8fafc;
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 2px solid #edf2f7;
    }
    
    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f7;
        color: #2d3748;
    }
    
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    /* Form & Input Styling */
    .form-control {
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
    }
    
    .search-container .input-group {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .search-container .input-group-text {
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-right: none;
        color: #4a5568;
    }
    
    .search-container .form-control {
        border-left: none;
    }
    
    /* Button Styling */
    .btn-primary {
        background-color: #1a73e8;
        border-color: #1a73e8;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #185abc;
        border-color: #185abc;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(26, 115, 232, 0.1);
    }
    
    .btn-warning {
        background-color: #f9a825;
        border-color: #f9a825;
        color: white;
    }
    
    .btn-warning:hover {
        background-color: #f57f17;
        border-color: #f57f17;
        color: white;
    }
    
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    
    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .modal-header {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-bottom: 1px solid #edf2f7;
        padding: 1.5rem;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        border-top: 1px solid #edf2f7;
        padding: 1.2rem 1.5rem;
    }
    
    /* Select2 Styling */
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        min-height: 42px;
    }
    
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #1a73e8;
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
    }
    
    /* Action Buttons Container */
    .action-buttons {
        white-space: nowrap;
    }
    
    .action-buttons .btn {
        margin: 0 0.2rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
    }
    
    /* Loading Spinner */
    .loading {
        background-color: rgba(255, 255, 255, 0.9);
    }
    
    .spinner-border {
        color: #1a73e8;
    }
    </style>
</head>

<body class="bg-light">

    <button id="sidebarToggle" class="d-md-none">
        <i class="bi bi-list"></i>
    </button>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-tab="products">
                            <i class="bi bi-box me-1"></i>Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-tab="suppliers">
                            <i class="bi bi-truck me-1"></i>Suppliers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-tab="categories">
                            <i class="bi bi-tags me-1"></i>Categories
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="loading d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container py-4">
        <div id="products" class="tab-content active">
        <div class="card">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">Product Management</h4>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary" onclick="openAddModal()">
                            <i class="bi bi-plus-lg"></i> Add Product
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="search-container">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Category</th>
                                <th>Supplier</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                            @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->category ? $product->category->name : '-' }}</td>
                                <td>{{ $product->supplier ? $product->supplier->name : '-' }}</td>
                                <td class="action-buttons">
                                    <button class="btn btn-sm btn-warning" onclick="openEditModal('{{ $product->id }}')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct('{{ $product->id }}')">
                                        <i class="bi bi-trash"></i>
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

        <div id="suppliers" class="tab-content">
        <div class="card mt-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">Supplier Management</h4>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary" onclick="openAddSupplierModal()">
                            <i class="bi bi-plus-lg"></i> Add Supplier
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="search-container">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="supplierSearchInput" class="form-control"
                            placeholder="Search suppliers...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="supplierTableBody">
                            @foreach ($suppliers as $index => $supplier)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-warning"
                                            onclick="openEditSupplierModal('{{ $supplier->_id }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger"
                                            onclick="deleteSupplier('{{ $supplier->_id }}')">
                                            <i class="bi bi-trash"></i>
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

        <div id="categories" class="tab-content">
        <div class="card mt-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">Category Management</h4>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary" onclick="openAddCategoryModal()">
                            <i class="bi bi-plus-lg"></i> Add Category
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="search-container">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="categorySearchInput" class="form-control" placeholder="Search categories...">
                    </div>
                </div>
        
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody">
                            @foreach ($categories as $index => $category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-warning" onclick="openEditCategoryModal('{{ $category->_id }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteCategory('{{ $category->_id }}')">
                                            <i class="bi bi-trash"></i>
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
        
        <!-- Add Category Modal -->
        <div class="modal fade" id="categoryModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalTitle">Add Category</h5>
                        <button type="button" class="btn-close" onclick="closeCategoryModal()"></button>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm">
                            <div class="form-group">
                                <label for="categoryName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="categoryName" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="categoryDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="categoryDescription" rows="3"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="modal-footer px-0 pb-0">
                                <button type="button" class="btn btn-secondary" onclick="closeCategoryModal()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Tambahkan modal supplier setelah modal product -->
    <div class="modal fade" id="supplierModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalTitle">Add Supplier</h5>
                    <button type="button" class="btn-close" onclick="closeSupplierModal()"></button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm">
                        <div class="form-group">
                            <label for="supplierName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="supplierName" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="supplierEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="supplierEmail" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="supplierPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="supplierPhone" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="supplierAddress" class="form-label">Address</label>
                            <textarea class="form-control" id="supplierAddress" required rows="3"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeSupplierModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Product</h5>
                    <button type="button" class="btn-close" onclick="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <div class="form-group">
                            <label for="supplierId" class="form-label">Supplier</label>
                            <select class="form-control select2" id="supplierId" name="supplier_id" required>
                                <option value="">Select Supplier</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="productPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="productPrice" required min="0">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="productStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="productStock" required min="0">
                            <div class="invalid-feedback"></div>
                        </div>
                        <!-- Ganti input kategori dengan select2 -->
                        <div class="form-group">
                            <label for="categoryId" class="form-label">Category</label>
                            <select class="form-control select2" id="categoryId" name="category_id" required>
                                <option value="">Select Category</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Di bagian head, tambahkan CSS select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            initializeSelect2();
        });

        function initializeSelect2() {
    // Initialize category select
    $('#categoryId').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Category',
        allowClear: true,
        ajax: {
            url: '/categories',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.map(item => ({
                        id: item._id,
                        text: item.name
                    }))
                };
            }
        },
        dropdownParent: $('#productModal')
    }).on('select2:open', function() {
        $.get('/categories').then(function(data) {
            const options = data.map(item => 
                new Option(item.name, item._id, false, false)
            );
            $('#categoryId').empty().append(options);
        });
    });

    // Initialize supplier select
    $('#supplierId').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Supplier',
        allowClear: true,
        ajax: {
            url: '/suppliers/list',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('Supplier data received:', data);
                return {
                    results: data.map(function(item) {
                        return {
                            id: item._id,
                            text: item.name
                        };
                    })
                };
            },
            cache: true
        },
        dropdownParent: $('#productModal')
    }).on('select2:open', function() {
        $.get('/suppliers/list').then(function(data) {
            const options = data.map(item => 
                new Option(item.name, item._id, false, false)
            );
            $('#supplierId').empty().append(options);
        });
    });

    // Reset supplier selection when closing modal
    $('#productModal').on('hidden.bs.modal', function() {
        $('#supplierId').val(null).trigger('change');
    });
}


        // Di bagian ajax setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error: function(xhr, status, error) {
        console.error('AJAX Error:', {
            status: status,
            error: error,
            response: xhr.responseText
        });
    }
});

// Tambahkan logging untuk semua request AJAX
$(document).ajaxSend(function(event, xhr, settings) {
    console.log('AJAX Request:', settings.url);
});

$(document).ajaxComplete(function(event, xhr, settings) {
    console.log('AJAX Response:', {
        url: settings.url,
        response: xhr.responseJSON
    });
});

        // Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Show/Hide Loading
        $(document).ajaxStart(function() {
            $('.loading').removeClass('d-none');
        }).ajaxStop(function() {
            $('.loading').addClass('d-none');
        });

        let editingId = null;
        const productModal = new bootstrap.Modal(document.getElementById('productModal'));

        // Initialize
        $(document).ready(function() {
            $('#productForm').on('submit', handleSubmit);

            // Search functionality with debounce
            let searchTimeout;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                const searchValue = $(this).val();

                searchTimeout = setTimeout(function() {
                    $.get(`/products/search?search=${searchValue}`)
                        .done(function(data) {
                            renderProducts(data);
                        })
                        .fail(function(xhr) {
                            toastr.error('Error searching products');
                        });
                }, 500);
            });
        });

        // Render products
        function renderProducts(response) {
            if (response.success) {
                $('#productTableBody').html(response.html);
            } else {
                toastr.error('Error loading products');
            }
        }

        // Modal functions
        function openAddModal() {
            $('#modalTitle').text('Add Product');
            $('#productForm')[0].reset();
            
            // Reset and reinitialize select2 fields
            $('#categoryId').val(null).trigger('change');
            $('#supplierId').val(null).trigger('change');
            
            editingId = null;
            
            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('productModal'));
            modal.show();
            
            // Reinitialize select2 after modal is shown
            $('#productModal').on('shown.bs.modal', function() {
                $('#supplierId').select2('destroy').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#productModal')
                });
                $('#categoryId').select2('destroy').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#productModal')
                });
            });
        }

        function openEditModal(id) {
    editingId = id;
    $.get(`/products/${id}`)
        .done(function(product) {
            $('#modalTitle').text('Edit Product');
            $('#productName').val(product.name);
            $('#productPrice').val(product.price);
            $('#productStock').val(product.stock);

            // Set supplier if exists
            if (product.supplier) {
                const supplierOption = new Option(
                    product.supplier.name,
                    product.supplier._id,  // pastikan menggunakan _id
                    true,
                    true
                );
                $('#supplierId').empty().append(supplierOption).trigger('change');
            }

            // Set category if exists
            if (product.category) {
                const categoryOption = new Option(
                    product.category.name,
                    product.category._id,
                    true,
                    true
                );
                $('#categoryId').empty().append(categoryOption).trigger('change');
            }

            productModal.show();
        })
        .fail(function() {
            toastr.error('Error loading product data');
        });
}

        function closeModal() {
            $('#productModal').modal('hide');
            $('#productForm')[0].reset();
            $('#categoryId').val(null).trigger('change');
            $('#supplierId').val(null).trigger('change');
            editingId = null;
        }



      // Ubah fungsi handleSubmit
      function handleSubmit(e) {
    e.preventDefault();
    
    const submitButton = $(e.target).find('button[type="submit"]');
    submitButton.prop('disabled', true);
    
    const categoryId = $('#categoryId').val();
    const supplierId = $('#supplierId').val();
    
    // Debug untuk memastikan nilai yang dikirim
    console.log('Selected supplier ID:', supplierId);
    
    if (!categoryId || !supplierId) {
        toastr.error('Category and Supplier are required');
        submitButton.prop('disabled', false);
        return;
    }
    
    const formData = {
        name: $('#productName').val(),
        price: Number($('#productPrice').val()),
        stock: Number($('#productStock').val()),
        category_id: categoryId,
        supplier_id: supplierId  // ini sekarang akan berupa MongoDB ObjectId
    };

    const url = editingId ? `/products/${editingId}` : '/products';
    const method = editingId ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        type: method,
        data: formData,
        success: function(response) {
            if (response.success) {
                toastr.success(editingId ? 'Product updated successfully' : 'Product added successfully');
                closeModal();
                location.reload();
            }
        },
        error: function(xhr) {
            submitButton.prop('disabled', false);
            console.error('Error:', xhr);
            const errors = xhr.responseJSON?.errors;
            if (errors) {
                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key][0]);
                });
            } else {
                toastr.error(xhr.responseJSON?.message || (editingId ? 'Error updating product' : 'Error adding product'));
            }
        }
    });
}

        function refreshTable() {
            $.get('/', function(response) {
                const products = $(response).find('#productTableBody').html();
                $('#productTableBody').html(products);
            });
        }

        // Delete product
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: `/products/${id}`,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Product deleted successfully');
                            // Ganti refreshTable() dengan reload halaman
                            location.reload();
                        }
                    },
                    error: function() {
                        toastr.error('Error deleting product');
                    }
                });
            }
        }
    </script>
    <script>
        // Supplier related JavaScript
        let supplierEditingId = null;
        const supplierModal = new bootstrap.Modal(document.getElementById('supplierModal'));

        // Initialize supplier functionality
        $(document).ready(function() {
            $('#supplierForm').on('submit', handleSupplierSubmit);

            // Search functionality for suppliers with debounce
            let supplierSearchTimeout;
            $('#supplierSearchInput').on('keyup', function() {
                clearTimeout(supplierSearchTimeout);
                const searchValue = $(this).val();

                supplierSearchTimeout = setTimeout(function() {
                    $.get(`/suppliers/search?search=${searchValue}`)
                        .done(function(data) {
                            renderSuppliers(data);
                        })
                        .fail(function(xhr) {
                            toastr.error('Error searching suppliers');
                        });
                }, 500);
            });
        });

        // Render suppliers
        function renderSuppliers(response) {
            if (response.success) {
                $('#supplierTableBody').html(response.html);
            } else {
                toastr.error('Error loading suppliers');
            }
        }

        // Supplier modal functions
        function openAddSupplierModal() {
            $('#supplierModalTitle').text('Add Supplier');
            $('#supplierForm')[0].reset();
            supplierEditingId = null;
            supplierModal.show();
        }

        function openEditSupplierModal(id) {
            supplierEditingId = id;
            $.get(`/suppliers/${id}`)
                .done(function(supplier) {
                    $('#supplierModalTitle').text('Edit Supplier');
                    $('#supplierName').val(supplier.name);
                    $('#supplierEmail').val(supplier.email);
                    $('#supplierPhone').val(supplier.phone);
                    $('#supplierAddress').val(supplier.address);
                    supplierModal.show();
                })
                .fail(function(xhr) {
                    toastr.error('Error loading supplier data');
                });
        }

        function closeSupplierModal() {
            supplierModal.hide();
            $('#supplierForm')[0].reset();
            supplierEditingId = null;
        }

        function handleSupplierSubmit(e) {
            e.preventDefault();
            const formData = {
                name: $('#supplierName').val(),
                email: $('#supplierEmail').val(),
                phone: $('#supplierPhone').val(),
                address: $('#supplierAddress').val()
            };

            const url = supplierEditingId ? `/suppliers/${supplierEditingId}` : '/suppliers';
            const method = supplierEditingId ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        toastr.success(supplierEditingId ? 'Supplier updated successfully' :
                            'Supplier added successfully');
                        closeSupplierModal();
                        // Ganti dengan reload halaman
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        Object.keys(errors).forEach(key => {
                            toastr.error(errors[key][0]);
                        });
                    } else {
                        toastr.error(supplierEditingId ? 'Error updating supplier' : 'Error adding supplier');
                    }
                }
            });
        }

        function refreshSupplierTable() {
            $.get('/suppliers', function(response) {
                const suppliers = $(response).find('#supplierTableBody').html();
                $('#supplierTableBody').html(suppliers);
            });
        }

        function deleteSupplier(id) {
            if (confirm('Are you sure you want to delete this supplier?')) {
                $.ajax({
                    url: `/suppliers/${id}`,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Supplier deleted successfully');
                            // Ganti dengan reload halaman
                            location.reload();
                        }
                    },
                    error: function() {
                        toastr.error('Error deleting supplier');
                    }
                });
            }
        }
    </script>

<script>
    let categoryEditingId = null;
    const categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));

    // Initialize category functionality
    $(document).ready(function() {
        $('#categoryForm').on('submit', handleCategorySubmit);

        // Search functionality for categories with debounce
        let categorySearchTimeout;
        $('#categorySearchInput').on('keyup', function() {
            clearTimeout(categorySearchTimeout);
            const searchValue = $(this).val();

            categorySearchTimeout = setTimeout(function() {
                $.get(`/categories/search?search=${searchValue}`)
                    .done(function(data) {
                        renderCategories(data);
                    })
                    .fail(function(xhr) {
                        toastr.error('Error searching categories');
                    });
            }, 500);
        });
    });

    // Render categories
    function renderCategories(response) {
        if (response.success) {
            $('#categoryTableBody').html(response.html);
        } else {
            toastr.error('Error loading categories');
        }
    }

    // Category modal functions
    function openAddCategoryModal() {
        $('#categoryModalTitle').text('Add Category');
        $('#categoryForm')[0].reset();
        categoryEditingId = null;
        categoryModal.show();
    }

    function openEditCategoryModal(id) {
        categoryEditingId = id;
        $.get(`/categories/${id}`)
            .done(function(category) {
                $('#categoryModalTitle').text('Edit Category');
                $('#categoryName').val(category.name);
                $('#categoryDescription').val(category.description);
                categoryModal.show();
            })
            .fail(function(xhr) {
                toastr.error('Error loading category data');
            });
    }

    function closeCategoryModal() {
        categoryModal.hide();
        $('#categoryForm')[0].reset();
        categoryEditingId = null;
    }

    function handleCategorySubmit(e) {
        e.preventDefault();
        const formData = {
            name: $('#categoryName').val(),
            description: $('#categoryDescription').val()
        };

        const url = categoryEditingId ? `/categories/${categoryEditingId}` : '/categories';
        const method = categoryEditingId ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                if (response.success) {
                    toastr.success(categoryEditingId ? 'Category updated successfully' : 'Category added successfully');
                    closeCategoryModal();
                    location.reload();
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.keys(errors).forEach(key => {
                        toastr.error(errors[key][0]);
                    });
                } else {
                    toastr.error(categoryEditingId ? 'Error updating category' : 'Error adding category');
                }
            }
        });
    }

    function deleteCategory(id) {
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: `/categories/${id}`,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        toastr.success('Category deleted successfully');
                        location.reload();
                    }
                },
                error: function() {
                    toastr.error('Error deleting category');
                }
            });
        }
    }
</script>

<script>
    // Tab switching functionality
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links and tabs
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Show corresponding tab
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
</script>
</body>

</html>
