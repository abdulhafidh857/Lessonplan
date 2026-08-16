<?php
session_start();
require_once 'config.php';

$id = $_GET['id'] ?? '';
$lessonPlan = getLessonPlan($id);

if (!$lessonPlan) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($lessonPlan['title']) ?> - Enhanced Lesson Plan System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1><i class="fas fa-eye"></i> View Lesson Plan</h1>
                <div class="header-actions">
                    <a href="index.php" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <a href="edit.php?id=<?= $lessonPlan['id'] ?>" class="btn btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="lesson-view">
                <!-- Lesson Header -->
                <div class="lesson-view-header">
                    <div class="lesson-title-section">
                        <h2 class="lesson-view-title"><?= htmlspecialchars($lessonPlan['title']) ?></h2>
                        <p class="lesson-view-description"><?= htmlspecialchars($lessonPlan['description']) ?></p>
                    </div>
                    
                    <div class="lesson-meta-grid">
                        <div class="meta-item">
                            <i class="fas fa-book"></i>
                            <div>
                                <label>Subject</label>
                                <value><?= htmlspecialchars($lessonPlan['subject']) ?></value>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-users"></i>
                            <div>
                                <label>Grade Level</label>
                                <value><?= htmlspecialchars($lessonPlan['grade']) ?></value>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <label>Duration</label>
                                <value><?= htmlspecialchars($lessonPlan['duration']) ?> minutes</value>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <div>
                                <label>Created</label>
                                <value><?= date('M j, Y', strtotime($lessonPlan['created_at'])) ?></value>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lesson Content -->
                <div class="lesson-content-grid">
                    <!-- Learning Objectives -->
                    <div class="content-section">
                        <h3><i class="fas fa-target"></i> Learning Objectives</h3>
                        <div class="content-text">
                            <?= nl2br(htmlspecialchars($lessonPlan['objectives'])) ?>
                        </div>
                    </div>

                    <!-- Materials -->
                    <?php if ($lessonPlan['materials']): ?>
                    <div class="content-section">
                        <h3><i class="fas fa-tools"></i> Materials & Resources</h3>
                        <div class="content-text">
                            <?= nl2br(htmlspecialchars($lessonPlan['materials'])) ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Lesson Content -->
                    <div class="content-section full-width">
                        <h3><i class="fas fa-book-open"></i> Lesson Content & Activities</h3>
                        <div class="content-text">
                            <?= nl2br(htmlspecialchars($lessonPlan['content'])) ?>
                        </div>
                    </div>

                    <!-- Assessment -->
                    <?php if ($lessonPlan['assessment']): ?>
                    <div class="content-section">
                        <h3><i class="fas fa-clipboard-check"></i> Assessment Methods</h3>
                        <div class="content-text">
                            <?= nl2br(htmlspecialchars($lessonPlan['assessment'])) ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Homework -->
                    <?php if ($lessonPlan['homework']): ?>
                    <div class="content-section">
                        <h3><i class="fas fa-home"></i> Homework & Follow-up</h3>
                        <div class="content-text">
                            <?= nl2br(htmlspecialchars($lessonPlan['homework'])) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="lesson-actions-footer">
                    <a href="edit.php?id=<?= $lessonPlan['id'] ?>" class="btn btn-secondary">
                        <i class="fas fa-edit"></i> Edit This Lesson Plan
                    </a>
                    <a href="delete.php?id=<?= $lessonPlan['id'] ?>" class="btn btn-danger" 
                       onclick="return confirm('Are you sure you want to delete this lesson plan?')">
                        <i class="fas fa-trash"></i> Delete Lesson Plan
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>