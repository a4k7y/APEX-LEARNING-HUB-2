<?php
require_once '../../includes/session_check.php';
checkAccess(['dean'], '../../auth/login.php');
require_once '../../config/db.php';

$professorsStmt = $pdo->query("
    SELECT u.id, u.first_name, u.last_name, u.email, u.is_active,
           COUNT(DISTINCT c.id) AS assigned_courses,
           COUNT(DISTINCT a.id) AS assessment_count,
           COUNT(DISTINCT an.id) AS announcement_count
    FROM users u
    LEFT JOIN courses c ON c.professor_id = u.id
    LEFT JOIN assignments a ON a.professor_id = u.id
    LEFT JOIN announcements an ON an.author_id = u.id
    WHERE u.role = 'professor' AND u.archived_at IS NULL
    GROUP BY u.id, u.first_name, u.last_name, u.email, u.is_active
    ORDER BY u.is_active DESC, u.last_name ASC, u.first_name ASC
");
$professors = $professorsStmt->fetchAll();

$pageTitle = 'My Professors | APEX Learning Hub';
$extraCss = ['../../css/admin.css?v=202610311100', '../../css/student.css?v=202610292224'];
$extraJs = ['../../js/admin.js?v=202610301355', '../../js/student.js?v=202610301835'];
$bodyClass = 'admin-dashboard student-dashboard dean-portal';
$useVisualTheme = true;
$deanPage = 'professors';
require_once '../../includes/header.php';
?>

<div class="student-dashboard-shell" id="studentDashboardShell">
    <?php require '../../includes/dean_sidebar.php'; ?>
    <div class="container student-dashboard-content">
        <header class="student-page-header">
            <span class="student-eyebrow">Faculty overview</span>
            <h1>My Professors</h1>
            <p>Review the professors assigned to your department and their current portal activity.</p>
        </header>

        <?php if (empty($professors)): ?>
            <section class="student-overview-card student-empty-state">
                <h2>No professors yet</h2>
                <p>No professor accounts have been created or assigned to this Dean portal.</p>
            </section>
        <?php else: ?>
            <section class="student-course-grid dean-professor-card-grid" aria-label="Professors">
                <?php foreach ($professors as $professor): ?>
                    <?php $fullName = trim($professor['first_name'] . ' ' . $professor['last_name']); ?>
                    <article class="course-card dean-professor-card">
                        <div class="course-card-top">
                            <div class="dean-professor-card-heading">
                                <div class="dean-professor-avatar" aria-hidden="true"><?= htmlspecialchars(strtoupper(substr($professor['first_name'], 0, 1) . substr($professor['last_name'], 0, 1))) ?></div>
                                <div>
                                    <h2 class="course-title"><?= htmlspecialchars($fullName) ?></h2>
                                    <span class="dean-professor-status <?= $professor['is_active'] ? 'active' : 'inactive' ?>"><?= $professor['is_active'] ? 'Active' : 'Disabled' ?></span>
                                </div>
                            </div>
                            <p class="student-course-email"><?= htmlspecialchars($professor['email']) ?></p>
                        </div>
                        <div class="student-course-details dean-professor-card-details">
                            <p><strong>Assigned courses</strong><span><?= (int) $professor['assigned_courses'] ?></span></p>
                            <p><strong>Uploads</strong><span><?= (int) $professor['assessment_count'] ?></span></p>
                            <p><strong>Announcements</strong><span><?= (int) $professor['announcement_count'] ?></span></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </div>
</div>
<button type="button" class="student-sidebar-backdrop" aria-label="Close dean navigation"></button>
<button type="button" class="student-mobile-toggle" aria-label="Open dean navigation" aria-controls="studentSidebar" aria-expanded="false"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"></path></svg></button>
<?php require_once '../../includes/footer.php'; ?>

