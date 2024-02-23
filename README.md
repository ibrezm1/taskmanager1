# TaskManagerApp

This project was generated with [Angular CLI](https://github.com/angular/angular-cli) version 14.2.13.

## Development server

Run `ng serve` for a dev server. Navigate to `http://localhost:4200/`. The application will automatically reload if you change any of the source files.

## Code scaffolding

Run `ng generate component component-name` to generate a new component. You can also use `ng generate directive|pipe|service|class|guard|interface|enum|module`.

## Build

Run `ng build` to build the project. The build artifacts will be stored in the `dist/` directory.

## Running unit tests

Run `ng test` to execute the unit tests via [Karma](https://karma-runner.github.io).

## Running end-to-end tests

Run `ng e2e` to execute the end-to-end tests via a platform of your choice. To use this command, you need to first add a package that implements end-to-end testing capabilities.

## Further help

To get more help on the Angular CLI use `ng help` or go check out the [Angular CLI Overview and Command Reference](https://angular.io/cli) page.

## DB 

```sql
CREATE TABLE IF NOT EXISTS demo_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255)
);
```

```php
$servername = "localhost";
$username = "new_user";
$password = "password";
$database = "test";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

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

```

## Serve Build Angular 

```bash 
npx ng serve --configuration=production
npx ng build --configuration=production --base-href=/proj1/
```