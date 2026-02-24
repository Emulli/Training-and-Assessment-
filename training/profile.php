<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
$message = "";
$msg_type = "";

// 1. HANDLE 201 FILE UPLOAD
if (isset($_POST['upload_requirements'])) {
    $target_dir = "../assets/uploads/requirements/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    
    $program = $_POST['program_choice'];
    $file_extension = strtolower(pathinfo($_FILES["req_file"]["name"], PATHINFO_EXTENSION));
    $file_name = time() . "_" . $user_id . "." . $file_extension;
    $target_file = $target_dir . $file_name;
    
    if (move_uploaded_file($_FILES["req_file"]["tmp_name"], $target_file)) {
        $db_path = "assets/uploads/requirements/" . $file_name;
        $stmt = $conn->prepare("UPDATE users SET requirement_file = ?, status = 'pending_approval', requested_category = ? WHERE id = ?");
        $stmt->bind_param("ssi", $db_path, $program, $user_id);
        
        if($stmt->execute()) {
            $message = "Application submitted for <strong>$program</strong>! Please wait for Admin approval.";
            $msg_type = "success";
            $user['status'] = 'pending_approval';
            $user['requirement_file'] = $db_path;
            $user['requested_category'] = $program;
        }
    } else {
        $message = "File upload failed.";
        $msg_type = "error";
    }
}

// 2. HANDLE PROFILE UPDATES
if (isset($_POST['update_profile'])) {
    $new_name = trim($_POST['name']);
    $new_password = $_POST['password'];
    $avatar_path = $user['avatar']; 

    if (!empty($_FILES['avatar']['name'])) {
        $target_dir = "../assets/uploads/avatars/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $new_filename = "user_" . $user_id . "_" . time() . "." . strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir . $new_filename)) {
            $avatar_path = "assets/uploads/avatars/" . $new_filename;
        }
    }

    if (!empty($new_password)) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, password = ?, avatar = ? WHERE id = ?");
        $stmt->bind_param("sssi", $new_name, $new_password, $avatar_path, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, avatar = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_name, $avatar_path, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['user_name'] = $new_name;
        header("Location: profile.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile | TVLSTC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { brand: '#4c1d95', brandLight: '#8b5cf6' } } } }
    </script>
</head>
<body class="bg-gray-50 font-sans min-h-screen">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="training.php" class="flex items-center text-gray-500 hover:text-brand font-bold transition-colors">
                &larr; Back to Dashboard
            </a>
            <h1 class="text-xl font-black text-gray-800">My Profile</h1>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto mt-12 space-y-6 px-6 pb-20">
        <?php if (!empty($message)): ?>
            <div class="p-4 rounded-lg text-sm font-bold text-center <?php echo $msg_type == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="text-center">
                    <div class="relative w-24 h-24 mx-auto mb-4 group">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg ring-2 ring-gray-100">
                            <?php if (!empty($user['avatar'])): ?>
                                <img src="../<?php echo $user['avatar']; ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-brand text-white flex items-center justify-center text-3xl font-black"><?php echo substr($user['name'], 0, 1); ?></div>
                            <?php endif; ?>
                        </div>
                        <label class="absolute inset-0 flex items-center justify-center bg-black/50 text-white rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                            <span class="text-xs font-bold">Change</span>
                            <input type="file" name="avatar" accept="image/*" class="hidden">
                        </label>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800"><?php echo $user['name']; ?></h2>
                    <p class="text-sm text-gray-500"><?php echo $user['email']; ?></p>
                    
                    <div class="mt-3 flex flex-col items-center gap-2">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                            <?php echo $user['status']=='approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                            <?php echo $user['status']; ?> 
                        </span>
                        <?php if($user['enrolled_category']): ?>
                            <span class="text-xs text-brand font-bold bg-purple-50 px-3 py-1 rounded-full">
                                🎓 Enrolled in: <?php echo $user['enrolled_category']; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full Name</label>
                    <input type="text" name="name" value="<?php echo $user['name']; ?>" class="w-full px-4 py-3 border border-gray-200 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">New Password (Optional)</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current" class="w-full px-4 py-3 border border-gray-200 rounded-lg">
                </div>
                <button type="submit" name="update_profile" class="w-full py-3 bg-brand text-white font-bold rounded-lg shadow-lg hover:bg-purple-800 transition-all">Save Profile Changes</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <h3 class="font-bold text-gray-800 text-lg mb-2">Program Application</h3>
            
            <div class="bg-blue-50 text-blue-800 text-sm p-4 rounded-lg mb-6 border border-blue-100">
                <p class="font-bold mb-2">Please compile the following into one (1) PDF or ZIP file:</p>
                <ul class="list-disc list-inside space-y-1 ml-2">
                    <li>PSA Birth Certificate</li>
                    <li>PSA Marriage Certificate (if married)</li>
                    <li>Form 137, Report Card, TOR, or Diploma</li>
                </ul>
            </div>

            <?php if(!empty($user['requirement_file'])): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">📄</span>
                        <div>
                            <p class="text-sm font-bold text-green-800">Application Submitted</p>
                            <p class="text-xs text-green-600">Program: <strong><?php echo $user['requested_category'] ?? 'Not specified'; ?></strong></p>
                            <a href="../<?php echo $user['requirement_file']; ?>" target="_blank" class="text-xs underline hover:text-green-900">View File</a>
                        </div>
                    </div>
                    <span class="text-green-600 text-xl">✅</span>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Select Program</label>
                    <select name="program_choice" class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white outline-none" required>
                        <option value="" disabled selected>Choose a course...</option>
                        <option value="IT" <?php echo ($user['requested_category']=='IT')?'selected':''; ?>>IT (Hardware & Servicing)</option>
                        <option value="Cybersecurity" <?php echo ($user['requested_category']=='Cybersecurity')?'selected':''; ?>>Cybersecurity</option>
                        <option value="Business" <?php echo ($user['requested_category']=='Business')?'selected':''; ?>>Bookkeeping & Business</option>
                        <option value="Security" <?php echo ($user['requested_category']=='Security')?'selected':''; ?>>Security Services</option>
                    </select>
                </div>

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-brand hover:bg-purple-50 transition-all cursor-pointer relative">
                    <input type="file" name="req_file" accept=".pdf,.zip,.rar,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('fileName').innerText = this.files[0].name" required>
                    <span class="text-gray-500 text-sm font-medium">Click to upload 201 File</span>
                </div>
                <p id="fileName" class="text-xs text-brand font-bold text-center h-4"></p>
                
                <button type="submit" name="upload_requirements" class="w-full py-3 bg-gray-800 text-white font-bold rounded-lg shadow-lg hover:bg-black transition-all">Submit Application</button>
            </form>
        </div>

    </div>
</body>
</html>