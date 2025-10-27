@extends('layouts.app')

@section('content')
<div class="card mx-auto shadow-sm border-0" style="max-width: 600px; border-radius: 15px;">
    <div class="card-body p-4">
        <h5 class="card-title mb-4 text-primary fw-bold">ایجاد تیکت جدید</h5>

        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">عنوان</label>
                <input type="text" name="title" class="form-control rounded-3 shadow-sm" placeholder="عنوان تیکت را وارد کنید" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">توضیحات</label>
                <textarea name="description" class="form-control rounded-3 shadow-sm" rows="5" placeholder="توضیحات خود را وارد کنید" required></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">فایل پیوست (PDF یا تصویر)</label>
                <input type="file" name="file" class="form-control rounded-3 shadow-sm" accept=".pdf,image/*" required>
            </div>

            <button class="btn btn-success w-100 shadow-sm fw-bold" type="submit">
                ثبت تیکت
            </button>
        </form>
    </div>
</div>

<style>
    input, textarea, label, button {
        font-family: Vazir, sans-serif;
    }

    input:hover, textarea:hover, input:focus, textarea:focus {
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
        border-color: #0d6efd;
        transition: all 0.2s;
    }
    
    button.btn-success:hover {
        background-color: #28a745cc;
        transform: translateY(-2px);
        transition: all 0.2s;
    }
</style>
@endsection
