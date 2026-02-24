<?php
session_start();
include '../db/connection.php'; 

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); 

    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | TVLSTC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#7c3aed', dark: '#4c1d95', light: '#8b5cf6' },
                        secondary: { DEFAULT: '#0ea5e9' },
                        neutral: { bg: '#f3f4f6' }
                    },
                    fontFamily: { sans: ['Roboto', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-neutral-bg h-screen flex items-center justify-center relative overflow-hidden">
    
    <div class="absolute top-0 right-0 -mr-20 w-96 h-96 bg-purple-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 w-80 h-80 bg-blue-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

    <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md relative z-10 border border-gray-100">
        
        <div class="text-center mb-8">
            <img src="../assets/images/TVLC_log.jpg" class="h-16 w-auto mx-auto mb-4 object-contain">
            <h2 class="text-2xl font-black text-gray-800">Admin <span class="text-primary">Portal</span></h2>
            <p class="text-sm text-gray-400 font-medium tracking-wide uppercase mt-1">Restricted Access</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-6 text-center border border-red-100 font-medium">
                ⚠️ <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Username</label>
                <input type="text" name="username" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-purple-100 outline-none transition-all bg-gray-50 focus:bg-white" placeholder="Enter username" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-purple-100 outline-none transition-all bg-gray-50 focus:bg-white" placeholder="••••••••" required>
            </div>
            
            <button type="submit" name="login" class="w-full py-3 bg-gradient-to-r from-primary to-purple-600 text-white font-bold rounded-lg shadow-lg hover:shadow-purple-500/30 hover:-translate-y-0.5 transition-all">
                Access Dashboard
            </button>
        </form>

        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <a href="../index.php" class="text-sm text-gray-400 hover:text-primary transition-colors flex items-center justify-center gap-2">
                &larr; Return to Website
            </a>
        </div>
    </div>
</body>
</html>