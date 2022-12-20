<?php
require_once 'mysql.php';
define('BASE_URL', 'http://localhost/js');

function get_category_list(){
    $sql = 'SELECT * FROM CATEGORIES';
    $pdo = get_pdo();

    $stmt = $pdo->query($sql);
    $category_list = array();

    while ($row = $stmt->fetch()) {
        $category = array(
            'id' => $row['id'],
            'name' => $row['name']
        );

        array_push($category_list, $category);
    }
    
    return json_encode($category_list);
}

/**
 * Api for product
 */
function get_product_list(){
    $sql = 'SELECT * FROM PRODUCTS';
    $pdo = get_pdo();

    $stmt = $pdo->query($sql);
    $product_list = array();

    while ($row = $stmt->fetch()) {
        $product = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'img' => $row['img'],
            'price' => $row['price'],
            'category_id' => $row['category_id']
        );

        array_push($product_list, $product);
    }
    
    return json_encode($product_list);
}

function get_product_list_by_category($category_id){
    $sql = 'SELECT * FROM PRODUCTS WHERE category_id=:category_id';
    $pdo = get_pdo();

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute();

    $product_list = array();

    while ($row = $stmt->fetch()) {
        $product = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'img' => $row['img'],
            'price' => $row['price'],
            'category_id' => $row['category_id']
        );
        array_push($product_list, $product);
    }

    return json_encode($product_list);
}

function get_product($id){
    $sql = 'SELECT * FROM PRODUCTS WHERE id=:id';
    $pdo = get_pdo();

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $product = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'img' => $row['img'],
            'price' => $row['price'],
            'category_id' => $row['category_id']
        );

        return $product;
    }
    
    return null;
}


/**
 * Authentication
 */
// đăng nhập
function login($email, $password){
    $sql = 'SELECT * FROM USERS WHERE email=:email AND password=:password';
    $pdo = get_pdo();

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $user = array(
            'id' => $row['id'],
            'email' => $row['email'],
            'password' => $row['password']
        );

        return $user;
    }
    
    return false;
}
// tạo tài khoản/đăng ký
function register($email, $password){
    $sql = 'INSERT INTO USERS (id, email, password) VALUES (null, :email, :password)';
    $pdo = get_pdo();

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    
    return false;
}

/**
 * Category api
 */
//Xóa Category
function delete_category($id){
    $sql = 'DELETE FROM CATEGORIES WHERE ID=:id';
    $pdo = get_pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}
//create category/thêm category
function create_category($name){
    $sql = 'INSERT INTO CATEGORIES(ID,NAME) VALUES (NULL, :name)';
    $pdo = get_pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);

    return $stmt->execute();
}
function get_category($id){
    $sql = 'SELECT * FROM CATEGORIES WHERE id=:id';
    $pdo = get_pdo();

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $category = array(
            'id' => $row['id'],
            'name' => $row['name'],
            
        );

        return $category;
    }
    
    return null;
}
// Sửa Category
function update_category($id,$name){
    $sql = 'UPDATE  CATEGORIES SET NAME=:name WHERE ID=:id';
    $pdo = get_pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);

    return $stmt->execute();
}
//xóa product
function delete_products($id){
    $sql = 'DELETE FROM PRODUCTS WHERE ID=:id';
    $pdo = get_pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}
// thêm product
function create_products($name,$price,$img,$category_id){
    $sql = 'INSERT INTO PRODUCTS(ID,NAME,PRICE,CATEGORY_ID,IMG) VALUES (NULL, :name, :price, :category_id, :img)';
    $pdo = get_pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':img', $img);

    return $stmt->execute();
}
// Sửa product
function update_products($id,$name,$price,$img){
    $sql = 'UPDATE PRODUCTS SET NAME=:name, PRICE=:price,IMG=:img WHERE ID=:id';
    $pdo = get_pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':img', $img);

    return $stmt->execute();
}