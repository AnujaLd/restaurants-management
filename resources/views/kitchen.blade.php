<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #343a40;
        }
        .table {
            margin-bottom: 0;
        }
        .thead-dark th {
            background-color: #343a40;
            color: #ffffff;
        }
        .status-select {
            min-width: 150px;
        }
        .btn-update {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><i class="fas fa-utensils"></i> Kitchen Orders</h1>
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
                            <button class="btn btn-primary btn-update" data-order-id="{{ $order->id }}"><i class="fas fa-sync-alt"></i> Update</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('.btn-update').click(function() {
                var orderId = $(this).data('order-id');
                var newStatus = $(this).siblings('.status-select').val();

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