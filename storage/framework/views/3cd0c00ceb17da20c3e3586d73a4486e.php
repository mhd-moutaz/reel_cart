<?php $__env->startSection('title', 'إدارة المستخدمين - لوحة التحكم'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/users-styles.css')); ?>">
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

        <select class="filter-select" id="roleFilter">
            <option value="">كل الصلاحيات</option>
            <option value="user">user</option>
            <option value="admin">admin</option>
            <option value="superadmin">superadmin</option>
        </select>

        <select class="filter-select" id="statusFilter">
            <option value="">حالة الحساب</option>
            <option value="active">مفعل</option>
            <option value="inactive">غير مفعل</option>
        </select>
    </div>

    <!-- Users Grid -->
    <div class="addresses-grid users-grid">
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="address-card user-card <?php echo e($u->is_active ?? false ? 'default active' : 'inactive'); ?>"
                data-name="<?php echo e(strtolower($u->user->name)); ?>" data-email="<?php echo e(strtolower($u->email)); ?>"
                data-role="<?php echo e(strtolower($u->role ?? '')); ?>">

                

                <div class="address-header user-header">
                    <div class="address-icon avatar-wrapper">
                        <?php if(!empty($u->avatar)): ?>
                            <img src="<?php echo e(asset('storage/' . $u->avatar)); ?>" alt="<?php echo e($u->name); ?>" class="avatar-img">
                        <?php else: ?>
                            <div class="avatar-fallback"><?php echo e(strtoupper(substr($u->name ?? '-', 0, 1))); ?></div>
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
                        <span class="address-label">أنشئ في:</span>
                        <span class="address-value"><?php echo e(optional($u->created_at)->format('Y-m-d') ?? '-'); ?></span>
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
        (function() {
            const searchInput = document.getElementById('searchInput');
            const roleFilter = document.getElementById('roleFilter');
            const statusFilter = document.getElementById('statusFilter');

            function applyFilters() {
                const q = (searchInput.value || '').trim().toLowerCase();
                const role = roleFilter.value;
                const status = statusFilter.value;

                document.querySelectorAll('.user-card').forEach(card => {
                    const name = (card.dataset.name || '').toLowerCase();
                    const email = (card.dataset.email || '').toLowerCase();
                    const cardRole = (card.dataset.role || '').toLowerCase();
                    const isActive = card.classList.contains('active');

                    let visible = true;

                    if (q && !(name.includes(q) || email.includes(q))) visible = false;
                    if (role && cardRole !== role.toLowerCase()) visible = false;
                    if (status) {
                        if (status === 'active' && !isActive) visible = false;
                        if (status === 'inactive' && isActive) visible = false;
                    }

                    card.style.display = visible ? 'block' : 'none';
                });
            }

            searchInput.addEventListener('input', applyFilters);
            roleFilter.addEventListener('change', applyFilters);
            statusFilter.addEventListener('change', applyFilters);
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mouaz\Desktop\blog\reel_cart\resources\views/admin/users.blade.php ENDPATH**/ ?>