@extends('layouts.app')

@section('content')
<div class="card mx-auto" style="max-width: 600px;">
    <div class="card-body">
        <h5 class="card-title mb-3">ایجاد تیکت جدید</h5>

        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>عنوان</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>توضیحات</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label>فایل پیوست (PDF یا تصویر)</label>
                <input type="file" name="file" class="form-control" accept=".pdf,image/*" required>
            </div>

            <button class="btn btn-success w-100">ثبت تیکت</button>
        </form>
    </div>
</div>
@endsection
