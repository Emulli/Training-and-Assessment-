<?php 
session_start();
include '../db/connection.php'; 

// 1. SECURITY
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. GET USER DATA
$user_query = $conn->query("SELECT * FROM users WHERE id=$user_id");
$user = $user_query->fetch_assoc();
$status = $user['status']; 
$my_category = $user['enrolled_category'];

// 3. FETCH COURSES (Only if approved)
$result = null;
if ($status == 'approved' && !empty($my_category)) {
    $stmt = $conn->prepare("SELECT * FROM courses WHERE category = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $my_category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = false; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | TVLSTC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#4c1d95', 
                        brandLight: '#8b5cf6'
                    },
                    fontFamily: { sans: ['Roboto', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 h-16 flex items-center justify-between">
            <a href="training.php" class="flex items-center gap-2 font-black text-xl text-brand tracking-tight">
                TVL<span class="text-brandLight">STC</span> <span class="text-xs bg-brand text-white px-2 py-0.5 rounded uppercase">Student</span>
            </a>

            <div class="flex items-center gap-4">
                <a href="profile.php" class="flex items-center gap-3 hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors group">
                    <div class="text-right hidden md:block">
                        <p class="text-xs font-bold text-gray-700 leading-none group-hover:text-brand"><?php echo htmlspecialchars($user['name']); ?></p>
                        <p class="text-[10px] text-gray-400 leading-none mt-1">View Profile</p>
                    </div>
                    <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-200 shadow-md ring-2 ring-transparent group-hover:ring-brandLight transition-all">
                        <?php if(!empty($user['avatar'])): ?>
                            <img src="../<?php echo $user['avatar']; ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-brand text-white flex items-center justify-center font-bold text-sm">
                                <?php echo substr($user['name'], 0, 1); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                <a href="../logout.php" class="text-gray-400 hover:text-red-500 transition-colors" title="Logout">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
            </div>
        </div>
    </nav>

    <div class="bg-brand relative py-16 overflow-hidden text-center">
        <div class="absolute inset-0 opacity-10 bg-[url('/OJT/assets/images/test1.jpg')] bg-cover bg-[center_50%]"></div>
        <div class="container mx-auto px-6 relative z-10">
            <h1 class="text-3xl md:text-4xl font-black text-white mb-2 tracking-tight">Student Dashboard</h1>
            
            <?php if($status == 'approved' && !empty($my_category)): ?>
                <p class="text-purple-200 text-lg">Enrolled in: <strong class="text-white bg-white/20 px-3 py-1 rounded ml-1"><?php echo $my_category; ?></strong></p>
            <?php else: ?>
                <p class="text-purple-200 text-sm md:text-base max-w-xl mx-auto">Access your specialized training modules for IT, Cybersecurity, Bookkeeping, and Security Services.</p>
            <?php endif; ?>

            <div class="mt-6 inline-block bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20">
                <span class="text-xs font-bold text-white uppercase tracking-wider">Status: </span>
                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded ml-2 shadow-sm
                    <?php 
                        if($status == 'approved') echo 'bg-green-500 text-white';
                        elseif($status == 'pending_approval') echo 'bg-yellow-500 text-white';
                        elseif($status == 'rejected') echo 'bg-red-500 text-white';
                        else echo 'bg-blue-500 text-white'; 
                    ?>">
                    <?php echo str_replace('_', ' ', $status); ?>
                </span>
            </div>
        </div>
    </div>

    <div class="py-10">
        <div class="container mx-auto px-6">
            
            <?php if($status == 'active'): ?>
                <div class="max-w-3xl mx-auto bg-blue-50 border border-blue-100 rounded-xl p-8 text-center shadow-sm">
                    <div class="text-4xl mb-4">📂</div>
                    <h3 class="font-bold text-blue-900 text-xl mb-2">Registration Required</h3>
                    <p class="text-sm text-blue-700 mb-6">Please upload your <strong>201 File</strong> and select a program before you can access any courses.</p>
                    <a href="profile.php" class="inline-block px-8 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-all shadow-md">
                        Go to Profile
                    </a>
                </div>

            <?php elseif($status == 'pending_approval'): ?>
                <div class="max-w-3xl mx-auto bg-yellow-50 border border-yellow-100 rounded-xl p-8 text-center shadow-sm">
                    <div class="text-4xl mb-4">⏳</div>
                    <h3 class="font-bold text-yellow-900 text-xl mb-2">Pending Admin Review</h3>
                    <p class="text-sm text-yellow-700">Your documents are currently being reviewed by the Admin. Please check back later.</p>
                </div>

            <?php elseif($status == 'rejected'): ?>
                <div class="max-w-3xl mx-auto bg-red-50 border border-red-100 rounded-xl p-8 text-center shadow-sm">
                    <div class="text-4xl mb-4 text-red-500">❌</div>
                    <h3 class="font-bold text-red-900 text-xl mb-2">Application Rejected</h3>
                    <p class="text-sm text-red-700 mb-6">
                        Unfortunately, your application was not approved. This may be due to incorrect or missing documents.<br>
                        Please check your email for details or try uploading your requirements again.
                    </p>
                    <a href="profile.php" class="inline-block px-8 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-all shadow-md">
                        Re-Upload Documents
                    </a>
                </div>

            <?php else: ?>
                <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
                    <h2 class="text-gray-800 font-bold text-lg">Your Learning Modules</h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"> 
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($c = $result->fetch_assoc()): ?>
                            
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">
                                <div class="h-40 bg-gray-200 relative overflow-hidden">
                                    <?php if(!empty($c['thumbnail'])): ?>
                                        <img src="../<?php echo $c['thumbnail']; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center text-white">No Image</div>
                                    <?php endif; ?>
                                    <div class="absolute inset-0 bg-brand/10 group-hover:bg-transparent transition-colors"></div>
                                    <span class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm text-brand text-[10px] uppercase font-bold px-2 py-1 rounded shadow-sm border border-purple-100">
                                        <?php echo $c['category']; ?>
                                    </span>
                                </div>
                                
                                <div class="p-5 flex-1 flex flex-col">
                                    <h3 class="font-bold text-gray-800 text-base mb-2 leading-tight group-hover:text-brand transition-colors line-clamp-1"><?php echo $c['title']; ?></h3>
                                    <p class="text-gray-500 text-xs mb-4 flex-1 line-clamp-3"><?php echo $c['description']; ?></p>
                                    
                                    <div class="border-t border-gray-100 pt-4 flex items-center justify-between mt-auto">
                                        <a href="learn.php?course_id=<?php echo $c['id']; ?>" class="w-full text-center py-2.5 rounded-lg bg-brand text-white font-bold text-xs hover:bg-purple-800 transition-all shadow-md">
                                            Start Learning &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-span-3 text-center py-20 bg-white rounded-xl border-2 border-dashed border-gray-200">
                            <h3 class="text-xl font-bold text-gray-400 mb-2">No Courses Available</h3>
                            <p class="text-gray-500 text-sm">There are currently no courses assigned to the <strong><?php echo $my_category; ?></strong> program.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>