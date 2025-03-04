<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

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
}
