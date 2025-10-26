@extends('layouts.app')

@section('content')
<div class="card mx-auto" style="max-width: 400px;">
    <div class="card-body">
        <h5 class="card-title text-center mb-4">ثبت‌نام کاربر</h5>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label>نام</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>ایمیل</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>رمز عبور</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>تکرار رمز عبور</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-success w-100">ثبت‌نام</button>
        </form>
    </div>
</div>
@endsection
