<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../config/database.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $conn = getDatabaseConnection();

    $query = 'SELECT * FROM users WHERE id=?';

    $result = $conn->prepare($query);
    $result->bindParam(1, $id, PDO::PARAM_INT);

    $result->execute();

    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo json_encode(array('status'=> true, 'data' => $row ));
    } else {
        echo json_encode(array('status'=> false, 'message' => "No user found for this id." ));
    }

} else {
    echo json_encode(array('status'=> false, 'message' => "Id is missing in URL." ));
}