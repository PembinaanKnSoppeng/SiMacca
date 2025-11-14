@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-6 space-y-10">

    {{-- 🌈 Card Profil Utama --}}
    <div class="bg-gradient-to-br from-blue-500/10 to-indigo-500/10 dark:from-blue-900/20 dark:to-indigo-800/20 
                border border-gray-200 dark:border-gray-700 shadow-lg rounded-3xl p-8 transition-all duration-500
                hover:shadow-blue-500/20 hover:border-blue-400/40">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8">

            {{-- 🖼 Avatar --}}
            <div class="relative group">
                <div id="avatarPreview" 
                     class="w-28 h-28 rounded-full overflow-hidden border-4 border-blue-500/40 shadow-lg flex items-center justify-center 
                            text-3xl font-bold text-white select-none transition-transform duration-300 group-hover:scale-105"
                     style="background-color: {{ $user->avatar_color ?? '#2563EB' }}">
                    @if($user->avatar)
                        <img id="avatarImage" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <span id="avatarInitials">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    @endif
                </div>

                {{-- Tombol edit avatar --}}
                <label for="avatarInput"
                       class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white text-xs px-2 py-1 rounded-full shadow 
                              cursor-pointer transform translate-y-1/2 transition-all duration-300 opacity-0 group-hover:opacity-100">
                    ✏️ Ganti
                </label>
            </div>

            {{-- 🧍 Info Pengguna --}}
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">{{ $user->name }}</h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $user->email }}</p>
                <p class="text-sm mt-1 text-gray-500 dark:text-gray-400">
                    Peran: <strong class="text-blue-600 dark:text-blue-300">{{ ucfirst($user->role ?? 'User') }}</strong>
                </p>

                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('profil.password') }}"
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                              text-white px-4 py-2 rounded-lg text-sm shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v1h2v-1a5 5 0 10-10 0v1h2v-1zM5 11a2 2 0 104 0v-1H5v1zm0 4h14a2 2 0 012 2v1H3v-1a2 2 0 012-2z" />
                        </svg>
                        Ganti Password
                    </a>

                    @if($user->avatar)
                    <button type="button" id="hapusAvatarBtn"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 
                                   text-white px-4 py-2 rounded-lg text-sm shadow transition">
                        🗑️ Hapus Avatar
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ✏️ Form Edit Profil --}}
    <div class="bg-white dark:bg-[#10193a] border border-gray-200 dark:border-gray-700 shadow-md rounded-3xl p-8 space-y-5 transition-all duration-500 hover:shadow-blue-500/10">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
            Edit Informasi Profil
        </h3>

        <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-[#0B132B] dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-[#0B132B] dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Warna Avatar</label>
                <input type="color" name="avatar_color" id="avatarColor" value="{{ $user->avatar_color ?? '#2563EB' }}"
                       class="mt-1 w-16 h-10 cursor-pointer rounded-lg border border-gray-300 dark:border-gray-600">
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 
                               text-white rounded-lg shadow-md transition">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 🔔 Toast Container --}}
<div id="toast-container" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3"></div>

{{-- 🌫 Modal Hapus Avatar --}}
<div id="modalConfirm" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-[9998] hidden">
    <div class="bg-white dark:bg-[#1B2541] rounded-2xl shadow-2xl p-6 w-96 text-center transform scale-95 opacity-0 transition-all duration-300">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">⚠️ Hapus Avatar?</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
            Apakah kamu yakin ingin menghapus avatar ini?<br>
            <span class="text-red-500 font-medium">Tindakan ini tidak dapat dibatalkan!</span>
        </p>
        <div class="flex justify-center gap-3">
            <button id="cancelDelete" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-md text-sm">Batal</button>
            <button id="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- ⚙️ Script --}}
<script>
/* ✅ Live Preview Avatar */
const avatarInput = document.getElementById('avatarInput');
const avatarPreview = document.getElementById('avatarPreview');
const avatarImage = document.getElementById('avatarImage');
const avatarInitials = document.getElementById('avatarInitials');

avatarInput.addEventListener('change', e => {
  const [file] = e.target.files;
  if (file) {
    const reader = new FileReader();
    reader.onload = ev => {
      // kalau sudah ada img, ubah src; kalau belum, buat baru
      if (avatarImage) {
        avatarImage.src = ev.target.result;
      } else {
        const img = document.createElement('img');
        img.src = ev.target.result;
        img.className = 'w-full h-full object-cover';
        avatarPreview.innerHTML = '';
        avatarPreview.appendChild(img);
      }
    };
    reader.readAsDataURL(file);
  }
});

/* ✅ Toast Notification */
function showToast(type, message) {
  const container = document.getElementById('toast-container');
  const toast = document.createElement('div');
  const colors = { success: 'bg-green-600/90', error: 'bg-red-600/90', info: 'bg-blue-600/90' };
  const icons = { success: '✅', error: '❌', info: 'ℹ️' };
  toast.className = `${colors[type] || 'bg-gray-800/90'} backdrop-blur-md text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 opacity-0 translate-x-6 transition-all duration-500`;
  toast.innerHTML = `<span class="text-xl">${icons[type]}</span><div>${message}</div>`;
  container.appendChild(toast);
  setTimeout(() => toast.classList.remove('opacity-0', 'translate-x-6'), 50);
  setTimeout(() => { toast.classList.add('opacity-0', 'translate-x-6'); setTimeout(() => toast.remove(), 500); }, 4000);
}

/* ✅ Modal Hapus Avatar */
const modal = document.getElementById('modalConfirm');
const btnDelete = document.getElementById('hapusAvatarBtn');
const btnCancel = document.getElementById('cancelDelete');
const btnConfirm = document.getElementById('confirmDelete');

btnDelete?.addEventListener('click', () => {
  modal.classList.remove('hidden');
  setTimeout(() => modal.querySelector('div').classList.replace('opacity-0', 'opacity-100'), 50);
});

btnCancel?.addEventListener('click', () => modal.classList.add('hidden'));

btnConfirm?.addEventListener('click', async () => {
  try {
    const response = await fetch("{{ route('profil.avatar.delete') }}", {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    });
    modal.classList.add('hidden');
    if (response.ok) {
      showToast('success', 'Avatar berhasil dihapus!');
      setTimeout(() => window.location.reload(), 1500);
    } else {
      showToast('error', 'Gagal menghapus avatar.');
    }
  } catch {
    showToast('error', 'Terjadi kesalahan koneksi.');
  }
});

/* 🎨 Live Update Warna Avatar */
document.getElementById('avatarColor')?.addEventListener('input', e => {
  document.getElementById('avatarPreview').style.backgroundColor = e.target.value;
});
</script>
@endsection
