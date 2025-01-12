<?php

function get_all_categories($conn){
    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $categories = $stmt->fetchAll();
    }else $categories = 0;

    return $categories;
}

function insert_category($conn, $data){
    $sql = "INSERT INTO categories (name, notes) VALUES(?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

function update_category($conn, $data){
    $sql = "UPDATE categories SET name=?, notes=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

function delete_category($conn, $id){
    $sql = "DELETE FROM categories WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
}

function get_category_by_id($conn, $id){
    $sql = "SELECT * FROM categories WHERE id =?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0){
        $category = $stmt->fetch();
    }else $category = 0;

    return $category;
}

function count_categories($conn){
	$sql = "SELECT id FROM categories ";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	return $stmt->rowCount();
}



