<?php

function __e($key)
{
    global $translation;
    if (!empty($translation[$key])) {
        return $translation[$key];
    }
    return $key;
}

function dump_die($param)
{
    var_dump($param);
    die;
}


function conn($query, $params = [], $get_list = false)
{
    $conn = new mysqli(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        dynamicBindVariables($stmt, $params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $items = [];
    if ($result) {
        if ($get_list) {
            while ($obj = $result->fetch_object()) {
                array_push($items, $obj);
            }
        } else {
            $items = $result->fetch_object();
        }
        $result->close();
    }

    return $items;
}

function bindTypes($param)
{
    $types = '';
    if (is_int($param)) {
        $types .= 'i';
    } elseif (is_float($param)) {
        $types .= 'd';
    } elseif (is_string($param)) {
        $types .= 's';
    } else {
        $types .= 'b';
    }
    return $types;
}

function dynamicBindVariables($stmt, $params)
{
    if ($params != null && !is_array($params)) {
        $param = $params;
        $type = '';
        $type .= bindTypes($params);
        $stmt->bind_param($type, $param);
    } else {
        $bind_names = [];
        $types = '';
        foreach ($params as $param) {
            $types .= bindTypes($param);
        }
        $bind_names[] = $types;
        for ($i = 0; $i < count($params); $i++) {
            $bind_name = 'bind' . $i;
            $$bind_name = $params[$i];
            $bind_names[] = &$$bind_name;
        }
        call_user_func_array(array($stmt, 'bind_param'), $bind_names);
    }
    return $stmt;
}


function flash($name = '', $message = '')
{
    if (!empty($name)) {

        if (!empty($message) && empty($_SESSION['errors'][$name])) {
            if (!empty($_SESSION['errors'][$name])) {
                unset($_SESSION['errors'][$name]);
            }
            $_SESSION['errors'][$name] = $message;
        } elseif (!empty($_SESSION['errors'][$name]) && empty($message)) {
            echo $_SESSION['errors'][$name];
            unset($_SESSION['errors'][$name]);
        }
    }
}

function oldData($name = '', $message = '')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION['old'][$name])) {
            if (!empty($_SESSION['old'][$name])) {
                unset($_SESSION['old'][$name]);
            }
            $_SESSION['old'][$name] = $message;
        } elseif (!empty($_SESSION['old'][$name]) && empty($message)) {
            $result = $_SESSION['old'][$name];
            unset($_SESSION['old'][$name]);
            return $result;
        }
    }
}


function productValidation()
{
    $is_error = false;
    if (!isset($_POST['title']) || empty($_POST['title'])) {
        $is_error = true;
        flash('title', 'Title is required');
    } else {
        old('title', $_POST['title']);
    }
    if (!isset($_POST['description']) || empty($_POST['description'])) {
        $is_error = true;
        flash('description', 'Description is required');
    } else {
        old('description', $_POST['description']);
    }
    if (!isset($_POST['price']) || empty($_POST['price'])) {
        $is_error = true;
        flash('price', 'Price is required');
    } else {
        old('price', $_POST['price']);
    }
    return $is_error;
}
function uploadImage()
{
    if (!isset($_FILES['image']) || empty($_FILES['image'])) {
        flash('image-upload', 'Need to upload a image!');
        redirect($_SERVER['HTTP_REFERER']);
        return null;
    }
    $target_dir = storage_path('app/public/images/');
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $name = md5(date('Y-m-d H:i:s')) . '.' . $imageFileType;
    $imgName = $target_dir . $name;
    $acceptedTypes = ["image/jpg", "image/png", "image/jpeg", "image/gif"];

    if (!in_array($_FILES["image"]["type"], $acceptedTypes)) {
        flash('image-type', 'This image type cant be stored!');
        redirect($_SERVER['HTTP_REFERER']);
        return null;
    } elseif (!move_uploaded_file($_FILES["image"]["tmp_name"], $imgName)) {
        flash('image-uploaded', 'This image cant be stored!');
        redirect($_SERVER['HTTP_REFERER']);
        return null;
    }
    move_uploaded_file($_FILES["image"]["tmp_name"], $imgName);
    return $name;
}
