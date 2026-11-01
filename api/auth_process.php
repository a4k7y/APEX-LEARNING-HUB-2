<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once '../config/db.php';
require_once '../includes/password_policy.php';
require_once '../includes/email_policy.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'login';

if ($action === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password = is_string($password) ? $password : '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
        exit;
    }
    if (!isValidApexEmail($email)) {
        echo json_encode(['success' => false, 'message' => apexEmailPolicyMessage()]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        if ((int) $user['is_active'] !== 1 || $user['archived_at'] !== null) {
            echo json_encode(['success' => false, 'message' => 'This account is disabled or archived. Contact an administrator for assistance.']);
            exit;
        }
        session_regenerate_id(true);
        $_SESSION['user_id']   = (int)$user['id'];
        $_SESSION['user_name'] = trim($user['first_name'] . ' ' . $user['last_name']);
        $_SESSION['role']      = $user['role'];
        $_SESSION['email']     = $user['email'];

        $dashboardPaths = [
            'admin' => '../views/admin/admin_dashboard.php',
            'registrar' => '../views/registrar/registrar_dashboard.php',
            'professor' => '../views/professor/professor_dashboard.php',
            'dean' => '../views/dean/dean_dashboard.php',
            'student' => '../views/student/student_dashboard.php',
        ];
        $redirect = $dashboardPaths[$user['role']] ?? '../auth/login.php';
        echo json_encode(['success' => true, 'redirect' => $redirect, 'role' => $user['role']]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    exit;
}

if ($action === 'register') {
    $firstName       = trim($_POST['first_name'] ?? '');
    $lastName        = trim($_POST['last_name'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $password        = $_POST['password'] ?? '';
    $password        = is_string($password) ? $password : '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $confirmPassword = is_string($confirmPassword) ? $confirmPassword : '';

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled.']);
        exit;
    }
    if (!isValidApexEmail($email)) {
        echo json_encode(['success' => false, 'message' => apexEmailPolicyMessage()]);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }
    if (!isValidPassword($password)) {
        echo json_encode(['success' => false, 'message' => passwordPolicyMessage()]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'An account already exists with that email.']);
        exit;
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $ins = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (:fn, :ln, :email, :pass, 'student')");
    $ins->execute([
        'fn'    => $firstName,
        'ln'    => $lastName,
        'email' => $email,
        'pass'  => $hash
    ]);

    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Unknown action.']);
exit;
