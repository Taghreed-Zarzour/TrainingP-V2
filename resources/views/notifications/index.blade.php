@extends('frontend.layouts.master')


@section('title', 'الإشعارات')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">الإشعارات</h3>
                    @if(Auth::user()->unreadNotifications()->count() > 0)
                        <form action="{{ route('notifications.markAllRead') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary">تعريف الكل كمقروء</button>
                        </form>
                    @endif
                </div>
                <div class="card-body">
                    <div class="notifications-list">
                        @if($notifications->isEmpty())
                            <div class="text-center py-4">
                                <p>لا توجد إشعارات</p>
                            </div>
                        @else
                            @foreach($notifications as $notification)
                                <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }} mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between">
                                        <div class="notification-message">
                                            <strong>{{ $notification->data['message'] ?? 'إشعار جديد' }}</strong>
                                            <div class="text-muted small">{{ $notification->created_at->diffForHumans() }}</div>
                                            
                                            @if(isset($notification->data['rejection_reason']))
                                                <p class="mt-2">السبب: {{ $notification->data['rejection_reason'] }}</p>
                                            @endif
                                            
                                            @if(isset($notification->data['type']) && $notification->data['type'] === 'enrollmentRequest')
                                                <div class="notification-actions mt-3">
                                                    <form action="{{ route('participants.handleAction', ['program' => $notification->data['program_id'], 'participant' => $notification->data['trainee_id']]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="accept">
                                                        <input type="hidden" name="is_org" value="{{ $notification->data['is_org'] }}">
                                                        <button type="submit" class="btn btn-sm btn-success">قبول</button>
                                                    </form>
                                                    <form action="{{ route('participants.handleAction', ['program' => $notification->data['program_id'], 'participant' => $notification->data['trainee_id']]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="reject">
                                                        <input type="hidden" name="is_org" value="{{ $notification->data['is_org'] }}">
                                                        <button type="submit" class="btn btn-sm btn-danger">رفض</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if(!$notification->read_at)
                                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">تعريف كمقروء</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // تحديث الإشعارات كل 30 ثانية
        setInterval(function() {
            $.ajax({
                url: '{{ route('notifications.refresh') }}',
                method: 'GET',
                success: function(data) {
                    // تحديث عدد الإشعارات غير المقروءة في الهيدر
                    let unreadCount = data.filter(n => !n.read_at).length;
                    let badge = $('.notification-badge');
                    if (unreadCount > 0) {
                        badge.text(unreadCount > 99 ? '99+' : unreadCount).show();
                    } else {
                        badge.hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error refreshing notifications:", error);
                }
            });
        }, 30000);
    });
</script>
@endsection