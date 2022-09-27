<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods,Content-Type,Access-Control-Allow-Origin,Authorization,X-Requested-With');

require_once '../config/database.php';

$conn = getDatabaseConnection();

$data = json_decode(file_get_contents('php://input'));

$id = isset($_GET['id']) ? $_GET['id'] : null;
$name = $data->name;
$fname = $data->fname;

$query = 'UPDATE users SET name=:name, fathername=:fname WHERE id=:id';

$result = $conn->prepare($query);

$name = htmlspecialchars(strip_tags($name));
$fname = htmlspecialchars(strip_tags($fname));

$result->bindParam(':name', $name);
$result->bindParam(':fname', $fname);
$result->bindParam(':id', $id, PDO::PARAM_INT);

if ($result->execute()) {
    echo json_encode(array('status' => true, 'message' => 'User Updated.'));
} else {
    echo json_encode(array('status' => false, 'message' => 'Something went wrong.'));
}