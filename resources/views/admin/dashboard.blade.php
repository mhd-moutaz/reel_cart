@extends('admin.layouts.admin-layout')

@section('title', 'لوحة التحكم - الرئيسية')

@section('content')
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
            <div class="number">{{ $vendors->count();}}</div>
        </div>

        <div class="stat-card">
            <div class="icon">👥</div>
            <h3>المستخدمين</h3>
            <div class="number">{{ $clients->count(); }}</div>
        </div>

        <div class="stat-card">
            <div class="icon">👕</div>
            <h3>المنتجات</h3>
            <div class="number">{{ $products->count(); }}</div>
        </div>

        <div class="stat-card">
            <div class="icon">🏪</div>
            <h3>المحلات</h3>
            <div class="number">{{ $stores->count() ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="icon">📦</div>
            <h3>الطلبات</h3>
            <div class="number">{{ $orders->count(); }}</div>
        </div>
    </div>
@endsection
