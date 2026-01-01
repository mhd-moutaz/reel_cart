<?php $__env->startSection('title', 'لوحة التحكم - الرئيسية'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header" style="background: linear-gradient(90deg,#2c3e50,#34495e);">
        <h2>لوحة التحكم — ملخص</h2>
        <div class="page-stats" style="display:flex; gap:12px;">
        </div>
    </div>

    <div class="welcome-card">
        <h2>🎉 مرحباً بك في لوحة التحكم</h2>
        <p>تم تسجيل الدخول بنجاح</p>
    </div>

    <div class="stats-grid">

        <div class="stat-card">
            <div class="icon">👥</div>
            <h3>الناشرين</h3>
            <div class="number"><?php echo e($vendors->count()); ?></div>
        </div>

        <div class="stat-card">
            <div class="icon">👥</div>
            <h3>المستخدمين</h3>
            <div class="number"><?php echo e($clients->count()); ?></div>
        </div>

        <div class="stat-card">
            <div class="icon">👕</div>
            <h3>المنتجات</h3>
            <div class="number"><?php echo e($products->count()); ?></div>
        </div>

        
        <div class="stat-card">
            <div class="icon">📦</div>
            <h3>الطلبات</h3>
            <div class="number"><?php echo e($orders->count()); ?></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mouaz\Desktop\blog\reel_cart\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>