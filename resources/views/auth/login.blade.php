<!DOCTYPE html>
<html lang="id" class="antialiased">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login — Sistem Perpustakaan</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#F7FAFC] via-[#EEF2F7] to-[#E9EEF3] dark:from-[#0D1321] dark:via-[#101A32] dark:to-[#0A0F25] transition-colors duration-500">

  {{-- 🌈 Decorative Background Shapes --}}
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute w-64 h-64 bg-blue-400/20 dark:bg-blue-500/10 rounded-full blur-3xl top-10 left-10 animate-pulse"></div>
    <div class="absolute w-80 h-80 bg-indigo-500/10 dark:bg-indigo-400/10 rounded-full blur-3xl bottom-10 right-10 animate-pulse-slow"></div>
  </div>

  {{-- 🔷 Card Login --}}
  <div class="relative z-10 w-full max-w-4xl mx-6 bg-white/70 dark:bg-[#111C3A]/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/30 dark:border-[#1C295F]/30 overflow-hidden flex flex-col md:flex-row animate-fade-in">

    {{-- 🖼️ Left Side (Form) --}}
    <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
      {{-- Logo & Title --}}
      <div class="flex flex-col items-center md:items-start mb-8">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Perpustakaan" class="w-16 h-16 mb-3 object-contain drop-shadow-md">
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">Sistem Perpustakaan</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Masuk untuk mengelola dan memantau data perpustakaan Kejaksaan Negeri Soppeng.</p>
      </div>

      {{-- ⚠️ Error --}}
      @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 rounded-lg text-sm">
          @foreach ($errors->all() as $e)
            <p>⚠️ {{ $e }}</p>
          @endforeach
        </div>
      @endif

      {{-- 🔐 Form --}}
      <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
          <input type="email" name="email" required placeholder="contoh@email.com"
            class="w-full px-4 py-2.5 rounded-xl bg-gray-50/80 dark:bg-[#0B132B] border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200 hover:shadow-md">
        </div>

        {{-- Password --}}
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Sandi</label>
          <div class="relative">
            <input type="password" id="password" name="password" required placeholder="••••••••"
              class="w-full px-4 py-2.5 rounded-xl bg-gray-50/80 dark:bg-[#0B132B] border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200 hover:shadow-md">
            <button type="button" id="togglePassword" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">👁️</button>
          </div>
        </div>

        {{-- Tombol Masuk --}}
        <button type="submit"
          class="w-full py-2.5 bg-gradient-to-r from-[#6B4EFF]/90 to-[#8E6BFF]/90 hover:from-[#00C6FB]/90 to-[#005BEA]/90  text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition transform hover:scale-[1.02] active:scale-95 duration-200">
          Masuk Sekarang
        </button>
      </form>

      {{-- Footer --}}
      <p class="mt-6 text-center md:text-left text-xs text-gray-500 dark:text-gray-400">
        Belum punya akun? <span class="text-blue-600 dark:text-blue-400 font-medium">Hubungi Admin</span>
      </p>
    </div>

    {{-- 🌆 Right Side (Ilustrasi) --}}
    <div class="hidden md:flex w-1/2 bg-gradient-to-br from-[#7F00FF]/90 to-[#E100FF]/90 items-center justify-center relative">
      <img src="{{ asset('images/7.svg') }}" alt="Library Illustration" class="w-4/5 drop-shadow-2xl animate-float-slow">
      <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-3xl"></div>
    </div>
  </div>

  {{-- ✨ Animasi --}}
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.6s ease-out; }
    @keyframes pulseSlow {
      0%, 100% { opacity: 0.8; transform: scale(1); }
      50% { opacity: 1; transform: scale(1.05); }
    }
    .animate-pulse-slow { animation: pulseSlow 6s ease-in-out infinite; }
    @keyframes floatSlow {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-8px); }
    }
    .animate-float-slow { animation: floatSlow 5s ease-in-out infinite; }
  </style>

  {{-- 👁️ Toggle Password --}}
  <script>
    document.getElementById('togglePassword').addEventListener('click', () => {
      const input = document.getElementById('password');
      input.type = input.type === 'password' ? 'text' : 'password';
    });
  </script>

</body>
</html>
