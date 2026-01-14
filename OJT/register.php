<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | TVLSTC</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#7c3aed', dark: '#4c1d95', light: '#8b5cf6' },
                        secondary: { DEFAULT: '#0ea5e9' },
                    },
                    fontFamily: { sans: ['Roboto', 'sans-serif'] },
                    animation: { 'blob': 'blob 20s infinite' },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-blue-500 via-cyan-800 to-indigo-900 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-32 left-20 w-96 h-96 bg-pink-600 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl overflow-hidden flex flex-col md:flex-row relative z-10 min-h-[600px]">
        
        <div class="hidden md:flex w-5/12 bg-gradient-to-br from-violet-700 to-cyan-800 text-white p-8 flex-col justify-center relative">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            
            <div class="relative z-10 text-center">
                <div class="mx-auto bg-white p-2 w-24 h-24 rounded-full flex items-center justify-center mb-6 shadow-xl ring-4 ring-white/20">
                    <img src="/OJT/assets/images/TVLC_log.jpg" alt="Logo" class="w-full h-full object-contain rounded-full">
                </div>
                
                <h2 class="text-2xl font-black uppercase tracking-wide mb-2">Join TVLSTC</h2>
                <div class="w-12 h-1 bg-secondary mx-auto mb-6 rounded-full"></div>
                
                <p class="text-blue-100 text-sm leading-relaxed px-4 mb-8">
                    "Start your journey towards a certified career. Create an account to access our training modules and assessment booking system."
                </p>

                <div class="bg-white/10 rounded-lg p-4 text-left text-xs space-y-2 border border-white/10 backdrop-blur-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Track your progress</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Download certificates</span>
                    </div>
                     <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Apply for jobs</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-7/12 p-8 md:p-12 bg-white flex flex-col justify-center">
            
            <div class="mb-8 text-center md:text-left">
                <h3 class="text-2xl font-bold text-gray-800">Create Account</h3>
                <p class="text-gray-500 text-sm">Fill in your details to get started.</p>
            </div>

            <form action="register_action.php" method="POST" class="space-y-4">
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase">First Name</label>
                        <input type="text" name="firstname" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary outline-none transition-all text-sm" placeholder="Juan" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase">Last Name</label>
                        <input type="text" name="lastname" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary outline-none transition-all text-sm" placeholder="Dela Cruz" required>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                     <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase">Email Address</label>
                        <input type="email" name="email" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary outline-none transition-all text-sm" placeholder="email@example.com" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase">Phone Number</label>
                        <input type="text" name="phone" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary outline-none transition-all text-sm" placeholder="0912 345 6789">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary outline-none transition-all text-sm" placeholder="••••••••" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase">Confirm Password</label>
                    <input type="password" name="confirm_password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary outline-none transition-all text-sm" placeholder="••••••••" required>
                </div>

                <div class="flex items-start mt-2">
                    <div class="flex items-center h-5">
                        <input id="terms" type="checkbox" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary" required>
                    </div>
                    <div class="ml-2 text-xs">
                        <label for="terms" class="text-gray-500">I agree to the <a href="#" class="text-primary font-bold hover:underline">Terms of Service</a> and <a href="#" class="text-primary font-bold hover:underline">Privacy Policy</a>.</label>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-violet-600 to-purple-600 text-white font-bold py-3 rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm mt-4">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center border-t border-gray-100 pt-6">
                <p class="text-xs text-gray-500 mb-2">
                    Already have an account? 
                </p>
                <a href="login.php" class="text-primary font-bold hover:underline text-sm block mb-4">
                    Log In Here
                </a>
                
                <a href="index.php" class="text-xs text-gray-400 hover:text-primary flex items-center justify-center gap-1 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Home
                </a>
            </div>

        </div>
    </div>

</body>
</html>