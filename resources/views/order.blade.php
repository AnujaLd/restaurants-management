<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
</head>
<body>
    <h1>Create Order</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <label for="concessions">Select Concessions:</label>
        <select name="concessions[]" id="concessions" multiple required>
            @foreach($concessions as $concession)
                <option value="{{ $concession->id }}">{{ $concession->name }} - ${{ $concession->price }}</option>
            @endforeach
        </select>
        <br>
        <label for="send_to_kitchen_time">Send to Kitchen Time:</label>
        <input type="datetime-local" name="send_to_kitchen_time" id="send_to_kitchen_time" required>
        <br>
        <button type="submit">Create Order</button>
    </form>

    <h1>Orders</h1>
    <table>
        <thead>
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
                    <td>{{ $order->status }}</td>
                    <td>
                        @if($order->status === 'Pending')
                            <form action="{{ route('orders.send', $order) }}" method="POST">
                                @csrf
                                <button type="submit">Send to Kitchen</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>