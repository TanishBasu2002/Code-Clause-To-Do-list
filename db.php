<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'to-do';

// Connect to the database
$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create the tasks table (if it doesn't exist)
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(255) NOT NULL,
    completed BOOLEAN NOT NULL DEFAULT FALSE
)";
if (!mysqli_query($conn, $sql)) {
    echo "Error creating table: " . mysqli_error($conn);
}

// Insert a task into the tasks table
if (isset($_POST['task'])) {
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    $sql = "INSERT INTO tasks (text) VALUES ('$task')";
    if (!mysqli_query($conn, $sql)) {
        echo "Error inserting task: " . mysqli_error($conn);
    }
}

// Update a task's completion status
if (isset($_POST['id']) && isset($_POST['completed'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $completed = mysqli_real_escape_string($conn, $_POST['completed']);
    $sql = "UPDATE tasks SET completed='$completed' WHERE id='$id'";
    if (!mysqli_query($conn, $sql)) {
        echo "Error updating task: " . mysqli_error($conn);
    }
}

// Delete a task from the tasks table
if (isset($_POST['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_id']);
    $sql = "DELETE FROM tasks WHERE id='$id'";
    if (!mysqli_query($conn, $sql)) {
        echo "Error deleting task: " . mysqli_error($conn);
    }
}

// Retrieve all tasks from the tasks table
$sql = "SELECT * FROM tasks";
$result = mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>
