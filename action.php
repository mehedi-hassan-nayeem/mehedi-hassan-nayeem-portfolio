<?php
// check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // database connection parameters (adjust these based on your database configuration)
    $dsn = "mysql:host=localhost;dbname=CHANGE";
    $username = "CHANGE";
    $password = "CHANGE";

    // attempt database connection
    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare SQL statement to insert data into the database
        $sql = "INSERT INTO test (u_id, u_name, u_email, u_subject, u_message) VALUES (:i, :n, :e, :s, :m)";
        $stmt = $pdo->prepare($sql);

        // generate unique ID
        $unique_id = uniqid("pt-", true);

        // bind parameters to the statement
        $stmt->bindParam(':i', $unique_id);
        $stmt->bindParam(':n', $name);
        $stmt->bindParam(':e', $email);
        $stmt->bindParam(':s', $subject);
        $stmt->bindParam(':m', $message);

        // execute the statement
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Form submitted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Unable to submit form. Please try again later."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }

    // close connection
    $pdo = null;
}
