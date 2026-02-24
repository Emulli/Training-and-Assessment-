<?php
session_start();
include '../db/connection.php';

// LOAD PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit(); }

// --- BULK ACTION LOGIC ---
if (isset($_POST['bulk_action_type'])) {
    $ids = $_POST['selected_users'] ?? [];
    $type = $_POST['bulk_action_type']; // 'approve' or 'reject'
    
    if (!empty($ids)) {
        foreach ($ids as $uid) {
            // Get user info for email & requested category
            $u = $conn->query("SELECT email, name, requested_category FROM users WHERE id = $uid")->fetch_assoc();
            
            if ($type == 'approve') {
                $category_to_assign = $u['requested_category'] ?? 'Vocational'; // Default if empty
                $stmt = $conn->prepare("UPDATE users SET status = 'approved', enrolled_category = ? WHERE id = ?");
                $stmt->bind_param("si", $category_to_assign, $uid);
                
                if($stmt->execute()) {
                    // Send Email (Simplified)
                    try {
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; $mail->SMTPAuth = true;
                        $mail->Username = 'jhon.emerwin05@gmail.com'; $mail->Password = 'lspwgnuryyospkve';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; $mail->Port = 587;
                        $mail->setFrom('no-reply@tvlstc.edu', 'TVLSTC Admin');
                        $mail->addAddress($u['email'], $u['name']);
                        $mail->isHTML(true);
                        $mail->Subject = 'Application Approved - TVLSTC';
                        $mail->Body = "Hi {$u['name']},<br>You have been approved for <strong>$category_to_assign</strong>.<br><a href='http://localhost/OJT/login.php'>Login Now</a>";
                        $mail->send();
                    } catch (Exception $e) {}
                }
            } else {
                $conn->query("UPDATE users SET status = 'rejected' WHERE id = $uid");
            }
        }
    }
    header("Location: dashboard.php?page=applicants");
    exit();
}

// ... (Keep existing Course/Lesson/Quiz Add/Delete Logic Here - It's unchanged) ...
// (I am omitting it for brevity, but keep your existing ADD/DELETE PHP blocks here)

// 2. ADD COURSE
if (isset($_POST['add_course'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $category = $_POST['category'];
    $thumbnail = '';

    if (!empty($_FILES['thumbnail']['name'])) {
        $target_dir = "../assets/uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $file_name = time() . "_" . basename($_FILES["thumbnail"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
            $thumbnail = "assets/uploads/" . $file_name;
        }
    }

    $stmt = $conn->prepare("INSERT INTO courses (title, description, thumbnail, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $desc, $thumbnail, $category);
    $stmt->execute();
    header("Location: dashboard.php?page=courses");
    exit();
}

// 3. ADD LESSON
if (isset($_POST['add_lesson'])) {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $time_limit = $_POST['time_limit'];
    $db_path = NULL;
    $file_type = NULL;

    if (!empty($_FILES["lesson_file"]["name"])) {
        $target_dir = "../assets/uploads/lessons/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $file_name = time() . "_" . basename($_FILES["lesson_file"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (move_uploaded_file($_FILES["lesson_file"]["tmp_name"], $target_file)) {
            $db_path = "assets/uploads/lessons/" . $file_name;
        }
    }

    $stmt = $conn->prepare("INSERT INTO lessons (course_id, title, file_path, file_type, time_limit) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $course_id, $title, $db_path, $file_type, $time_limit);
    $stmt->execute();
    header("Location: dashboard.php?page=edit_course&id=$course_id");
    exit();
}

// 4. ADD QUIZ QUESTION
if (isset($_POST['add_question'])) {
    $lesson_id = $_POST['lesson_id'];
    $course_id = $_POST['course_id'];
    $q_text = $_POST['question_text'];
    $correct_idx = $_POST['correct_option'];
    $options = $_POST['options'];

    $stmt = $conn->prepare("INSERT INTO questions (lesson_id, question_text) VALUES (?, ?)");
    $stmt->bind_param("is", $lesson_id, $q_text);
    $stmt->execute();
    $question_id = $conn->insert_id;

    foreach ($options as $index => $opt_text) {
        $is_correct = ($index == $correct_idx) ? 1 : 0;
        $stmt_opt = $conn->prepare("INSERT INTO question_options (question_id, option_text, is_correct) VALUES (?, ?, ?)");
        $stmt_opt->bind_param("isi", $question_id, $opt_text, $is_correct);
        $stmt_opt->execute();
    }
    header("Location: dashboard.php?page=manage_quiz&lesson_id=$lesson_id&course_id=$course_id");
    exit();
}

// 5. DELETE ITEM
if (isset($_POST['delete_item'])) {
    $type = $_POST['type'];
    $id = $_POST['id'];
    if ($type == 'course') {
        $conn->query("DELETE FROM courses WHERE id=$id");
        header("Location: dashboard.php?page=courses");
    } elseif ($type == 'lesson') {
        $course_id = $_POST['redirect_id'];
        $conn->query("DELETE FROM lessons WHERE id=$id");
        header("Location: dashboard.php?page=edit_course&id=$course_id");
    } elseif ($type == 'question') {
        $lesson_id = $_POST['redirect_id'];
        $course_id = $_POST['course_id'];
        $conn->query("DELETE FROM questions WHERE id=$id");
        header("Location: dashboard.php?page=manage_quiz&lesson_id=$lesson_id&course_id=$course_id");
    }
    exit();
}

$page = $_GET['page'] ?? 'courses';
$filter_category = $_GET['filter_cat'] ?? 'all'; // Get filter
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | TVLSTC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { primary: '#4c1d95' } } } }
    </script>
</head>
<body class="bg-gray-50 text-gray-700 font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col shadow-lg z-20">
        <div class="h-20 flex items-center justify-center border-b border-gray-50">
            <span class="text-2xl font-black text-gray-800">TVL<span class="text-primary">STC</span></span>
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="?page=applicants" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium <?php echo $page=='applicants'?'bg-purple-50 text-primary':'text-gray-500 hover:bg-gray-50'; ?>">
                👥 Applicants
                <?php 
                    $pending_count = $conn->query("SELECT COUNT(*) as total FROM users WHERE status='pending_approval'")->fetch_assoc()['total'];
                    if($pending_count > 0) echo "<span class='bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full'>$pending_count</span>";
                ?>
            </a>
            <a href="?page=courses" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium <?php echo $page=='courses'?'bg-purple-50 text-primary':'text-gray-500 hover:bg-gray-50'; ?>">📚 Manage Courses</a>
            <a href="?page=students" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium <?php echo $page=='students'?'bg-purple-50 text-primary':'text-gray-500 hover:bg-gray-50'; ?>">🎓 Students</a>
        </nav>
        <div class="p-4"><a href="logout.php" class="block w-full py-2 text-center bg-red-50 text-red-500 rounded-lg font-bold">Sign Out</a></div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-8 relative">
        <div class="max-w-6xl mx-auto">

            <?php if ($page == 'applicants'): ?>
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-black text-gray-800">Incoming Applications</h1>
                    
                    <form method="GET" class="flex gap-2">
                        <input type="hidden" name="page" value="applicants">
                        <select name="filter_cat" onchange="this.form.submit()" class="px-4 py-2 border rounded-lg bg-white text-sm font-bold text-gray-600">
                            <option value="all" <?php echo $filter_category=='all'?'selected':''; ?>>All Programs</option>
                            <option value="IT" <?php echo $filter_category=='IT'?'selected':''; ?>>IT Only</option>
                            <option value="Cybersecurity" <?php echo $filter_category=='Cybersecurity'?'selected':''; ?>>Cybersecurity</option>
                            <option value="Business" <?php echo $filter_category=='Business'?'selected':''; ?>>Bookkeeping</option>
                        </select>
                    </form>
                </div>

                <form method="POST" id="bulkForm">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 w-10"><input type="checkbox" onclick="toggleAll(this)"></th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Applicant</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Applied For</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Requirements</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php 
                                $sql = "SELECT * FROM users WHERE status = 'pending_approval'";
                                if ($filter_category != 'all') {
                                    $sql .= " AND requested_category = '$filter_category'";
                                }
                                $sql .= " ORDER BY created_at DESC";
                                $result = $conn->query($sql);
                                
                                if($result && $result->num_rows > 0): while($row = $result->fetch_assoc()): 
                                ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4"><input type="checkbox" name="selected_users[]" value="<?php echo $row['id']; ?>" class="user-checkbox rounded text-primary focus:ring-primary"></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                                                <?php if(!empty($row['avatar'])): ?><img src="../<?php echo $row['avatar']; ?>" class="w-full h-full object-cover"><?php else: ?><div class="w-full h-full bg-primary text-white flex items-center justify-center text-xs font-bold"><?php echo substr($row['name'],0,1); ?></div><?php endif; ?>
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800"><?php echo $row['name']; ?></div>
                                                <div class="text-xs text-gray-500"><?php echo $row['email']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-purple-50 text-primary px-2 py-1 rounded text-xs font-bold">
                                            <?php echo $row['requested_category'] ?? 'Unspecified'; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if(!empty($row['requirement_file'])): ?>
                                            <a href="../<?php echo $row['requirement_file']; ?>" target="_blank" class="text-blue-600 text-xs font-bold hover:underline">📄 View File</a>
                                        <?php else: ?>
                                            <span class="text-gray-300 text-xs italic">Missing</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-yellow-600 bg-yellow-50 px-2 py-1 rounded text-xs font-bold">Pending</span>
                                    </td>
                                </tr>
                                <?php endwhile; else: ?>
                                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">No pending applications found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-4 z-50 transition-all duration-300" id="bulkBar" style="display:none; transform: translate(-50%, 100px);">
                        <span class="text-sm font-bold"><span id="count">0</span> Selected</span>
                        <div class="h-4 w-px bg-gray-700"></div>
                        <button type="submit" name="bulk_action_type" value="approve" class="text-green-400 hover:text-green-300 font-bold text-sm">Approve Selected</button>
                        <button type="submit" name="bulk_action_type" value="reject" class="text-red-400 hover:text-red-300 font-bold text-sm" onclick="return confirm('Reject selected?')">Reject</button>
                    </div>
                </form>

                <script>
                    function toggleAll(source) {
                        checkboxes = document.getElementsByClassName('user-checkbox');
                        for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = source.checked; }
                        updateBulkBar();
                    }
                    
                    // Show bar only if checked
                    const checkboxes = document.querySelectorAll('.user-checkbox');
                    const bar = document.getElementById('bulkBar');
                    const countSpan = document.getElementById('count');

                    function updateBulkBar() {
                        let count = document.querySelectorAll('.user-checkbox:checked').length;
                        countSpan.innerText = count;
                        if(count > 0) {
                            bar.style.display = 'flex';
                            setTimeout(() => { bar.style.transform = 'translate(-50%, 0)'; }, 10);
                        } else {
                            bar.style.transform = 'translate(-50%, 100px)';
                        }
                    }

                    checkboxes.forEach(box => { box.addEventListener('change', updateBulkBar); });
                </script>

            <?php elseif ($page == 'courses'): ?>
               <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-black text-gray-800">Course Management</h1>
                    <div x-data="{ open: false }">
                        <button @click="open = true" class="px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-purple-800 transition-all">+ New Course</button>
                        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" style="display:none;">
                            <div class="bg-white p-8 rounded-2xl shadow-2xl w-96">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Create Course</h3>
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="text" name="title" placeholder="Title" class="w-full mb-3 px-4 py-2 border rounded-lg" required>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Category</label>
                                    <select name="category" class="w-full mb-3 px-4 py-2 border rounded-lg bg-white">
                                        <option value="" disabled selected>Select a Category</option>
                                        <option value="IT">IT (Hardware & Servicing)</option>
                                        <option value="Cybersecurity">Cybersecurity & Network</option>
                                        <option value="Business">Bookkeeping & Business</option>
                                        <option value="Security">Security Services (Physical)</option>
                                        <option value="Vocational">General Vocational</option>
                                    </select>
                                    <textarea name="description" placeholder="Description" class="w-full mb-3 px-4 py-2 border rounded-lg"></textarea>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Thumbnail</label>
                                    <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm mb-6">
                                    <button type="submit" name="add_course" class="w-full py-2 bg-primary text-white font-bold rounded-lg">Create Now</button>
                                    <button type="button" @click="open = false" class="w-full mt-2 text-gray-400 text-sm">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php 
                    $courses = $conn->query("SELECT * FROM courses ORDER BY created_at DESC");
                    if($courses->num_rows > 0): while($c = $courses->fetch_assoc()): 
                    ?>
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden group flex flex-col h-full">
                        <div class="h-40 bg-gray-100 relative">
                            <?php if (!empty($c['thumbnail'])): ?>
                                <img src="../<?php echo $c['thumbnail']; ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                            <?php endif; ?>
                            <span class="absolute top-2 right-2 px-2 py-1 text-xs font-bold rounded text-white bg-primary">
                                <?php echo $c['category']; ?>
                            </span>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-lg text-gray-800 mb-2"><?php echo $c['title']; ?></h3>
                            <p class="text-sm text-gray-500 mb-4 flex-1 line-clamp-3"><?php echo $c['description']; ?></p>
                            <div class="flex gap-2 mt-auto">
                                <a href="?page=edit_course&id=<?php echo $c['id']; ?>" class="flex-1 py-2 text-center rounded-lg border border-primary text-primary font-bold text-sm hover:bg-primary hover:text-white transition-all">Manage Lessons</a>
                                <form method="POST" onsubmit="return confirm('Delete course?');">
                                    <input type="hidden" name="type" value="course">
                                    <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                                    <button type="submit" name="delete_item" class="px-3 py-2 rounded-lg border border-red-200 text-red-500 hover:bg-red-50">🗑️</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; endif; ?>
                </div>

            <?php elseif ($page == 'edit_course'): 
                $id = $_GET['id'];
                $course_query = $conn->query("SELECT * FROM courses WHERE id=$id");
                if($course_query->num_rows == 0) { echo "<script>window.location='?page=courses';</script>"; exit; }
                $course = $course_query->fetch_assoc();
                $lessons = $conn->query("SELECT * FROM lessons WHERE course_id=$id ORDER BY order_index ASC");
            ?>
                <div class="mb-8">
                    <a href="?page=courses" class="text-sm text-gray-500 hover:text-primary font-bold mb-4 inline-block">&larr; Back to Courses</a>
                    <h1 class="text-3xl font-black text-gray-800">Manage: <span class="text-primary"><?php echo $course['title']; ?></span></h1>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-8">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">Add New Lesson / Quiz</h3>
                    <form method="POST" enctype="multipart/form-data" class="flex gap-4 items-end">
                        <input type="hidden" name="course_id" value="<?php echo $id; ?>">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Title</label>
                            <input type="text" name="title" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div class="w-32">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Timer (Mins)</label>
                            <input type="number" name="time_limit" value="20" class="w-full px-4 py-2 border rounded-lg text-center" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">File (Optional)</label>
                            <input type="file" name="lesson_file" class="block w-full text-sm text-gray-500">
                        </div>
                        <button type="submit" name="add_lesson" class="px-6 py-2 bg-secondary text-white font-bold rounded-lg hover:bg-cyan-600">Create</button>
                    </form>
                </div>
                <div class="space-y-4">
                    <?php if($lessons && $lessons->num_rows > 0): while($lesson = $lessons->fetch_assoc()): ?>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center text-xl">
                                <?php echo !empty($lesson['file_path']) ? '📕' : '📝'; ?>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800"><?php echo $lesson['title']; ?></h4>
                                <div class="flex gap-3 text-xs text-gray-500">
                                    <?php if(!empty($lesson['file_path'])): ?>
                                        <a href="../<?php echo $lesson['file_path']; ?>" target="_blank" class="text-blue-500 hover:underline">View File</a>
                                    <?php else: ?>
                                        <span class="text-orange-500 font-bold">Quiz Only</span>
                                    <?php endif; ?>
                                    <span>⏱️ <?php echo $lesson['time_limit']; ?> mins</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="?page=manage_quiz&lesson_id=<?php echo $lesson['id']; ?>&course_id=<?php echo $id; ?>" class="px-4 py-2 text-xs font-bold text-white bg-green-500 rounded-lg hover:bg-green-600">📝 Manage Quiz</a>
                            <form method="POST" onsubmit="return confirm('Delete lesson?');">
                                <input type="hidden" name="type" value="lesson">
                                <input type="hidden" name="id" value="<?php echo $lesson['id']; ?>">
                                <input type="hidden" name="redirect_id" value="<?php echo $id; ?>">
                                <button type="submit" name="delete_item" class="text-red-400 hover:text-red-600 font-bold px-2">✕</button>
                            </form>
                        </div>
                    </div>
                    <?php endwhile; endif; ?>
                </div>

            <?php elseif ($page == 'manage_quiz'): 
                $lesson_id = $_GET['lesson_id'];
                $course_id = $_GET['course_id'];
                $lesson = $conn->query("SELECT * FROM lessons WHERE id=$lesson_id")->fetch_assoc();
                $questions = $conn->query("SELECT * FROM questions WHERE lesson_id=$lesson_id");
            ?>
                <div class="mb-8">
                    <a href="?page=edit_course&id=<?php echo $course_id; ?>" class="text-sm text-gray-500 hover:text-primary font-bold mb-4 inline-block">&larr; Back to Lesson List</a>
                    <h1 class="text-2xl font-black text-gray-800">Quiz for: <span class="text-primary"><?php echo $lesson['title']; ?></span></h1>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-8">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">Add Question</h3>
                    <form method="POST">
                        <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
                        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                        <div class="mb-4">
                            <input type="text" name="question_text" class="w-full px-4 py-2 border rounded-lg bg-gray-50" placeholder="Enter question..." required>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <?php for($i=0; $i<4; $i++): ?>
                            <div class="flex items-center gap-2">
                                <input type="radio" name="correct_option" value="<?php echo $i; ?>" <?php echo $i==0?'checked':''; ?>>
                                <input type="text" name="options[]" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="Option <?php echo $i+1; ?>" required>
                            </div>
                            <?php endfor; ?>
                        </div>
                        <button type="submit" name="add_question" class="px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-purple-800">Add Question</button>
                    </form>
                </div>
                <div class="space-y-4">
                    <?php if($questions && $questions->num_rows > 0): while($q = $questions->fetch_assoc()): ?>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-800">Q: <?php echo $q['question_text']; ?></h4>
                            <form method="POST" onsubmit="return confirm('Delete question?');">
                                <input type="hidden" name="type" value="question">
                                <input type="hidden" name="id" value="<?php echo $q['id']; ?>">
                                <input type="hidden" name="redirect_id" value="<?php echo $lesson_id; ?>">
                                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                                <button type="submit" name="delete_item" class="text-red-400 hover:text-red-600 text-sm">Delete</button>
                            </form>
                        </div>
                        <ul class="ml-4 list-disc text-sm text-gray-600">
                            <?php 
                            $q_id = $q['id'];
                            $opts = $conn->query("SELECT * FROM question_options WHERE question_id=$q_id");
                            while($opt = $opts->fetch_assoc()):
                            ?>
                                <li class="<?php echo $opt['is_correct'] ? 'text-green-600 font-bold' : ''; ?>">
                                    <?php echo $opt['option_text']; ?> <?php if($opt['is_correct']) echo '✅'; ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <?php endwhile; endif; ?>
                </div>

            <?php elseif ($page == 'students'): ?>
               <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-black text-gray-800">Enrolled Students</h1>
                </div>
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Student</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase">Contact</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php 
                            $students = $conn->query("SELECT * FROM users WHERE status='approved' ORDER BY created_at DESC");
                            if($students && $students->num_rows > 0):
                                while($stu = $students->fetch_assoc()): 
                            ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-200 flex-shrink-0 border border-gray-200">
                                            <?php if(!empty($stu['avatar'])): ?>
                                                <img src="../<?php echo $stu['avatar']; ?>" class="h-full w-full object-cover">
                                            <?php else: ?>
                                                <div class="h-full w-full flex items-center justify-center bg-primary text-white font-bold text-sm">
                                                    <?php echo substr($stu['name'], 0, 1); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800"><?php echo $stu['name']; ?></div>
                                            <div class="text-[10px] text-gray-400">Joined: <?php echo date('M Y', strtotime($stu['created_at'])); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?php echo $stu['email']; ?></td>
                                <td class="px-6 py-4 text-right">
                                    <a href="?page=student_details&id=<?php echo $stu['id']; ?>" class="px-4 py-2 bg-violet-100 text-primary rounded-lg text-xs font-bold hover:bg-violet-200">View Results</a>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                                <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">No approved students yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($page == 'student_details'): 
                $stu_id = $_GET['id'];
                $student = $conn->query("SELECT * FROM users WHERE id=$stu_id")->fetch_assoc();
                $results = $conn->query("SELECT qr.*, l.title as lesson_title, c.title as course_title FROM quiz_results qr JOIN lessons l ON qr.lesson_id = l.id JOIN courses c ON l.course_id = c.id WHERE qr.user_id = $stu_id ORDER BY qr.date_taken DESC");
            ?>
                <div class="mb-8">
                    <a href="?page=students" class="text-sm text-gray-500 hover:text-primary font-bold mb-4 inline-block">&larr; Back to List</a>
                    <h1 class="text-3xl font-black text-gray-800"><?php echo $student['name']; ?></h1>
                    <p class="text-gray-500"><?php echo $student['email']; ?></p>
                </div>
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-400">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-400">Lesson</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-400">Score</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-400">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php if($results && $results->num_rows > 0): while($res = $results->fetch_assoc()): 
                                $percent = ($res['score'] / $res['total_items']) * 100;
                                $color = $percent >= 75 ? 'text-green-600 bg-green-50' : 'text-red-500 bg-red-50';
                            ?>
                            <tr>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700"><?php echo $res['course_title']; ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600"><?php echo $res['lesson_title']; ?></td>
                                <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-bold <?php echo $color; ?>"><?php echo $res['score']; ?> / <?php echo $res['total_items']; ?></span></td>
                                <td class="px-6 py-4 text-sm text-gray-400"><?php echo date('M d, Y', strtotime($res['date_taken'])); ?></td>
                            </tr>
                            <?php endwhile; endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </div>
    </main>
</body>
</html>