<?php
require_once '../../includes/session_check.php';
checkAccess(['student'], '../../auth/login.php');
require_once '../../config/db.php';

$studentId = (int) $_SESSION['user_id'];
$announcementsStmt = $pdo->prepare("
    SELECT DISTINCT a.*, c.course_code, c.course_name, u.first_name, u.last_name, u.role
    FROM announcements a
    JOIN users u ON a.author_id = u.id
    LEFT JOIN courses c ON a.course_id = c.id
    WHERE a.course_id IS NULL
       OR EXISTS (
            SELECT 1
            FROM enrollments e
            WHERE e.course_id = a.course_id
              AND e.student_id = :student_id
              AND e.status = 'APPROVED'
       )
    ORDER BY a.created_at DESC
");
$announcementsStmt->execute(['student_id' => $studentId]);
$announcements = $announcementsStmt->fetchAll();
$studentAnnouncementCount = count($announcements);

$taskCountStmt = $pdo->prepare("
    SELECT
        (SELECT COUNT(*) FROM enrollments WHERE student_id = :pending_student_id AND status = 'PENDING')
        +
        (SELECT COUNT(*)
         FROM assignments a
         JOIN enrollments e ON e.course_id = a.course_id
         LEFT JOIN assignment_completions ac
           ON ac.assignment_id = a.id AND ac.student_id = :completion_student_id
         WHERE e.student_id = :enrolled_student_id
           AND e.status = 'APPROVED'
           AND ac.assignment_id IS NULL) AS pending_count
");
$taskCountStmt->execute([
    'pending_student_id' => $studentId,
    'completion_student_id' => $studentId,
    'enrolled_student_id' => $studentId,
]);
$studentPendingTaskCount = (int) $taskCountStmt->fetchColumn();

$pageTitle = 'Announcements | APEX Learning Hub';
$extraCss = ['../../css/admin.css?v=202610291355', '../../css/student.css?v=202610292118'];
$extraJs = '../../js/student.js?v=202610291930';
$bodyClass = 'admin-dashboard student-dashboard';
$useVisualTheme = true;
$studentPage = 'announcements';
require_once '../../includes/header.php';
?>

<div class="student-dashboard-shell" id="studentDashboardShell">
    <?php require '../../includes/student_sidebar.php'; ?>
    <div class="container student-dashboard-content">
        <header class="student-page-header">
            <span class="student-eyebrow">Your updates</span>
            <h1>Announcements</h1>
            <p>Campus-wide notices and announcements from the instructors of your enrolled courses.</p>
        </header>

        <?php if (!empty($announcements)): ?>
            <div class="student-announcement-search">
                <svg class="student-announcement-search-icon" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input
                    type="search"
                    id="announcementSearch"
                    class="form-control student-announcement-search-input"
                    aria-label="Search announcements"
                    placeholder="Search by course name, course code, title, or announcement..."
                    autocomplete="off"
                >
            </div>
        <?php endif; ?>

        <section class="student-page-list" id="studentAnnouncementList" aria-label="Announcements for this student">
            <?php if (empty($announcements)): ?>
                <div class="student-overview-card student-empty-state">
                    <h2>You&rsquo;re all caught up</h2>
                    <p>There are no campus or course announcements for you right now.</p>
                </div>
            <?php else: ?>
                <?php foreach ($announcements as $announcement): ?>
                    <article class="student-overview-card student-announcement-full" data-announcement-item>
                        <div class="student-announcement-full-heading">
                            <span class="student-announcement-mark" aria-hidden="true"></span>
                            <div>
                                <span class="student-eyebrow">
                                    <?= htmlspecialchars($announcement['course_code']
                                        ? $announcement['course_code'] . ' · ' . $announcement['course_name']
                                        : 'Campus-wide') ?>
                                </span>
                                <h2><?= htmlspecialchars($announcement['title']) ?></h2>
                            </div>
                            <time datetime="<?= htmlspecialchars(date('c', strtotime($announcement['created_at']))) ?>">
                                <?= date('M j, Y', strtotime($announcement['created_at'])) ?> &middot; <?= date('g:i A', strtotime($announcement['created_at'])) ?>
                            </time>
                        </div>
                        <p class="student-announcement-author">
                            Posted by <?= htmlspecialchars($announcement['first_name'] . ' ' . $announcement['last_name']) ?>
                            &middot; <?= htmlspecialchars(ucfirst($announcement['role'])) ?>
                        </p>
                        <div class="student-announcement-body">
                            <?= nl2br(htmlspecialchars($announcement['message'])) ?>
                        </div>
                    </article>
                <?php endforeach; ?>
                <p class="student-empty-note student-announcement-no-results" id="announcementNoResults" aria-live="polite" hidden>
                    No announcements match your search.
                </p>
            <?php endif; ?>
        </section>
    </div>
</div>
<?php require_once '../../includes/footer.php'; ?>
