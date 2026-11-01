<?php
require_once '../../includes/session_check.php';
checkAccess(['admin'], '../../auth/login.php');
require_once '../../config/db.php';
require_once '../../includes/admin_account_helpers.php';

$accountStatus = $accountStatus ?? 'disabled';
$isArchivedPage = $accountStatus === 'archived';
$pageTitle = ($isArchivedPage ? 'Archived Accounts' : 'Disabled Accounts') . ' | APEX Learning Hub';
$extraCss = ['../../css/admin.css?v=202610301240', '../../css/student.css?v=202610292224'];
$extraJs = '../../js/admin.js?v=202610292245';
$bodyClass = 'admin-dashboard student-dashboard admin-portal';
$useVisualTheme = true;
$hideSharedSearch = true;
$adminPage = $isArchivedPage ? 'archived' : 'accounts';
$csrfToken = adminCsrfToken();

$accountsStmt = $pdo->query("
    SELECT u.id, u.first_name, u.last_name, u.email, u.role, u.created_at,
           u.is_active, u.archived_at
    FROM users u
    WHERE u.is_active = 0
      AND u.role <> 'admin'
    ORDER BY (u.archived_at IS NOT NULL) DESC, u.last_name, u.first_name
");
$accounts = $accountsStmt->fetchAll();
$message = trim($_GET['msg'] ?? '');
$error = trim($_GET['error'] ?? '');

require_once '../../includes/header.php';
?>

<div class="student-dashboard-shell" id="studentDashboardShell">
    <?php require '../../includes/admin_sidebar.php'; ?>
    <div class="student-dashboard-content container">
        <section class="dashboard-header admin-portal-heading">
            <div class="dashboard-title">
                <h1><?= $isArchivedPage ? 'Archived Accounts' : 'Disabled Accounts' ?></h1>
                <p><?= $isArchivedPage ? 'Accounts retained for records and no longer available to users.' : 'Accounts with access disabled and available for archiving.' ?></p>
            </div>
        </section>

        <?php if ($message !== ''): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php $status = $isArchivedPage ? 'archived' : 'disabled'; ?>
            <section class="admin-account-status-section <?= $status ?>" aria-labelledby="<?= $status ?>-accounts-title">
                <h2 class="sr-only" id="<?= $status ?>-accounts-title"><?= $isArchivedPage ? 'Archived Accounts' : 'Disabled Accounts' ?></h2>
                <?php foreach (['dean' => 'Deans', 'professor' => 'Professors', 'student' => 'Students'] as $role => $roleLabel): ?>
                    <?php $roleAccounts = array_values(array_filter($accounts, static fn(array $account): bool => $account['role'] === $role && ($isArchivedPage ? $account['archived_at'] !== null : $account['archived_at'] === null))); ?>
                    <section class="card admin-user-table-card admin-role-table-card" aria-labelledby="<?= $status ?>-<?= $role ?>-title">
                <div class="table-toolbar">
                    <div>
                        <h3 class="card-title" id="<?= $status ?>-<?= $role ?>-title"><?= $roleLabel ?></h3>
                        <span class="admin-account-count" aria-label="<?= number_format(count($roleAccounts)) ?> <?= strtolower($roleLabel) ?>"><?= number_format(count($roleAccounts)) ?></span>
                    </div>
                    <div class="search-box">
                        <input type="search" placeholder="Search name, email, or role..." aria-label="Search <?= $status ?> <?= strtolower($roleLabel) ?>"
                            data-table-search="adminAccounts<?= ucfirst($status) ?><?= ucfirst($role) ?>Table">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table admin-user-table" id="adminAccounts<?= ucfirst($status) ?><?= ucfirst($role) ?>Table">
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
                        <?php if (!$roleAccounts): ?>
                            <tr><td class="admin-table-empty" colspan="6">There are no <?= $status ?> <?= strtolower($roleLabel) ?>.</td></tr>
                        <?php else: ?>
                            <?php foreach ($roleAccounts as $account): ?>
                                <?php
                                $displayName = trim($account['first_name'] . ' ' . $account['last_name']);
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($account['first_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($account['last_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($account['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><span class="role-pill role-<?= htmlspecialchars($account['role'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(ucfirst($account['role']), ENT_QUOTES, 'UTF-8') ?></span></td>
                                    <td><?= htmlspecialchars(date('M j, Y', strtotime($account['created_at'])), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>
                                        <div class="admin-account-actions">
                                            <?php if (!$isArchivedPage): ?>
                                                <form action="../../api/admin_accounts_process.php" method="POST"
                                                    onsubmit="return confirm('Restore access for <?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?>?');">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                                                    <input type="hidden" name="action" value="restore_user">
                                                    <input type="hidden" name="user_id" value="<?= (int) $account['id'] ?>">
                                                    <input type="hidden" name="return_to" value="<?= $isArchivedPage ? 'archived' : 'disabled' ?>">
                                                    <button type="submit" class="btn btn-outline btn-restore btn-sm">Restore Access</button>
                                                </form>
                                                <form action="../../api/admin_accounts_process.php" method="POST"
                                                    onsubmit="return confirm('Archive <?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?> for records?');">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                                                    <input type="hidden" name="action" value="archive_user">
                                                    <input type="hidden" name="user_id" value="<?= (int) $account['id'] ?>">
                                                    <input type="hidden" name="return_to" value="disabled">
                                                    <button type="submit" class="btn btn-outline btn-archive btn-sm">Archive</button>
                                                </form>
                                            <?php else: ?>
                                                <form action="../../api/admin_accounts_process.php" method="POST"
                                                    onsubmit="return confirm('Unarchive <?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?> and move the account back to Disabled Accounts?');">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                                                <input type="hidden" name="action" value="unarchive_user">
                                                <input type="hidden" name="user_id" value="<?= (int) $account['id'] ?>">
                                                <input type="hidden" name="return_to" value="disabled">
                                                <button type="submit" class="btn btn-outline btn-restore btn-sm">Unarchive</button>
                                                </form>
                                            <?php endif; ?>
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
            </section>
    </div>
</div>
<button type="button" class="student-sidebar-backdrop" aria-label="Close admin navigation"></button>
<button type="button" class="student-mobile-toggle" aria-label="Open admin navigation"
    aria-controls="studentSidebar" aria-expanded="false">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
</button>

<?php require_once '../../includes/footer.php'; ?>

