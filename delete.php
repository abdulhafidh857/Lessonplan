<?php
session_start();
require_once 'config.php';

$id = $_GET['id'] ?? '';
$lessonPlan = getLessonPlan($id);

if (!$lessonPlan) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (deleteLessonPlan($id)) {
        $success = 'Lesson plan deleted successfully!';
        // Redirect after 2 seconds
        header("refresh:2;url=index.php");
    } else {
        $error = 'Failed to delete lesson plan. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Lesson Plan - Enhanced Lesson Plan System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1><i class="fas fa-trash"></i> Delete Lesson Plan</h1>
                <a href="view.php?id=<?= $lessonPlan['id'] ?>" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Lesson Plan
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="delete-container">
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?= htmlspecialchars($success) ?>
                        <br><small>Redirecting to dashboard...</small>
                    </div>
                <?php else: ?>
                    <div class="delete-confirmation">
                        <div class="delete-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h2>Are you sure you want to delete this lesson plan?</h2>
                            <p>This action cannot be undone. The lesson plan will be permanently removed from the system.</p>
                        </div>

                        <div class="lesson-preview">
                            <h3><?= htmlspecialchars($lessonPlan['title']) ?></h3>
                            <div class="lesson-meta">
                                <span><strong>Subject:</strong> <?= htmlspecialchars($lessonPlan['subject']) ?></span>
                                <span><strong>Grade:</strong> <?= htmlspecialchars($lessonPlan['grade']) ?></span>
                                <span><strong>Duration:</strong> <?= htmlspecialchars($lessonPlan['duration']) ?> minutes</span>
                            </div>
                            <p><?= htmlspecialchars($lessonPlan['description']) ?></p>
                        </div>

                        <form method="POST" class="delete-form">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Yes, Delete Lesson Plan
                                </button>
                                <a href="view.php?id=<?= $lessonPlan['id'] ?>" class="btn btn-outline">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>