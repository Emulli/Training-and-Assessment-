<?php 
include 'includes/header.php'; 
include 'db/connection.php'; 

$sql = "SELECT * FROM partners";
$result = $conn->query($sql);

$partners_data = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // 1. Convert comma-separated string to array
        // Check if services exist before exploding to prevent errors
        $row['services'] = !empty($row['services']) ? explode(', ', $row['services']) : [];
        
        // 2. Map Database Columns to JavaScript Names
        // Your DB uses 'image_url', but JS wants 'image'
        $row['image'] = $row['image_url']; 
        $row['logo'] = $row['logo_initials'];
        $row['color'] = $row['color_class'];

        // 3. Group socials
        $row['socials'] = [
            'fb' => $row['social_fb'],
            'web' => $row['social_web'],
            'linkedin' => $row['social_linkedin']
        ];
        
        $partners_data[] = $row;
    }
} else {
    // Fallback: If DB is empty, $partners_data is empty array
    // You might want to insert your hardcoded data into the DB (See Step 3 below)
}
?>

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
    class="relative h-[100px] md:h-[550px] bg-gray-900 overflow-hidden group"
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
            <a href="register.php" class="text-gray-900 font-bold text-sm bg-secondary hover:bg-cyan-400 transition-colors px-5 py-2 rounded-lg shadow-lg shadow-cyan-500/20">
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
                <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-br from-violet-600 to-purple-600 mb-1">98%</div>
                <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Passing Rate</div>
            </div>
            <div class="relative">
                <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-br from-orange-500 to-purple-500 mb-1">10</div>
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

<script>
    window.partnersData = <?php echo !empty($partners_data) ? json_encode($partners_data) : '[]'; ?>;
</script>

<section class="py-20 bg-white overflow-hidden" 
    id="partners"
    x-data="{ 
        activePartner: null,
        currentSlide: 0,
        itemsPerView: 3, 
        
        // Load data from the script tag above
        partners: window.partnersData,

        init() {
            this.updateLayout();
            const params = new URLSearchParams(window.location.search);
            const urlId = params.get('partner_id');
            if (urlId && this.partners.length > 0) {
                const found = this.partners.find(p => p.id == urlId);
                if (found) {
                    this.activePartner = found;
                    this.$nextTick(() => {
                        const el = document.getElementById('partners');
                        if(el) el.scrollIntoView({ behavior: 'smooth' });
                    });
                }
            }
        },

        updateLayout() {
            this.itemsPerView = window.innerWidth < 768 ? 1 : 3;
            if(this.partners.length > 0) {
                const maxSlide = this.partners.length - this.itemsPerView;
                if (this.currentSlide > maxSlide) this.currentSlide = Math.max(0, maxSlide);
            }
        },
        
        next() {
            if(this.partners.length === 0) return;
            const maxSlide = this.partners.length - this.itemsPerView;
            if (this.currentSlide < maxSlide) {
                this.currentSlide++;
            } else {
                this.currentSlide = 0; 
            }
        },
        prev() {
            if(this.partners.length === 0) return;
            const maxSlide = this.partners.length - this.itemsPerView;
            if (this.currentSlide > 0) {
                this.currentSlide--;
            } else {
                this.currentSlide = Math.max(0, maxSlide); 
            }
        }
    }"
    @resize.window="updateLayout()"
>
    <div class="container mx-auto px-6 relative">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-gray-800 mb-4">Our Industry Partners</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">
                We collaborate with top-tier companies to ensure our training meets industry standards.
            </p>
            <div class="w-16 h-1 bg-secondary mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="relative group" x-show="partners.length > 0">
            <button @click="prev()" class="absolute -left-4 md:-left-12 top-1/2 -translate-y-1/2 z-20 bg-white p-3 rounded-full shadow-lg text-primary hover:bg-primary hover:text-white transition-all disabled:opacity-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <button @click="next()" class="absolute -right-4 md:-right-12 top-1/2 -translate-y-1/2 z-20 bg-white p-3 rounded-full shadow-lg text-primary hover:bg-primary hover:text-white transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div class="overflow-hidden py-4 -mx-4 px-4">
                <div class="flex transition-transform duration-500 ease-out" :style="'transform: translateX(-' + (currentSlide * (100 / itemsPerView)) + '%)'">
                    <template x-for="partner in partners" :key="partner.id">
                        <div class="flex-shrink-0 px-4" :style="'width: ' + (100 / itemsPerView) + '%'">
                            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 group/card flex flex-col h-full">
                                <div class="h-48 relative overflow-hidden">
                                    <div class="absolute inset-0 bg-primary/20 group-hover/card:bg-transparent transition-colors z-10"></div>
                                    <img :src="partner.image" :alt="partner.name" class="w-full h-full object-cover transform group-hover/card:scale-110 transition-transform duration-700">
                                    <div class="absolute -bottom-6 right-6 w-12 h-12 rounded-lg shadow-lg flex items-center justify-center text-white font-bold text-sm border-2 border-white z-20" :class="partner.color">
                                        <span x-text="partner.logo"></span>
                                    </div>
                                </div>
                                <div class="p-6 pt-10 flex-grow flex flex-col">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover/card:text-primary transition-colors" x-text="partner.name"></h3>
                                    <p class="text-sm text-gray-500 leading-relaxed mb-6 flex-grow line-clamp-3" x-text="partner.overview"></p>
                                    <button @click="activePartner = partner" class="w-full py-3 rounded-lg border-2 border-primary text-primary font-bold text-sm uppercase tracking-wider hover:bg-primary hover:text-white transition-all focus:outline-none">
                                        See Company Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
        <div x-show="partners.length === 0" class="text-center py-10 text-gray-400">
            <p>No partners currently available.</p>
        </div>
    </div>

    <div x-show="activePartner" style="display: none;" class="fixed inset-0 z-[70] overflow-y-auto" aria-modal="true">
        <div x-show="activePartner" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="activePartner = null"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="activePartner" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                <button @click="activePartner = null" class="absolute top-4 right-4 text-white bg-black/20 hover:bg-black/40 rounded-full p-1 z-20"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                <div class="h-48 w-full relative">
                     <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
                     <img :src="activePartner?.image" class="w-full h-full object-cover">
                     <div class="absolute bottom-4 left-6 z-20 text-white">
                         <h3 class="text-3xl font-black" x-text="activePartner?.name"></h3>
                         <span class="text-sm opacity-90">Official Industry Partner</span>
                     </div>
                </div>
                <div class="px-6 py-8 sm:px-10 max-h-[60vh] overflow-y-auto">
                    <div class="mb-8"><h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Company Overview</h4><p class="text-gray-600 leading-relaxed" x-text="activePartner?.description"></p></div>
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-violet-50 p-5 rounded-xl border-l-4 border-primary"><h5 class="font-bold text-primary mb-2">Our Mission</h5><p class="text-sm text-gray-600 italic" x-text="activePartner?.mission"></p></div>
                        <div class="bg-blue-50 p-5 rounded-xl border-l-4 border-secondary"><h5 class="font-bold text-secondary mb-2">Our Vision</h5><p class="text-sm text-gray-600 italic" x-text="activePartner?.vision"></p></div>
                    </div>
                    <div class="mb-8"><h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Key Services</h4><ul class="space-y-2"><template x-for="service in activePartner?.services"><li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span x-text="service"></span></li></template></ul></div>
                    
                    <div class="border-t border-gray-100 pt-6 flex justify-between items-center mt-8">
                        <span class="text-sm font-bold text-gray-500">Connect with them:</span>
                        <div class="flex space-x-4">
                            <a :href="activePartner?.socials.fb" target="_blank" class="text-gray-400 hover:text-blue-600 transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                            <a :href="activePartner?.socials.web" target="_blank" class="text-gray-400 hover:text-gray-800 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white overflow-hidden" 
    id="partners"
    x-data="{ 
        activePartner: null,
        currentSlide: 0,
        itemsPerView: 3, 
        
        // NOW WE JUST REFERENCE THE VARIABLE (No PHP quotes here to break things)
        partners: window.tvlcPartners,

        init() {
            this.updateLayout();
            
            // Check URL for partner_id to open modal automatically
            const params = new URLSearchParams(window.location.search);
            const urlId = params.get('partner_id');
            
            if (urlId && this.partners.length > 0) {
                // Find the partner with the matching ID
                const found = this.partners.find(p => p.id == urlId);
                if (found) {
                    this.activePartner = found;
                    this.$nextTick(() => {
                        const el = document.getElementById('partners');
                        if(el) el.scrollIntoView({ behavior: 'smooth' });
                    });
                }
            }
        },

        updateLayout() {
            this.itemsPerView = window.innerWidth < 768 ? 1 : 3;
            if(this.partners.length > 0) {
                const maxSlide = this.partners.length - this.itemsPerView;
                if (this.currentSlide > maxSlide) {
                    this.currentSlide = maxSlide < 0 ? 0 : maxSlide;
                }
            }
        },
        
        next() {
            if(this.partners.length === 0) return;
            const maxSlide = this.partners.length - this.itemsPerView;
            if (this.currentSlide < maxSlide) {
                this.currentSlide++;
            } else {
                this.currentSlide = 0; 
            }
        },
        prev() {
            if(this.partners.length === 0) return;
            const maxSlide = this.partners.length - this.itemsPerView;
            if (this.currentSlide > 0) {
                this.currentSlide--;
            } else {
                this.currentSlide = maxSlide < 0 ? 0 : maxSlide; 
            }
        }
    }"
    @resize.window="updateLayout()"
>
    <div class="container mx-auto px-6 relative">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-gray-800 mb-4">Our Industry Partners</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">
                We collaborate with top-tier companies to ensure our training meets industry standards.
            </p>
            <div class="w-16 h-1 bg-secondary mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="relative group" x-show="partners.length > 0">
            
            <button @click="prev()" class="absolute -left-4 md:-left-12 top-1/2 -translate-y-1/2 z-20 bg-white p-3 rounded-full shadow-lg text-primary hover:bg-primary hover:text-white transition-all disabled:opacity-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <button @click="next()" class="absolute -right-4 md:-right-12 top-1/2 -translate-y-1/2 z-20 bg-white p-3 rounded-full shadow-lg text-primary hover:bg-primary hover:text-white transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div class="overflow-hidden py-4 -mx-4 px-4">
                <div class="flex transition-transform duration-500 ease-out" :style="'transform: translateX(-' + (currentSlide * (100 / itemsPerView)) + '%)'">
                    
                    <template x-for="partner in partners" :key="partner.id">
                        <div class="flex-shrink-0 px-4" :style="'width: ' + (100 / itemsPerView) + '%'">
                            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 group/card flex flex-col h-full">
                                
                                <div class="h-48 relative overflow-hidden">
                                    <div class="absolute inset-0 bg-primary/20 group-hover/card:bg-transparent transition-colors z-10"></div>
                                    <img :src="partner.image" :alt="partner.name" class="w-full h-full object-cover transform group-hover/card:scale-110 transition-transform duration-700">
                                    <div class="absolute -bottom-6 right-6 w-12 h-12 rounded-lg shadow-lg flex items-center justify-center text-white font-bold text-sm border-2 border-white z-20" :class="partner.color">
                                        <span x-text="partner.logo"></span>
                                    </div>
                                </div>

                                <div class="p-6 pt-10 flex-grow flex flex-col">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover/card:text-primary transition-colors" x-text="partner.name"></h3>
                                    <p class="text-sm text-gray-500 leading-relaxed mb-6 flex-grow line-clamp-3" x-text="partner.overview"></p>
                                    <button @click="activePartner = partner" class="w-full py-3 rounded-lg border-2 border-primary text-primary font-bold text-sm uppercase tracking-wider hover:bg-primary hover:text-white transition-all focus:outline-none">
                                        See Company Profile
                                    </button>
                                </div>

                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
        
        <div x-show="partners.length === 0" class="text-center py-10 text-gray-400">
            <p>No partners currently available.</p>
        </div>

    </div>

    <div x-show="activePartner" style="display: none;" class="fixed inset-0 z-[70] overflow-y-auto" aria-modal="true">
        <div x-show="activePartner" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="activePartner = null"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="activePartner" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                <button @click="activePartner = null" class="absolute top-4 right-4 text-white bg-black/20 hover:bg-black/40 rounded-full p-1 z-20"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                
                <div class="h-48 w-full relative">
                     <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
                     <img :src="activePartner?.image" class="w-full h-full object-cover">
                     <div class="absolute bottom-4 left-6 z-20 text-white">
                         <h3 class="text-3xl font-black" x-text="activePartner?.name"></h3>
                         <span class="text-sm opacity-90">Official Industry Partner</span>
                     </div>
                </div>

                <div class="px-6 py-8 sm:px-10 max-h-[60vh] overflow-y-auto">
                    <div class="mb-8"><h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Company Overview</h4><p class="text-gray-600 leading-relaxed" x-text="activePartner?.description"></p></div>
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-violet-50 p-5 rounded-xl border-l-4 border-primary"><h5 class="font-bold text-primary mb-2">Our Mission</h5><p class="text-sm text-gray-600 italic" x-text="activePartner?.mission"></p></div>
                        <div class="bg-blue-50 p-5 rounded-xl border-l-4 border-secondary"><h5 class="font-bold text-secondary mb-2">Our Vision</h5><p class="text-sm text-gray-600 italic" x-text="activePartner?.vision"></p></div>
                    </div>
                    
                    <div class="mb-8">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Key Services</h4>
                        <ul class="space-y-2">
                            <template x-for="service in activePartner?.services">
                                <li class="flex items-center text-gray-700">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span x-text="service"></span>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="border-t border-gray-100 pt-6 flex justify-between items-center mt-8">
                        <span class="text-sm font-bold text-gray-500">Connect with them:</span>
                        <div class="flex space-x-4">
                            <a :href="activePartner?.socials.fb" target="_blank" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a :href="activePartner?.socials.web" target="_blank" class="text-gray-400 hover:text-gray-800 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                            </a>
                            <a :href="activePartner?.socials.linkedin" target="_blank" class="text-gray-400 hover:text-blue-700 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
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

<section class="py-20 bg-gray-50 relative">
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-gray-800 mb-4">Visit Our Center</h2>
            <p class="text-gray-500">We are conveniently located to serve your training needs.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 shadow-2xl rounded-3xl overflow-hidden bg-white">
            
            <div class="w-full lg:w-1/3 bg-primary text-white p-10 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                
                <div class="relative z-10 space-y-8">
                    <div>
                        <h3 class="text-xl font-bold mb-1">Our Location</h3>
                        <p class="text-blue-100 text-sm">
                            3568 St Agnes <br>
                            Caloocan City, Metro Manila, <br>
                            Philippines
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-1">Contact Us</h3>
                        <p class="text-blue-100 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            0992 987 1284
                        </p>
                        <p class="text-blue-100 text-sm flex items-center gap-2 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            tvlc.inc.24@gmail.com
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-1">Office Hours</h3>
                        <p class="text-blue-100 text-sm">Mon - Fri: 8:00 AM - 5:00 PM</p>
                        <p class="text-blue-100 text-sm">Sat: 8:00 AM - 12:00 PM</p>
                    </div>
                </div>

                <div class="relative z-10 flex gap-4 mt-8">
                    <a href="https://www.facebook.com/profile.php?id=61559506239987&rdid=0bsFGS3skOliGt81&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1A4PNYYKd1%2F#" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-primary transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://www.instagram.com/tvlc_inc/" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-primary transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>
                
            </div>

            <div class="w-full lg:w-2/3 relative group bg-gray-200 min-h-[400px]">
                
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3491.4481603517766!2d121.04321927457575!3d14.75912307317701!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b0259d6afffd%3A0xda652371cfafaf6e!2s3568%20St%20Agnes%2C%20Caloocan%2C%20Metro%20Manila!5e1!3m2!1sen!2sph!4v1764831462674!5m2!1sen!2sph" 
                    width="100%" 
                    height="100%" 
                    style="border:0; min-height: 400px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>

                <div 
                    class="absolute inset-0 bg-black/10 flex items-center justify-center cursor-pointer group-hover:bg-transparent transition-all"
                    onclick="this.style.pointerEvents='none'; this.style.opacity='0';"
                >
                    <span class="bg-white px-4 py-2 rounded-full shadow-lg text-sm font-bold text-gray-700 pointer-events-none group-hover:opacity-0 transition-opacity">
                        Click map to interact
                    </span>
                </div>

            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>