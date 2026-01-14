<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technological Vocational Learning Center  | Assessment & Training</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 
                            DEFAULT: '#7c3aed', // Violet-600
                            dark: '#4c1d95',    // Violet-900
                            light: '#8b5cf6'    // Violet-500
                        },
                        secondary: { DEFAULT: '#0ea5e9' }, // Cyan
                        accent: { DEFAULT: '#f97316' },    // Orange
                        neutral: { bg: '#f3f4f6' }
                    },
                    fontFamily: { sans: ['Roboto', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-neutral-bg text-gray-700 flex flex-col min-h-screen">


    <nav class="bg-white shadow-lg sticky top-0 z-40 border-b border-gray-100" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            
             <a href="/" class="flex items-center gap-3 group">
                <?php 
                $path = ($_SERVER['SERVER_NAME'] == 'localhost') 
                    ? 'OJT'
                    : '/'; 
                ?>
                <img src="/OJT/assets/images/TVLC_log.jpg" alt="TVLC Logo" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
                
                <div class="flex flex-col">
                    <span class="text-2xl font-black text-gray-800 tracking-tight leading-none group-hover:text-primary transition-colors">
                        TVL<span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-600 to-fuchsia-600">STC</span>
                    </span>
                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Assessment & Training</span>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-8 font-semibold text-gray-600 text-sm tracking-wide">
                <a href="/OJT/index.php" class="hover:text-primary transition-colors py-2 border-b-2 border-transparent hover:border-primary">
                    Home
                </a>
                <a href="/OJT/index.php?tab=training#about-us" class="hover:text-primary transition-colors py-2 border-b-2 border-transparent hover:border-primary">
                    About Us
                </a>
               <a href="/OJT/index.php?tab=training#popular-programs" class="hover:text-primary transition-colors py-2 border-b-2 border-transparent hover:border-primary">
                     Training
                </a>
                <a href="/trainees" class="hover:text-primary transition-colors py-2 border-b-2 border-transparent hover:border-primary">
                    Trainees 
                </a>
                <a href="/hiring" class="hover:text-primary transition-colors py-2 border-b-2 border-transparent hover:border-primary">
                    Job Hiring
                </a>

                <div class="relative" x-data="{ open: false }" @click.away="open = false" @mouseleave="open = false">
                    
                    <button 
                        @mouseover="open = true" 
                        @click="open = !open"
                        class="flex items-center gap-1 hover:text-primary transition-colors py-2 border-b-2 border-transparent hover:border-primary focus:outline-none"
                        :class="open ? 'text-primary border-primary' : ''"
                    >
                        Affiliations
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div 
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute left-0 mt-0 w-64 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-2"
                        style="display: none;" 
                    >
                        
                        <div class="px-2 pb-2 mb-2 border-b border-gray-100">
                            <a href="/OJT/index.php?tab=#affiliates" class="block px-4 py-2 text-xs font-bold text-primary uppercase tracking-wider bg-violet-50 rounded-lg hover:bg-violet-100 transition-colors">
                                View All Affiliates &rarr;
                            </a>
                        </div>

                        <div 
                            class="relative group/nested px-2" 
                            x-data="{ subOpen: false }" 
                            @mouseleave="subOpen = false"
                        >
                            <a 
                                href="/OJT/index.php?partner_id=11#partners"
                                @mouseover="subOpen = true" 
                                class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-600 rounded-lg hover:text-primary hover:bg-gray-50 transition-colors text-left"
                            >
                                ATB Car Rental Services
                            </a>
                            
                        </div>

                        <div 
                            class="relative group/nested px-2 mt-1" 
                            x-data="{ subOpen: false }" 
                            @mouseleave="subOpen = false"
                        >
                            <button 
                                @mouseover="subOpen = true" 
                                @click="subOpen = !subOpen"
                                class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-600 rounded-lg hover:text-primary hover:bg-gray-50 transition-colors text-left"
                            >
                                CyberSafe Systems
                            </button>
                        </div>

                        <div class="px-2 mt-1">
                            <a href="/partners#innovate-ph" class="block w-full px-4 py-2 text-sm text-gray-600 rounded-lg hover:text-primary hover:bg-gray-50 transition-colors">
                                Innovate PH
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4">

                <a href="/jobs" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 shadow-md transition-all hover:-translate-y-0.5">
                    <span class="relative px-6 py-2.5 transition-all ease-in duration-75 bg-white text-gray-800 font-bold rounded-md group-hover:bg-opacity-0 group-hover:text-white">
                        Job Board
                    </span>
                </a>
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
            </button>
        </div>
        
        <div x-show="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-100 p-4 space-y-2">
             <a href="index.php" class="block py-2 text-gray-600 hover:text-primary">Home</a>
             <a href="/OJT/index.php?tab=#about-us" class="block py-2 text-gray-600 hover:text-primary">About Us</a>
             <a href="/OJT/index.php?tab=training#popular-programs" class="block py-2 text-gray-600 hover:text-primary">Training</a>
             <a href="/trainees" class="block py-2 text-gray-600 hover:text-primary">Trainees</a>
             <a href="/hiring" class="block py-2 text-gray-600 hover:text-primary">Job Hiring</a>
             <a href="/OJT/index.php?tab=#affiliates" class="block py-2 text-gray-600 hover:text-primary">Companies</a>
        </div>
    </nav>