<?php
require_once '../../includes/session_check.php';
checkAccess(['admin'], '../../auth/login.php');
require_once '../../config/db.php';
require_once '../../includes/admin_account_helpers.php';

$pageTitle = 'My Profile | APEX Learning Hub';
$extraCss = ['../../css/admin.css?v=202610292302', '../../css/student.css?v=202610292224'];
$extraJs = '../../js/admin.js?v=202610292245';
$bodyClass = 'admin-dashboard student-dashboard admin-portal';
$useVisualTheme = true;
$hideSharedSearch = true;
$adminPage = 'profile';
$csrfToken = adminCsrfToken();

$profileStmt = $pdo->prepare('SELECT first_name, last_name, email, role, created_at FROM users WHERE id = :id');
$profileStmt->execute(['id' => (int) $_SESSION['user_id']]);
$profile = $profileStmt->fetch();
if (!$profile) {
    header('Location: admin_dashboard.php?error=' . urlencode('Your profile could not be loaded.'));
    exit;
}

$message = trim($_GET['msg'] ?? '');
$error = trim($_GET['error'] ?? '');

require_once '../../includes/header.php';
?>

<div class="student-dashboard-shell" id="studentDashboardShell">
    <?php require '../../includes/admin_sidebar.php'; ?>
    <div class="student-dashboard-content container">
        <section class="dashboard-header admin-portal-heading">
            <div class="dashboard-title">
                <h1>My Profile</h1>
                <p>Update your administrator account details.</p>
            </div>
        </section>

        <?php if ($message !== ''): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <section class="card admin-profile-card" aria-labelledby="admin-profile-title">
            <h2 class="card-title" id="admin-profile-title">Administrator Information</h2>
            <form action="../../api/admin_accounts_process.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="action" value="update_admin_profile">
                <div class="admin-form-name-grid">
                    <div class="form-group">
                        <label for="profileFirstName">First Name</label>
                        <input class="form-control" id="profileFirstName" name="first_name" placeholder="e.g. Juan" maxlength="50"
                            value="<?= htmlspecialchars($profile['first_name'], ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="profileLastName">Last Name</label>
                        <input class="form-control" id="profileLastName" name="last_name" placeholder="e.g. Dela Cruz" maxlength="50"
                            value="<?= htmlspecialchars($profile['last_name'], ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="profileEmail">APEX Email</label>
                    <input class="form-control" type="email" id="profileEmail" name="email" maxlength="100"
                        pattern="[A-Za-z0-9._%+\-]+@apex\.edu\.ph"
                        title="Use an APEX Email ending in @apex.edu.ph."
                        value="<?= htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="admin-profile-actions">
                    <a class="btn btn-outline" href="admin_dashboard.php">Cancel</a>
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                </div>
            </form>
        </section>
    </div>
</div>
<button type="button" class="student-sidebar-backdrop" aria-label="Close admin navigation"></button>
<button type="button" class="student-mobile-toggle" aria-label="Open admin navigation"
    aria-controls="studentSidebar" aria-expanded="false">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
</button>

<?php require_once '../../includes/footer.php'; ?>

