<?php
require_once '../../includes/session_check.php';
checkAccess(['student'], '../../auth/login.php');
require_once '../../config/db.php';
require_once '../../includes/dashboard_greeting.php';

$pageTitle = 'Student Portal | APEX Learning Hub';
$extraCss  = ['../../css/admin.css?v=202610291355', '../../css/student.css?v=202610292118'];
$extraJs   = '../../js/student.js?v=202610291930';
$bodyClass = 'admin-dashboard student-dashboard';
$useVisualTheme = true;

$studentId = (int)$_SESSION['user_id'];
$msg       = $_GET['msg'] ?? '';
$error     = $_GET['error'] ?? '';

$userStmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$userStmt->execute(['id' => $studentId]);
$currentUser = $userStmt->fetch();

$approvedStmt = $pdo->prepare("
    SELECT e.id AS enrollment_id, e.decided_at,
           c.id AS course_id, c.course_code, c.course_name, c.max_capacity,
           c.meeting_days, c.start_time, c.end_time, c.room,
           u.first_name AS prof_first, u.last_name AS prof_last, u.email AS prof_email
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    LEFT JOIN users u ON c.professor_id = u.id
    WHERE e.student_id = :sid AND e.status = 'APPROVED'
    ORDER BY c.course_code ASC
");
$approvedStmt->execute(['sid' => $studentId]);
$enrolledCourses = $approvedStmt->fetchAll();

$myAppsStmt = $pdo->prepare("
    SELECT e.id AS enrollment_id, e.status, e.applied_at, e.decided_at,
           c.id AS course_id, c.course_code, c.course_name,
           u.first_name AS prof_first, u.last_name AS prof_last
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    LEFT JOIN users u ON c.professor_id = u.id
    WHERE e.student_id = :sid
    ORDER BY e.applied_at DESC
");
$myAppsStmt->execute(['sid' => $studentId]);
$myApplications = $myAppsStmt->fetchAll();

$catalogStmt = $pdo->prepare("
    SELECT c.*, 
           u.first_name AS prof_first, u.last_name AS prof_last, u.email AS prof_email,
           (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id AND status = 'APPROVED') AS approved_students,
           (SELECT status FROM enrollments WHERE course_id = c.id AND student_id = :sid LIMIT 1) AS my_status
    FROM courses c
    LEFT JOIN users u ON c.professor_id = u.id
    ORDER BY c.course_code ASC
");
$catalogStmt->execute(['sid' => $studentId]);
$catalogCourses = $catalogStmt->fetchAll();

$enrolledCourseIds = array_column($enrolledCourses, 'course_id');
$inClause = !empty($enrolledCourseIds) ? implode(',', array_map('intval', $enrolledCourseIds)) : '0';

$announcementsStmt = $pdo->query("
    SELECT a.*, c.course_code, c.course_name, u.first_name, u.last_name, u.role
    FROM announcements a
    JOIN users u ON a.author_id = u.id
    LEFT JOIN courses c ON a.course_id = c.id
    WHERE a.course_id IS NULL OR a.course_id IN ($inClause)
    ORDER BY a.created_at DESC
");
$announcements = $announcementsStmt->fetchAll();

$enrolledCount = count($enrolledCourses);
$assignmentStmt = $pdo->prepare("
    SELECT a.id, a.title, a.due_at, c.course_code, c.course_name
    FROM assignments a
    JOIN courses c ON a.course_id = c.id
    JOIN enrollments e ON e.course_id = c.id AND e.student_id = :student_id AND e.status = 'APPROVED'
    LEFT JOIN assignment_completions ac ON ac.assignment_id = a.id AND ac.student_id = :completion_student_id
    WHERE ac.assignment_id IS NULL
    ORDER BY a.due_at ASC
");
$assignmentStmt->execute([
    'student_id' => $studentId,
    'completion_student_id' => $studentId,
]);
$pendingAssignments = $assignmentStmt->fetchAll();
$pendingEnrollmentTasks = array_values(array_filter(
    $myApplications,
    static fn($application) => $application['status'] === 'PENDING'
));
$studentPendingTaskCount = count($pendingAssignments) + count($pendingEnrollmentTasks);
$studentAnnouncementCount = count($announcements);
$studentPage = 'dashboard';
$manilaNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Manila'));
$greeting = dashboardGreeting($manilaNow);
$greetingFil = dashboardGreetingFilipino($manilaNow);
$filipinoWeekdays = ['Linggo', 'Lunes', 'Martes', 'Miyerkules', 'Huwebes', 'Biyernes', 'Sabado'];
$filipinoMonths = [1 => 'Enero', 'Pebrero', 'Marso', 'Abril', 'Mayo', 'Hunyo', 'Hulyo', 'Agosto', 'Setyembre', 'Oktubre', 'Nobyembre', 'Disyembre'];
$dashboardDateFil = $filipinoWeekdays[(int) $manilaNow->format('w')]
    . ', ' . $filipinoMonths[(int) $manilaNow->format('n')]
    . ' ' . $manilaNow->format('j, Y');

require_once '../../includes/header.php';
?>

<div class="student-dashboard-shell" id="studentDashboardShell">
    <?php require '../../includes/student_sidebar.php'; ?>

<div class="container student-dashboard-content">
    <div class="student-dashboard-heading">
        <div class="student-dashboard-heading-copy">
            <h1>Dashboard</h1>
        </div>
        <p class="student-dashboard-date">
            <span data-lang-en><?= htmlspecialchars($manilaNow->format('l, F j, Y')) ?></span>
            <span data-lang-fil style="display:none;"><?= htmlspecialchars($dashboardDateFil) ?></span>
        </p>
    </div>

    <div class="student-dashboard-layout">
        <div class="student-dashboard-main-column student-dashboard-intro">
        <section class="student-welcome-card">
            <div class="student-welcome-copy">
                <h1><span data-lang-en><?= htmlspecialchars($greeting) ?></span><span data-lang-fil style="display:none;"><?= htmlspecialchars($greetingFil) ?></span>, <?= htmlspecialchars($currentUser['first_name'] ?? $_SESSION['user_name']) ?></h1>
                <a class="btn btn-primary" href="student_class_schedule.php">View class schedule</a>
            </div>
            <span class="student-id-chip">Student ID #<?= $studentId ?></span>
        </section>
        </div>

        <aside class="student-dashboard-side-column" aria-label="Student updates and tasks">
        <section class="student-overview-card student-tasks-preview">
            <div class="student-overview-card-heading">
                <div>
                    <h2>Pending tasks</h2>
                    <p><span data-lang-en><?= $studentPendingTaskCount ?> item<?= $studentPendingTaskCount === 1 ? '' : 's' ?> need attention</span><span data-lang-fil style="display:none;"><?= $studentPendingTaskCount ?> gawaing kailangang asikasuhin</span></p>
                </div>
                <a href="student_tasks.php">View all</a>
            </div>
            <div class="student-checklist">
                <?php foreach (array_slice($pendingAssignments, 0, 3) as $task): ?>
                    <a class="student-checklist-item" href="student_tasks.php">
                        <span class="student-check-empty" aria-hidden="true"></span>
                        <span class="student-checklist-copy">
                            <strong><?= htmlspecialchars($task['title']) ?></strong>
                            <small><?= htmlspecialchars($task['course_code']) ?></small>
                        </span>
                        <time datetime="<?= htmlspecialchars(date('c', strtotime($task['due_at']))) ?>">
                            <?= date('M j', strtotime($task['due_at'])) ?>
                        </time>
                    </a>
                <?php endforeach; ?>
                <?php foreach (array_slice($pendingEnrollmentTasks, 0, max(0, 3 - count($pendingAssignments))) as $task): ?>
                    <a class="student-checklist-item" href="student_tasks.php">
                        <span class="student-check-empty" aria-hidden="true"></span>
                        <span class="student-checklist-copy">
                            <strong>Enrollment decision pending</strong>
                            <small><?= htmlspecialchars($task['course_code']) ?> &middot; <?= htmlspecialchars($task['course_name']) ?></small>
                        </span>
                        <span class="student-task-status">Pending</span>
                    </a>
                <?php endforeach; ?>
                <?php if ($studentPendingTaskCount === 0): ?>
                    <p class="student-empty-note student-empty-inline">You&rsquo;re all caught up. No pending tasks.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="student-overview-card student-announcements-preview">
            <div class="student-overview-card-heading">
                <div>
                    <h2><span data-lang-en>Latest announcement</span><span data-lang-fil style="display:none;">Pinakabagong anunsyo</span></h2>
                    <p><span data-lang-en>The most recent campus or class update for you</span><span data-lang-fil style="display:none;">Pinakabagong anunsyo sa kampus o klase para sa iyo.</span></p>
                </div>
                <a href="student_announcements.php"><span data-lang-en>View all</span><span data-lang-fil style="display:none;">Tingnan lahat</span></a>
            </div>
            <div class="student-announcement-list">
                <?php foreach (array_slice($announcements, 0, 1) as $announcement): ?>
                    <a class="student-announcement-preview" href="student_announcements.php">
                        <span class="student-announcement-mark" aria-hidden="true"></span>
                        <span>
                            <strong><?= htmlspecialchars($announcement['title']) ?></strong>
                            <small>
                                <?= htmlspecialchars($announcement['course_code'] ?: 'Campus-wide') ?>
                                &middot; <?= htmlspecialchars($announcement['first_name'] . ' ' . $announcement['last_name']) ?>
                            </small>
                        </span>
                    </a>
                <?php endforeach; ?>
                <?php if (empty($announcements)): ?>
                    <p class="student-empty-note student-empty-inline"><span data-lang-en>No announcements for your courses yet.</span><span data-lang-fil style="display:none;">Wala pang anunsyo para sa mga kurso mo.</span></p>
                <?php endif; ?>
            </div>
        </section>

        </aside>

        <div class="student-dashboard-main-column student-dashboard-details">

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon teal" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M5 3.5h14A2.5 2.5 0 0 1 21.5 6v14H7a3 3 0 0 1-3-3V5.5A2 2 0 0 1 6 3.5"/><path d="M4 17a3 3 0 0 1 3-3h14M8 7h8M8 10h6"/></svg>
            </div>
            <div class="metric-data">
                <h3><?= $enrolledCount ?></h3>
                <p>My Courses</p>
            </div>
        </div>
        <div class="metric-card">
            <div class="metric-icon gold" aria-hidden="true">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
            </div>
            <div class="metric-data">
                <h3><?= $studentPendingTaskCount ?></h3>
                <p>Pending Tasks</p>
            </div>
        </div>
    </div>
    <div class="tab-panel" id="tabCatalog">
        <div class="card">
            <div class="table-toolbar">
                <div class="search-box" style="flex:1; max-width:400px;">
                    <input type="text" id="catalogSearch" placeholder="Search by course code, title, or professor...">
                </div>
                <div class="text-muted" style="font-size:0.85rem;">
                    Browse active courses and apply with 1 click
                </div>
            </div>

            <div class="catalog-grid">
                <?php foreach ($catalogCourses as $c): ?>
                    <?php 
                        $isFull = $c['approved_students'] >= $c['max_capacity'];
                        $pct = $c['max_capacity'] > 0 ? min(100, round(($c['approved_students'] / $c['max_capacity']) * 100)) : 0;
                    ?>
                    <div class="course-card">
                        <div class="course-card-top">
                            <div class="course-badge-row">
                                <span class="course-code-tag"><?= htmlspecialchars($c['course_code']) ?></span>
                                <?php if ($c['my_status'] === 'APPROVED'): ?>
                                    <span class="badge badge-approved">Enrolled</span>
                                <?php elseif ($c['my_status'] === 'PENDING'): ?>
                                    <span class="badge badge-pending">Pending Approval</span>
                                <?php elseif ($c['my_status'] === 'REJECTED'): ?>
                                    <span class="badge badge-rejected">Rejected</span>
                                <?php elseif ($isFull): ?>
                                    <span class="badge" style="background:#fff0f2; color:var(--coral-dark);">Class Full</span>
                                <?php else: ?>
                                    <span class="badge" style="background:var(--teal-light); color:var(--teal-dark);">Open Seats</span>
                                <?php endif; ?>
                            </div>
                            <h3 class="course-title"><?= htmlspecialchars($c['course_name']) ?></h3>
                            <div class="course-instructor">
                                <div class="instructor-avatar">P</div>
                                <span>Prof. <?= htmlspecialchars($c['prof_first'] . ' ' . $c['prof_last']) ?></span>
                            </div>
                        </div>

                        <div class="course-card-bottom">
                            <div class="course-meta-stats">
                                <span>Seats: <?= (int)$c['approved_students'] ?> / <?= (int)$c['max_capacity'] ?></span>
                                <span><?= 100 - $pct ?>% Available</span>
                            </div>
                            <div class="capacity-meter">
                                <div class="capacity-fill <?= $pct >= 85 ? 'high' : '' ?>" style="width: <?= $pct ?>%;"></div>
                            </div>

                            <div style="margin-top:1rem;">
                                <?php if ($c['my_status'] === 'APPROVED'): ?>
                                    <button class="btn btn-outline btn-sm" style="width:100%; cursor:default;" disabled>
                                        &#10003; Enrolled in Class
                                    </button>
                                <?php elseif ($c['my_status'] === 'PENDING'): ?>
                                    <button class="btn btn-outline btn-sm" style="width:100%; color:var(--status-pending);" disabled>
                                        Application Pending
                                    </button>
                                <?php elseif ($isFull): ?>
                                    <button class="btn btn-outline btn-sm" style="width:100%;" disabled>
                                        Capacity Reached
                                    </button>
                                <?php else: ?>
                                    <form action="../../api/student_process.php" method="POST">
                                        <input type="hidden" name="action" value="apply_course">
                                        <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
                                        <button type="submit" class="btn btn-teal btn-sm" style="width:100%;">
                                            <?= $c['my_status'] === 'REJECTED' ? 'Re-Apply for Enrollment' : '+ Apply for Enrollment' ?>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    
    <div class="tab-panel" id="tabApplications">
        <div class="card">
            <div class="card-header">
                <div class="card-title">My Application History &amp; Decisions</div>
                <span class="text-muted" style="font-size:0.85rem;">All courses you have applied for</span>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Instructor</th>
                            <th>Status</th>
                            <th>Applied On</th>
                            <th>Decision Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($myApplications)): ?>
                            <tr><td colspan="6" style="text-align:center; padding:2rem;">No enrollment applications submitted yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($myApplications as $app): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($app['course_code']) ?></strong> &bull; <?= htmlspecialchars($app['course_name']) ?>
                                    </td>
                                    <td>Prof. <?= htmlspecialchars($app['prof_first'] . ' ' . $app['prof_last']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= strtolower($app['status']) ?>">
                                            <?= htmlspecialchars($app['status']) ?>
                                        </span>
                                    </td>
                                    <td style="font-size:0.8rem;"><?= date('M d, Y', strtotime($app['applied_at'])) ?></td>
                                    <td style="font-size:0.8rem;">
                                        <?= $app['decided_at'] ? date('M d, Y', strtotime($app['decided_at'])) : '<span class="text-muted">Awaiting decision</span>' ?>
                                    </td>
                                    <td>
                                        <form action="../../api/student_process.php" method="POST" onsubmit="return confirm('Withdraw or remove this course application?');">
                                            <input type="hidden" name="action" value="drop_course">
                                            <input type="hidden" name="enrollment_id" value="<?= $app['enrollment_id'] ?>">
                                            <button type="submit" class="btn btn-outline btn-sm" style="color:var(--coral-dark);">
                                                <?= $app['status'] === 'APPROVED' ? 'Drop' : 'Cancel' ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-panel" id="tabProfile">
        <div class="profile-layout">
            <div class="profile-card-sidebar">
                <div class="profile-avatar-large">
                    <?= strtoupper(substr($currentUser['first_name'] ?? 'S', 0, 1)) ?>
                </div>
                <h2 style="font-size:1.3rem; color:var(--navy);">
                    <?= htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']) ?>
                </h2>
                <p class="text-muted" style="font-size:0.875rem;"><?= htmlspecialchars($currentUser['email']) ?></p>
                <div style="margin-top:1rem;">
                    <span class="role-pill role-student">APEX Student</span>
                </div>
                <div style="margin-top:1.5rem; text-align:left; font-size:0.85rem; border-top:1px solid var(--surface-border); padding-top:1rem;">
                    <p style="margin-bottom:0.4rem;"><strong>Student ID:</strong> #<?= $studentId ?></p>
                    <p style="margin-bottom:0.4rem;"><strong>Joined:</strong> <?= date('F j, Y', strtotime($currentUser['created_at'])) ?></p>
                    <p><strong>Status:</strong> Active Scholar</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Profile Information</div>
                </div>

                <form action="../../api/student_process.php" method="POST">
                    <input type="hidden" name="action" value="update_profile">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div class="form-group">
                            <label for="prof_fn">First Name *</label>
                            <input type="text" id="prof_fn" name="first_name" class="form-control"
                                placeholder="e.g. Juan" value="<?= htmlspecialchars($currentUser['first_name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prof_ln">Last Name *</label>
                            <input type="text" id="prof_ln" name="last_name" class="form-control"
                                placeholder="e.g. Dela Cruz" value="<?= htmlspecialchars($currentUser['last_name']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="prof_email">APEX Email</label>
                        <input type="email" id="prof_email" class="form-control" value="<?= htmlspecialchars($currentUser['email']) ?>" disabled>
                        <small class="text-muted">Email address is managed by campus administration.</small>
                    </div>

                    <button type="submit" class="btn btn-teal" style="margin-top:0.5rem;">
                        Save Profile Updates
                    </button>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
</div>

<?php require_once '../../includes/footer.php'; ?>
