<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Pengguna Aplikasi') }}
            </h2>
            <a href="{{ route('admin.provinsi.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Pending</h4>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $pending_count }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">Menunggu validasi</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Aktif</h4>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $active_count }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">Sudah tervalidasi</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Total</h4>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $pending_count + $active_count }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zM5 20a4 4 0 01-1.12-7.878m16.326-2.158A4 4 0 0019.988 9m-5.141-7.12A3.988 3.988 0 0116 3c-1.657 0-3.172.671-4.257 1.757m4.257 15.243h.008v.008h-.008v-.008z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">Semua pengguna</p>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.provinsi.users.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pengguna</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Role</option>
                                    <option value="guru" {{ request('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="admin_provinsi" {{ request('role') === 'admin_provinsi' ? 'selected' : '' }}>Admin Provinsi</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-sm">
                                    🔍 Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Users Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuota Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $user->sekolah?->nama_sekolah ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if($user->kelompok_kelas_id)
                                            {{ $user->kelompokKelas?->nama_kelompok ?? '-' }}
                                        @elseif($user->nama_kelompok_kelas_baru)
                                            <span class="italic text-xs">(Baru)</span> {{ $user->nama_kelompok_kelas_baru }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($user->role === 'guru')
                                            @if($user->status === 'active' && $user->guru)
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-gray-900 font-medium">{{ $user->guru->student_quota ?? 0 }}</span>
                                                    <button type="button" onclick="openEditQuotaModal({{ $user->id }}, {{ $user->guru->id }}, {{ $user->guru->student_quota ?? 0 }})" class="text-blue-600 hover:text-blue-900">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @elseif($user->status === 'pending')
                                                <span class="text-xs text-gray-500 italic">Akan diisi saat validasi</span>
                                            @else
                                                -
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            @if($user->status == 'pending')
                                                @if($user->role === 'guru')
                                                    <button type="button" onclick="openValidateModal({{ $user->id }})" class="text-green-600 hover:text-green-900 font-semibold text-xs">
                                                        ✓ Validasi
                                                    </button>
                                                @else
                                                    <form action="{{ route('admin.provinsi.users.validate', $user) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900 font-semibold text-xs">
                                                            ✓ Validasi
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <form action="{{ route('admin.provinsi.users.deactivate', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900 font-semibold text-xs">
                                                        ⊝ Nonaktif
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.provinsi.users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-xs" onclick="return confirm('Hapus pengguna ini secara permanen?')">
                                                    ✕ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada pengguna yang ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Validasi Guru dengan Kuota Siswa -->
    <div id="validateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Validasi Guru & Atur Kuota Siswa</h3>
            
            <form id="validateForm" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Siswa</label>
                    <input type="number" name="student_quota" id="studentQuota" min="1" max="1000" value="30" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Jumlah maksimal siswa yang bisa didaftarkan oleh guru ini</p>
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeValidateModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition font-medium">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                        Validasi & Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kuota Siswa -->
    <div id="editQuotaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Kuota Siswa</h3>
            
            <form id="editQuotaForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Siswa Baru</label>
                    <input type="number" name="student_quota" id="editQuotaValue" min="1" max="1000" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Jumlah maksimal siswa yang bisa didaftarkan</p>
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeEditQuotaModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition font-medium">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Simpan Kuota
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openValidateModal(userId) {
            const form = document.getElementById('validateForm');
            form.action = `/admin/provinsi/users/${userId}/validate`;
            document.getElementById('validateModal').classList.remove('hidden');
            document.getElementById('studentQuota').focus();
        }

        function closeValidateModal() {
            document.getElementById('validateModal').classList.add('hidden');
        }

        function openEditQuotaModal(userId, guruId, currentQuota) {
            const form = document.getElementById('editQuotaForm');
            form.action = `/admin/provinsi/guru/${guruId}/quota`;
            document.getElementById('editQuotaValue').value = currentQuota;
            document.getElementById('editQuotaModal').classList.remove('hidden');
            document.getElementById('editQuotaValue').select();
        }

        function closeEditQuotaModal() {
            document.getElementById('editQuotaModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.getElementById('validateModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeValidateModal();
        });

        document.getElementById('editQuotaModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeEditQuotaModal();
        });
    </script>
</x-app-layout>
