<?php $__env->startSection('title', 'إدارة المستخدمين - لوحة التحكم'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/users-styles.css')); ?>">
    <style>
        .verification-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .verification-select {
            flex: 1;
            padding: 8px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 0.9rem;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .verification-select:hover {
            border-color: #2c3e50;
        }
        
        .verification-select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .verification-status {
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-block;
        }
        
        .verification-status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .verification-status.verified {
            background-color: #d4edda;
            color: #155724;
        }
        
        .verification-status.rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .work-location-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .work-location-badge.online {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        .work-location-badge.in_site {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }
        
        .filter-section {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 768px) {
            .filter-section {
                grid-template-columns: 1fr;
            }
        }
        
        .update-btn {
            padding: 8px 16px;
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .update-btn:hover {
            background: #34495e;
            transform: translateY(-1px);
        }
        
        .update-btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
            transform: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Header -->
    <div class="page-header" style="background: linear-gradient(90deg,#2c3e50,#34495e);">
        <h2>👥 إدارة المستخدمين</h2>
        <div class="page-stats">
            <span class="stat-badge">إجمالي: <?php echo e($users->count() ?? 0); ?></span>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="ابحث عن اسم، إيميل أو هاتف...">
        </div>

        <select class="filter-select" id="workLocationFilter">
            <option value="">مكان العمل - الكل</option>
            <option value="online">Online</option>
            <option value="in_site">In Site</option>
        </select>

        <select class="filter-select" id="verificationFilter">
            <option value="">حالة التحقق - الكل</option>
            <option value="pending">قيد الانتظار</option>
            <option value="verified">موثق</option>
            <option value="rejected">مرفوض</option>
        </select>
    </div>

    <!-- Users Grid -->
    <div class="addresses-grid users-grid">
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="address-card user-card" 
                data-user-id="<?php echo e($u->id); ?>"
                data-name="<?php echo e(strtolower($u->user->name ?? '')); ?>" 
                data-email="<?php echo e(strtolower($u->user->email ?? '')); ?>"
                data-phone="<?php echo e($u->user->phone_number ?? ''); ?>"
                data-work-location="<?php echo e(strtolower($u->has_store ?? '')); ?>"
                data-verification="<?php echo e(strtolower($u->verification_status ?? 'pending')); ?>">

                <div class="address-header user-header">
                    <div class="address-icon avatar-wrapper">
                        <?php if(!empty($u->user->avatar)): ?>
                            <img src="<?php echo e(asset('storage/' . $u->user->avatar)); ?>" alt="<?php echo e($u->user->name); ?>" class="avatar-img">
                        <?php else: ?>
                            <div class="avatar-fallback"><?php echo e(strtoupper(substr($u->user->name ?? '-', 0, 1))); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="address-info user-info">
                        <div class="customer-name"><?php echo e($u->user->name ?? '-'); ?></div>
                        <div class="customer-phone">📧 <?php echo e($u->user->email ?? '-'); ?></div>
                    </div>
                </div>

                <div class="address-details user-details">
                    <div class="address-row">
                        <span class="address-label">الهاتف:</span>
                        <span class="address-value"><?php echo e($u->user->phone_number ?? '-'); ?></span>
                    </div>
                    
                    <div class="address-row">
                        <span class="address-label">الرقم الوطني:</span>
                        <span class="address-value"><?php echo e($u->national_id ?? '-'); ?></span>
                    </div>
                    
                    <div class="address-row">
                        <span class="address-label">نوع العمل:</span>
                        <span class="address-value"><?php echo e($u->business_type ?? '-'); ?></span>
                    </div>
                    
                    <div class="address-row">
                        <span class="address-label">مكان العمل:</span>
                        <span class="work-location-badge <?php echo e(strtolower($u->has_store ?? '')); ?>">
                            <?php echo e($u->has_store == 'online' ? '🌐 Online' : '🏪 In Site'); ?>

                        </span>
                    </div>
                    
                    <div class="address-row">
                        <span class="address-label">اسم المحل:</span>
                        <span class="address-value"><?php echo e($u->store->store_name ?? '-'); ?></span>
                    </div>
                    
                    <div class="address-row">
                        <span class="address-label">حالة التحقق:</span>
                        <span class="verification-status <?php echo e(strtolower($u->verification_status ?? 'pending')); ?>">
                            <?php
                                $statusText = [
                                    'pending' => '⏳ قيد الانتظار',
                                    'verified' => '✓ موثق',
                                    'rejected' => '✗ مرفوض'
                                ];
                                echo $statusText[strtolower($u->verification_status ?? 'pending')] ?? 'قيد الانتظار';
                            ?>
                        </span>
                    </div>
                    
                    <!-- Verification Control -->
                    <div class="verification-toggle">
                        <span class="address-label">تحديث التحقق:</span>
                        <select class="verification-select" data-user-id="<?php echo e($u->id); ?>">
                            <option value="pending" <?php echo e(strtolower($u->verification_status ?? 'pending') == 'pending' ? 'selected' : ''); ?>>
                                قيد الانتظار
                            </option>
                            <option value="verified" <?php echo e(strtolower($u->verification_status ?? '') == 'verified' ? 'selected' : ''); ?>>
                                موثق
                            </option>
                            <option value="rejected" <?php echo e(strtolower($u->verification_status ?? '') == 'rejected' ? 'selected' : ''); ?>>
                                مرفوض
                            </option>
                        </select>
                        <button class="update-btn" onclick="updateVerification(<?php echo e($u->id); ?>)">
                            تحديث
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <?php if(method_exists($users, 'links')): ?>
        <div class="mt-4 pagination-wrapper">
            <?php echo e($users->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Filter Functionality
        (function() {
            const searchInput = document.getElementById('searchInput');
            const workLocationFilter = document.getElementById('workLocationFilter');
            const verificationFilter = document.getElementById('verificationFilter');

            function applyFilters() {
                const query = (searchInput.value || '').trim().toLowerCase();
                const workLocation = workLocationFilter.value.toLowerCase();
                const verification = verificationFilter.value.toLowerCase();

                document.querySelectorAll('.user-card').forEach(card => {
                    const name = (card.dataset.name || '').toLowerCase();
                    const email = (card.dataset.email || '').toLowerCase();
                    const phone = (card.dataset.phone || '').toLowerCase();
                    const cardWorkLocation = (card.dataset.workLocation || '').toLowerCase();
                    const cardVerification = (card.dataset.verification || '').toLowerCase();

                    let visible = true;

                    // Search filter
                    if (query && !(name.includes(query) || email.includes(query) || phone.includes(query))) {
                        visible = false;
                    }

                    // Work location filter
                    if (workLocation && cardWorkLocation !== workLocation) {
                        visible = false;
                    }

                    // Verification filter
                    if (verification && cardVerification !== verification) {
                        visible = false;
                    }

                    card.style.display = visible ? 'block' : 'none';
                });
            }

            searchInput.addEventListener('input', applyFilters);
            workLocationFilter.addEventListener('change', applyFilters);
            verificationFilter.addEventListener('change', applyFilters);
        })();

        // Update Verification Function
        function updateVerification(userId) {
            const card = document.querySelector(`[data-user-id="${userId}"]`);
            const selectElement = card.querySelector('.verification-select');
            const newStatus = selectElement.value;
            const updateBtn = card.querySelector('.update-btn');
            const statusBadge = card.querySelector('.verification-status');
            
            // Disable button during update
            updateBtn.disabled = true;
            updateBtn.textContent = 'جاري التحديث...';
            
            fetch(`/admin/users/${userId}/update-verification`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    verification_status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update status badge
                    statusBadge.className = `verification-status ${newStatus}`;
                    const statusText = {
                        'pending': '⏳ قيد الانتظار',
                        'verified': '✓ موثق',
                        'rejected': '✗ مرفوض'
                    };
                    statusBadge.textContent = statusText[newStatus];
                    
                    // Update card data attribute
                    card.dataset.verification = newStatus;
                    
                    // Show success notification
                    showNotification('تم تحديث حالة التحقق بنجاح', 'success');
                } else {
                    showNotification('حدث خطأ أثناء التحديث', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ في الاتصال', 'error');
            })
            .finally(() => {
                // Re-enable button
                updateBtn.disabled = false;
                updateBtn.textContent = 'تحديث';
            });
        }

        function showNotification(message, type) {
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
                font-weight: 600;
            `;
            
            document.body.appendChild(notification);
            
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
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mouaz\Desktop\blog\reel_cart\resources\views/admin/vendors.blade.php ENDPATH**/ ?>