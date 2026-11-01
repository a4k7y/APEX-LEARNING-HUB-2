<?php
session_start();
require_once '../config/db.php';
require_once '../includes/session_check.php';
checkAccess(['student', 'professor'], '../auth/login.php');

$lessonId = (int) ($_GET['id'] ?? 0);
$userId = (int) $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT l.file_name, l.file_path, l.file_mime, l.file_size, l.professor_id
    FROM lessons l
    LEFT JOIN enrollments e ON e.course_id = l.course_id
        AND e.student_id = :student_id
        AND e.status = 'APPROVED'
    WHERE l.id = :lesson_id
      AND (l.professor_id = :professor_id OR e.student_id IS NOT NULL)
");
$stmt->execute([
    'student_id' => $userId,
    'lesson_id' => $lessonId,
    'professor_id' => $userId,
]);
$lesson = $stmt->fetch();

if (!$lesson || empty($lesson['file_path'])) {
    http_response_code(404);
    exit('Lesson file not found.');
}

$baseDirectory = realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'lessons');
$file = realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $lesson['file_path']));
if ($baseDirectory === false || $file === false || strncmp($file, $baseDirectory . DIRECTORY_SEPARATOR, strlen($baseDirectory) + 1) !== 0 || !is_file($file)) {
    http_response_code(404);
    exit('Lesson file not found.');
}

header('Content-Type: ' . ($lesson['file_mime'] ?: 'application/octet-stream'));
header('Content-Length: ' . (int) $lesson['file_size']);
header('Content-Disposition: attachment; filename="' . str_replace('"', '', basename($lesson['file_name'])) . '"');
readfile($file);
