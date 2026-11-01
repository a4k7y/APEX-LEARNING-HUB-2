<?php
require_once '../config/db.php';
require_once '../includes/session_check.php';
require_once '../includes/password_policy.php';
require_once '../includes/email_policy.php';
require_once '../includes/admin_account_helpers.php';

checkAccess(['admin'], '../auth/login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/admin/admin_dashboard.php');
    exit;
}

if (!isValidAdminCsrfToken($_POST['csrf_token'] ?? null)) {
    header('Location: ../views/admin/admin_dashboard.php?error=' . urlencode('Your session expired. Please try again.'));
    exit;
}

$action = $_POST['action'] ?? '';
$userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
$returnTo = $_POST['return_to'] ?? '';
$returnPath = $returnTo === 'archived' ? '../views/admin/admin_archived_accounts.php' : '../views/admin/admin_accounts.php';
$redirectTo = $action === 'disable_user'
    ? '../views/admin/admin_users.php'
    : $returnPath;

function adminAccountRedirect(bool $success, string $message, string $destination): void
{
    $parameter = $success ? 'msg' : 'error';
    header('Location: ' . $destination . '?' . $parameter . '=' . urlencode($message));
    exit;
}

try {
    if ($action === 'create_registrar') {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password = is_string($password) ? $password : '';

        if ($firstName === '' || $lastName === '' || $email === '' || $password === '') {
            adminAccountRedirect(false, 'Complete all fields to create the registrar account.', '../views/admin/admin_dashboard.php');
        }
        if (strlen($firstName) > 50 || strlen($lastName) > 50 || strlen($email) > 100 || !isValidApexEmail($email)) {
            adminAccountRedirect(false, apexEmailPolicyMessage(), '../views/admin/admin_dashboard.php');
        }
        if (!isValidPassword($password)) {
            adminAccountRedirect(false, passwordPolicyMessage(), '../views/admin/admin_dashboard.php');
        }

        $insert = $pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password, role, created_by)
            VALUES (:first_name, :last_name, :email, :password, 'registrar', :created_by)
        ");
        try {
            $insert->execute([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'created_by' => (int) $_SESSION['user_id'],
            ]);
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                adminAccountRedirect(false, 'An account already uses that email address.', '../views/admin/admin_dashboard.php');
            }
            throw $exception;
        }

        adminAccountRedirect(true, 'Registrar account created successfully.', '../views/admin/admin_dashboard.php');
    }

    if ($action === 'update_admin_profile') {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($firstName === '' || $lastName === '' || !isValidApexEmail($email)
            || strlen($firstName) > 50 || strlen($lastName) > 50 || strlen($email) > 100) {
            adminAccountRedirect(false, 'Enter valid profile details within the allowed length.', '../views/admin/admin_profile.php');
        }

        $duplicate = $pdo->prepare('SELECT id FROM users WHERE email = :email AND id <> :id');
        $duplicate->execute(['email' => $email, 'id' => (int) $_SESSION['user_id']]);
        if ($duplicate->fetch()) {
            adminAccountRedirect(false, 'An account already uses that email address.', '../views/admin/admin_profile.php');
        }

        $update = $pdo->prepare("
            UPDATE users
            SET first_name = :first_name, last_name = :last_name, email = :email
            WHERE id = :id AND role = 'admin'
        ");
        $update->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'id' => (int) $_SESSION['user_id'],
        ]);
        $_SESSION['user_name'] = $firstName . ' ' . $lastName;
        $_SESSION['email'] = $email;
        adminAccountRedirect(true, 'Profile updated successfully.', '../views/admin/admin_profile.php');
    }

    if (!in_array($action, ['disable_user', 'archive_user', 'restore_user', 'unarchive_user'], true) || !$userId || $userId <= 0) {
        adminAccountRedirect(false, 'Choose a valid account action.', $redirectTo);
    }

    if ($action === 'disable_user') {
        $statement = $pdo->prepare("
            UPDATE users
            SET is_active = 0
            WHERE id = :id AND role IN ('dean', 'professor', 'student')
              AND is_active = 1 AND archived_at IS NULL
        ");
        $statement->execute(['id' => $userId]);
        $successMessage = 'Account disabled. Its access will be blocked immediately.';
    } elseif ($action === 'archive_user') {
        $statement = $pdo->prepare("
            UPDATE users
            SET archived_at = CURRENT_TIMESTAMP
            WHERE id = :id AND role IN ('dean', 'professor', 'student')
              AND is_active = 0 AND archived_at IS NULL
        ");
        $statement->execute(['id' => $userId]);
        $successMessage = 'Account archived and access disabled.';
    } elseif ($action === 'restore_user') {
        $statement = $pdo->prepare("
            UPDATE users
            SET is_active = 1, archived_at = NULL
            WHERE id = :id AND role <> 'admin'
              AND is_active = 0 AND archived_at IS NULL
        ");
        $statement->execute(['id' => $userId]);
        $successMessage = 'Account access restored.';
    } else {
        $statement = $pdo->prepare("
            UPDATE users
            SET is_active = 0, archived_at = NULL
            WHERE id = :id AND role IN ('dean', 'professor', 'student')
              AND is_active = 0 AND archived_at IS NOT NULL
        ");
        $statement->execute(['id' => $userId]);
        $successMessage = 'Account unarchived and returned to Disabled Accounts.';
    }

    if ($statement->rowCount() !== 1) {
        adminAccountRedirect(false, 'The account could not be updated. It may have already changed or is not manageable here.', $redirectTo);
    }

    adminAccountRedirect(true, $successMessage, $redirectTo);
} catch (PDOException $exception) {
    error_log('Admin account operation failed: ' . $exception->getMessage());
    adminAccountRedirect(false, 'The account operation failed. Please try again.', $redirectTo);
}

