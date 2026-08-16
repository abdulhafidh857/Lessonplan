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
    // Validate required fields
    $required_fields = ['title', 'subject', 'grade', 'duration', 'description', 'objectives', 'content'];
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = ucfirst($field);
        }
    }
    
    if (!empty($missing_fields)) {
        $error = 'Please fill in all required fields: ' . implode(', ', $missing_fields);
    } else {
        // Sanitize input data
        $data = [
            'title' => sanitizeInput($_POST['title']),
            'subject' => sanitizeInput($_POST['subject']),
            'grade' => sanitizeInput($_POST['grade']),
            'duration' => sanitizeInput($_POST['duration']),
            'description' => sanitizeInput($_POST['description']),
            'objectives' => sanitizeInput($_POST['objectives']),
            'materials' => sanitizeInput($_POST['materials']),
            'content' => sanitizeInput($_POST['content']),
            'assessment' => sanitizeInput($_POST['assessment']),
            'homework' => sanitizeInput($_POST['homework'])
        ];
        
        if (updateLessonPlan($id, $data)) {
            $success = 'Lesson plan updated successfully!';
            // Refresh the lesson plan data
            $lessonPlan = getLessonPlan($id);
            // Redirect after 2 seconds
            header("refresh:2;url=view.php?id=" . $id);
        } else {
            $error = 'Failed to update lesson plan. Please try again.';
        }
    }
}

// Use POST data if available, otherwise use existing lesson plan data
$formData = $_POST ?: $lessonPlan;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= htmlspecialchars($lessonPlan['title']) ?> - Enhanced Lesson Plan System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1><i class="fas fa-edit"></i> Edit Lesson Plan</h1>
                <div class="header-actions">
                    <a href="view.php?id=<?= $lessonPlan['id'] ?>" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back to View
                    </a>
                    <a href="index.php" class="btn btn-outline">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="form-container">
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
                        <br><small>Redirecting to lesson plan...</small>
                    </div>
                <?php endif; ?>

                <form method="POST" class="lesson-form">
                    <div class="form-grid">
                        <!-- Basic Information -->
                        <div class="form-section">
                            <h3><i class="fas fa-info-circle"></i> Basic Information</h3>
                            
                            <div class="form-group">
                                <label for="title">Lesson Title *</label>
                                <input type="text" id="title" name="title" required 
                                       value="<?= htmlspecialchars($formData['title']) ?>"
                                       placeholder="Enter the lesson title">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="subject">Subject *</label>
                                    <input type="text" id="subject" name="subject" required 
                                           value="<?= htmlspecialchars($formData['subject']) ?>"
                                           placeholder="e.g., Mathematics, Science">
                                </div>

                                <div class="form-group">
                                    <label for="grade">Grade Level *</label>
                                    <input type="text" id="grade" name="grade" required 
                                           value="<?= htmlspecialchars($formData['grade']) ?>"
                                           placeholder="e.g., 5, 6-8, High School">
                                </div>

                                <div class="form-group">
                                    <label for="duration">Duration (minutes) *</label>
                                    <input type="number" id="duration" name="duration" required min="1" max="300"
                                           value="<?= htmlspecialchars($formData['duration']) ?>"
                                           placeholder="45">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description *</label>
                                <textarea id="description" name="description" required rows="3"
                                          placeholder="Brief description of the lesson"><?= htmlspecialchars($formData['description']) ?></textarea>
                            </div>
                        </div>

                        <!-- Learning Objectives -->
                        <div class="form-section">
                            <h3><i class="fas fa-target"></i> Learning Objectives</h3>
                            
                            <div class="form-group">
                                <label for="objectives">Objectives *</label>
                                <textarea id="objectives" name="objectives" required rows="4"
                                          placeholder="List the learning objectives for this lesson"><?= htmlspecialchars($formData['objectives']) ?></textarea>
                            </div>
                        </div>

                        <!-- Materials & Resources -->
                        <div class="form-section">
                            <h3><i class="fas fa-tools"></i> Materials & Resources</h3>
                            
                            <div class="form-group">
                                <label for="materials">Materials Needed</label>
                                <textarea id="materials" name="materials" rows="3"
                                          placeholder="List all materials, resources, and equipment needed"><?= htmlspecialchars($formData['materials']) ?></textarea>
                            </div>
                        </div>

                        <!-- Lesson Content -->
                        <div class="form-section">
                            <h3><i class="fas fa-book-open"></i> Lesson Content</h3>
                            
                            <div class="form-group">
                                <label for="content">Lesson Content & Activities *</label>
                                <textarea id="content" name="content" required rows="8"
                                          placeholder="Detailed lesson content, activities, and teaching strategies"><?= htmlspecialchars($formData['content']) ?></textarea>
                            </div>
                        </div>

                        <!-- Assessment -->
                        <div class="form-section">
                            <h3><i class="fas fa-clipboard-check"></i> Assessment</h3>
                            
                            <div class="form-group">
                                <label for="assessment">Assessment Methods</label>
                                <textarea id="assessment" name="assessment" rows="4"
                                          placeholder="How will you assess student learning and understanding?"><?= htmlspecialchars($formData['assessment']) ?></textarea>
                            </div>
                        </div>

                        <!-- Homework -->
                        <div class="form-section">
                            <h3><i class="fas fa-home"></i> Homework & Follow-up</h3>
                            
                            <div class="form-group">
                                <label for="homework">Homework Assignment</label>
                                <textarea id="homework" name="homework" rows="3"
                                          placeholder="Homework or follow-up activities (if any)"><?= htmlspecialchars($formData['homework']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Lesson Plan
                        </button>
                        <a href="view.php?id=<?= $lessonPlan['id'] ?>" class="btn btn-outline">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>