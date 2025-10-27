@extends('admin.layouts.app')

@section('content')
<div class="card mx-auto shadow-sm rounded-4" style="max-width: 700px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between">
            <h5 class="card-title fw-bold text-primary mb-0">جزئیات تیکت</h5>
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
        </div>
        <hr>

        <p><strong>کاربر:</strong> {{ $ticket->user->name }}</p>
        <p><strong>عنوان:</strong> {{ $ticket->title }}</p>
        <p><strong>توضیحات:</strong></p>
        <p>{!! nl2br($ticket->description) !!}</p>

        @if($ticket->attachment_path)
        <p><strong>فایل پیوست:</strong>
            <a href="{{ asset('storage/'.$ticket->attachment_path) }}" target="_blank" class="text-decoration-none text-primary">
                مشاهده
            </a>
        </p>
        @endif

        @if($ticket->admin1_reason || $ticket->admin2_reason)
        <div class="mt-4 p-3 bg-light rounded-3 shadow-sm">
            <h6 class="fw-bold text-secondary mb-2">دلایل مدیران</h6>

            @if($ticket->admin1_reason)
            <div class="mb-2 p-2 bg-white rounded-2">
                <div class="d-flex justify-content-between align-items-center">
                    <strong>دلیل Admin1:</strong>
                    @if($ticket->status === App\Enums\TicketStatus::RejectedByAdmin1->value)
                        <span class="badge bg-danger">رد</span>
                    @else
                        <span class="badge bg-success">تایید</span>
                    @endif
                </div>
                <p class="mb-0">{{ $ticket->admin1_reason }}</p>
            </div>
            @endif

            @if($ticket->admin2_reason)
            <div class="mb-2 p-2 bg-white rounded-2">
                <div class="d-flex justify-content-between align-items-center">
                    <strong>دلیل Admin2:</strong>
                    @if($ticket->status === App\Enums\TicketStatus::RejectedByAdmin2->value)
                        <span class="badge bg-danger">رد</span>
                    @else
                        <span class="badge bg-success">تایید</span>
                    @endif
                </div>
                <p class="mb-0">{{ $ticket->admin2_reason }}</p>
            </div>
            @endif

        </div>
        @endif

        @php
            $admin = auth()->user();
        @endphp

        @if(
            ($admin->is_admin_level == 1 && $ticket->status == 'submitted') ||
            ($admin->is_admin_level == 2 && $ticket->status == 'approved_by_admin1')
        )
            <div class="d-flex gap-2 mt-3">
                <button class="btn btn-success shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#statusModal" data-status="approve">تأیید</button>
                <button class="btn btn-danger shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#statusModal" data-status="reject">رد</button>
            </div>
        @endif
    </div>
</div>

<!-- Modal تغییر وضعیت -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-sm rounded-4">
      <form id="statusForm" method="POST">
        @csrf
        <div class="modal-header bg-light">
          <h5 class="modal-title fw-bold">دلیل وضعیت</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <textarea name="reason" class="form-control rounded-3 shadow-sm" rows="3" placeholder="دلیل را بنویسید" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary shadow-sm fw-bold">ارسال</button>
          <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">لغو</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
const statusModal = document.getElementById('statusModal');
statusModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const status = button.getAttribute('data-status');
    const form = document.getElementById('statusForm');

    if(status === 'approve'){
        form.action = "{{ route('admin.tickets.approve', $ticket) }}";
    } else {
        form.action = "{{ route('admin.tickets.reject', $ticket) }}";
    }
});
</script>
@endsection

@section('styles')
<style>
.card, textarea, button, input, label {
    font-family: Vazir, sans-serif;
}

button.btn:hover {
    transform: translateY(-2px);
    transition: all 0.2s;
}

a.text-info:hover {
    text-decoration: underline;
    transition: all 0.2s;
}

</style>
@endsection
