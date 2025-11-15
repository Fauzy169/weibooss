@extends('layout.layout')

@php
    $css = '<link rel="stylesheet" href="' . asset('assets/css/variables/variable6.css') . '"/>';
    $title='Account';
    $subTitle = 'Shop';
    $subTitle2 = 'Account';
    $script = '<script src="' . asset('assets/js/vendors/zoom.js') . '"></script>';
@endphp

@push('styles')
<style>
.account-main-area {
    flex: 1;
    width: 100%;
}
.account-main {
    width: 100%;
}
</style>
@endpush

@section('content')

    <div class="rts-account-section section-gap">
        <div class="container">
            <div class="account-inner">
                <div class="account-side-navigation">
                    <button class="filter-btn active" data-show=".dashboard"><i class="fal fa-user"></i>
                        My Account</button>
                    <button class="filter-btn" data-show=".orders"><i class="fal fa-shopping-cart"></i> Orders</button>
                    <button class="filter-btn" data-show=".accountdtls"><i class="fal fa-edit"></i> Account
                        Details</button>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="filter-btn" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;"><i
                                class="fal fa-long-arrow-left"></i>
                            Logout</button>
                    </form>
                </div>
                <div class="account-main-area">
                    <div class="account-main dashboard filterd-items">
                        <div class="account-profile-area">
                            <div class="profile-dp">
                                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #d51243 0%, #8b0a2e 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: bold;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="d-block">
                                <span class="profile-name"><span>Hi,</span> {{ Auth::user()->name }}</span>
                                <span class="profile-date d-block">{{ Auth::user()->created_at->format('F d, Y') }}</span>
                            </div>
                        </div>
                        <p>From your account dashboard you can view your recent orders, manage your shipping and billing
                            addresses, and edit your password and account details.</p>

                        <div class="activity-box">
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-user"></i></div>
                                <span class="title">Name</span>
                                <span class="value">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-envelope"></i></div>
                                <span class="title">Email</span>
                                <span class="value">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-phone"></i></div>
                                <span class="title">Phone</span>
                                <span class="value">{{ Auth::user()->phone ?? 'Not set' }}</span>
                            </div>
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                                <span class="title">Address</span>
                                <span class="value">{{ Auth::user()->address ?? 'Not set' }}</span>
                            </div>
                            <div class="activity-item">
                                <div class="icon"><i class="fas fa-user-tag"></i></div>
                                <span class="title">Role</span>
                                <span class="value">{{ ucfirst(Auth::user()->role) }}</span>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="activity-item" style="cursor: pointer; border: none; background: transparent; width: 100%;">
                                    <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
                                    <span class="title">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="account-main orders filterd-items hide">
                        <h2 class="mb--30">My Orders</h2>
                        @if($orders->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr class="top-tr">
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('F d, Y') }}</td>
                                        <td>
                                            <span style="padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; 
                                                @if($order->status == 'completed') background: #d4edda; color: #155724;
                                                @elseif($order->status == 'processing') background: #fff3cd; color: #856404;
                                                @elseif($order->status == 'pending') background: #d1ecf1; color: #0c5460;
                                                @else background: #f8d7da; color: #721c24;
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td><button class="btn-small d-block" onclick="showOrderDetails({{ $order->id }})">View</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div style="text-align: center; padding: 60px 20px; color: #999;">
                                <i class="fas fa-shopping-cart" style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;"></i>
                                <h3 style="margin-bottom: 10px; color: #666;">No Orders Yet</h3>
                                <p style="margin-bottom: 20px;">You haven't placed any orders yet.</p>
                                <a href="{{ route('shop') }}" class="btn" style="display: inline-block; padding: 12px 30px; background: #d51243; color: white; text-decoration: none; border-radius: 4px;">Start Shopping</a>
                            </div>
                        @endif
                    </div>
                    <div class="account-main accountdtls filterd-items hide">
                        <div class="login-form">
                            <div class="section-title">
                                <h2>Account Details</h2>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success" style="padding: 12px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 4px; margin-bottom: 20px;">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    
                                    @if($errors->any())
                                        <div class="alert alert-danger" style="padding: 12px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 4px; margin-bottom: 20px;">
                                            <ul style="margin: 0; padding-left: 20px;">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="{{ route('account.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="form">
                                            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600;">Full Name *</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ Auth::user()->name }}" required>
                                        </div>
                                        
                                        <div class="form">
                                            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600;">Email Address *</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ Auth::user()->email }}" required>
                                        </div>
                                        
                                        <div class="form">
                                            <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600;">Phone Number</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ Auth::user()->phone }}">
                                        </div>
                                        
                                        <div class="form">
                                            <label for="address" style="display: block; margin-bottom: 8px; font-weight: 600;">Address</label>
                                            <textarea class="form-control" id="address" name="address" rows="3">{{ Auth::user()->address }}</textarea>
                                        </div>
                                        
                                        <div class="form" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                                            <h4 style="margin-bottom: 15px;">Change Password (Optional)</h4>
                                            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">Leave blank if you don't want to change password</p>
                                        </div>
                                        
                                        <div class="form">
                                            <label for="current_password" style="display: block; margin-bottom: 8px; font-weight: 600;">Current Password</label>
                                            <div class="password-input">
                                                <input type="password" class="form-control" id="current_password" name="current_password">
                                                <span class="show-password-input"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form">
                                            <label for="new_password" style="display: block; margin-bottom: 8px; font-weight: 600;">New Password</label>
                                            <div class="password-input">
                                                <input type="password" class="form-control" id="new_password" name="new_password">
                                                <span class="show-password-input"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form">
                                            <label for="new_password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 600;">Confirm New Password</label>
                                            <div class="password-input">
                                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                                                <span class="show-password-input"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form">
                                            <button type="submit" class="btn">Update Account <i
                                                    class="fal fa-check"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6);">
        <div style="background-color: #fefefe; margin: 5% auto; padding: 0; border-radius: 8px; width: 90%; max-width: 800px; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
            <div style="padding: 20px 30px; background: #d51243; color: white; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0; font-size: 24px;">Order Details</h2>
                <span onclick="closeOrderModal()" style="cursor: pointer; font-size: 32px; font-weight: 300;">&times;</span>
            </div>
            <div id="orderDetailsContent" style="padding: 30px;">
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #d51243;"></i>
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function showOrderDetails(orderId) {
    document.getElementById('orderModal').style.display = 'block';
    
    fetch(`/shop/order/${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const order = data.order;
                let itemsHtml = '';
                
                order.items.forEach(item => {
                    itemsHtml += `
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <img src="${item.product_image || '/assets/images/products/product-details.jpg'}" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    <div>
                                        <strong>${item.product_name}</strong>
                                        ${item.product_type === 'service' ? '<br><small style="color: #d51243;">Service</small>' : ''}
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
                                Rp${parseInt(item.price).toLocaleString('id-ID')}
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
                                ${item.quantity}
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: right;">
                                <strong>Rp${parseInt(item.price * item.quantity).toLocaleString('id-ID')}</strong>
                            </td>
                        </tr>
                    `;
                });
                
                let statusColor = '#6c757d';
                if (order.status === 'completed') statusColor = '#28a745';
                else if (order.status === 'processing') statusColor = '#ffc107';
                else if (order.status === 'pending') statusColor = '#17a2b8';
                else if (order.status === 'cancelled') statusColor = '#dc3545';
                
                const html = `
                    <div style="margin-bottom: 24px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <p style="margin: 0 0 8px 0; color: #666;"><strong>Order ID:</strong></p>
                                <p style="margin: 0; font-size: 18px; font-weight: 600;">#${order.id}</p>
                            </div>
                            <div>
                                <p style="margin: 0 0 8px 0; color: #666;"><strong>Order Date:</strong></p>
                                <p style="margin: 0; font-size: 16px;">${order.date}</p>
                            </div>
                            <div>
                                <p style="margin: 0 0 8px 0; color: #666;"><strong>Status:</strong></p>
                                <span style="display: inline-block; padding: 6px 16px; background: ${statusColor}; color: white; border-radius: 20px; font-size: 14px; font-weight: 600;">
                                    ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                                </span>
                            </div>
                            <div>
                                <p style="margin: 0 0 8px 0; color: #666;"><strong>Total Amount:</strong></p>
                                <p style="margin: 0; font-size: 20px; font-weight: 700; color: #d51243;">Rp${parseInt(order.total).toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                    </div>
                    
                    <h3 style="margin: 24px 0 16px 0; font-size: 18px; border-bottom: 2px solid #d51243; padding-bottom: 8px;">Order Items</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                        <thead>
                            <tr style="background: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Product</th>
                                <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Price</th>
                                <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Qty</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHtml}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="padding: 16px 12px; text-align: right; font-weight: 600; border-top: 2px solid #dee2e6;">Total:</td>
                                <td style="padding: 16px 12px; text-align: right; font-weight: 700; font-size: 20px; color: #d51243; border-top: 2px solid #dee2e6;">
                                    Rp${parseInt(order.total).toLocaleString('id-ID')}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    ${order.notes ? `
                        <div style="margin-top: 20px; padding: 16px; background: #f8f9fa; border-radius: 4px;">
                            <p style="margin: 0 0 8px 0; font-weight: 600; color: #666;">Notes:</p>
                            <p style="margin: 0;">${order.notes}</p>
                        </div>
                    ` : ''}
                `;
                
                document.getElementById('orderDetailsContent').innerHTML = html;
            } else {
                document.getElementById('orderDetailsContent').innerHTML = `
                    <div class="text-center" style="padding: 40px;">
                        <i class="fas fa-exclamation-circle" style="font-size: 48px; color: #dc3545; margin-bottom: 16px;"></i>
                        <p style="font-size: 16px; color: #666;">Failed to load order details.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            document.getElementById('orderDetailsContent').innerHTML = `
                <div class="text-center" style="padding: 40px;">
                    <i class="fas fa-exclamation-circle" style="font-size: 48px; color: #dc3545; margin-bottom: 16px;"></i>
                    <p style="font-size: 16px; color: #666;">Error loading order details.</p>
                </div>
            `;
        });
}

function closeOrderModal() {
    document.getElementById('orderModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('orderModal');
    if (event.target == modal) {
        closeOrderModal();
    }
}
</script>
@endpush