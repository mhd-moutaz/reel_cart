<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title><?php echo $__env->yieldContent('title', 'إدارة - لوحة التحكم'); ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-styles.css')); ?>">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div style="display:flex; align-items:center; gap:12px;">
            <!-- mobile toggle (visible on small screens) -->
            <button id="mobileSidebarToggle" class="sidebar-toggle" aria-label="فتح القائمة">☰</button>
            <h1>🏪 لوحة تحكم المتجر</h1>
        </div>

        <div class="user-info">
            <span><?php echo e(Auth::user()->name ?? 'المدير'); ?></span>
            <form action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn">🚪 تسجيل الخروج</button>
            </form>
        </div>
    </nav>

    <div class="layout">
        <!-- SIDEBAR -->
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">✅ <?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="<?php echo e(asset('js/admin-scripts_dashboard.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\mouaz\Desktop\blog\reel_cart\resources\views/admin/layouts/admin-layout.blade.php ENDPATH**/ ?>