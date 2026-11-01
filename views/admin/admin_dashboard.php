<?php
require_once '../../includes/session_check.php';
checkAccess(['admin'], '../../auth/login.php');
require_once '../../config/db.php';
require_once '../../includes/admin_account_helpers.php';
require_once '../../includes/dashboard_greeting.php';

$pageTitle = 'Admin Dashboard | APEX Learning Hub';
$extraCss = ['../../css/admin.css?v=202610301232', '../../css/student.css?v=202610292224'];
$extraJs = ['../../js/admin.js?v=202610292245', '../../js/student.js?v=202610301835'];
$bodyClass = 'admin-dashboard student-dashboard admin-portal';
$useVisualTheme = true;
$hideSharedSearch = true;
$adminPage = 'dashboard';
$csrfToken = adminCsrfToken();

$summaryStmt = $pdo->query("
    SELECT
        SUM(role IN ('dean', 'professor', 'student') AND is_active = 1 AND archived_at IS NULL) AS active_users,
        SUM(role = 'registrar' AND is_active = 1 AND archived_at IS NULL) AS active_registrars,
        SUM(role IN ('dean', 'professor', 'student') AND is_active = 0 AND archived_at IS NULL) AS disabled_users,
        SUM(role IN ('dean', 'professor', 'student') AND archived_at IS NOT NULL) AS archived_users
    FROM users
");
$summary = $summaryStmt->fetch();
$message = trim($_GET['msg'] ?? '');
$error = trim($_GET['error'] ?? '');
$manilaNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Manila'));
$greeting = dashboardGreeting($manilaNow);

require_once '../../includes/header.php';
?>

<div class="student-dashboard-shell" id="studentDashboardShell">
    <?php require '../../includes/admin_sidebar.php'; ?>
    <div class="container student-dashboard-content">
        <div class="student-dashboard-heading">
            <div class="student-dashboard-heading-copy">
                <h1>Dashboard</h1>
            </div>
            <p class="student-dashboard-date"><?= htmlspecialchars($manilaNow->format('l, F j, Y'), ENT_QUOTES, 'UTF-8') ?></p>
        </div>

        <?php if ($message !== ''): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <div class="student-dashboard-layout admin-dashboard-layout">
            <div class="student-dashboard-main-column student-dashboard-intro">
                <section class="student-welcome-card">
                    <div class="student-welcome-copy">
                        <h1><?= $greeting ?>, <?= htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') ?></h1>
                        <button type="button" class="btn btn-primary" data-open-modal="createRegistrarModal">
                            <svg class="dashboard-action-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                            Create Registrar Account
                        </button>
                    </div>
                </section>
            </div>

            <aside class="student-dashboard-side-column" aria-label="Administrator account actions">
                <a class="student-overview-card admin-dashboard-action-card" href="admin_users.php">
                    <span class="admin-dashboard-action-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><path d="M3 20v-1a6 6 0 0 1 12 0v1M16 5.5a3 3 0 0 0 0 5.8M18 14a5 5 0 0 1 3 4.5V20"/></svg>
                    </span>
                    <span>
                        <strong>Manage User Accounts</strong>
                        <small>Manage deans, professors, and students</small>
                    </span>
                    <svg class="admin-dashboard-action-arrow" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m9 5 7 7-7 7"/>
                    </svg>
                </a>

                <a class="student-overview-card admin-dashboard-action-card" href="admin_accounts.php">
                    <span class="admin-dashboard-action-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><path d="M3 20v-1a6 6 0 0 1 12 0v1M17 8h4M19 6v4"/></svg>
                    </span>
                    <span>
                        <strong>Review Disabled Accounts</strong>
                        <small>Review accounts waiting to be archived</small>
                    </span>
                    <svg class="admin-dashboard-action-arrow" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m9 5 7 7-7 7"/>
                    </svg>
                </a>
            </aside>

            <div class="student-dashboard-main-column student-dashboard-details">
                <section class="metrics-grid admin-summary-grid" aria-label="Account overview">
                    <article class="metric-card">
                        <div class="metric-icon navy" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><path d="M3 20v-1a6 6 0 0 1 12 0v1M16 5.5a3 3 0 0 0 0 5.8M18 14a5 5 0 0 1 3 4.5V20"/></svg>
                        </div>
                        <div class="metric-data">
                            <h3><?= number_format((int) ($summary['active_users'] ?? 0)) ?></h3>
                            <p>Active Deans, Professors &amp; Students</p>
                        </div>
                    </article>
                    <article class="metric-card">
                        <div class="metric-icon teal" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 8v6M23 11h-6"/></svg>
                        </div>
                        <div class="metric-data">
                            <h3><?= number_format((int) ($summary['active_registrars'] ?? 0)) ?></h3>
                            <p>Active Registrar Accounts</p>
                        </div>
                    </article>
                    <article class="metric-card">
                        <div class="metric-icon coral" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><path d="M3 20v-1a6 6 0 0 1 12 0v1M17 8h4M19 6v4"/></svg>
                        </div>
                        <div class="metric-data">
                            <h3><?= number_format((int) ($summary['disabled_users'] ?? 0)) ?></h3>
                            <p>Disabled Accounts</p>
                        </div>
                    </article>
                    <article class="metric-card">
                        <div class="metric-icon gold" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M4 7h16v13H4zM3 4h18v3H3zM9 11h6"/></svg>
                        </div>
                        <div class="metric-data">
                            <h3><?= number_format((int) ($summary['archived_users'] ?? 0)) ?></h3>
                            <p>Archived Accounts</p>
                        </div>
                    </article>
                </section>
            </div>
        </div>
    </div>
</div>
<button type="button" class="student-sidebar-backdrop" aria-label="Close admin navigation"></button>
<button type="button" class="student-mobile-toggle" aria-label="Open admin navigation"
    aria-controls="studentSidebar" aria-expanded="false">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
</button>

<div class="modal-backdrop" id="createRegistrarModal">
    <div class="modal-dialog">
        <form action="../../api/admin_accounts_process.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="action" value="create_registrar">
            <div class="modal-header">
                <h2 class="modal-title">Create Registrar Account</h2>
                <button type="button" class="modal-close" data-close-modal aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="admin-form-name-grid">
                    <div class="form-group">
                        <label for="registrarFirstName">First Name *</label>
                        <input type="text" class="form-control" id="registrarFirstName" name="first_name"
                            placeholder="e.g. Juan" maxlength="50" autocomplete="given-name" required>
                    </div>
                    <div class="form-group">
                        <label for="registrarLastName">Last Name *</label>
                        <input type="text" class="form-control" id="registrarLastName" name="last_name"
                            placeholder="e.g. Dela Cruz" maxlength="50" autocomplete="family-name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="registrarEmail">APEX Email *</label>
                    <input type="email" id="registrarEmail" name="email" class="form-control"
                        placeholder="user@apex.edu.ph" maxlength="100" autocomplete="email"
                        pattern="[A-Za-z0-9._%+\-]+@apex\.edu\.ph"
                        title="Use an APEX Email ending in @apex.edu.ph." required>
                </div>
                <div class="form-group">
                    <label for="registrarPassword">Initial Password *</label>
                    <input type="password" id="registrarPassword" name="password" class="form-control"
                        placeholder="8+ characters, upper/lowercase, number, symbol"
                        minlength="8" maxlength="72"
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9\s]).{8,72}"
                        title="Use at least 8 characters with an uppercase letter, a lowercase letter, a number, and a special character."
                        autocomplete="new-password" required>
                    <small class="text-muted">Use at least 8 characters, including uppercase and lowercase letters, a number, and a special character.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-close-modal>Cancel</button>
                <button type="submit" class="btn btn-primary">Add User Account</button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
