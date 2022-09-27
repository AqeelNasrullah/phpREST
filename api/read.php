<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../config/database.php';

$conn = getDatabaseConnection();

$query = 'SELECT * FROM users';

$result = $conn->prepare($query);

$result->execute();

$num = $result->rowCount();

if ($num > 0) {
    $users = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        array_push($users, $row);
    }
    echo json_encode(array('status' => true, 'data' => $users));
} else {
    echo json_encode(array('status' => false, 'message' => 'No user found in database.'));
}