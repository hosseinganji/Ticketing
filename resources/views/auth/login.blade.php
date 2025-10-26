@extends('layouts.app')

@section('content')
<div class="card mx-auto" style="max-width: 400px;">
    <div class="card-body">
        <h5 class="card-title text-center mb-4">ورود به سامانه</h5>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label>ایمیل</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>رمز عبور</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">ورود</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('register') }}">ثبت‌نام کاربر جدید</a>
        </div>
    </div>
</div>
@endsection
