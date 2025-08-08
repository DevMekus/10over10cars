<?php
header('Content-Type: application/json');

// Prevent direct access
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

session_start();
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['action'])) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

switch ($input['action']) {
    case 'set':
        if (isset($input['token'], $input['role'], $input['userid'])) {
            $_SESSION['token'] = $input['token'];
            $_SESSION['role'] = $input['role'];
            $_SESSION['userid'] = $input['userid'];
            $_SESSION['last_refresh'] = time(); // Save refresh time
            echo json_encode(["success" => true, "message" => "Session set"]);
            exit;
        }
        break;

    case 'refresh':
        if (isset($_SESSION['token'])) {
            $_SESSION['last_refresh'] = time(); // Just update refresh time
            echo json_encode(["success" => true, "message" => "Session refreshed"]);
            exit;
        }
        break;

    case 'clear':
        session_unset();
        session_destroy();
        echo json_encode(["success" => true, "message" => "Session cleared"]);
        exit;
}

// Default response if nothing else matched
echo json_encode(["success" => false, "message" => "Unhandled request"]);
exit;
