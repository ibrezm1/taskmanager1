<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);


$servername = "localhost";
$username = "new_user";
$password = "password";
$database = "test";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable CORS

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
//header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


if (
  isset( $_SERVER['REQUEST_METHOD'] )
  && $_SERVER['REQUEST_METHOD'] === 'OPTIONS'
) {
  // need preflight here
  header( 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept' );
  // add cache control for preflight cache
  // @link https://httptoolkit.tech/blog/cache-your-cors/
  header( 'Access-Control-Max-Age: 86400' );
  header( 'Cache-Control: public, max-age=86400' );
  header( 'Vary: origin' );
  // just exit and CORS request will be okay
  // NOTE: We are exiting only when the OPTIONS preflight request is made
  // because the pre-flight only checks for response header and HTTP status code.
  exit( 0 );
}


// Handle HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Retrieve tasks
        $result = $conn->query("SELECT * FROM demo_tasks");
        $tasks = [];

        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }

        echo json_encode($tasks);
        break;

    case 'POST':
        // Handle different operations based on the flag
        $data = json_decode(file_get_contents("php://input"), true);

        $operation = $data['operation'];

        switch ($operation) {
            case 'add':
                // Create a new task
                $title = $data['title'];
                $description = $data['description'];
                $conn->query("INSERT INTO demo_tasks (title, description) VALUES ('$title', '$description')");
                $taskId = $conn->insert_id;
                echo json_encode(['id' => $taskId, 'message' => 'Task added successfully']);
                break;

            case 'update':
                // Update an existing task
                $taskId = $data['id'];
                $title = $data['title'];
                $description = $data['description'];
                $conn->query("UPDATE demo_tasks SET title='$title', description='$description' WHERE id=$taskId");
                echo json_encode(['message' => 'Task updated successfully']);
                break;

            case 'delete':
                // Delete a task
                $taskId = $data['id'];
                $conn->query("DELETE FROM demo_tasks WHERE id=$taskId");
                echo json_encode(['message' => 'Task deleted successfully']);
                break;

            default:
                http_response_code(400);
                echo json_encode(['error' => 'Invalid operation']);
                break;
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
}

$conn->close();
?>
