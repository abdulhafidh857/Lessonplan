<?php
// Configuration file for the Lesson Plan System

// Data directory
define('DATA_DIR', 'data');
define('LESSON_PLANS_FILE', DATA_DIR . '/lesson_plans.json');

// Create data directory if it doesn't exist
if (!file_exists(DATA_DIR)) {
    mkdir(DATA_DIR, 0755, true);
}

// Initialize lesson plans file if it doesn't exist
if (!file_exists(LESSON_PLANS_FILE)) {
    file_put_contents(LESSON_PLANS_FILE, json_encode([]));
}

/**
 * Get all lesson plans
 */
function getLessonPlans() {
    $data = file_get_contents(LESSON_PLANS_FILE);
    return json_decode($data, true) ?: [];
}

/**
 * Save lesson plans
 */
function saveLessonPlans($plans) {
    return file_put_contents(LESSON_PLANS_FILE, json_encode($plans, JSON_PRETTY_PRINT));
}

/**
 * Get a single lesson plan by ID
 */
function getLessonPlan($id) {
    $plans = getLessonPlans();
    foreach ($plans as $plan) {
        if ($plan['id'] === $id) {
            return $plan;
        }
    }
    return null;
}

/**
 * Add a new lesson plan
 */
function addLessonPlan($data) {
    $plans = getLessonPlans();
    $newPlan = [
        'id' => uniqid(),
        'title' => $data['title'],
        'subject' => $data['subject'],
        'grade' => $data['grade'],
        'duration' => $data['duration'],
        'description' => $data['description'],
        'objectives' => $data['objectives'],
        'materials' => $data['materials'],
        'content' => $data['content'],
        'assessment' => $data['assessment'],
        'homework' => $data['homework'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $plans[] = $newPlan;
    saveLessonPlans($plans);
    return $newPlan['id'];
}

/**
 * Update an existing lesson plan
 */
function updateLessonPlan($id, $data) {
    $plans = getLessonPlans();
    
    foreach ($plans as &$plan) {
        if ($plan['id'] === $id) {
            $plan['title'] = $data['title'];
            $plan['subject'] = $data['subject'];
            $plan['grade'] = $data['grade'];
            $plan['duration'] = $data['duration'];
            $plan['description'] = $data['description'];
            $plan['objectives'] = $data['objectives'];
            $plan['materials'] = $data['materials'];
            $plan['content'] = $data['content'];
            $plan['assessment'] = $data['assessment'];
            $plan['homework'] = $data['homework'];
            $plan['updated_at'] = date('Y-m-d H:i:s');
            break;
        }
    }
    
    return saveLessonPlans($plans);
}

/**
 * Delete a lesson plan
 */
function deleteLessonPlan($id) {
    $plans = getLessonPlans();
    $plans = array_filter($plans, function($plan) use ($id) {
        return $plan['id'] !== $id;
    });
    
    return saveLessonPlans(array_values($plans));
}

/**
 * Get unique subjects
 */
function getSubjects() {
    $plans = getLessonPlans();
    $subjects = array_unique(array_column($plans, 'subject'));
    sort($subjects);
    return $subjects;
}

/**
 * Sanitize input
 */
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>