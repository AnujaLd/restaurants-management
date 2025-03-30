<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen</title>
</head>
<body>
    <h1>Kitchen Orders</h1>
    <table>
        <thead>
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
                        <form action="{{ route('kitchen.update', $order) }}" method="POST">
                            @csrf
                            <select name="status" required>
                                <option value="In-Progress" {{ $order->status === 'In-Progress' ? 'selected' : '' }}>In-Progress</option>
                                <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>