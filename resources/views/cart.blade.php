@extends('layouts.master')

@section('content')


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #10B981;
            --secondary-color: #059669;
            --accent-color: #047857;
            --text-color: #1F2937;
            --light-bg: #F9FAFB;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
        }

        .cart-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #E5E7EB;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quantity-btn:hover {
            background: var(--light-bg);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid #E5E7EB;
            border-radius: 5px;
            padding: 5px;
            font-weight: 500;
        }

        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 20px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 24px;
            font-weight: 500;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 24px;
            font-weight: 500;
            border-radius: 8px;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-1px);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }

        .price-tag {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .remove-btn {
            color: #DC2626;
            transition: all 0.2s;
        }

        .remove-btn:hover {
            transform: scale(1.1);
        }

        .promo-input {
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.2s;
        }

        .promo-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        @media (max-width: 768px) {
            .cart-item {
                padding: 15px;
            }

            .product-image {
                height: 100px;
                margin-bottom: 15px;
            }

            .quantity-control {
                margin: 10px 0;
            }

            .summary-card {
                position: static;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Shopping Cart</h2>
                    <span class="text-muted">3 items</span>
                </div>

                <!-- Cart Item 1 -->
                <div class="cart-item">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500" class="product-image" alt="Premium Headphones">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1">Premium Headphones</h5>
                            <p class="text-muted mb-0">Color: Black</p>
                            <div class="mt-2">
                                <span class="badge bg-success">In Stock</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="quantity-control">
                                <button class="quantity-btn">-</button>
                                <input type="number" class="quantity-input" value="1" min="1">
                                <button class="quantity-btn">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="price-tag mb-1">$199.99</div>
                            <small class="text-muted">$199.99 each</small>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-link remove-btn p-0">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="cart-item">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="https://images.unsplash.com/photo-1527814050087-3793815479db?w=500" class="product-image" alt="Wireless Mouse">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1">Wireless Mouse</h5>
                            <p class="text-muted mb-0">Color: Silver</p>
                            <div class="mt-2">
                                <span class="badge bg-warning text-dark">Low Stock</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="quantity-control">
                                <button class="quantity-btn">-</button>
                                <input type="number" class="quantity-input" value="2" min="1">
                                <button class="quantity-btn">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="price-tag mb-1">$49.99</div>
                            <small class="text-muted">$49.99 each</small>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-link remove-btn p-0">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cart Item 3 -->
                <div class="cart-item">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="https://images.unsplash.com/photo-1511467687858-23d96c32e4ae?w=500" class="product-image" alt="Mechanical Keyboard">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1">Mechanical Keyboard</h5>
                            <p class="text-muted mb-0">Color: RGB</p>
                            <div class="mt-2">
                                <span class="badge bg-danger">Out of Stock</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="quantity-control">
                                <button class="quantity-btn">-</button>
                                <input type="number" class="quantity-input" value="1" min="1">
                                <button class="quantity-btn">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="price-tag mb-1">$129.99</div>
                            <small class="text-muted">$129.99 each</small>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-link remove-btn p-0">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Continue Shopping -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <button class="btn btn-outline-danger">
                        <i class="fas fa-trash-alt me-2"></i>Clear Cart
                    </button>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <h4 class="mb-4">Order Summary</h4>
                    
                    <!-- Subtotal -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>$429.96</span>
                    </div>
                    
                    <!-- Shipping -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span>$10.00</span>
                    </div>
                    
                    <!-- Tax -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>$35.00</span>
                    </div>
                    
                    <!-- Discount -->
                    <div class="d-flex justify-content-between mb-3">
                        <span>Discount</span>
                        <span class="text-success">-$20.00</span>
                    </div>
                    
                    <hr>
                    
                    <!-- Total -->
                    <div class="d-flex justify-content-between mb-4">
                        <h5>Total</h5>
                        <h5>$454.96</h5>
                    </div>

                    <!-- Promo Code -->
                    <div class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control promo-input" placeholder="Enter promo code">
                            <button class="btn btn-outline-primary">Apply</button>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <button class="btn btn-primary w-100 mb-3">
                        Proceed to Checkout
                    </button>

                    <!-- Payment Methods -->
                    <div class="text-center">
                        <p class="text-muted mb-2">We Accept</p>
                        <div class="d-flex justify-content-center gap-2">
                            <i class="fab fa-cc-visa fa-2x text-primary"></i>
                            <i class="fab fa-cc-mastercard fa-2x text-primary"></i>
                            <i class="fab fa-cc-amex fa-2x text-primary"></i>
                            <i class="fab fa-cc-paypal fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>

                <!-- Security Info -->
                <div class="text-center mt-4">
                    <p class="text-muted mb-2">
                        <i class="fas fa-lock me-2"></i>Secure Checkout
                    </p>
                    <small class="text-muted">
                        Your information is protected by SSL encryption
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Quantity control functionality
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                const currentValue = parseInt(input.value);
                
                if (this.textContent === '+') {
                    input.value = currentValue + 1;
                } else if (this.textContent === '-' && currentValue > 1) {
                    input.value = currentValue - 1;
                }
                
                // Trigger change event to update totals
                input.dispatchEvent(new Event('change'));
            });
        });

        // Prevent manual input of numbers less than 1
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                if (this.value < 1) {
                    this.value = 1;
                }
            });
        });

        // Remove item with animation
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.cart-item');
                item.style.opacity = '0';
                item.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    item.remove();
                }, 300);
            });
        });

        // Clear cart functionality
        document.querySelector('.btn-outline-danger').addEventListener('click', function() {
            const items = document.querySelectorAll('.cart-item');
            items.forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    item.remove();
                }, 300);
            });
        });
    </script>


@endsection