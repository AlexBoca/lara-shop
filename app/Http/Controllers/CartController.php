<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\Order;
use App\Product;
use App\User;

class CartController extends Controller
{
    public function index()
    {
        if (session('cart')->isNotEmpty()) {

            $items = Product::all()->whereNotIn('id', session('cart'));
        } else {
            $items = Product::all();
        }
        return view('index', ['items' => $items]);
    }

    public function show()
    {
        $items = [];
        if (session('cart')->isNotEmpty()) {
            $items = Product::all()->whereIn('id', session('cart'));
        }

        return view('cart', compact('items'));

    }

    public function store($id)
    {
        if (!empty($id)) {
            session('cart')->push($id);
        }
        return redirect()->back();

    }


    public function destroy()
    {
        session()->remove('cart');
        return redirect()->route('cart.index');
    }

    public function delete($id)
    {
        $cart = session('cart');
        $cart->forget($cart->search($id));

        return redirect()->route('cart.show');
    }

    public function email()
    {
        $validateData = request()->validate([
            'email' => 'required|email',
            'comments' => 'max:500',
        ]);
        if (session('cart')->isEmpty()) {
            return redirect()->route('index');
        }
        $order = [];
        $order['email'] = $validateData['email'];
        $order['comments'] = $validateData['comments'];
        $cart = Product::whereIn('id', session('cart'))->get();
        $order['cart'] = $cart;
        $user = new User(['email' => env('MANAGER_EMAIL')]);

        Mail::to($user)->send(new Order($order));
        return redirect()->back();
    }
}