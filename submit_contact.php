<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Only POST requests are accepted.']);
    exit;
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$topic = trim((string) ($_POST['topic'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$allowedTopics = ['Topic question', 'Project idea', 'Resource request', 'Assam case study'];

if ($name === '' || mb_strlen($name) > 120) {
    http_response_code(422);
    echo json_encode(['message' => 'Please enter a valid name.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 254) {
    http_response_code(422);
    echo json_encode(['message' => 'Please enter a valid email address.']);
    exit;
}

if (!in_array($topic, $allowedTopics, true) || $message === '' || mb_strlen($message) > 5000) {
    http_response_code(422);
    echo json_encode(['message' => 'Please select a topic and enter a message.']);
    exit;
}

try {
    require __DIR__ . '/db.php';
    $statement = $pdo->prepare(
        'INSERT INTO contact_messages (name, email, topic, message) VALUES (:name, :email, :topic, :message)'
    );
    $statement->execute([
        ':name' => $name,
        ':email' => $email,
        ':topic' => $topic,
        ':message' => $message,
    ]);

    echo json_encode(['message' => 'Thank you. Your message has been recorded.']);
} catch (Throwable $error) {
    error_log($error->getMessage());
    http_response_code(500);
    echo json_encode(['message' => 'The message could not be saved. Please try again later.']);
}