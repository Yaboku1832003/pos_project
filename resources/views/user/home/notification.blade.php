@extends('user.layouts.master')

@section('content')
    <section class="section bg-light">
        <div class="container">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <div class="d-flex justify-content-end align-items-center">
                    <a href="javascript:history.back()" class="btn btn-sm fs-2"><i class="fa-solid fa-xmark"></i></a>
                </div>
                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        New Notifications
                        <span class="badge bg-primary">{{ $unreadCount }}</span>
                    </h5>
                    <button id="markAllReadBtn" class="btn btn-link text-decoration-none p-0">Mark all as read</button>
                </div>

                {{-- Notifications List --}}
                <div class="list-group list-group-flush">
                    @if($orders->count()>0)
@foreach ($orders as $notification)
                        <a href="javascript:void(0);"
                            class="list-group-item list-group-item-action px-3 py-3 notification-item {{ $notification->readStatus == 0 ? 'bg-light' : 'bg-white' }}"
                            data-order="{{ $notification->order_code }}">

                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-start">
                                    {{-- Rounded Sheet Icon --}}
                                    <span class="d-flex justify-content-center align-items-center me-3"
                                        style="width:50px; height:50px; border-radius:50%; background-color: {{ $notification->status == 1 ? '#28a745' : '#dc3545' }};">
                                        <i class="bi bi-file-text-fill" style="font-size:24px; color:white;"></i>
                                    </span>

                                    {{-- Notification Text --}}
                                    <div>
                                        <p class="mb-1 fs-6 fs-md-5 fs-lg-4">
                                            <strong>Your order {{ $notification->order_code }}</strong>
                                        </p>
                                        <p class="mb-0">
                                            <span
                                                class="{{ $notification->status == '1' ? 'text-success' : 'text-danger' }}">
                                                {{ $notification->status == '1' ? 'has been approved' : 'has been declined' }}
                                            </span> by the admin team.
                                            {{ $notification->status == '1' ? 'Thank you for your order.' : 'We apologize for the inconvenience. Our support team will contact you regarding the refund.' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-muted small ms-3">{{ $notification->updated_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                    @else
                    <div class="text-center py-4 text-muted">
    <i class="bi bi-bell-slash-fill" style="font-size: 2rem;"></i>
    <h6 class="mt-2 mb-0" style="font-weight: 500;">No new notifications</h6>
    <p class="small text-secondary mb-0">You’re all caught up! Check back later for updates.</p>
</div>
@endif
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#markAllReadBtn').click(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "/user/notifications/mark-all-read",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if(res.success){
                           location.reload();
                        }
                        console.log('success'); // won't reach if dd fires
                    },
                    error: function(err) {
                        console.log('error', err);
                    }
                });
            });
            $('.notification-item').click(function(e) {
        e.preventDefault();

        let orderCode = $(this).data('order'); // get order_code
        let $thisItem = $(this);

        $.ajax({
            url: "/user/notifications/mark-single-read",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                order_code: orderCode
            },
            success: function(res) {
                if(res.success){
                    $thisItem.removeClass('bg-light').addClass('bg-white');
                    location.reload();
                }
            },
            error: function(err) {
                console.log('error', err);
            }
        });
    });
        });
    </script>
@endsection
