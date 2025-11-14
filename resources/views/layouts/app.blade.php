<!DOCTYPE html>
<html lang="id"
      x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen') ?? (window.innerWidth > 1024))
      }"
      x-init="
        document.documentElement.classList.toggle('dark', darkMode);
        $watch('darkMode', val => {
          document.documentElement.classList.toggle('dark', val);
          localStorage.setItem('darkMode', val);
        });
        $watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val));
        window.addEventListener('resize', () => {
          if (window.innerWidth < 1024) sidebarOpen = false;
        });
      "
      class="antialiased scroll-smooth">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'Perpustakaan')</title>

  @if (file_exists(public_path('build')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
      <script src="https://cdn.tailwindcss.com"></script>
  @endif

  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    [x-cloak]{display:none!important}
    @keyframes slideIn {from{transform:translateX(-10px);opacity:0;}to{transform:translateX(0);opacity:1;}}
    .animate-slide-in {animation: slideIn .4s ease-out;}
  </style>
</head>

<body class="bg-gradient-to-br from-[#F9FBFD] to-[#EAF1FA] dark:from-[#0A1328] dark:to-[#0E1C3D] 
             text-gray-900 dark:text-gray-100 transition-all duration-500">

@php
 $authPages = ['login', 'register'];  
@endphp

@if (!in_array(Route::currentRouteName(), $authPages))

{{-- 🌟 NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 z-40 backdrop-blur-xl bg-white/80 dark:bg-[#121b3b]/70 
           border-b border-gray-200 dark:border-gray-700 shadow-sm transition-all duration-300">
  <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-3">

    {{-- LOGO --}}
    <div class="flex items-center gap-3">
      <img src="{{ asset('images/logo.png') }}" alt="Logo"
           class="w-10 h-10 object-contain transition-transform duration-300 hover:scale-105">
      <div>
        <a href="{{ url('/dashboard') }}"
           class="text-lg font-bold text-[#004AAD] dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-200 transition">
          SI MACCA
        </a>
        <p class="text-xs text-gray-500 dark:text-gray-400 -mt-0.5"> Sistem Informasi Gemar Membaca Kejaksaan Negeri Soppeng</p>
      </div>
    </div>

    {{-- TOGGLE + AVATAR + LOGOUT --}}
    <div class="flex items-center gap-4">
      {{-- DARK MODE TOGGLE --}}
      <button @click="darkMode = !darkMode"
          class="relative w-11 h-6 bg-gray-300 dark:bg-blue-600 rounded-full transition">
          <div class="absolute w-5 h-5 bg-white rounded-full top-0.5 left-0.5 shadow 
                      transition-all duration-300"
               :class="darkMode ? 'translate-x-5' : 'translate-x-0'"></div>
      </button>

      @auth
      @php
          $avatarColor = auth()->user()->avatar_color ?? '#2563EB';
          $isAdmin = auth()->user()->role === 'admin';
          $initials = strtoupper(substr(auth()->user()->name, 0, $isAdmin ? 2 : 1));
      @endphp

      <div class="flex items-center gap-2">
          <div class="relative w-9 h-9 rounded-full overflow-hidden flex items-center justify-center shadow-sm border border-gray-300 dark:border-gray-600"
               style="background-color: {{ $avatarColor }}">
              @if (auth()->user()->avatar)
                  <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar"
                       class="w-full h-full object-cover">
              @else
                  <span class="text-white font-semibold text-sm">{{ $initials }}</span>
              @endif
          </div>
          <div class="flex flex-col leading-tight">
              <span class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</span>
              <span class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(auth()->user()->role) }}</span>
          </div>
      </div>

      {{-- LOGOUT --}}
      <form method="POST" action="{{ route('logout') }}">@csrf
        <button class="px-3 py-1.5 rounded-md bg-red-500 hover:bg-red-600 text-white text-sm shadow-sm">
          Keluar
        </button>
      </form>
      @endauth
    </div>
  </div>
</nav>

{{-- 🌈 LAYOUT --}}
<div class="pt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex gap-6 transition-all duration-500">

  {{-- 📚 SIDEBAR --}}
  <aside
    class="bg-white/90 dark:bg-[#0F172A]/90 border border-gray-200 dark:border-[#1E293B]/60
           rounded-2xl shadow-xl shadow-blue-100/50 dark:shadow-blue-900/20 backdrop-blur-lg
           transition-all duration-500 flex flex-col justify-between overflow-hidden items-center animate-slide-in"
    :class="sidebarOpen ? 'w-64 p-4' : 'w-20 p-3'">

    {{-- Logo & Toggle --}}
    <div class="w-full">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
          <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-[#0F172A] shadow-sm">
            <img src="{{ asset('images/logo.png') }}" class="w-8 h-8 object-contain" alt="Logo">
          </div>
          <span x-show="sidebarOpen" x-transition
                class="font-bold text-[#004AAD] dark:text-blue-300 text-sm ml-1">Perpustakaan</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen"
                class="p-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-[#1b2b50] transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  :d="sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
          </svg>
        </button>
      </div>

      {{-- Navigation --}}
      <nav class="flex flex-col gap-1 text-sm mt-4">
        @php
          $links = [
            ['route'=>'dashboard','label'=>'Dashboard','icon'=>'🏠'],
            ['route'=>'buku.index','label'=>'Buku','icon'=>'📚'],
            ['route'=>'anggota.index','label'=>'Anggota','icon'=>'👥'],
            ['route'=>'peminjaman.index','label'=>'Peminjaman','icon'=>'📦'],
            ['route'=>'profil','label'=>'Profil','icon'=>'⚙️'],
          ];
          if (auth()->check() && auth()->user()->role === 'admin') {
              $links[] = ['route'=>'users.index','label'=>'Manajemen Pengguna','icon'=>'🧑‍💼'];
          }
        @endphp

        @foreach($links as $link)
          @php $active = request()->routeIs($link['route']); @endphp
          <a href="{{ route($link['route']) }}"
             class="group relative flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-300 justify-center md:justify-start
                    {{ $active
                        ? 'bg-gradient-to-r from-[#0094FF]/90 to-[#0066FF]/80 text-white font-semibold shadow-md shadow-blue-500/30'
                        : 'text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-[#243B63]/70 hover:text-blue-700 dark:hover:text-blue-300' }}">
            <span class="text-lg transition-transform duration-300 group-hover:scale-110">{{ $link['icon'] }}</span>
            <span x-show="sidebarOpen" x-transition>{{ $link['label'] }}</span>
            @if ($active)
              <span class="absolute right-2 w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
            @endif
          </a>
        @endforeach
      </nav>
    </div>

    {{-- Footer --}}
    <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-3 text-center w-full">
      <p class="text-xs text-gray-500 dark:text-gray-400" x-show="sidebarOpen" x-transition>
        © {{ date('Y') }} Kejari Soppeng
      </p>
    </div>
  </aside>

  {{-- 🧭 MAIN CONTENT --}}
  <main class="flex-1 transition-all duration-500 relative">
    <div id="toast-container" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3"></div>
    @yield('content')
  </main>
</div>

{{-- Footer --}}
<footer class="text-center text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-10 py-4 border-t border-gray-100 dark:border-gray-800">
  © {{ date('Y') }} <span class="font-semibold text-blue-600 dark:text-blue-400">Kejaksaan Negeri Soppeng</span> — Sistem Perpustakaan
</footer>

{{-- TOAST SCRIPT --}}
<script>
  function showToast(type, message) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    const colors = { success: 'bg-green-600', error: 'bg-red-600', info: 'bg-blue-600', warning: 'bg-yellow-500' };
    const icons = { success: '✅', error: '❌', info: 'ℹ️', warning: '⚠️' };
    toast.className = `${colors[type] || 'bg-gray-800'} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 transform translate-x-96 opacity-0 transition-all duration-500`;
    toast.innerHTML = `<span class="text-xl">${icons[type] || '🔔'}</span>
      <div class="flex-1 text-sm font-medium">${message}</div>
      <button onclick="this.parentElement.remove()" class="ml-auto text-white/70 hover:text-white text-lg">&times;</button>`;
    container.appendChild(toast);
    setTimeout(() => toast.classList.remove('translate-x-96', 'opacity-0'), 30);
    setTimeout(() => { toast.classList.add('translate-x-96', 'opacity-0'); setTimeout(() => toast.remove(), 400); }, 4000);
  }
  @if(session('success')) showToast('success', "{{ session('success') }}"); @endif
  @if($errors->any()) showToast('error', "{{ $errors->first() }}"); @endif
</script>

@endif
</body>
</html>
