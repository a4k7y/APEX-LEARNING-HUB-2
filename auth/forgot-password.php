<?php
session_start();
require_once '../config/db.php';
require_once '../includes/email_policy.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $error = "Please enter your APEX email address.";
    } elseif (!isValidApexEmail($email)) {
        $error = apexEmailPolicyMessage();
    } else {
        $stmt = $pdo->prepare("SELECT id, email FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['reset_user_id'] = (int) $user['id'];
            $_SESSION['reset_email'] = $user['email'];
            header("Location: reset-password.php");
            exit;
        }

        $error = "No account was found with that email address.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password • APEX Learning Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=202610291340">
    <link rel="stylesheet" href="../visual/css/visual.css?v=202610291340">
    <link rel="stylesheet" href="../css/auth.css">
    <style>
        .auth-page {
            display: block;
            padding: 0;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.18) 0%, rgba(255, 236, 240, 0.22) 100%),
                url('../bgimage/APEX Learning Hub.png') center / cover fixed no-repeat;
        }

        .auth-page .sub-search {
            display: none;
        }

        .auth-main {
            min-height: calc(100vh - 68px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            padding-bottom: 75px;
        }

        .auth-container {
            width: min(780px, calc(100vw - 32px));
            max-width: 780px;
            min-height: 520px;
            position: relative;
            isolation: isolate;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, 0.72), rgba(255, 226, 233, 0.58)),
                url('../bgimage/APEX Learning Hub.png') 52% 48% / cover no-repeat;
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow:
                0 24px 70px rgba(126, 54, 74, 0.16),
                inset 0 1px 0 rgba(255, 255, 255, 0.95);
            grid-template-columns: 1fr;
        }

        .auth-form-panel {
            position: relative;
            z-index: 1;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(2px);
        }

        .auth-form-header {
            margin-bottom: 1.75rem;
        }

        .auth-form-header h1 {
            color: #d98596;
            font-size: 2.75rem;
            font-weight: 800;
            line-height: 1.2;
        }

        .auth-form-header p {
            margin-top: 0.5rem;
            color: #64748b;
            font-size: 1.25rem;
            line-height: 1.6;
        }

        .auth-page .form-group label {
            color: #d98596;
            font-weight: 600;
        }

        .auth-page .form-control {
            height: 48px;
            border-color: rgba(148, 163, 184, 0.55);
            background: rgba(255, 255, 255, 0.82);
            box-shadow: 0 5px 18px rgba(217, 133, 150, 0.035);
        }

        .auth-page .form-control:focus {
            border-color: rgba(230, 161, 174, 0.58);
            background: rgba(255, 255, 255, 0.94);
            box-shadow: 0 0 0 3px rgba(230, 161, 174, 0.1);
            outline: none;
        }

        .auth-page .btn-primary {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #df8d9d, #e6a1ae);
            border: 1px solid #df8d9d;
            color: #fff;
            box-shadow: 0 4px 14px rgba(223, 141, 157, 0.24);
        }

        .auth-page .btn-primary:hover {
            background: linear-gradient(135deg, #e6a1ae, #efb4be);
            color: #fff;
            box-shadow: 0 6px 18px rgba(223, 141, 157, 0.32);
        }

        .auth-switch {
            margin-top: 1.5rem;
        }

        .auth-switch a {
            color: #d98596;
            font-weight: 600;
        }

        .auth-switch a:hover {
            color: #e6a1ae;
        }

        @media (max-width: 640px) {
            .auth-form-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="auth-page" data-visual-base="../visual/">
    <?php
    $visualBase = '../visual/';
    include __DIR__ . '/../visual/_partials/navigation.php';
    ?>

    <main class="auth-main">
        <div class="auth-container">
            <section class="auth-form-panel">
                <div class="auth-form-header">
                    <h1>Forgot Password?</h1>
                    <p>Enter your registered APEX email to reset your portal password.</p>
                </div>

                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger" role="alert">
                        <span><?= htmlspecialchars($error) ?></span>
                    </div>
                <?php endif; ?>

                <form action="forgot-password.php" method="POST" autocomplete="on">
                    <div class="form-group">
                        <label for="email">APEX Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="e.g. name@apex.edu.ph" pattern="[A-Za-z0-9._%+\-]+@apex\.edu\.ph"
                            title="Use an APEX Email ending in @apex.edu.ph." autocomplete="email" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Find Account &amp; Proceed
                    </button>
                </form>

                <div class="auth-switch">
                    <a href="login.php">&larr; Return to Sign In</a>
                </div>
            </section>
        </div>
    </main>

    <?php
    $visualBase = '../visual/';
    include __DIR__ . '/../visual/_partials/foot.php';
    ?>
</body>
</html>
