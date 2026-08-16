<?php
session_start();
require_once 'config.php';

// Get all lesson plans
$lessonPlans = getLessonPlans();
$subjects = getSubjects();

// Filter by subject if requested
$filterSubject = $_GET['subject'] ?? '';
$searchQuery = $_GET['search'] ?? '';

if ($filterSubject || $searchQuery) {
    $lessonPlans = array_filter($lessonPlans, function($plan) use ($filterSubject, $searchQuery) {
        $subjectMatch = !$filterSubject || $plan['subject'] === $filterSubject;
        $searchMatch = !$searchQuery || 
                      stripos($plan['title'], $searchQuery) !== false ||
                      stripos($plan['description'], $searchQuery) !== false ||
                      stripos($plan['content'], $searchQuery) !== false;
        return $subjectMatch && $searchMatch;
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Lesson Plan System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1><i class="fas fa-graduation-cap"></i> Lesson Plan Manager</h1>
                <p>Create and manage your lesson plans with ease</p>
            </div>
        </header>

        <!-- Navigation -->
        <nav class="nav-bar">
            <div class="nav-content">
                <a href="create.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Lesson Plan
                </a>
                
                <!-- Search and Filter -->
                <div class="search-filter">
                    <form method="GET" class="search-form">
                        <div class="search-group">
                            <input type="text" name="search" placeholder="Search lesson plans..." 
                                   value="<?= htmlspecialchars($searchQuery) ?>" class="search-input">
                            <select name="subject" class="filter-select">
                                <option value="">All Subjects</option>
                                <?php foreach ($subjects as $subject): ?>
                                    <option value="<?= htmlspecialchars($subject) ?>" 
                                            <?= $filterSubject === $subject ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($subject) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <?php if (empty($lessonPlans)): ?>
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <h2>No lesson plans found</h2>
                    <p>Get started by creating your first lesson plan!</p>
                    <a href="create.php" class="btn btn-primary">Create Lesson Plan</a>
                </div>
            <?php else: ?>
                <div class="lesson-grid">
                    <?php foreach ($lessonPlans as $plan): ?>
                        <div class="lesson-card">
                            <div class="lesson-header">
                                <div class="lesson-subject"><?= htmlspecialchars($plan['subject']) ?></div>
                                <div class="lesson-duration">
                                    <i class="fas fa-clock"></i> <?= htmlspecialchars($plan['duration']) ?> min
                                </div>
                            </div>
                            
                            <h3 class="lesson-title"><?= htmlspecialchars($plan['title']) ?></h3>
                            <p class="lesson-description"><?= htmlspecialchars($plan['description']) ?></p>
                            
                            <div class="lesson-meta">
                                <span class="lesson-grade">
                                    <i class="fas fa-users"></i> Grade <?= htmlspecialchars($plan['grade']) ?>
                                </span>
                                <span class="lesson-date">
                                    <i class="fas fa-calendar"></i> <?= date('M j, Y', strtotime($plan['created_at'])) ?>
                                </span>
                            </div>
                            
                            <div class="lesson-actions">
                                <a href="view.php?id=<?= $plan['id'] ?>" class="btn btn-outline">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="edit.php?id=<?= $plan['id'] ?>" class="btn btn-secondary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete.php?id=<?= $plan['id'] ?>" class="btn btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this lesson plan?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; 2025 Enhanced Lesson Plan System. Built with PHP.</p>
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>