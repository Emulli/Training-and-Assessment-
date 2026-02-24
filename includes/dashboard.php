<?php
// FIX: Only include the header if it hasn't been included yet.
// We use 'include_once' to prevent the repetition bug automatically.
include_once 'includes/header.php'; 
?>

<div class="flex flex-col md:flex-row min-h-screen bg-neutral-bg">

   <aside class="w-full md:w-64 bg-white border-r border-gray-200 hidden md:block">
        <div class="p-6">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Main Menu</h2>
            <ul class="space-y-2">
                <li>
                    <a href="/dashboard.php" class="flex items-center gap-3 px-4 py-2 text-gray-600 hover:bg-gray-50 hover:text-primary rounded-lg transition">
                        <span>📊</span> Dashboard
                    </a>
                </li>
                
               <li>
                    <a href="/OJT/index.php?tab=training#popular-programs" class="flex items-center gap-3 px-4 py-2 text-gray-600 hover:bg-gray-50 hover:text-primary rounded-lg transition">
                        <span>🎓</span> 
                        <span class="font-medium">Training Programs</span>
                    </a>
                </li>

                <li>
                    <a href="/index.php?tab=assessment#popular-programs" class="flex items-center gap-3 px-4 py-2 text-gray-600 hover:bg-gray-50 hover:text-primary rounded-lg transition">
                        <span>📜</span> Assessment
                    </a>
                </li>
                </ul>
        </div>
    </aside>

    <main class="flex-1 p-6 md:p-10">
        
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 mb-8">
            <h1 class="text-2xl font-bold text-primary mb-2">Welcome back, Trainee!</h1>
            <p class="text-gray-500">Here is an overview of your training progress.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-secondary">
                <div class="text-sm text-gray-400 uppercase font-bold mb-1">Active Courses</div>
                <div class="text-3xl font-bold text-gray-800">2</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-accent">
                <div class="text-sm text-gray-400 uppercase font-bold mb-1">Pending Assessments</div>
                <div class="text-3xl font-bold text-gray-800">1</div>
            </div>

             <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-primary">
                <div class="text-sm text-gray-400 uppercase font-bold mb-1">Certificates</div>
                <div class="text-3xl font-bold text-gray-800">0</div>
            </div>
        </div>

    </main>
</div>

<?php include_once 'includes/footer.php'; ?>