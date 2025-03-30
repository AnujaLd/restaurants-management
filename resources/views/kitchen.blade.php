<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Kitchen Orders</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Concessions</th>
                    <th>Total Cost</th>
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
                        <td>${{ array_sum(array_map(fn($id) => $concessions->find($id)->price, $order->concessions)) }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <select name="status" class="form-control status-select" data-order-id="{{ $order->id }}">
                                <option value="In-Progress" {{ $order->status === 'In-Progress' ? 'selected' : '' }}>In-Progress</option>
                                <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('.status-select').change(function() {
                var orderId = $(this).data('order-id');
                var newStatus = $(this).val();

                $.ajax({
                    url: '{{ route('kitchen.update', '') }}/' + orderId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error updating the status.'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>