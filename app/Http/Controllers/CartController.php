<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $cart[] = [
            'event_id' => $validated['event_id'],
            'ticket_type' => $validated['ticket_type'],
            'quantity' => $validated['quantity'],
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.view')->with('success', 'Ticket added to cart.');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);

        return view('cart.view', compact('cart'));
    }

    public function updateCart(Request $request)
    {
        $cart = $request->input('cart', []);
        session(['cart' => $cart]);

        return redirect()->route('cart.view')->with('success', 'Cart updated successfully!');
    }

}
