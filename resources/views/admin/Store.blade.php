@extends('admin.layouts.admin-layout')
@section('title', 'إدارة العناوين - لوحة التحكم')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/addresses-styles.css') }}">
    <style>
        .verification-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #4CAF50;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }

        .verification-status {
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
        }

        .verification-status.verified {
            background-color: #d4edda;
            color: #155724;
        }

        .verification-status.not-verified {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header" style="background: linear-gradient(90deg,#2c3e50,#34495e);">
        <h2>📍 إدارة عناوين التوصيل</h2>
        <div class="page-stats">
            <span class="stat-badge">إجمالي: {{ $stores->count() ?? 0 }}</span>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="ابحث عن عنوان أو اسم عميل...">
        </div>
        <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchCityInput" placeholder="ابحث عن المدينة">
        </div>
    </div>

    <!-- Addresses Grid -->
    <div class="addresses-grid">
        @foreach ($stores as $store)
            <div class="address-card {{ $store->is_default ? 'default' : '' }}" data-store-id="{{ $store->id }}">
                <div class="address-header">
                    <div class="address-icon">🏢</div>
                    <div class="address-info">
                        <div class="customer-name">{{ $store->store_name }}</div>
                        <div class="customer-phone">📱 {{ $store->vendor->user->phone_number }}</div>
                    </div>
                </div>

                <div class="address-details">
                    <div class="address-row">
                        <span class="address-label">صاحب المتجر:</span>
                        <span class="address-value">{{ $store->vendor->user->name }}</span>
                    </div>
                    <div class="address-row">
                        <span class="address-label">العنوان:</span>
                        <span class="address-value">{{ $store->address ?? '-' }}</span>
                    </div>
                    <div class="address-row">
                        <span class="address-label">أوقات الفتح :</span>
                        <span class="address-value">{{ $store->opening_hours ?? '-' }}</span>
                    </div>
                    <div class="address-row">
                        <span class="address-label">حالة التحقق:</span>
                        <span class="verification-status {{ $store->is_verified ? 'verified' : 'not-verified' }}">
                            {{ $store->is_verified ? '✓ موثق' : '✗ غير موثق' }}
                        </span>
                    </div>

                    <!-- Toggle Switch for Verification -->
                    <div class="verification-toggle">
                        <span class="address-label">تفعيل التحقق:</span>
                        <label class="toggle-switch">
                            <input type="checkbox"
                                   class="verification-checkbox"
                                   data-store-id="{{ $store->id }}"
                                   {{ $store->is_verified ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/addresses-scripts.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle verification toggle
            document.querySelectorAll('.verification-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const storeId = this.dataset.storeId;
                    const isVerified = this.checked;

                    // Update verification status
                    updateVerificationStatus(storeId, isVerified);
                });
            });

            function updateVerificationStatus(storeId, isVerified) {
                // Show loading state
                const card = document.querySelector(`[data-store-id="${storeId}"]`);
                const statusElement = card.querySelector('.verification-status');
                const originalText = statusElement.textContent;
                statusElement.textContent = '⏳ جاري التحديث...';

                fetch(`/admin/stores/${storeId}/update-verification`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        is_verified: isVerified
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update status badge
                        statusElement.className = `verification-status ${isVerified ? 'verified' : 'not-verified'}`;
                        statusElement.textContent = isVerified ? '✓ موثق' : '✗ غير موثق';

                        // Show success message
                        showNotification('تم تحديث حالة التحقق بنجاح', 'success');
                    } else {
                        // Revert checkbox on error
                        const checkbox = card.querySelector('.verification-checkbox');
                        checkbox.checked = !isVerified;
                        statusElement.textContent = originalText;
                        showNotification('حدث خطأ أثناء التحديث', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Revert checkbox on error
                    const checkbox = card.querySelector('.verification-checkbox');
                    checkbox.checked = !isVerified;
                    statusElement.textContent = originalText;
                    showNotification('حدث خطأ في الاتصال', 'error');
                });
            }

            function showNotification(message, type) {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.textContent = message;
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 15px 25px;
                    background: ${type === 'success' ? '#4CAF50' : '#f44336'};
                    color: white;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    z-index: 10000;
                    animation: slideIn 0.3s ease-out;
                `;

                document.body.appendChild(notification);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.style.animation = 'slideOut 0.3s ease-out';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Add CSS animations
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes slideOut {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
@endpush
