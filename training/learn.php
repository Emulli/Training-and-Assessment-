<?php 
session_start();
include '../db/connection.php'; 

// 1. SECURITY CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_check = $conn->query("SELECT status FROM users WHERE id=$user_id")->fetch_assoc();

if ($user_check['status'] != 'approved') {
    header("Location: training.php"); 
    exit();
}

// 2. GET COURSE DATA
$course_id = $_GET['course_id'] ?? 0;
$lesson_id = $_GET['lesson_id'] ?? 0;

$course = $conn->query("SELECT * FROM courses WHERE id = $course_id")->fetch_assoc();
if (!$course) exit("<div class='p-10 text-center'>Course not found. <a href='training.php' class='text-blue-500'>Go Back</a></div>");

$lessons = [];
$l_query = $conn->query("SELECT * FROM lessons WHERE course_id = $course_id ORDER BY order_index ASC");
while($l = $l_query->fetch_assoc()) $lessons[] = $l;

// 3. SET ACTIVE LESSON (SAFE MODE)
$current_lesson = null; // Initialize to avoid crash

if (count($lessons) > 0) {
    if ($lesson_id > 0) {
        // Find requested lesson
        foreach($lessons as $l) {
            if ($l['id'] == $lesson_id) {
                $current_lesson = $l;
                break;
            }
        }
    } else {
        // Default to first lesson
        $current_lesson = $lessons[0];
        $lesson_id = $current_lesson['id'];
    }
}

// 4. CHECK QUIZ STATUS (Only if a lesson exists)
$quiz_data = null;
$has_taken_quiz = false;
$question_count = 0;

if ($current_lesson) {
    $q_check = $conn->query("SELECT COUNT(*) as total FROM questions WHERE lesson_id = " . $current_lesson['id']);
    if($q_check) {
        $question_count = $q_check->fetch_assoc()['total'];
    }

    $res_check = $conn->query("SELECT * FROM quiz_results WHERE user_id = $user_id AND lesson_id = " . $current_lesson['id']);
    if ($res_check->num_rows > 0) {
        $has_taken_quiz = true;
        $quiz_data = $res_check->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $course['title']; ?> | Classroom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#4c1d95',
                        brandLight: '#8b5cf6'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans flex flex-col h-screen overflow-hidden">

    <header class="bg-brand h-16 flex items-center justify-between px-6 flex-shrink-0 z-30 shadow-md">
        <div class="flex items-center gap-4">
            <a href="training.php" class="flex items-center text-white/80 hover:text-white transition-colors text-sm font-bold">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Dashboard
            </a>
            <div class="h-6 w-px bg-white/20"></div>
            <h1 class="text-lg font-black text-white tracking-tight">
                <?php echo $course['title']; ?>
            </h1>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-xs font-bold text-white/60 uppercase tracking-widest hidden md:block">Student Mode</span>
            <div class="w-8 h-8 bg-white text-brand rounded-full flex items-center justify-center font-bold text-xs shadow-lg">
                <?php echo substr($_SESSION['user_name'] ?? 'U', 0, 1); ?>
            </div>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        
        <aside class="w-80 bg-white border-r border-gray-200 flex flex-col z-20 flex-shrink-0 shadow-lg hidden md:flex">
             <div class="p-6 border-b border-gray-100">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Course Content</div>
                <div class="text-sm font-bold text-gray-800">Select a lesson</div>
            </div>
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <?php if(count($lessons) > 0): ?>
                    <?php foreach($lessons as $index => $l): ?>
                        <?php $isActive = ($current_lesson && $l['id'] == $current_lesson['id']); ?>
                        <a href="?course_id=<?php echo $course_id; ?>&lesson_id=<?php echo $l['id']; ?>" 
                           class="group flex items-start gap-3 p-3 rounded-xl transition-all border <?php echo $isActive ? 'bg-violet-50 border-violet-200 shadow-sm' : 'border-transparent hover:bg-gray-50'; ?>">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold mt-0.5 <?php echo $isActive ? 'bg-brand text-white' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'; ?>">
                                <?php echo $index + 1; ?>
                            </div>
                            <div class="text-sm font-medium <?php echo $isActive ? 'text-brand font-bold' : 'text-gray-600 group-hover:text-gray-900'; ?>">
                                <?php echo $l['title']; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-8 text-center text-gray-400 text-sm italic">
                        No lessons available for this course yet.
                    </div>
                <?php endif; ?>
            </nav>
        </aside>

        <main class="flex-1 overflow-y-auto relative bg-gray-50 p-6 md:p-10">
            <?php if ($current_lesson): ?>
                
                <div class="max-w-5xl mx-auto space-y-8">
                    <div class="flex items-center justify-between border-b border-gray-200 pb-6">
                        <div>
                            <h2 class="text-3xl font-black text-gray-800 mb-2"><?php echo $current_lesson['title']; ?></h2>
                            <p class="text-sm text-gray-500 flex items-center gap-2">
                                <span class="bg-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs font-bold uppercase">Lesson</span>
                                <?php echo !empty($current_lesson['file_path']) ? 'Read the material below.' : 'This module contains a quiz only.'; ?>
                            </p>
                        </div>
                        <?php if(!empty($current_lesson['file_path'])): ?>
                        <a href="../<?php echo $current_lesson['file_path']; ?>" download class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-brand hover:border-brand transition-all shadow-sm">
                            Download Material
                        </a>
                        <?php endif; ?>
                    </div>

                    <?php if(!empty($current_lesson['file_path'])): ?>
                    <div class="rounded-2xl shadow-xl border border-gray-200 overflow-hidden h-[75vh] relative flex flex-col bg-white">
                        <?php 
                            $file_ext = $current_lesson['file_type'];
                            $file_url = "../" . $current_lesson['file_path']; 
                        ?>
                        <?php if ($file_ext == 'pdf'): ?>
                            <iframe src="<?php echo $file_url; ?>" class="w-full h-full border-0"></iframe>
                        <?php elseif (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <div class="flex-1 overflow-y-auto p-4 bg-gray-50 flex justify-center items-center">
                                <img src="<?php echo $file_url; ?>" class="max-w-full max-h-full shadow-lg rounded">
                            </div>
                        <?php elseif (in_array($file_ext, ['mp4', 'webm', 'ogg'])): ?>
                            <div class="h-full bg-black flex items-center justify-center">
                                <video controls class="max-h-full w-auto shadow-2xl"><source src="<?php echo $file_url; ?>" type="video/<?php echo $file_ext; ?>"></video>
                            </div>
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center h-full bg-gray-50 text-gray-500">
                                <h3 class="text-lg font-bold text-gray-700 mb-2">File Format: <?php echo strtoupper($file_ext); ?></h3>
                                <a href="<?php echo $file_url; ?>" download class="px-6 py-3 bg-brand text-white font-bold rounded-lg shadow-lg hover:bg-violet-800 transition-colors">
                                    Download to View
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if($question_count > 0): ?>
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden p-8 relative">
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-violet-500 to-fuchsia-500"></div>
                            
                            <?php if ($has_taken_quiz): ?>
                                <div class="text-center py-4">
                                    <div class="inline-block p-4 rounded-full bg-violet-50 mb-4 text-4xl border border-violet-100">
                                        <?php 
                                            $percent = ($quiz_data['score'] / $quiz_data['total_items']) * 100;
                                            echo $percent >= 75 ? '🏆' : '📊'; 
                                        ?>
                                    </div>
                                    <h3 class="text-2xl font-black text-gray-800 mb-2">Assessment Complete</h3>
                                    <p class="text-gray-500 mb-6">You scored <strong class="text-brand text-xl"><?php echo $quiz_data['score']; ?> / <?php echo $quiz_data['total_items']; ?></strong></p>
                                    
                                    <div class="w-full bg-gray-200 rounded-full h-4 max-w-md mx-auto overflow-hidden shadow-inner">
                                        <div class="bg-gradient-to-r from-violet-600 to-fuchsia-600 h-4 rounded-full transition-all duration-1000" style="width: <?php echo $percent; ?>%"></div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                                    <div>
                                        <h3 class="text-2xl font-black text-gray-800 mb-2">Ready for the Quiz?</h3>
                                        <div class="flex gap-4 text-sm font-bold text-gray-600">
                                            <span class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-full">
                                                ❓ <?php echo $question_count; ?> Questions
                                            </span>
                                            <span class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-full">
                                                ⏱️ <?php echo $current_lesson['time_limit']; ?> Mins
                                            </span>
                                        </div>
                                    </div>
                                    <a href="quiz.php?course_id=<?php echo $course_id; ?>&lesson_id=<?php echo $lesson_id; ?>" 
                                       onclick="return confirm('⚠️ WARNING: \n\nStarting this quiz will activate the timer.\nLeaving or refreshing the page will AUTO-SUBMIT your answers.\n\nProceed?');"
                                       class="px-10 py-4 bg-brand hover:bg-violet-800 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1">
                                        Start Quiz Now
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>

            <?php else: ?>
                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                    <span class="text-6xl mb-4 opacity-30">🚧</span>
                    <h2 class="text-2xl font-bold text-gray-500">No Content Available</h2>
                    <p class="mt-2 text-sm">The instructor hasn't uploaded any lessons for this course yet.</p>
                    <a href="training.php" class="mt-6 px-6 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold hover:bg-gray-50 text-brand transition-colors shadow-sm">
                        Back to Dashboard
                    </a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>