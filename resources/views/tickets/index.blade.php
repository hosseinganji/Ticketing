@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>تیکت‌های من</h4>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">+ تیکت جدید</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->title }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td>{{ verta($ticket->created_at)->format('Y/m/d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">تیکتی وجود ندارد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
