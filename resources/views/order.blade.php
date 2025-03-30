<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
        }
        .form-section, .table-section {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .form-section h1, .table-section h1 {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary, .btn-success, .btn-secondary {
            margin-right: 10px;
        }
        .thead-dark th {
            color: #ffffff;
            background-color: #343a40;
        }
        .badge-warning {
            background-color: #ffc107;
        }
        .badge-success {
            background-color: #28a745;
        }
        .form-section, .table-section {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .form-section:hover, .table-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 form-section">
                <h1 class="text-primary"><i class="fas fa-utensils"></i> Create Order</h1>
                <form id="orderForm">
                    @csrf
                    <div class="form-group">
                        <label for="concessions">Select Concessions:</label>
                        <select name="concessions[]" id="concessions" class="form-control" multiple required>
                            @foreach($concessions as $concession)
                                <option value="{{ $concession->id }}">{{ $concession->name }} - ${{ $concession->price }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="send_to_kitchen_time">Send to Kitchen Time:</label>
                        <input type="datetime-local" name="send_to_kitchen_time" id="send_to_kitchen_time" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create Order</button>
                </form>
            </div>
            <div class="col-md-6 table-section">
                <h1 class="text-success"><i class="fas fa-clipboard-list"></i> Orders</h1>
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Concessions</th>
                            <th>Send to Kitchen Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    @foreach($order->concessions as $concessionId)
                                        {{ $concessions->find($concessionId)->name }},
                                    @endforeach
                                </td>
                                <td>{{ $order->send_to_kitchen_time }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status === 'Pending' ? 'warning' : 'success' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->status === 'Pending')
                                        <button class="btn btn-success send-to-kitchen" data-id="{{ $order->id }}">
                                            <i class="fas fa-paper-plane"></i> Send to Kitchen
                                        </button>
                                        <button class="btn btn-secondary automate-send-to-kitchen" data-id="{{ $order->id }}" data-time="{{ $order->send_to_kitchen_time }}">
                                            <i class="fas fa-clock"></i> Automate
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    $('#orderForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('orders.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.success,
                }).then(() => {
                    location.reload();
                });
            }
        });
    });

    $('.send-to-kitchen').on('click', function() {
        let orderId = $(this).data('id');
        $.ajax({
            url: `/orders/send/${orderId}`,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.success,
                }).then(() => {
                    location.reload();
                });
            }
        });
    });

    $('.automate-send-to-kitchen').on('click', function() {
        let orderId = $(this).data('id');
        let sendTime = new Date($(this).data('time')).getTime();
        let currentTime = new Date().getTime();
        let timeDifference = sendTime - currentTime;

        Swal.fire({
            icon: 'info',
            title: 'Automation Initiated',
            text: 'This order will be sent to the kitchen automatically at the specified time.',
        });

        if (timeDifference > 0) {
            setTimeout(() => {
                $.ajax({
                    url: `/orders/send/${orderId}`,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }, timeDifference);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Send to Kitchen Time has already passed.',
            });
        }
    });
</script>

</body>
</html>