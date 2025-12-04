<?php include 'includes/header.php'; ?>

<section 
    x-data="{
        activeSlide: 0,
        slides: [
            {
                image: 'assets/images/test1.jpg',
                title: 'Launch Your Career in Technology',
                subtitle: 'Industry-relevant training programs designed to get you hired.',
                cta: 'Explore Courses',
                link: 'training/training.php',
                theme: 'from-violet-600 to-purple-600'
            },
            {
                image: 'assets/images/test2.jpg',
                title: 'Get Certified. Get Recognized.',
                subtitle: 'Official National Competency (NC) assessments to validate your skills.',
                cta: 'Book Assessment',
                link: '/assessment',
                theme: 'from-blue-500 to-cyan-500'
            },
             {
                image: 'assets/images/test3.jpg',
                title: 'Join Our Network of Professionals',
                subtitle: 'Connect with top companies looking for certified talent.',
                cta: 'View Job Board',
                link: '/jobs',
                theme: 'from-orange-500 to-red-500'
            }
        ],
        timer: null,
        init() { this.startAutoPlay(); },
        startAutoPlay() { this.timer = setInterval(() => { this.nextSlide(); }, 3000); },
        nextSlide() { this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1; },
        prevSlide() { this.activeSlide = (this.activeSlide === 0) ? this.slides.length - 1 : this.activeSlide - 1; },
        goToSlide(index) { this.activeSlide = index; clearInterval(this.timer); this.startAutoPlay(); }
    }"
    class="relative h-[100px] md:h-[750px] bg-gray-900 overflow-hidden group"
>
    <template x-for="(slide, index) in slides" :key="index">
        <div 
            class="absolute inset-0 transition-opacity duration-900 ease-in-out"
            x-show="activeSlide === index"
            x-transition:enter="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transform transition-transform duration-[3000ms] ease-linear" 
                :style="`background-image: url('${slide.image}');`" 
                :class="activeSlide === index ? 'scale-210' : 'scale-100'">
             </div>
            <div class="absolute inset-0 bg-gray-900/60 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>

            <div class="absolute inset-0 flex items-center justify-center z-10">
                <div class="container mx-auto px-6 text-center md:text-left">
                    <div class="max-w-3xl">
                        <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-700 delay-100" x-transition:enter-start="opacity-0 translate-y-12" x-transition:enter-end="opacity-100 translate-y-0">
                            <span class="inline-block py-1 px-3 rounded font-bold text-sm uppercase tracking-wider mb-4 text-white bg-gradient-to-r" :class="`bg-gradient-to-r ${slide.theme}`">Welcome to Technological Vocational Learning Center </span>
                            <h1 class="text-4xl md:text-7xl font-black text-white mb-6 leading-tight" x-text="slide.title"></h1>
                            <p class="text-xl text-gray-200 mb-10 leading-relaxed max-w-2xl" x-text="slide.subtitle"></p>
                            <a :href="slide.link" class="group/btn relative inline-flex items-center justify-center p-0.5 overflow-hidden text-lg font-bold text-white rounded-md group bg-gradient-to-br hover:text-white shadow-2xl hover:shadow-purple-500/50 transition-all" :class="`bg-gradient-to-br ${slide.theme}`">
                                <span class="relative px-8 py-4 transition-all ease-in duration-200 bg-gray-900 rounded-[4px] group-hover/btn:bg-opacity-0">
                                    <span x-text="slide.cta"></span>
                                    <svg class="w-5 h-5 inline-block ml-2 -mr-1 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <div class="absolute top-0 right-0 p-8 z-30 w-full md:w-auto flex flex-col items-end gap-4">
        
        <div class="flex items-center gap-3">
            <a href="login.php" class="text-white hover:text-secondary font-medium text-sm transition-colors flex items-center gap-2 px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Login
            </a>
            <a href="/register" class="text-gray-900 font-bold text-sm bg-secondary hover:bg-cyan-400 transition-colors px-5 py-2 rounded-lg shadow-lg shadow-cyan-500/20">
                Register
            </a>
        </div>

        <div class="relative group w-full md:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-secondary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input 
                type="text" 
                class="block w-full pl-10 pr-3 py-2 border border-white/20 rounded-lg leading-5 bg-white/10 text-white placeholder-gray-300 focus:outline-none focus:bg-white/20 focus:border-secondary focus:ring-1 focus:ring-secondary sm:text-sm backdrop-blur-md transition-all" 
                placeholder="Search courses, assessments..."
            >
        </div>
    </div>
    <button @click="prevSlide(); clearInterval(timer); startAutoPlay();" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 text-white/50 hover:text-white hover:bg-white/10 p-2 rounded-full transition-all hidden md:block opacity-0 group-hover:opacity-100">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    <button @click="nextSlide(); clearInterval(timer); startAutoPlay();" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 text-white/50 hover:text-white hover:bg-white/10 p-2 rounded-full transition-all hidden md:block opacity-0 group-hover:opacity-100">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex space-x-3">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="goToSlide(index)" class="w-3 h-3 rounded-full transition-all duration-300" :class="activeSlide === index ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/70'"></button>
        </template>
    </div>
</section>

<section class="relative z-30 -mt-16 mb-20">
    <div class="container mx-auto px-6">
        <div class="bg-white rounded-lg shadow-2xl border-b-4 border-primary p-8 grid grid-cols-2 md:grid-cols-3 gap-8 text-center relative overflow-hidden">
             <div class="absolute inset-0 bg-gradient-to-r from-violet-100/50 via-transparent to-blue-100/50 opacity-50 pointer-events-none"></div>
            <div class="relative">
                <div class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-br from-violet-600 to-purple-600 mb-1">98%</div>
                <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Passing Rate</div>
            </div>
            <div class="relative">
                <div class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-br from-orange-500 to-purple-500 mb-1">10</div>
                <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Company Partners</div>
            </div>
            <div class="relative border-l border-gray-100 pl-8 hidden md:block text-left">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                         <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                     <div class="font-bold text-gray-800">TESDA Accredited</div>
                </div>
                <div class="text-sm text-gray-500 pl-14">Center ID: #</div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-gray-50 via-white to-white opacity-60 pointer-events-none"></div>

    <div class="container mx-auto px-6 relative z-10">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Who We Are</h2>
            <h3 class="text-3xl md:text-4xl font-black text-gray-800 mb-4">
                Empowering Futures Through <span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-600 to-fuchsia-600">Excellence</span>
            </h3>
            <div class="w-16 h-1 bg-secondary mx-auto rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-12 text-center">

            <div class="group p-6 rounded-2xl shadow-xl border border-gray-100 hover:bg-gray-50 transition-colors duration-300">
                <div class="w-20 h-20 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">Our Mission</h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    "Our mission is to empower individuals with the practical, industry-relevant skills and knowledge needed to excel in today's technology-driven world. We are committed to providing accessible, high-quality vocational education."
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-white shadow-xl border border-gray-100 transform md:-translate-y-4 relative z-20">
                <div class="w-20 h-20 mx-auto bg-violet-50 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">Vocational Training</h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    We bridge the gap between education and employment. From Basic Education to specialized TVL tracks, we provide the certification you need to land the job.
                </p>
            </div>

            <div class="group p-6 rounded-2xl shadow-xl border border-gray-100 hover:bg-gray-50 transition-colors duration-300">
                <div class="w-20 h-20 mx-auto bg-blue-50 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">Our Vision</h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    "To be a global leader in vocational education, empowering individuals with cutting-edge technological skills that drive innovation and shape the future of industries."
                </p>
            </div>

        </div>
    </div>
</section>

<section
    class="py-24 bg-white relative overflow-hidden" x-data="{ showModal: false }" 
    id="about-us" 
        class="py-20 bg-neutral-bg" 
        x-data="{ 
            activeTab: 'all',
            init() {
                const params = new URLSearchParams(window.location.search);
                if(params.get('tab')) {
                    this.activeTab = params.get('tab');
                }
            }
        }">
    
    <div class="absolute top-20 right-0 -mr-20 w-96 h-96 bg-purple-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
    <div class="absolute bottom-20 left-0 -ml-20 w-80 h-80 bg-blue-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            
            <div class="w-full lg:w-1/2 relative">
                <div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl border-4 border-white transform hover:scale-[1.02] transition-transform duration-500">
                    <img src="assets/images/test2.jpg" class="w-full h-auto object-cover">
                    <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur-md p-4 rounded-xl shadow-lg border-l-4 border-primary">
                        <div class="text-3xl font-black text-gray-800">2024</div>
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Established</div>
                    </div>
                </div>
                <div class="absolute -bottom-10 -right-10 w-2/3 rounded-2xl overflow-hidden shadow-2xl border-4 border-white z-20 hidden md:block transform hover:translate-y-2 transition-transform duration-500">
                    <img src="assets/images/test1.jpg" alt="Hands-on Training" class="w-full h-auto object-cover">
                </div>
                <div class="absolute -top-6 -left-6 text-gray-100 z-0">
                    <svg width="100" height="100" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14 10L24 12L14 14L12 24L10 14L0 12L10 10z"/></svg>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-50 text-primary text-xs font-bold uppercase tracking-widest mb-6">
                    <span class="w-2 h-2 rounded-full bg-primary"></span> About TVLSTC
                </div>
                
                <h2 class="text-4xl font-black text-gray-900 mb-6 leading-tight">
                    Bridging the Gap Between <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-600 to-purple-600">Education & Industry</span>
                </h2>

                <div class="prose prose-lg text-gray-500 mb-8 leading-relaxed">
                    <p class="mb-4">
                        The <strong>Technological Vocational Learning Center (TVLSTC)</strong> is an institution dedicated to providing high-quality vocational education in cutting-edge fields. Established to solve the workforce skills gap, we don't just teach theory—we build careers.
                    </p>
                    <p>
                        From Information Technology to Advanced Manufacturing, our curriculum is crafted by industry experts to ensure every graduate is job-ready from day one.
                    </p>
                </div>

                <div class="space-y-6 mb-10">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">State-of-the-Art Facilities</h4>
                            <p class="text-sm text-gray-500 mt-1">A dynamic environment where students can explore, innovate, and grow using the latest industry tools.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Industry-Expert Curriculum</h4>
                            <p class="text-sm text-gray-500 mt-1">Tailored programs designed to meet the current needs of the job market, ensuring high employability.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="training/training.php" class="px-8 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-purple-500/30 hover:bg-purple-800 hover:-translate-y-1 transition-all">
                        Find Your Course
                    </a>
                    <button @click="showModal = true" class="px-8 py-3 border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:border-primary hover:text-primary transition-all">
                        Read Full Story
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div 
        x-show="showModal" 
        style="display: none;"
        class="fixed inset-0 z-[60] overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <div 
            x-show="showModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" 
            @click="showModal = false"
        ></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div 
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl max-h-[90vh] overflow-y-auto"
            >
                <div class="sticky top-0 z-10 bg-white border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-full bg-violet-50 flex items-center justify-center">
                            <img src="/OJT/assets/images/TVLC_log.jpg" alt="TVLC Logo" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
                        </div>
                        <h3 class="text-lg font-bold leading-6 text-gray-900">About TVLSTC</h3>
                    </div>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="px-6 py-8 sm:px-10">
                    
                    <div class="mb-10">
                        <h4 class="text-2xl font-black text-primary mb-4">Company Overview</h4>
                        <div class="space-y-4 text-gray-600 leading-relaxed text-justify">
                            <p>The <strong>Technological Vocational Learning Center (TVLSTC)</strong> is an institution dedicated to providing high-quality vocational education and training in cutting-edge technological fields. Established with a mission to bridge the skills gap in the workforce, TVLSTC offers a wide range of programs designed to equip students with the practical, hands-on skills needed to succeed in today’s fast-paced, technology-driven industries.</p>
                            <p>TVLSTC’s curriculum is crafted by industry experts and focuses on real-world applications, ensuring that students are not only learning theoretical concepts but are also gaining the experience necessary to thrive in their chosen careers. From information technology and electronics to automotive technology and advanced manufacturing, TVLSTC’s programs are tailored to meet the current and future needs of the job market.</p>
                            <p>With state-of-the-art facilities and a team of highly qualified instructors, TVLSTC provides a dynamic learning environment where students can explore, innovate, and grow. Our commitment to excellence is reflected in our small class sizes, personalized learning paths, and strong connections with industry partners, which help to ensure that our graduates are job-ready and highly sought after by employers.</p>
                            <p>Whether you are a recent high school graduate, a career changer, or a professional looking to upgrade your skills, TVLSTC offers flexible learning options, including full-time, part-time, and online courses, to accommodate your unique needs and help you achieve your career goals. At TVLSTC, we are dedicated to empowering our students to lead, innovate, and excel in the ever-evolving world of technology.</p>
                        </div>
                    </div>

                    <div class="mb-10 bg-violet-50 p-6 rounded-xl border-l-4 border-primary">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Mission Statement</h4>
                        <p class="text-gray-700 italic">"Our mission is to empower individuals with the practical, industry-relevant skills and knowledge needed to excel in today's technology-driven world. We are committed to providing accessible, high-quality vocational and basic education that fosters innovation, supports lifelong learning, and bridges the gap between education and employment, ultimately contributing to a skilled and adaptable workforce."</p>
                    </div>

                    <div class="mb-10">
                        <h4 class="text-2xl font-black text-primary mb-6">Core Values</h4>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h5 class="font-bold text-gray-900 mb-1">Excellence</h5>
                                <p class="text-sm text-gray-600">We strive to deliver the highest quality of education to empower learners.</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h5 class="font-bold text-gray-900 mb-1">Innovation</h5>
                                <p class="text-sm text-gray-600">Embracing the latest technological advancements and teaching methodologies.</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h5 class="font-bold text-gray-900 mb-1">Integrity</h5>
                                <p class="text-sm text-gray-600">Fostering a culture of honesty, accountability, and transparency.</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h5 class="font-bold text-gray-900 mb-1">Inclusivity</h5>
                                <p class="text-sm text-gray-600">Providing equal access to education for all, regardless of background.</p>
                            </div>
                             <div class="bg-gray-50 p-4 rounded-lg">
                                <h5 class="font-bold text-gray-900 mb-1">Collaboration</h5>
                                <p class="text-sm text-gray-600">Working with industry experts, government, and community organizations.</p>
                            </div>
                             <div class="bg-gray-50 p-4 rounded-lg">
                                <h5 class="font-bold text-gray-900 mb-1">Lifelong Learning</h5>
                                <p class="text-sm text-gray-600">Promoting continuous learning and personal development beyond the classroom.</p>
                            </div>
                             <div class="bg-gray-50 p-4 rounded-lg col-span-1 md:col-span-2">
                                <h5 class="font-bold text-gray-900 mb-1">Social Responsibility</h5>
                                <p class="text-sm text-gray-600">Contributing to the betterment of society by empowering individuals to make positive changes.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-2xl font-black text-primary mb-6">Products & Services</h4>
                        <div class="space-y-6">
                            
                            <div class="border-b border-gray-100 pb-4">
                                <h5 class="text-lg font-bold text-gray-800">1. Vocational Training Programs</h5>
                                <p class="text-sm text-gray-600 mb-2">Comprehensive, hands-on training courses designed to equip students with practical skills.</p>
                                <ul class="list-disc list-inside text-sm text-gray-500 ml-2 space-y-1">
                                    <li>Information Technology (IT)</li>
                                    <li>Electronics & Electrical Technology</li>
                                    <li>Automotive Technology</li>
                                    <li>Welding & Fabrication</li>
                                    <li>Office Work & Bookkeeping</li>
                                    <li>Language, Construction, Housekeeping, Beauty Care, etc.</li>
                                </ul>
                            </div>

                            <div class="border-b border-gray-100 pb-4">
                                <h5 class="text-lg font-bold text-gray-800">2. Certification and Licensing Courses</h5>
                                <p class="text-sm text-gray-600">Short-term courses for industry-recognized certifications (e.g., TESDA RAC Technician).</p>
                            </div>

                            <div class="border-b border-gray-100 pb-4">
                                <h5 class="text-lg font-bold text-gray-800">3. Online & E-Learning Platforms</h5>
                                <p class="text-sm text-gray-600">Virtual classrooms, self-paced modules, and online certification exams.</p>
                            </div>

                            <div class="border-b border-gray-100 pb-4">
                                <h5 class="text-lg font-bold text-gray-800">4. Corporate Training & Workforce Development</h5>
                                <p class="text-sm text-gray-600">Customized upskilling and safety compliance training for businesses.</p>
                            </div>

                            <div class="border-b border-gray-100 pb-4">
                                <h5 class="text-lg font-bold text-gray-800">5. Apprenticeship & Internship Programs</h5>
                                <p class="text-sm text-gray-600">Partnerships with local businesses and mentorship opportunities.</p>
                            </div>

                             <div class="pb-2">
                                <h5 class="text-lg font-bold text-gray-800">6. Career Counseling & Placement</h5>
                                <p class="text-sm text-gray-600">Resume building, job fairs, and dedicated placement assistance.</p>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-lg bg-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-800 sm:ml-3 sm:w-auto" @click="showModal = false">
                        Close
                    </button>
                    <a href="training/training.php" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        View Courses
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

<section 
    id="popular-programs" 
    class="py-20 bg-neutral-bg" 
    x-data="{ 
        activeTab: 'all',
        init() {
            const params = new URLSearchParams(window.location.search);
            if(params.get('tab')) {
                this.activeTab = params.get('tab');
            }
        }
    }"
>
    <div class="container mx-auto px-6">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-b border-gray-200 pb-4">
            <div class="mb-4 md:mb-0">
                <h2 class="text-3xl font-black text-gray-800 mb-2">Popular Programs</h2>
                <p class="text-gray-500">Explore our top-rated courses and assessments.</p>
            </div>

            <div class="flex space-x-8">
                <button 
                    @click="activeTab = 'all'" 
                    class="pb-4 text-sm font-bold uppercase tracking-wider transition-all border-b-4"
                    :class="activeTab === 'all' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'"
                >
                    All Programs
                </button>

                <button 
                    @click="activeTab = 'training'" 
                    class="pb-4 text-sm font-bold uppercase tracking-wider transition-all border-b-4"
                    :class="activeTab === 'training' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'"
                >
                    Training
                </button>

                <button 
                    @click="activeTab = 'assessment'" 
                    class="pb-4 text-sm font-bold uppercase tracking-wider transition-all border-b-4"
                    :class="activeTab === 'assessment' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'"
                >
                    Assessment
                </button>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            
            <div 
                x-show="activeTab === 'all' || activeTab === 'training'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group"
            >
                <div class="h-56 bg-gray-200 relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1577035474912-ea9375d9318d?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div> 
                    <span class="absolute top-4 right-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">Training</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-primary transition-colors">Book keeping</h3>
                    <div class="flex items-center text-sm text-gray-500 mb-6 space-x-4">
                        <span>⏱️ 12 Weeks</span>
                        <span>💻 On-Site</span>
                    </div>
                    <a href="/training/web-dev" class="block w-full border-2 border-primary text-primary text-center py-3 rounded-lg hover:bg-primary hover:text-white transition-colors font-bold">View Syllabus</a>
                </div>
            </div>

            <div 
                x-show="activeTab === 'all' || activeTab === 'assessment'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group"
            >
                <div class="h-56 bg-gray-200 relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1695668548342-c0c1ad479aee?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
                     <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                     <span class="absolute top-4 right-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">Assessment</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-secondary transition-colors">Computer Systems Servicing NC II</h3>
                    <div class="flex items-center text-sm text-gray-500 mb-6 space-x-4">
                        <span>⏱️ 4 Hours</span>
                        <span>🏢 On-Site</span>
                    </div>
                    <a href="/assessment/css-nc2" class="block w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-center py-3 rounded-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all font-bold">Book Slot</a>
                </div>
            </div>
            
             <div 
                x-show="activeTab === 'all' || activeTab === 'training'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group"
            >
                <div class="h-56 bg-gray-200 relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1626785774573-4b799315345d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');">
                     <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                     <span class="absolute top-4 right-4 bg-gradient-to-r from-violet-600 to-purple-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">Training</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-primary transition-colors">Graphic Design Fundamentals</h3>
                    <div class="flex items-center text-sm text-gray-500 mb-6 space-x-4">
                        <span>⏱️ 8 Weeks</span>
                        <span>💻 Hybrid</span>
                    </div>
                    <a href="/training/graphic-design" class="block w-full border-2 border-primary text-primary text-center py-3 rounded-lg hover:bg-primary hover:text-white transition-colors font-bold">View Syllabus</a>
                </div>
            </div>

            <div 
                x-show="activeTab === 'all' || activeTab === 'assessment'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group"
            >
                <div class="h-56 bg-gray-200 relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');">
                     <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                     <span class="absolute top-4 right-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">Assessment</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-secondary transition-colors">Animation NC II</h3>
                    <div class="flex items-center text-sm text-gray-500 mb-6 space-x-4">
                        <span>⏱️ 5 Hours</span>
                        <span>🏢 On-Site</span>
                    </div>
                    <a href="/assessment/animation-nc2" class="block w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-center py-3 rounded-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all font-bold">Book Slot</a>
                </div>
            </div>
        </div>
        
        <div class="mt-12 text-center">
            <a href="training/training.php" class="inline-flex items-center text-primary font-bold hover:text-purple-800 transition-colors">
                View Full Catalog
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>