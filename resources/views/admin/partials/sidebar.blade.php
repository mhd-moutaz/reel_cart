<!-- resources/views/admin/partials/sidebar.blade.php -->
<aside id="sidebar" class="sidebar" aria-label="القائمة الجانبية">
    <div class="sidebar-header">
        <h2>📊 القائمة الرئيسية</h2>
    </div>

    <button class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="طي/فتح الشريط">☰</button>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon">🏠</span>
                <span class="text">لوحة التحكم</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.stores') }}" class="{{ request()->routeIs('admin.stores') ? 'active' : '' }}">
                <span class="icon">🏪</span>
                <span class="text">المتاجر</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <span class="icon">👥</span>
                <span class="text">المستخدمين</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.vendors') ?? '#' }}">
                <span class="icon">👥</span>
                <span class="text">البائعين</span>
            </a>
        </li>

        <li>
            {{-- <a href="{{ route('admin.designs') ?? '#' }}"> --}}
                <span class="icon">👕</span>
                <span class="text">التصميمات</span>
            </a>
        </li>
        <li>
            {{-- <a href="{{ route('admin.orders.index') ?? '#' }}"> --}}
                <span class="icon">📦</span>
                <span class="text">الطلبات</span>
            </a>
        </li>
        <li>
            {{-- <a href="{{ route('admin.wallets.index') }}"
                class="{{ request()->routeIs('admin.wallets.*') ? 'active' : '' }}">
                <span class="icon">💰</span>
                <span class="text">المحافظ</span>
            </a> --}}
        </li>
        {{--
        <li>
            <a href="{{ route('admin.orders.index') ?? '#' }}">
                <span class="icon">🛒</span>
                <span class="text">الطلبات</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.users.index') ?? '#' }}">
                <span class="icon"></span>
                <span class="text">العملاء</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.profile') ?? '#' }}"
                class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <span class="icon">👤</span>
                <span class="text">الملف الشخصي</span>
            </a>
        </li>

         --}}
    </ul>
</aside>
