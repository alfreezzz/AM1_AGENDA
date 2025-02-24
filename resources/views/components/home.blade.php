<!-- Main Container -->
<div class="py-6">
    <div class="container mx-auto">
        <!-- Character and Content Container -->
        <div class="flex justify-between items-center md:px-16">
            <!-- Left Character -->
            <div class="w-full md:w-1/4 flex justify-center">
                <img src="assets/images/liah.png" alt="Liah" class="h-56 md:h-80 w-auto object-contain hover:scale-105 transition-transform duration-300">
            </div>

            <!-- Center Content -->
            <div class="w-full md:w-2/4 text-center">
                <div class="flex justify-center md:mb-5 mb-3">
                    <img src="assets/images/icon.png" alt="School Logo" class="w-32 md:w-56 h-auto hover:rotate-3 transition-transform duration-300">
                </div>
                <h1 class="text-xs md:text-2xl font-serif text-gray-800 font-bold">
                    SMK Amaliah 1&2 Ciawi Bogor
                </h1>
                <p class="text-[0.5rem] md:text-xl italic text-gray-600 font-medium">
                    "Tauhid is Our Fundament"
                </p>
                <div class="md:w-24 w-12 md:h-1 h-0.5 bg-blue-500 mx-auto rounded-full md:mt-8 mt-5"></div>
            </div>

            <!-- Right Character -->
            <div class="w-full md:w-1/4 flex justify-center">
                <img src="assets/images/amal.png" alt="Amal" class="h-56 md:h-80 w-auto object-contain hover:scale-105 transition-transform duration-300">
            </div>
        </div>
    </div>

    <!-- Program Icons -->
    <div class="py-8 mt-8">
        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center items-center gap-2 md:gap-4">
                <img src="assets/images/LOGO-ANIMASI-01-500x500.png" alt="AN" class="h-5 md:h-10 object-contain hover:scale-110 transition-all duration-300">
                <img src="assets/images/TKJ-Baru-500x500.png" alt="TJKT" class="h-5 md:h-10 object-contain hover:scale-110 transition-all duration-300">
                <img src="assets/images/LOGO-RPL-01-500x500.png" alt="PPLG" class="h-5 md:h-10 object-contain hover:scale-110 transition-all duration-300">
                <img src="assets/images/LOGO-AKL-01-500x500.png" alt="AKL" class="h-5 md:h-10 object-contain hover:scale-110 transition-all duration-300">
                <img src="assets/images/BR-500x500.png" alt="BR" class="h-5 md:h-10 object-contain hover:scale-110 transition-all duration-300">
                <img src="assets/images/Logo-TB-OK-01-500x500.png" alt="DPB" class="h-5 md:h-10 object-contain hover:scale-110 transition-all duration-300">
                <img src="assets/images/LOGO-LPS-01-500x500.png" alt="LPS" class="h-5 md:h-10 object-contain hover:scale-110 transition-all duration-300">
                <img src="assets/images/MP-Baru-500x500.png" alt="MP" class="h-5 md:h-10 object-contain hover:scale-110 transition-all duration-300">
            </div>
        </div>
    </div>

    <!-- App Information Section -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mt-24" x-data="{ activeTab: 'tentang' }">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-400 p-8">
            <h2 class="text-2xl md:text-4xl font-bold text-center text-white mb-6">
                AM Agenda Pembelajaran Harian
            </h2>
            
            <!-- Navigation Tabs -->
            <div class="flex justify-center space-x-4">
                <button 
                    @click="activeTab = 'tentang'" 
                    :class="{ 'bg-white text-emerald-600': activeTab === 'tentang', 'bg-emerald-500 text-white': activeTab !== 'tentang' }"
                    class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-md">
                    Tentang Aplikasi
                </button>
                <button 
                    @click="activeTab = 'fitur'" 
                    :class="{ 'bg-white text-emerald-600': activeTab === 'fitur', 'bg-emerald-500 text-white': activeTab !== 'fitur' }"
                    class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-md">
                    Fitur Utama
                </button>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="p-8">
            <!-- Tentang Section -->
            <div x-show="activeTab === 'tentang'" class="space-y-6" x-transition>
                <div class="bg-emerald-50 rounded-xl p-6 shadow-inner">
                    <p class="text-gray-700 text-lg leading-relaxed mb-4">
                        Amaliah Agenda Pembelajaran Harian adalah aplikasi inovatif yang dirancang khusus untuk membantu guru dan siswa SMK Amaliah dalam mengelola dan mengoptimalkan proses pembelajaran sehari-hari.
                    </p>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        Dengan antarmuka yang mudah digunakan dan fitur yang komprehensif, aplikasi ini memungkinkan pencatatan, pemantauan, dan evaluasi kegiatan pembelajaran secara efektif dan efisien.
                    </p>
                </div>
            </div>

            <!-- Fitur Section -->
            <div x-show="activeTab === 'fitur'" class="grid md:grid-cols-2 gap-6" x-transition>
                <div class="bg-emerald-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">1</div>
                        <h3 class="font-semibold text-xl text-emerald-600 ml-4">Agenda Harian Digital</h3>
                    </div>
                    <p class="text-gray-600">Pencatatan dan pengelolaan agenda pembelajaran harian secara digital dan terorganisir dengan sistem yang mudah digunakan.</p>
                </div>
                <div class="bg-emerald-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">2</div>
                        <h3 class="font-semibold text-xl text-emerald-600 ml-4">Monitoring Pembelajaran</h3>
                    </div>
                    <p class="text-gray-600">Pemantauan progress pembelajaran siswa dan pencapaian target kurikulum secara real-time dan terukur.</p>
                </div>
                <div class="bg-emerald-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">3</div>
                        <h3 class="font-semibold text-xl text-emerald-600 ml-4">Kemudahan dalam Pencatatan Kehadiran</h3>
                    </div>
                    <p class="text-gray-600">Memudahkan guru dan sekretaris dalam mencatat kehadiran siswa dengan fitur pencatatan kehadiran yang sederhana dan cepat digunakan.</p>
                </div>
                <div class="bg-emerald-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">4</div>
                        <h3 class="font-semibold text-xl text-emerald-600 ml-4">Laporan & Evaluasi</h3>
                    </div>
                    <p class="text-gray-600">Pembuatan laporan dan evaluasi pembelajaran secara otomatis dengan visualisasi data yang informatif.</p>
                </div>
            </div>
        </div>
    </div>
</div>