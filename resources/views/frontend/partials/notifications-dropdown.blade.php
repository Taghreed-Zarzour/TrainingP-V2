@php
    $userId = Auth::id();
    $cacheKey = 'user_notifications_' . $userId;
    $notifications = Cache::remember($cacheKey, 60, function() use ($userId) {  // تغيير المدة من 1 إلى 60 ثانية
        return Auth::user()
            ->notifications()
            ->latest()
            ->limit(10)  // زيادة عدد الإشعارات المعروضة
            ->get(['id', 'data', 'created_at', 'read_at']);
    });
    
    $unreadCount = Auth::user()->unreadNotifications()->count();
@endphp
<li class="nav-item dropdown notifications-dropdown">
    <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ asset('images/icons/notification.svg') }}" alt="Notifications" />
        @if($unreadCount > 0)
            <span class="notification-badge">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
        @endif
    </a>
    
    <ul class="dropdown-menu dropdown-menu-end notifications-list" aria-labelledby="notificationDropdown">
        <li class="notifications-header d-flex justify-content-between align-items-center">
            <span>الإشعارات</span>
            @if($unreadCount > 0)
                <a href="#" class="mark-all-read" data-url="{{ route('notifications.markAllRead') }}">تعريف الكل كمقروء</a>
            @endif
        </li>
        
        <li>
            <div class="notifications-container">
                @if($notifications->isEmpty())
                    <div class="no-notifications text-center py-3">
                        <p>لا توجد إشعارات</p>
                    </div>
                @else
                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}" data-id="{{ $notification->id }}">
                            <div class="notification-content">
                                <div class="notification-message">
                                    {{ $notification->data['message'] ?? 'إشعار جديد' }}
                                </div>
                                <div class="notification-time">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                                
                                @if(isset($notification->data['type']))
                                    @switch($notification->data['type'])
                                        @case('enrollmentRequest')
                                            <div class="notification-actions mt-2">
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
                                            @break
                                            
                                        @case('enrollmentRejected')
                                            @if(isset($notification->data['rejection_reason']))
                                                <div class="notification-reason mt-2">
                                                    <small class="text-muted">السبب: {{ $notification->data['rejection_reason'] }}</small>
                                                </div>
                                            @endif
                                            @break
                                            
                                        @case('enrollmentAccepted')
                                            <div class="notification-link mt-2">
                                              {{-- {{ route('trainings.show', $notification->data['program_id']) }} --}}
                                                <a href="" class="btn btn-sm btn-outline-primary">
                                                    عرض البرنامج
                                                </a>
                                            </div>
                                            @break
                                    @endswitch
                                @endif
                            </div>
                            
                            @if(!$notification->read_at)
                                <div class="mark-as-read" data-url="{{ route('notifications.markAsRead', $notification->id) }}">
                                    <img src="{{ asset('images/icons/check.svg') }}" alt="Mark as read">
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </li>
        
        <li>
            <a href="{{ route('notifications.index') }}" class="view-all-notifications text-center py-2">
                عرض جميع الإشعارات
            </a>
        </li>
    </ul>
</li>
<script>
$(document).ready(function() {
    // تسجيل FCM Token
    function registerFCMToken() {
        // الحصول على FCM Token من Firebase SDK
        if (typeof firebase !== 'undefined') {
            const messaging = firebase.messaging();
            
            messaging.getToken().then(function(token) {
                console.log('FCM Token:', token);
                
                // إرسال Token إلى الخادم
                $.post('{{ route("notifications.fcmToken") }}', {
                    token: token,
                    _token: '{{ csrf_token() }}'
                })
                .done(function(response) {
                    console.log('FCM Token saved successfully');
                })
                .fail(function(error) {
                    console.error('Failed to save FCM Token:', error);
                });
            }).catch(function(error) {
                console.error('Error getting FCM Token:', error);
            });
            
            // التعامل مع الإشعارات الواردة
            messaging.onMessage(function(payload) {
                console.log('Message received:', payload);
                
                // تحديث قائمة الإشعارات
                updateNotificationsDropdown([payload.data]);
                
                // عرض إشعار المتصفح
                if (Notification.permission === 'granted') {
                    const notification = payload.notification;
                    new Notification(notification.title, {
                        body: notification.body,
                        icon: notification.icon || '/favicon.ico'
                    });
                }
            });
        }
    }
    
    // استدعاء دالة التسجيل عند تحميل الصفحة
    registerFCMToken();
    
    // دالة لتحديث قائمة الإشعارات
    function updateNotificationsDropdown(notifications) {
        // تحديث عدد الإشعارات غير المقروءة
        const currentCount = parseInt($('.notification-badge').text()) || 0;
        const newCount = currentCount + notifications.length;
        
        if (newCount > 0) {
            $('.notification-badge').text(newCount > 99 ? '99+' : newCount).show();
        } else {
            $('.notification-badge').hide();
        }
        
        // تحديث قائمة الإشعارات
        const container = $('.notifications-container');
        const noNotifications = container.find('.no-notifications');
        
        if (noNotifications.length > 0) {
            noNotifications.remove();
        }
        
        notifications.forEach(function(notification) {
            const notificationHtml = `
                <div class="notification-item unread" data-id="${notification.id}">
                    <div class="notification-content">
                        <div class="notification-message">
                            ${notification.message || 'إشعار جديد'}
                        </div>
                        <div class="notification-time">
                            الآن
                        </div>
                    </div>
                    <div class="mark-as-read" data-url="{{ route('notifications.markAsRead', '__ID__') }}".replace('__ID__', notification.id)">
                        <img src="{{ asset('images/icons/check.svg') }}" alt="Mark as read">
                    </div>
                </div>
            `;
            
            container.prepend(notificationHtml);
        });
    }
});
</script>
<style>
/* إشعارات الهيدر */
.notifications-dropdown .notification-badge {
    position: absolute;
    top: 7px;
    right: 7px;
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}

.notifications-list {
    width: 350px;
    max-height: 400px;
    overflow-y: auto;
    padding: 0;
}

.notifications-header {
    padding: 10px 15px;
    border-bottom: 1px solid #eee;
    font-weight: bold;
}

.notifications-header .mark-all-read {
    font-size: 12px;
    color: #003090;
    text-decoration: none;
}

.notifications-container {
    max-height: 300px;
    overflow-y: auto;
}

.notification-item {
    padding: 12px 15px;
    border-bottom: 1px solid #f0f0f0;
    position: relative;
    display: flex;
    justify-content: space-between;
}

.notification-item.unread {
    background-color: #f8f9fa;
    border-right: 3px solid #003090;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-content {
    flex: 1;
}

.notification-message {
    font-weight: 500;
    margin-bottom: 5px;
}

.notification-time {
    font-size: 12px;
    color: #6c757d;
}

.notification-actions {
    display: flex;
    gap: 5px;
}

.notification-item .mark-as-read {
    cursor: pointer;
    padding: 5px;
    margin-left: 5px;
    opacity: 0.7;
}

.notification-item .mark-as-read:hover {
    opacity: 1;
}

.view-all-notifications {
    display: block;
    padding: 10px;
    text-align: center;
    color: #003090;
    text-decoration: none;
    border-top: 1px solid #eee;
    font-weight: 500;
}

.no-notifications {
    padding: 20px;
    color: #6c757d;
}
</style>