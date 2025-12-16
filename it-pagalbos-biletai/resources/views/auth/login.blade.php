<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Prisijungimas – HelpDesk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Ikonos --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    {{-- Tailwind --}}
    @vite('resources/css/app.css')

    <style>
        /* Modal animacija */
        @keyframes modalIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-gray-900 text-white py-4 shadow-md">
        <div class="max-w-4xl mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center gap-2 text-lg font-semibold">
                <i class="fa-solid fa-headset text-blue-400"></i>
                HelpDesk
            </div>

            <!-- Desktop meniu (login puslapyje gali būti tuščias, bet laboratorijai reikia skirtingo stiliaus) -->
            <nav class="hidden md:block">
                <ul class="flex gap-6 text-sm text-gray-300">
                    <li><span class="opacity-60">Pagalbos sistema</span></li>
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
                <li class="py-1 opacity-70">Pagalbos sistema</li>
            </ul>
        </nav>
    </header>

    <!-- CONTENT -->
    <main class="flex-grow flex items-center justify-center px-4">
        <div class="bg-white shadow-xl rounded-xl p-8 w-full max-w-md">

            <div class="text-center mb-6">
                <i class="fa-solid fa-right-to-bracket text-4xl text-blue-500 mb-3"></i>
                <h2 class="text-2xl font-semibold">Prisijungimas</h2>
                <p class="text-gray-500 text-sm">Įveskite savo prisijungimo duomenis</p>
            </div>

            <form id="login-form" class="space-y-5">

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">El. paštas</label>
                    <input type="email" name="email" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Slaptažodis</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium shadow-md transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    Prisijungti
                </button>
            </form>

            <!-- Klaidos modalas -->
            <div id="errorModal"
                 class="fixed inset-0 bg-black/50 hidden items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-80 shadow-xl animate-[modalIn_0.25s_ease-out] relative">
                    <button id="closeModal" class="absolute top-2 right-3 text-xl">&times;</button>
                    <h3 class="text-lg font-semibold mb-2">Klaida</h3>
                    <p class="text-gray-600">Neteisingi prisijungimo duomenys.</p>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-200 text-gray-600 py-3 text-center text-sm">
        © 2025 HelpDesk sistema · API · Kontaktai
    </footer>

    <script>
        // Hamburger meniu
        const navToggle = document.getElementById('navToggle');
        const mobileNav = document.getElementById('mobileNav');

        navToggle.addEventListener('click', () => {
            mobileNav.classList.toggle('hidden');
        });

        // Modal valdymas
        const errorModal = document.getElementById('errorModal');
        const closeModal = document.getElementById('closeModal');

        closeModal.addEventListener('click', () => {
            errorModal.classList.add('hidden');
        });

        // Login logika
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const email = this.email.value;
            const password = this.password.value;

            const res = await fetch('/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email, password })
            });

            if (res.ok) {
                const data = await res.json();
                localStorage.setItem('access_token', data.access_token);
                localStorage.setItem('refresh_token', data.refresh_token);
                window.location.href = '/dashboard';
            } else {
                errorModal.classList.remove('hidden');
            }
        });
    </script>

</body>
</html>
