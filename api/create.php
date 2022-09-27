<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods,Content-Type,Access-Control-Allow-Origin,Authorization,X-Requested-With');

require_once '../config/database.php';

$conn = getDatabaseConnection();

$data = json_decode(file_get_contents('php://input'));

$name = $data->name;
$fname = $data->fname;

$query = 'INSERT INTO users (name, fathername) VALUES (:name, :fname)';
$result = $conn->prepare($query);

$name = htmlspecialchars(strip_tags($name));
$fname = htmlspecialchars(strip_tags($fname));

$result->bindParam(':name', $name);
$result->bindParam(':fname', $fname);

if ($result->execute()) {
    echo json_encode(array('status' => true, 'message' => 'User created.', 'data' => (int)$conn->lastInsertId()));
} else {
    echo json_encode(array('status' => false, 'message' => 'Something went wrong.'));
}