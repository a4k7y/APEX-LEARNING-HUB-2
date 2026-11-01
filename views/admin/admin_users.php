<?php
require_once '../../includes/session_check.php';
checkAccess(['admin'], '../../auth/login.php');
require_once '../../config/db.php';
require_once '../../includes/admin_account_helpers.php';

$pageTitle = 'User Management | APEX Learning Hub';
$extraCss = ['../../css/admin.css?v=202610301240', '../../css/student.css?v=202610292224'];
$extraJs = '../../js/admin.js?v=202610292245';
$bodyClass = 'admin-dashboard student-dashboard admin-portal';
$useVisualTheme = true;
$hideSharedSearch = true;
$adminPage = 'users';
$csrfToken = adminCsrfToken();

$usersStmt = $pdo->query("
    SELECT u.id, u.first_name, u.last_name, u.email, u.role, u.created_at
    FROM users u
    WHERE u.role IN ('dean', 'professor', 'student')
      AND u.is_active = 1
      AND u.archived_at IS NULL
    ORDER BY u.role, u.last_name, u.first_name
");
$users = $usersStmt->fetchAll();
$message = trim($_GET['msg'] ?? '');
$error = trim($_GET['error'] ?? '');

require_once '../../includes/header.php';
?>

<div class="student-dashboard-shell" id="studentDashboardShell">
    <?php require '../../includes/admin_sidebar.php'; ?>
    <div class="student-dashboard-content container">
        <section class="dashboard-header admin-portal-heading">
            <div class="dashboard-title">
                <h1>User Management</h1>
                <p>Review active Dean, Professor, and Student accounts created by Registrars.</p>
            </div>
        </section>

        <?php if ($message !== ''): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php foreach (['dean' => 'Deans', 'professor' => 'Professors', 'student' => 'Students'] as $role => $roleLabel): ?>
            <?php $roleUsers = array_values(array_filter($users, static fn(array $user): bool => $user['role'] === $role)); ?>
            <section class="card admin-user-table-card admin-role-table-card" aria-labelledby="active-<?= $role ?>-title">
                <div class="table-toolbar">
                    <div>
                        <h2 class="card-title" id="active-<?= $role ?>-title">Active <?= $roleLabel ?></h2>
                        <p class="text-muted"><?= number_format(count($roleUsers)) ?> active <?= strtolower($roleLabel) ?></p>
                    </div>
                    <div class="search-box">
                        <input type="search" placeholder="Search name, email, or role..." aria-label="Search active <?= strtolower($roleLabel) ?>"
                            data-table-search="adminUsers<?= ucfirst($role) ?>Table">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table admin-user-table" id="adminUsers<?= ucfirst($role) ?>Table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$roleUsers): ?>
                            <tr><td class="admin-table-empty" colspan="6">No active user accounts found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($roleUsers as $user): ?>
                                <?php $displayName = trim($user['first_name'] . ' ' . $user['last_name']); ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($user['last_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><span class="role-pill role-<?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(ucfirst($user['role']), ENT_QUOTES, 'UTF-8') ?></span></td>
                                    <td><?= htmlspecialchars(date('M j, Y', strtotime($user['created_at'])), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>
                                        <div class="admin-account-actions">
                                            <form action="../../api/admin_accounts_process.php" method="POST"
                                                onsubmit="return confirm('Disable access for <?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?>?');">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                                                <input type="hidden" name="action" value="disable_user">
                                                <input type="hidden" name="user_id" value="<?= (int) $user['id'] ?>">
                                                <button type="submit" class="btn btn-primary btn-sm">Disable</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                </div>
            </section>
        <?php endforeach; ?>
    </div>
</div>
<button type="button" class="student-sidebar-backdrop" aria-label="Close admin navigation"></button>
<button type="button" class="student-mobile-toggle" aria-label="Open admin navigation"
    aria-controls="studentSidebar" aria-expanded="false">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
</button>

<?php require_once '../../includes/footer.php'; ?>

