<?php 
include '../includes/header.php'; 
?>

<div class="bg-primary-dark relative py-16 md:py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('/OJT/assets/images/test1.jpg')] bg-cover bg-[center_50%]"></div>
    <div class="container mx-auto px-6 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight">Our Training Programs</h1>
        <p class="text-blue-200 text-lg max-w-2xl mx-auto">
            Upgrade your skills with our industry-recognized curriculums. From beginner workshops to advanced certification reviews.
        </p>
    </div>
</div>

<div class="bg-neutral-bg py-12" x-data="{ selectedCategory: 'all' }">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-8">

            <aside class="w-full lg:w-1/4 space-y-8">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Categories</h3>
                    <ul class="space-y-2">
                        <li>
                            <button @click="selectedCategory = 'all'" 
                                class="w-full text-left flex justify-between items-center text-sm font-medium transition-colors"
                                :class="selectedCategory === 'all' ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary'"
                            >
                                All Courses <span class="text-gray-400 text-xs bg-gray-100 px-2 py-0.5 rounded-full">12</span>
                            </button>
                        </li>
                        <li>
                            <button @click="selectedCategory = 'tech'" 
                                class="w-full text-left flex justify-between items-center text-sm font-medium transition-colors"
                                :class="selectedCategory === 'tech' ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary'"
                            >
                                Technology & IT <span class="text-gray-400 text-xs bg-gray-100 px-2 py-0.5 rounded-full">5</span>
                            </button>
                        </li>
                        <li>
                            <button @click="selectedCategory = 'industrial'" 
                                class="w-full text-left flex justify-between items-center text-sm font-medium transition-colors"
                                :class="selectedCategory === 'industrial' ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary'"
                            >
                                Industrial Arts <span class="text-gray-400 text-xs bg-gray-100 px-2 py-0.5 rounded-full">4</span>
                            </button>
                        </li>
                        <li>
                            <button @click="selectedCategory = 'medical'" 
                                class="w-full text-left flex justify-between items-center text-sm font-medium transition-colors"
                                :class="selectedCategory === 'medical' ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary'"
                            >
                                Medical Services <span class="text-gray-400 text-xs bg-gray-100 px-2 py-0.5 rounded-full">3</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-violet-600 to-purple-700 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                    
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Why Choose Us?
                    </h3>
                    <ul class="space-y-4 text-sm text-blue-50">
                        <li class="flex items-start gap-3">
                            <span class="bg-white/20 p-1 rounded-full mt-0.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                            <span><strong>TESDA Accredited</strong> programs recognized nationwide.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="bg-white/20 p-1 rounded-full mt-0.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                            <span><strong>Expert Instructors</strong> with real-world industry experience.</span>
                        </li>
                         <li class="flex items-start gap-3">
                            <span class="bg-white/20 p-1 rounded-full mt-0.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                            <span><strong>Flexible Schedules</strong> (Weekend & Night classes available).</span>
                        </li>
                    </ul>
                    <a href="/about" class="mt-6 block w-full bg-white text-primary text-center font-bold py-2 rounded-lg hover:bg-blue-50 transition-colors text-xs uppercase tracking-wider">
                        Learn More About TVLSTC
                    </a>
                </div>

                <a href="#" class="block bg-white border border-gray-200 p-4 rounded-xl text-center hover:border-primary hover:shadow-md transition-all group">
                    <div class="text-4xl mb-2">📄</div>
                    <div class="font-bold text-gray-700 group-hover:text-primary">Download Brochure</div>
                    <div class="text-xs text-gray-400">PDF Format (2.4 MB)</div>
                </a>

            </aside>

            <main class="w-full lg:w-3/4">
                
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-500 text-sm">Showing <strong>All</strong> Courses</span>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-500">Sort by:</label>
                        <select class="text-sm border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option>Newest</option>
                            <option>Popularity</option>
                            <option>Price: Low to High</option>
                        </select>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"> 

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group" 
                         x-show="selectedCategory === 'all' || selectedCategory === 'tech'">
                        <div class="h-48 bg-gray-200 relative">
                            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Web Dev" class="w-full h-full object-cover">
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-primary text-xs font-bold px-2 py-1 rounded">PHP 5,000</span>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-secondary">Technology</span>
                                <div class="flex text-yellow-400 text-xs">★★★★★</div>
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg mb-2 leading-tight group-hover:text-primary transition-colors">Web Development Bootcamp</h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2">Master HTML, CSS, JS, and PHP in this intensive 3-month program.</p>
                            
                            <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                    <span>👤 25 Enrolled</span>
                                </div>
                                <a href="#" class="text-primary font-bold text-sm hover:underline">Details &rarr;</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group" 
                         x-show="selectedCategory === 'all' || selectedCategory === 'tech'">
                        <div class="h-48 bg-gray-200 relative">
                            <img src="https://images.unsplash.com/photo-1695668548342-c0c1ad479aee?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Hardware" class="w-full h-full object-cover">
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-primary text-xs font-bold px-2 py-1 rounded">PHP 3,500</span>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-secondary">Hardware</span>
                                <div class="flex text-yellow-400 text-xs">★★★★☆</div>
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg mb-2 leading-tight group-hover:text-primary transition-colors">Computer Systems Servicing</h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2">Learn to assemble, repair, and maintain computer systems and networks.</p>
                            
                            <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                    <span>👤 40 Enrolled</span>
                                </div>
                                <a href="#" class="text-primary font-bold text-sm hover:underline">Details &rarr;</a>
                            </div>
                        </div>
                    </div>

                     <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group" 
                         x-show="selectedCategory === 'all' || selectedCategory === 'industrial'">
                        <div class="h-48 bg-gray-200 relative">
                            <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Welding" class="w-full h-full object-cover">
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-primary text-xs font-bold px-2 py-1 rounded">PHP 4,000</span>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-orange-500">Industrial</span>
                                <div class="flex text-yellow-400 text-xs">★★★★★</div>
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg mb-2 leading-tight group-hover:text-primary transition-colors">Shielded Metal Arc Welding</h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2">NC II Certification preparation for professional welders.</p>
                            
                            <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                    <span>👤 15 Enrolled</span>
                                </div>
                                <a href="#" class="text-primary font-bold text-sm hover:underline">Details &rarr;</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group" 
                         x-show="selectedCategory === 'all' || selectedCategory === 'medical'">
                        <div class="h-48 bg-gray-200 relative">
                            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Caregiving" class="w-full h-full object-cover">
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-primary text-xs font-bold px-2 py-1 rounded">PHP 6,000</span>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-pink-500">Medical</span>
                                <div class="flex text-yellow-400 text-xs">★★★★☆</div>
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg mb-2 leading-tight group-hover:text-primary transition-colors">Caregiving NC II</h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2">Professional caregiving for infants, the elderly, and people with special needs.</p>
                            
                            <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                    <span>👤 30 Enrolled</span>
                                </div>
                                <a href="#" class="text-primary font-bold text-sm hover:underline">Details &rarr;</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-12 flex justify-center space-x-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">Previous</button>
                    <button class="px-4 py-2 bg-primary text-white rounded-md">1</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">2</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">Next</button>
                </div>

            </main>
        </div>
    </div>
</div>

<?php 
// Adjust footer path similarly
include '../includes/footer.php'; 
?>