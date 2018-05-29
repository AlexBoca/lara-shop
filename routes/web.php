<?php

use Illuminate\Support\Facades\Route;

require_once __DIR__ . '/../bootstrap/common.php';

session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

Route::get('/', function () {
    if ($_SESSION['cart']) {
        $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
        $query = "SELECT * FROM products WHERE id NOT IN ($placeholders)";
        $items = conn($query, $_SESSION['cart'], true);
    } else {
        $query = "SELECT * FROM products";
        $items = conn($query, [], true);
    }
    return view('index', ['items' => $items]);
})->name('index');


Route::get('cart', function () {
    $items = [];
    if ($_SESSION['cart']) {
        $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
        $query = "SELECT * FROM  products WHERE id IN ($placeholders)";
        $items = conn($query, $_SESSION['cart'], true);
    }
    return view('cart', ['items' => $items]);
})->name('cart');


Route::get('cart/{id}', function ($id) {
    if (isset($id) && !empty($id) && !in_array($id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $id;
    }
    return redirect()->back();
})->name('add-cart');

Route::post('cart/send-email', function () {
    if (!empty($_SESSION['cart']) && isset($_POST['email'])) {
        $to = $subject = $headers = '';
        ob_start();
        include '../resources/views/send-email.blade.php';
        $message = ob_get_contents();
        ob_end_clean();
        $mail = mail($to, $subject, $message, implode("\r\n", $headers));
        return redirect()->route('cart', compact('mail'));
    }
    return redirect()->route('index');
})->name('send-email');


Route::get('remove-all', function () {
    $_SESSION['cart'] = [];
    return redirect()->route('index');
})->name('remove-all');

Route::get('remove/{id}', function ($id) {

    if (isset($id)) {
        if (empty($id) || empty($_SESSION['cart'])) {
            return redirect()->back();
        }
        $index = array_search($id, $_SESSION["cart"]);
        if ($index !== false) {
            unset($_SESSION["cart"][$index]);
            $_SESSION["cart"] = array_values($_SESSION["cart"]);
        }
    }
    return redirect()->route('cart');
})->name('remove');


Route::get('login', function () {
    return view('login');
})->name('login');

Route::post('login', function () {
    $name = $_POST["username"];
    $password = $_POST["password"];
    if (env('ADMIN_USERNAME') == $name && env('ADMIN_PASSWORD') == $password) {
        $_SESSION['user_login'] = true;
        return redirect()->back();
    }
    return redirect()->route('products');
})->name('login-user');

Route::get('logout', function () {
    if (isset($_SESSION['user_login'])) {
        unset($_SESSION['user_login']);
    }
    return redirect()->route('login');
})->name('logout');


Route::get('products', function () {
    if (!isset($_SESSION['user_login'])) {
        return redirect()->route('login');
    }
    $query = "SELECT * FROM products";
    $items = conn($query, [], true);
    return view('products', compact('items'));
})->name('products');

Route::get('/product', function () {
    return view('product');
})->name('product');

Route::post('product', function () {
    if (productValidation()) {
        return redirect()->back();
    }
    if (!isset($_SESSION['user_login'])) {
        return redirect()->back();
    }
    $params = ['title' => $_POST["title"], 'description' => $_POST["description"], 'price' => $_POST["price"]];
    $result = uploadImage();
    $params['image'] = $result;

    $paramKeys = implode(',', array_keys($params));
    $placeholders = implode(',', array_fill(0, count($params), '?'));
    $query = "INSERT INTO products ($paramKeys) VALUES ($placeholders)";

    conn($query, array_values($params));
    return redirect()->back();
})->name('product.create');

Route::get('product/delete/{id}', function ($id) {
    if (!isset($_SESSION['user_login'])) {
        return redirect()->route('products');
    }
    $query = "SELECT * FROM  products WHERE id=?";
    $product = conn($query, $id);
    unlink(storage_path('app/public/images/' . $product->image));
    $query = "DELETE FROM products WHERE id=?";
    conn($query, $id);
    return redirect()->back();
})->name('product.delete');


Route::get('product/edit/{id}', function ($id) {
    if (!isset($_SESSION['user_login'])) {
        return redirect()->back();
    }
    $query = "SELECT * FROM  products WHERE id=?";
    $product = conn($query, $id);

    return view('product', compact('product'));
})->name('product.edit');

Route::post('product/update/{id}', function ($id) {
    if (productValidation()) {
        return redirect()->back();
    }
    $params = ['title' => $_POST["title"], 'description' => $_POST["description"], 'price' => $_POST["price"]];
    $query = "SELECT * FROM  products WHERE id=?";
    $product = conn($query, $id);
    if ($_FILES["image"]["name"]) {
        unlink(storage_path('app/public/images/' . $product->image));
        $image = uploadImage();
        $params['image'] = $image;
    }

    $format = [];
    foreach ($params as $key => $value) {
        $format[] = $key . '=' . "?";
    }
    $format = implode(', ', $format);
    $params['id'] = $id;
    $query = "UPDATE products SET $format WHERE id=?";
    conn($query, array_values($params));

    return redirect()->back();
})->name('product.update');





