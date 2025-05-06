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
                    <img src="assets/images/icon.png" alt="School Logo" class="w-32 md:w-56 h-auto">
                </div>
                <h1 class="text-xs md:text-2xl font-serif text-gray-800 font-bold">
                    SMK Amaliah 1&2 Ciawi
                </h1>
                <p class="text-[0.5rem] md:text-xl italic text-gray-600 font-medium">
                    Tauhid is Our Fundament
                </p>
                <div class="md:w-24 w-12 md:h-1 h-0.5 bg-blue-500 mx-auto rounded-full md:mt-8 mt-5"></div>
            </div>

            <!-- Right Character -->
            <div class="w-full md:w-1/4 flex justify-center">
                <img src="assets/images/amal.png" alt="Amal" class="h-56 md:h-80 w-auto object-contain hover:scale-105 transition-transform duration-300">
            </div>
        </div>
    </div>

    {{ $slot }}
</div>