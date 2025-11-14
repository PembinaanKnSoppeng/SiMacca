@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <div class="bg-white dark:bg-[#10193a] shadow-md rounded-xl p-6"
         x-data="{ showOld: false, showNew: false, showConfirm: false, password: '', strength: 0 }"
         x-effect="
            if (password.length === 0) strength = 0;
            else if (password.length < 6) strength = 1;
            else if (password.match(/[A-Z]/) && password.match(/[0-9]/) && password.match(/[^A-Za-z0-9]/)) strength = 3;
            else strength = 2;
         ">

        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">
            🔒 Ganti Password
        </h2>

        {{-- 🧩 Form Ganti Password --}}
        <form method="POST" action="{{ route('profil.password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Password Lama --}}
            <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Password Lama</label>
                <input :type="showOld ? 'text' : 'password'" name="current_password" required
                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-[#0B132B] dark:text-white pr-10 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" @click="showOld = !showOld"
                        class="absolute right-3 top-8 text-gray-500 hover:text-gray-700 dark:text-gray-400">
                    <template x-if="!showOld">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.71 2.303-2.264 4.243-4.322 5.514" />
                        </svg>
                    </template>
                    <template x-if="showOld">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3l18 18M9.879 9.879a3 3 0 104.242 4.242" />
                        </svg>
                    </template>
                </button>
            </div>

            {{-- Password Baru --}}
            <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Password Baru</label>
                <input :type="showNew ? 'text' : 'password'" x-model="password" name="password" required
                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-[#0B132B] dark:text-white pr-10 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" @click="showNew = !showNew"
                        class="absolute right-3 top-8 text-gray-500 hover:text-gray-700 dark:text-gray-400">
                    <template x-if="!showNew">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.71 2.303-2.264 4.243-4.322 5.514" />
                        </svg>
                    </template>
                    <template x-if="showNew">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3l18 18M9.879 9.879a3 3 0 104.242 4.242" />
                        </svg>
                    </template>
                </button>

                {{-- 🔋 Indikator Kekuatan Password --}}
                <div class="mt-2 w-full h-2 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                    <div class="h-full transition-all duration-500"
                        :class="{
                            'w-1/4 bg-red-500': strength === 1,
                            'w-2/4 bg-yellow-500': strength === 2,
                            'w-full bg-green-500': strength === 3
                        }"></div>
                </div>
                <p class="text-xs mt-1 text-gray-500 dark:text-gray-400" x-show="strength === 1">Lemah 😕</p>
                <p class="text-xs mt-1 text-gray-500 dark:text-gray-400" x-show="strength === 2">Sedang 😐</p>
                <p class="text-xs mt-1 text-gray-500 dark:text-gray-400" x-show="strength === 3">Kuat 💪</p>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Konfirmasi Password Baru</label>
                <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-[#0B132B] dark:text-white pr-10 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" @click="showConfirm = !showConfirm"
                        class="absolute right-3 top-8 text-gray-500 hover:text-gray-700 dark:text-gray-400">
                    <template x-if="!showConfirm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.71 2.303-2.264 4.243-4.322 5.514" />
                        </svg>
                    </template>
                    <template x-if="showConfirm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3l18 18M9.879 9.879a3 3 0 104.242 4.242" />
                        </svg>
                    </template>
                </button>
            </div>

            {{-- Tombol --}}
            <div class="pt-4 flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-md transition">💾 Simpan Password</button>
                <a href="{{ route('profil') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-600 text-gray-900 dark:text-gray-100 rounded-md shadow transition">← Kembali</a>
            </div>
        </form>
    </div>
</div>

{{-- 🌟 TOAST --}}
<div id="toast-container" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3"></div>

<script>
function showToast(type, message) {
  const container = document.getElementById('toast-container');
  const toast = document.createElement('div');
  const colors = { success: 'bg-green-600/90', error: 'bg-red-600/90', info: 'bg-blue-600/90' };
  const icons = { success: '✅', error: '❌', info: 'ℹ️' };
  toast.className = `${colors[type] || 'bg-gray-800/90'} backdrop-blur-md text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 opacity-0 translate-x-8 transition-all duration-500`;
  toast.innerHTML = `<span class="text-xl">${icons[type]}</span><div>${message}</div>`;
  container.appendChild(toast);
  setTimeout(() => { toast.classList.remove('opacity-0', 'translate-x-8'); }, 50);
  setTimeout(() => { toast.classList.add('opacity-0', 'translate-x-8'); setTimeout(() => toast.remove(), 500); }, 5000);
}

@if(session('success'))
  showToast('success', "{{ session('success') }}");
@endif

@if(session('error'))
  showToast('error', "{{ session('error') }}");
@endif

@if($errors->any())
  showToast('error', "{{ $errors->first() }}");
@endif
</script>
@endsection
