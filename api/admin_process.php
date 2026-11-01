<?php
session_start();
require_once '../config/db.php';
require_once '../includes/session_check.php';
require_once '../includes/password_policy.php';
require_once '../includes/email_policy.php';

checkAccess(['registrar'], '../auth/login.php');

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$adminId = $_SESSION['user_id'];

function respond($success, $message, $redirect = null) {
    global $isAjax;
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }
    if ($redirect === null) {
        $redirect = '../views/registrar/registrar_dashboard.php';
    }
    $query = $success ? "msg=" . urlencode($message) : "error=" . urlencode($message);
    header("Location: $redirect?$query");
    exit;
}

function getCourseScheduleInput(): ?array {
    $validDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $submittedDays = $_POST['meeting_days'] ?? [];
    if (!is_array($submittedDays)) {
        return null;
    }

    foreach ($submittedDays as $day) {
        if (!in_array($day, $validDays, true)) {
            return null;
        }
    }

    $days = array_values(array_unique($submittedDays));
    $startInput = trim($_POST['start_time'] ?? '');
    $endInput = trim($_POST['end_time'] ?? '');
    $startTime = $startInput === '' ? null : DateTimeImmutable::createFromFormat('!H:i', $startInput);
    $endTime = $endInput === '' ? null : DateTimeImmutable::createFromFormat('!H:i', $endInput);
    $startErrors = DateTimeImmutable::getLastErrors();
    $endErrors = DateTimeImmutable::getLastErrors();

    if (($startInput === '') !== ($endInput === '')
        || ($startInput !== '' && (
            $startTime === false
            || $endTime === false
            || ($startErrors !== false && ($startErrors['warning_count'] || $startErrors['error_count']))
            || ($endErrors !== false && ($endErrors['warning_count'] || $endErrors['error_count']))
            || $startTime->format('H:i') !== $startInput
            || $endTime->format('H:i') !== $endInput
            || $endTime <= $startTime
        ))
        || (!empty($days) && $startInput === '')) {
        return null;
    }

    return [
        'meeting_days' => $days ? implode(',', $days) : null,
        'start_time' => $startTime ? $startTime->format('H:i:s') : null,
        'end_time' => $endTime ? $endTime->format('H:i:s') : null,
        'room' => trim($_POST['room'] ?? '') ?: null,
    ];
}

try {
    switch ($action) {
        case 'add_course':
            $code = strtoupper(trim($_POST['course_code'] ?? ''));
            $name = trim($_POST['course_name'] ?? '');
            $sectionName = trim($_POST['section_name'] ?? 'General');
            $profId = !empty($_POST['professor_id']) ? (int)$_POST['professor_id'] : null;
            $capacity = !empty($_POST['max_capacity']) ? (int)$_POST['max_capacity'] : 30;
            $schedule = getCourseScheduleInput();

            if (empty($code) || empty($name) || empty($sectionName) || strlen($sectionName) > 50 || $schedule === null) {
                respond(false, "Course Code, Name, and Section are required. Enter a valid schedule or leave schedule fields blank.");
            }

            $check = $pdo->prepare("SELECT id FROM courses WHERE course_code = :code");
            $check->execute(['code' => $code]);
            if ($check->fetch()) {
                respond(false, "A course with code '$code' already exists.");
            }

            $stmt = $pdo->prepare("
                INSERT INTO courses
                    (course_code, course_name, section_name, professor_id, max_capacity, meeting_days, start_time, end_time, room)
                VALUES (:code, :name, :section_name, :prof, :cap, :meeting_days, :start_time, :end_time, :room)
            ");
            $stmt->execute([
                'code' => $code,
                'name' => $name,
                'section_name' => $sectionName,
                'prof' => $profId,
                'cap' => $capacity,
                'meeting_days' => $schedule['meeting_days'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
                'room' => $schedule['room'],
            ]);
            respond(true, "Course $code created successfully.");
            break;

        case 'update_course_schedule':
            $courseId = (int) ($_POST['course_id'] ?? 0);
            $schedule = getCourseScheduleInput();
            if ($courseId <= 0 || $schedule === null) {
                respond(false, "Choose valid meeting days and a valid start and end time.");
            }

            $scheduleStmt = $pdo->prepare("
                UPDATE courses
                SET meeting_days = :meeting_days, start_time = :start_time,
                    end_time = :end_time, room = :room
                WHERE id = :course_id
            ");
            $scheduleStmt->execute([
                'meeting_days' => $schedule['meeting_days'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
                'room' => $schedule['room'],
                'course_id' => $courseId,
            ]);
            respond(true, "Course schedule updated.");
            break;

        case 'delete_course':
            $courseId = (int)($_POST['course_id'] ?? 0);
            if ($courseId <= 0) {
                respond(false, "Invalid course selected.");
            }
            $stmt = $pdo->prepare("DELETE FROM courses WHERE id = :id");
            $stmt->execute(['id' => $courseId]);
            respond(true, "Course removed successfully.");
            break;

        case 'add_user':
            $fn = trim($_POST['first_name'] ?? '');
            $ln = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $password = is_string($password) ? $password : '';
            $role = $_POST['role'] ?? 'student';
            $courseId = (int) ($_POST['course_id'] ?? 0);

            if (empty($fn) || empty($ln) || empty($email) || empty($password)) {
                respond(false, "All user fields are required.");
            }
            if (!isValidApexEmail($email)) {
                respond(false, apexEmailPolicyMessage());
            }
            if (!in_array($role, ['dean', 'professor', 'student'], true)) {
                respond(false, "Invalid role specified.");
            }
            if (!isValidPassword($password)) {
                respond(false, passwordPolicyMessage());
            }
            if ($role === 'student' && $courseId <= 0) {
                respond(false, "Choose the student's designated section.");
            }

            $check = $pdo->prepare("SELECT id FROM users WHERE email = :email");
            $check->execute(['email' => $email]);
            if ($check->fetch()) {
                respond(false, "User email '$email' is already registered.");
            }

            $course = null;
            if ($role === 'student') {
                $courseStmt = $pdo->prepare("
                    SELECT id, course_code, max_capacity,
                           (SELECT COUNT(*) FROM enrollments WHERE course_id = courses.id AND status = 'APPROVED') AS enrolled_count
                    FROM courses
                    WHERE id = :course_id
                ");
                $courseStmt->execute(['course_id' => $courseId]);
                $course = $courseStmt->fetch();
                if (!$course) {
                    respond(false, "The selected section does not exist.");
                }
                if ((int) $course['enrolled_count'] >= (int) $course['max_capacity']) {
                    respond(false, "The selected section has reached its maximum capacity.");
                }
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role, created_by) VALUES (:fn, :ln, :email, :pass, :role, :created_by)");
            $stmt->execute([
                'fn' => $fn,
                'ln' => $ln,
                'email' => $email,
                'pass' => $hash,
                'role' => $role,
                'created_by' => (int) $_SESSION['user_id'],
            ]);
            if ($role === 'student') {
                $enrollmentStmt = $pdo->prepare("
                    INSERT INTO enrollments (student_id, course_id, status, decided_at)
                    VALUES (:student_id, :course_id, 'APPROVED', NOW())
                ");
                $enrollmentStmt->execute([
                    'student_id' => (int) $pdo->lastInsertId(),
                    'course_id' => $courseId,
                ]);
                respond(true, "Student account created and assigned to {$course['course_code']}.");
            }
            respond(true, "New $role account created for $fn $ln.");
            break;

        case 'delete_user':
            $userId = (int)($_POST['user_id'] ?? 0);
            if ($userId === $adminId) {
                respond(false, "You cannot delete your own active account.");
            }
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            respond(true, "User deleted successfully.");
            break;

        case 'update_enrollment':
            $enrollmentId = (int)($_POST['enrollment_id'] ?? 0);
            $status = strtoupper(trim($_POST['status'] ?? ''));

            if (!in_array($status, ['APPROVED', 'REJECTED', 'PENDING'], true)) {
                respond(false, "Invalid enrollment decision.");
            }

            $stmt = $pdo->prepare("UPDATE enrollments SET status = :status, decided_at = NOW() WHERE id = :id");
            $stmt->execute(['status' => $status, 'id' => $enrollmentId]);
            respond(true, "Enrollment status updated to $status.");
            break;

        case 'post_announcement':
            $title = trim($_POST['title'] ?? '');
            $message = trim($_POST['message'] ?? '');
            $courseId = !empty($_POST['course_id']) ? (int)$_POST['course_id'] : null;

            if (empty($title) || empty($message)) {
                respond(false, "Title and announcement content are required.");
            }

            $stmt = $pdo->prepare("INSERT INTO announcements (title, message, course_id, author_id) VALUES (:title, :msg, :cid, :aid)");
            $stmt->execute(['title' => $title, 'msg' => $message, 'cid' => $courseId, 'aid' => $adminId]);
            respond(true, "Announcement published successfully.");
            break;

        case 'delete_announcement':
            $annId = (int)($_POST['announcement_id'] ?? 0);
            $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = :id");
            $stmt->execute(['id' => $annId]);
            respond(true, "Announcement deleted.");
            break;

        default:
            respond(false, "Invalid action specified.");
            break;
    }
} catch (Exception $e) {
    respond(false, "Operation failed: " . $e->getMessage());
}
