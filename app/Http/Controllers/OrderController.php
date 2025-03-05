<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function storeOrder(Request $request)
    {
        $validatedData = $request->validate([
            'coffee_id' => 'required|integer',
        ]);

        $order = new Orders();
        $order->user_id = auth()->user()->id;
        $order->coffee_id = $request->coffee_id;
        $order->quantity = 1;
        $order->save();

        return redirect()->route('dashboard')->with('success', 'Order created successfully.');
    }

    public function myOrder()
    {
        $orders = Orders::with('coffee')->where('user_id', auth()->user()->id)->get();

    //    return response()->json($orders);
        return Inertia::render('user/Order', [
            'orders' => $orders,
        ]);
    }
}
