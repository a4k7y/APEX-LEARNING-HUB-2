<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pageTitle = $pageTitle ?? 'APEX Learning Hub';
$activeUserRole = $_SESSION['role'] ?? 'guest';
$activeUserRoleLabel = match ($activeUserRole) {
    'admin' => 'Administrator',
    'registrar' => 'Registrar',
    'dean' => 'Dean',
    default => ucfirst($activeUserRole),
};
$isStudentPortal = $activeUserRole === 'student' && !empty($useVisualTheme);
$isAdminPortal = $activeUserRole === 'admin' && !empty($useVisualTheme);
$isRegistrarPortal = $activeUserRole === 'registrar' && !empty($useVisualTheme);
$isFacultyPortal = $activeUserRole === 'professor' && !empty($useVisualTheme);
$isDeanPortal = $activeUserRole === 'dean' && !empty($useVisualTheme);
$siteRootPath = isset($_SERVER['SCRIPT_FILENAME'])
    && str_contains(str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']), '/views/')
    ? '../../'
    : '../';
$activeUserName = $_SESSION['user_name'] ?? 'Guest User';
$userInitials = '';
if (!empty($activeUserName)) {
    $parts = explode(' ', trim($activeUserName));
    $userInitials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= $siteRootPath ?>css/style.css?v=202610312110">
    <?php if (!empty($useVisualTheme)): ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?= $siteRootPath ?>visual/css/visual.css?v=202610291340">
    <?php endif; ?>
    <?php if (isset($extraCss)): ?>
        <?php foreach ((array) $extraCss as $stylesheet): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($stylesheet) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body<?= !empty($bodyClass) ? ' class="' . htmlspecialchars($bodyClass) . '"' : '' ?><?= !empty($useVisualTheme) ? ' data-visual-base="' . htmlspecialchars($siteRootPath . 'visual/') . '"' : '' ?>>
    <header class="app-navbar">
    <?php if (!empty($useVisualTheme)): ?>
        <div class="navbar-brand header-logo" role="img" aria-label="APEX Learning Hub">
            <svg class="header-logo-mark" viewBox="0 0 504 428" role="img" aria-hidden="true">
                <title>APEX Brand Mark</title>
                <path fill="var(--red-base)" d="M252 0 154 103a19 19 0 0 0-5 13v97L0 361v67h82l120-119v-62l50-49z" />
                <path fill="var(--red-base)" d="m262 13 87 92a15 15 0 0 1 5 12v97l150 147v67h-75L301 301v-53l-39-40z" />
                <path fill="var(--red-base)" d="M213 312h83l118 116h-99l-55-56h-57l-54 56H97z" />
                </svg>
            <span class="header-logo-type">
                <span class="header-wordmark">APEX</span>
                <span class="header-tagline">Learning Hub</span>
            </span>
        </div>
    <?php else: ?>
        <div class="navbar-brand" role="img" aria-label="APEX Learning Hub">
            <div class="logo logo-nav">
                <svg class="logo-mark" viewBox="0 0 504 428" role="img" aria-labelledby="nav-mark-title">
                    <title id="nav-mark-title">APEX three-part geometric mark</title>
                    <path fill="var(--navy)" d="M252 0 154 103a19 19 0 0 0-5 13v97L0 361v67h82l120-119v-62l50-49z" />
                    <path fill="var(--teal)" d="m262 13 87 92a15 15 0 0 1 5 12v97l150 147v67h-75L301 301v-53l-39-40z" />
                    <path fill="var(--coral)" d="M213 312h83l118 116h-99l-55-56h-57l-54 56H97z" />
                </svg>
                <div class="logo-type">
                    <span class="wordmark">APEX</span>
                    <span class="tagline">Learning Hub</span>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($useVisualTheme)): ?>
        <?php require __DIR__ . '/language_switcher.php'; ?>
    <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="navbar-right">
                <?php if ($isStudentPortal || $isAdminPortal || $isRegistrarPortal || $isFacultyPortal || $isDeanPortal): ?>
                    <div class="student-profile-menu" data-profile-menu>
                        <button class="user-badge student-profile-trigger" type="button" aria-haspopup="true"
                            aria-expanded="false" aria-controls="profileDropdown" data-profile-menu-trigger>
                            <span class="avatar-circle"><?= htmlspecialchars($userInitials) ?></span>
                            <span class="user-meta">
                                <span class="user-name"><?= htmlspecialchars($activeUserName) ?></span>
                                <span class="role-pill role-<?= htmlspecialchars($activeUserRole) ?>"><?= htmlspecialchars($activeUserRoleLabel) ?></span>
                            </span>
                            <svg class="student-profile-chevron" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="m3 6 5 5 5-5"></path>
                            </svg>
                        </button>
                        <div class="student-profile-dropdown" id="profileDropdown" data-profile-menu-content hidden>
                            <a class="student-profile-dropdown-link" href="<?= $isAdminPortal ? 'admin_profile.php' : ($isRegistrarPortal ? 'registrar_dashboard.php' : ($isFacultyPortal ? 'professor_dashboard.php' : ($isDeanPortal ? 'dean_dashboard.php' : 'student_dashboard.php#tabProfile'))) ?>">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"></circle><path d="M4 21a8 8 0 0 1 16 0"></path></svg>
                                <span>My Profile</span>
                            </a>
                            <div class="student-profile-language">
                                <?php require __DIR__ . '/language_switcher.php'; ?>
                            </div>
                            <a href="<?= $siteRootPath ?>auth/logout.php" class="student-profile-dropdown-link student-profile-signout"
                                title="Sign out of your session">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 17l5-5-5-5"></path><path d="M15 12H3"></path><path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"></path></svg>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="user-badge">
                        <div class="avatar-circle"><?= htmlspecialchars($userInitials) ?></div>
                        <div class="user-meta">
                            <span class="user-name"><?= htmlspecialchars($activeUserName) ?></span>
                            <span class="role-pill role-<?= htmlspecialchars($activeUserRole) ?>">
                                <?= htmlspecialchars($activeUserRoleLabel) ?>
                            </span>
                        </div>
                    </div>
                    <a href="<?= $siteRootPath ?>auth/logout.php" class="btn btn-outline btn-sm<?= !empty($useVisualTheme) ? ' admin-signout' : '' ?>" title="Sign out of your session">
                        Sign Out
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="navbar-right">
                <a href="<?= $siteRootPath ?>auth/login.php" class="btn btn-primary btn-sm">Sign In</a>
                <a href="<?= $siteRootPath ?>auth/register.php" class="btn btn-teal btn-sm">Register</a>
            </div>
        <?php endif; ?>
    </header>
    <main class="app-main">
