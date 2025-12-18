<header class="bg-gray-900 text-white py-4 shadow-md">
    <div class="max-w-6xl mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center gap-2 text-lg font-semibold">
            <i class="fa-solid fa-headset text-blue-400"></i>
            HelpDesk
        </div>

        <!-- Desktop meniu -->
        <nav class="hidden md:block">
            <ul class="flex gap-6 text-sm text-gray-300">
                <li><a href="/dashboard" class="hover:text-white transition">Dashboard</a></li>
                <li><a href="/tickets" class="hover:text-white transition">Bilietai</a></li>
                <li><a href="/devices" class="hover:text-white transition">Įrenginiai</a></li>
            </ul>
        </nav>

        <!-- Hamburger -->
        <button id="navToggle" class="md:hidden flex flex-col gap-1">
            <span class="w-6 h-[3px] bg-white"></span>
            <span class="w-6 h-[3px] bg-white"></span>
            <span class="w-6 h-[3px] bg-white"></span>
        </button>
    </div>

    <!-- Mobile meniu -->
    <nav id="mobileNav" class="hidden bg-gray-800 md:hidden">
        <ul class="px-4 py-3 text-gray-300 text-sm">
            <li><a href="/dashboard" class="block py-1">Dashboard</a></li>
            <li><a href="/tickets" class="block py-1">Bilietai</a></li>
            <li><a href="/devices" class="block py-1">Įrenginiai</a></li>
        </ul>
    </nav>
</header>
