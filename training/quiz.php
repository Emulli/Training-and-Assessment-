<?php
session_start();
include '../db/connection.php';

// 1. USER CHECK
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
$user_id = $_SESSION['user_id'];

$lesson_id = $_GET['lesson_id'] ?? 0;
$course_id = $_GET['course_id'] ?? 0;

// 2. CHECK IF ALREADY TAKEN
// If found in DB, go back to results immediately
$check = $conn->query("SELECT id FROM quiz_results WHERE user_id=$user_id AND lesson_id=$lesson_id");
if ($check->num_rows > 0) {
    header("Location: learn.php?course_id=$course_id&lesson_id=$lesson_id");
    exit();
}

// 3. FETCH DATA
$lesson = $conn->query("SELECT * FROM lessons WHERE id=$lesson_id")->fetch_assoc();
if (!$lesson) die("Lesson not found");

// Fetch Randomized Questions
$questions = [];
$q_sql = "SELECT * FROM questions WHERE lesson_id=$lesson_id ORDER BY RAND()"; 
$q_query = $conn->query($q_sql);
while($q = $q_query->fetch_assoc()) {
    $q['options'] = [];
    $o_query = $conn->query("SELECT * FROM question_options WHERE question_id=" . $q['id'] . " ORDER BY RAND()");
    while($opt = $o_query->fetch_assoc()) $q['options'][] = $opt;
    $questions[] = $q;
}

// 4. HANDLE SUBMISSION (Both Normal & Auto-Submit)
if (isset($_POST['submit_quiz'])) {
    $score = 0;
    $total = count($questions);
    
    // Calculate Score
    if (isset($_POST['answers'])) {
        foreach($_POST['answers'] as $q_id => $opt_id) {
            $check_ans = $conn->query("SELECT is_correct FROM question_options WHERE id=$opt_id");
            if ($check_ans && $check_ans->fetch_assoc()['is_correct'] == 1) $score++;
        }
    }

    // Insert into DB (Use INSERT IGNORE to prevent double submission errors)
    $stmt = $conn->prepare("INSERT IGNORE INTO quiz_results (user_id, lesson_id, score, total_items) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiii", $user_id, $lesson_id, $score, $total);
    $stmt->execute();

    // If it's a background Beacon request, stop here (don't redirect)
    if (isset($_POST['is_beacon'])) {
        exit(); 
    }

    // Normal redirect
    header("Location: learn.php?course_id=$course_id&lesson_id=$lesson_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz: <?php echo $lesson['title']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { brand: '#4c1d95' } } } }
    </script>
    <style> body { user-select: none; } </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10" oncontextmenu="return false;">

    <div class="max-w-3xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden relative">
        
        <div class="bg-brand p-6 text-white flex justify-between items-center sticky top-0 z-50 shadow-md">
            <div>
                <h1 class="text-xl font-bold"><?php echo $lesson['title']; ?></h1>
                <p class="text-xs opacity-75">Do not refresh or leave this page.</p>
            </div>
            <div class="text-center bg-white/20 px-4 py-2 rounded-lg backdrop-blur-sm border border-white/10">
                <div class="text-[10px] uppercase font-bold tracking-wider opacity-90">Time Remaining</div>
                <div id="timer" class="text-2xl font-mono font-black">00:00</div>
            </div>
        </div>

        <form id="quizForm" method="POST" class="p-8 space-y-8">
            <input type="hidden" name="submit_quiz" value="1">
            
            <?php foreach($questions as $idx => $q): ?>
                <div class="border-b border-gray-100 pb-6 last:border-0">
                    <p class="font-bold text-lg text-gray-800 mb-4 flex gap-3">
                        <span class="flex-shrink-0 w-8 h-8 bg-purple-100 text-brand rounded-full flex items-center justify-center text-sm font-bold"><?php echo $idx + 1; ?></span>
                        <?php echo $q['question_text']; ?>
                    </p>
                    <div class="space-y-3 pl-11">
                        <?php foreach($q['options'] as $opt): ?>
                            <label class="flex items-center p-4 rounded-xl border-2 border-gray-100 cursor-pointer hover:border-brand hover:bg-purple-50 transition-all group">
                                <input type="radio" name="answers[<?php echo $q['id']; ?>]" value="<?php echo $opt['id']; ?>" class="w-5 h-5 text-brand focus:ring-brand" required>
                                <span class="ml-3 text-gray-600 group-hover:text-gray-900 font-medium"><?php echo $opt['option_text']; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="pt-6 border-t border-gray-100 text-right">
                <button type="submit" class="px-10 py-4 bg-brand text-white font-bold rounded-xl shadow-lg hover:bg-purple-800 transition-all transform hover:-translate-y-1">
                    Submit Final Answers
                </button>
            </div>
        </form>
    </div>

    <script>
        // --- 1. TIMER LOGIC ---
        let timeLimit = <?php echo $lesson['time_limit']; ?> * 60; 
        const timerDisplay = document.getElementById('timer');
        
        const timer = setInterval(() => {
            const minutes = Math.floor(timeLimit / 60);
            const seconds = timeLimit % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if(timeLimit < 60) { timerDisplay.parentElement.classList.add('bg-red-500/50', 'animate-pulse'); }

            if (timeLimit <= 0) {
                clearInterval(timer);
                alert("Time is up! Submitting your answers now.");
                document.getElementById('quizForm').submit();
            }
            timeLimit--;
        }, 1000);

        // --- 2. AUTO-SUBMIT LOGIC (The "Finalize" Feature) ---
        let isSubmitted = false;

        function autoSave() {
            if (isSubmitted) return;
            isSubmitted = true;

            const form = document.getElementById('quizForm');
            const formData = new FormData(form);
            formData.append('is_beacon', '1'); // Mark as background request

            // Use sendBeacon for reliable background submission even if tab closes
            navigator.sendBeacon(window.location.href, formData);
        }

        // Trigger on Page Refresh or Tab Close
        window.addEventListener('pagehide', autoSave);
        window.addEventListener('beforeunload', autoSave);

        // Trigger on Visibility Change (Optional: strict mode)
        // document.addEventListener('visibilitychange', () => {
        //    if (document.visibilityState === 'hidden') autoSave();
        // });

        // Normal Submit (Prevent double fire)
        document.getElementById('quizForm').addEventListener('submit', function() {
            window.removeEventListener('pagehide', autoSave);
            window.removeEventListener('beforeunload', autoSave);
            isSubmitted = true;
        });

        // --- 3. DISABLE REFRESH KEYS ---
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F5' || (e.ctrlKey && e.key === 'r')) {
                e.preventDefault();
                alert("Refreshing submits the quiz!");
                autoSave();
                document.getElementById('quizForm').submit();
            }
        });
    </script>

</body>
</html>