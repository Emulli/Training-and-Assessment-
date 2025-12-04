<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TVLSTC</title>
    
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
                    animation: {
                        'blob': 'blob 7s infinite',
                    },
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

    <div class="absolute top-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
    <div class="absolute -bottom-32 left-20 w-96 h-96 bg-pink-600 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col md:flex-row relative z-10 min-h-[500px]">
        
        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-violet-700 to-cyan-800 text-white p- flex-col justify-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            
            <div class="absolute top-10 left-10 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
            <div class="absolute bottom-10 right-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>

            <div class="relative z-10 text-center">
                <div class="mx-auto bg-white p-2 w-28 h-28 rounded-full flex items-center justify-center mb-6 shadow-xl ring-4 ring-white/20">
                    <img src="/OJT/assets/images/TVLC_log.jpg" alt="TVLSTC Logo" class="w-full h-full object-contain rounded-full">
                </div>
                
                <h2 class="text-2xl font-black uppercase tracking-wide mb-2 text-shadow">
                    Technological Vocational Learning Center
                </h2>
                
                <div class="w-16 h-1 bg-secondary mx-auto mb-6 rounded-full"></div>

                <p class="text-blue-100 text-sm leading-relaxed opacity-90 px-4">
                    "Empowering futures through technical excellence." <br><br>
                    Welcome to your student portal. Access your training modules, check assessment schedules, and track your certification progress.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-6 md:p-6 bg-white flex flex-col justify-center relative">
            
            <div class="md:hidden text-center mb-6">
                <img src="/OJT/assets/images/TVLC_log.jpg" alt="Logo" class="w-16 h-16 mx-auto mb-2">
                <h2 class="font-bold text-gray-800 text-lg">TVLSTC Inc.</h2>
            </div>

            <div class="mb-8">
                <h3 class="text-3xl font-bold text-gray-800 mb-2">Hello Again!</h3>
                <p class="text-gray-500">Welcome back you've been missed!</p>
            </div>

            <form action="login_action.php" method="POST" class="space-y-5">
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 ml-1">Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input type="email" name="email" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="Enter your email" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="Enter password" required>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-gray-500 hover:text-gray-700 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 text-primary border-black-300 rounded focus:ring-primary">
                        <span class="ml-2 font-medium">Remember me</span>
                    </label>
                    <a href="#" class="text-black-400 hover:text-primary font-medium transition-colors">Recovery Password</a>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-purple-500/30 hover:-translate-y-0.5 transition-all duration-200">
                    Sign In
                </button>
            </form>

            <div class="my-8 flex items-center gap-4">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-xs text-black-400 font-bold uppercase">Or continue with</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            <p class="text-center text-sm text-black-500">
                Not a member? 
                <a href="register.php" class="text-primary font-bold hover:underline">Register now</a>
            </p>

            <div class="mt-6 text-center">
                <a href="index.php" class="text-xs text-black-400 hover:text-primary flex items-center justify-center gap-1 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Home
                </a>
            </div>

        </div>
    </div>

</body>
</html>