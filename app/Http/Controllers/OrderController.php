<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Concession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class OrderController extends Controller
{
    public function index()
    {
        $concessions = Concession::all();
        $orders = Order::all();
        return view('order', compact('concessions', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concessions' => 'required|array',
            'send_to_kitchen_time' => 'required|date',
        ]);

        Order::create([
            'concessions' => $request->concessions,
            'send_to_kitchen_time' => $request->send_to_kitchen_time,
            'status' => 'Pending',
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function sendToKitchen(Order $order)
    {
        $order->update(['status' => 'In-Progress']);
        return redirect()->route('kitchen.index')->with('success', 'Order sent to kitchen.');
    }

    public function kitchen()
    {
        $orders = Order::where('status', '!=', 'Completed')->get();
        $concessions = Concession::all(); 
        return view('kitchen', compact('orders', 'concessions')); 
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:Pending,In-Progress,Completed']);
        $order->update(['status' => $request->status]);
        return redirect()->route('kitchen.index')->with('success', 'Order status updated.');
    }
}