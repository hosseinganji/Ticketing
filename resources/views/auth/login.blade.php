@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-sm border-0" style="max-width: 420px; width: 100%;">
            <div class="card-body p-4">
                <h4 class="text-center mb-4 fw-bold text-primary">ورود به سامانه</h4>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">ایمیل</label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg"
                            placeholder="example@mail.com" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg"
                            placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-2">ورود</button>
                </form>

                <div class="text-center mt-4">
                    <span class="text-muted">کاربر جدید هستید؟</span>
                    <a href="{{ route('register') }}" class="fw-semibold">ثبت‌نام کنید</a>
                </div>
            </div>
        </div>

    </div>
@endsection
