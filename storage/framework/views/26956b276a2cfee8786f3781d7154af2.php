<!-- resources/views/admin/partials/sidebar.blade.php -->
<aside id="sidebar" class="sidebar" aria-label="القائمة الجانبية">
    <div class="sidebar-header">
        <h2>📊 القائمة الرئيسية</h2>
    </div>

    <button class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="طي/فتح الشريط">☰</button>

    <ul class="sidebar-menu">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <span class="icon">🏠</span>
                <span class="text">لوحة التحكم</span>
            </a>
        </li>

        <li>
            
                <span class="icon">📍</span>
                <span class="text">العناوين</span>
            </a>
        </li>

        <li>
            <a href="<?php echo e(route('admin.users')); ?>" class="<?php echo e(request()->routeIs('admin.users') ? 'active' : ''); ?>">
                <span class="icon">👥</span>
                <span class="text">المستخدمين</span>
            </a>
        </li>

        <li>
            
                <span class="icon">⚙️</span>
                <span class="text">اعدادات التصميم</span>
            </a>
        </li>

        <li>
            
                <span class="icon">👕</span>
                <span class="text">التصميمات</span>
            </a>
        </li>
        <li>
            
                <span class="icon">📦</span>
                <span class="text">الطلبات</span>
            </a>
        </li>
        <li>
            
        </li>
        
    </ul>
</aside>
<?php /**PATH C:\Users\mouaz\Desktop\blog\reel_cart\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>