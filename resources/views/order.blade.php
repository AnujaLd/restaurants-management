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
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-primary"><i class="fas fa-utensils"></i> Create Order</h1>
        <form id="orderForm" class="border p-4 shadow-sm bg-light">
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

        <h1 class="mt-5 text-success"><i class="fas fa-clipboard-list"></i> Orders</h1>
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
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
    </script>
</body>
</html>