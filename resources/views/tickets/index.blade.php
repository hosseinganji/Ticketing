@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-primary">تیکت‌های من</h4>
    <a href="{{ route('tickets.create') }}" class="btn btn-success shadow-sm">+ تیکت جدید</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>عنوان</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                    <tr class="align-middle">
                        <td>
                            {{ $ticket->title }}
                        </td>
                        <td>
                            <span class="badge
                                @if($ticket->status == 'draft') bg-secondary
                                @elseif($ticket->status == 'submitted') bg-primary
                                @elseif(str_contains($ticket->status, 'approved')) bg-success
                                @elseif(str_contains($ticket->status, 'rejected')) bg-danger
                                @elseif($ticket->status == 'sent_to_webservice') bg-info
                                @else bg-dark
                                @endif">
                                {{ $ticket->status_label }}
                            </span>
                        </td>
                        <td class="text-muted">{{ verta($ticket->created_at)->format('H:i - Y/m/d') }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#ticketModal{{ $ticket->id }}">
                                جزئیات
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="ticketModal{{ $ticket->id }}" tabindex="-1" aria-labelledby="ticketModalLabel{{ $ticket->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title" id="ticketModalLabel{{ $ticket->id }}">جزئیات تیکت</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>کاربر:</strong> {{ $ticket->user->name }}</p>
                                    <p><strong>عنوان:</strong> {{ $ticket->title }}</p>
                                    <p><strong>توضیحات:</strong></p>
                                    <p>{!! nl2br($ticket->description) !!}</p>
                                    @if($ticket->attachment_path)
                                        <p><strong>فایل پیوست:</strong>
                                            <a href="{{ asset('storage/'.$ticket->attachment_path) }}" target="_blank" class="link-primary">مشاهده</a>
                                        </p>
                                    @endif
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">بستن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">تیکتی وجود ندارد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .badge {
        font-size: 0.9rem;
        padding: 0.45em 0.65em;
        border-radius: 0.5rem;
    }
    a {
        font-family: Vazir, sans-serif;
    }
    .modal-content {
        border-radius: 15px;
    }
</style>
@endsection
