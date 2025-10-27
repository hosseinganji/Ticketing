@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-sm border-0" style="max-width: 450px; width: 100%;">
            <div class="card-body p-4">
                <h4 class="text-center mb-4 fw-bold text-success">ثبت‌نام کاربر جدید</h4>


                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">نام</label>
                        <input type="text" id="name" name="name" class="form-control form-control-lg"
                            placeholder="نام و نام خانوادگی" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">ایمیل</label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg"
                            placeholder="example@mail.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg"
                            placeholder="••••••••" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">تکرار رمز عبور</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control form-control-lg" placeholder="تکرار رمز عبور" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 mt-2">ثبت‌نام</button>
                </form>

                <div class="text-center mt-4">
                    <span class="text-muted">قبلاً ثبت‌نام کرده‌اید؟</span>
                    <a href="{{ route('login') }}" class="fw-semibold">ورود به سامانه</a>
                </div>
            </div>
        </div>

    </div>
@endsection
