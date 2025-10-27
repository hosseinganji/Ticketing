@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-primary fw-bold">مدیریت تیکت‌ ها</h4>
</div>

<form id="bulkApproveForm" method="POST" action="{{ route('admin.tickets.bulk-approve') }}">
    @csrf
    <input type="hidden" name="reason" id="approveReason">

    <div class="card shadow-sm border-0">
        <div class="card-body p-3">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>کاربر</th>
                        <th>عنوان</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                    <tr>
                        <td>
                            <input type="checkbox" name="ticket_ids[]" value="{{ $ticket->id }}"
                                @if(!in_array($ticket->id, $editableTicketIds)) disabled @endif>
                        </td>

                        <td>{{ $ticket->user->name }}</td>
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
                        <td>
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-primary shadow-sm">جزئیات</a>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">هیچ تیکتی وجود ندارد</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <button type="button" class="btn btn-success mt-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#reasonModal">
                تأیید گروهی
            </button>
        </div>
    </div>
</form>

<div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow-sm rounded-3">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="reasonModalLabel">دلیل وضعیت</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
            </div>
            <div class="modal-body">
                <textarea name="reason" class="form-control rounded-3 shadow-sm" id="reasonText" rows="3" placeholder="دلیل را بنویسید"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-primary shadow-sm fw-bold" id="confirmReasonBtn">تأیید و ارسال</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('selectAll').addEventListener('click', function() {
    document.querySelectorAll('input[name="ticket_ids[]"]').forEach(cb => cb.checked = this.checked);
});

document.getElementById('confirmReasonBtn').addEventListener('click', function() {
    const reason = document.getElementById('reasonText').value.trim();
    if (!reason) {
        alert('لطفاً دلیل تأیید را وارد کنید.');
        return;
    }
    document.getElementById('approveReason').value = reason;
    document.getElementById('bulkApproveForm').submit();
});
</script>

<style>
    table, input, textarea, button, label {
        font-family: Vazir, sans-serif;
    }

    table.table-hover tbody tr:hover {
        background-color: #f1f7ff;
        transition: background 0.2s;
    }

    button.btn:hover, a.btn:hover {
        transform: translateY(-2px);
        transition: all 0.2s;
    }
</style>
@endsection
