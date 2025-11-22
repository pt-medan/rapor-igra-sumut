@extends('layouts.app')

@section('title', 'Manajemen Kuota Siswa Guru')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Kuota Siswa Guru</h1>
            <p class="mt-2 text-gray-600">Atur kuota siswa untuk setiap guru dalam sistem</p>
        </div>

        <!-- Search dan Filter -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6">
                <form action="{{ route('admin.provinsi.guru.quota.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Guru atau Email</label>
                            <input type="text" name="search" id="search" placeholder="Nama guru atau email..." 
                                value="{{ request('search') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Sekolah Filter -->
                        <div>
                            <label for="sekolah_id" class="block text-sm font-medium text-gray-700 mb-2">Sekolah</label>
                            <select name="sekolah_id" id="sekolah_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Sekolah</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" {{ request('sekolah_id') == $school->id ? 'selected' : '' }}>
                                        {{ $school->nama_sekolah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                </svg>
                <span class="text-green-800">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nama Guru</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Sekolah</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Kuota</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Terpakai</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Sisa</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($gurus as $guru)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="font-medium">{{ $guru->nama_guru }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $guru->user->email }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $guru->sekolah->nama_sekolah }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $guru->student_quota }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    {{ $guru->student_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $remaining = max(0, $guru->student_quota - $guru->student_count);
                                    $percentage = $guru->student_quota > 0 ? ($guru->student_count / $guru->student_quota) * 100 : 0;
                                @endphp
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-sm font-medium text-gray-900">{{ $remaining }}</span>
                                    <div class="w-24 bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="button" onclick="openQuotaModal({{ $guru->id }}, '{{ $guru->nama_guru }}', {{ $guru->student_quota }})"
                                    class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition">
                                    Edit Kuota
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                <p class="mt-4">Tidak ada data guru ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $gurus->links() }}
        </div>
    </div>
</div>

<!-- Modal Edit Kuota -->
<div id="quotaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Edit Kuota Siswa</h2>

        <form id="quotaForm" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Guru</label>
                <input type="text" id="guruName" disabled class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
            </div>

            <div>
                <label for="studentQuota" class="block text-sm font-medium text-gray-700 mb-2">Kuota Siswa</label>
                <input type="number" id="studentQuota" name="student_quota" min="0" max="1000" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-500">Masukkan jumlah siswa maksimal yang dapat ditambahkan guru ini</p>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeQuotaModal()" 
                    class="flex-1 px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition font-medium">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-1 px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition font-medium">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openQuotaModal(guruId, guruName, currentQuota) {
    document.getElementById('guruName').value = guruName;
    document.getElementById('studentQuota').value = currentQuota;
    document.getElementById('quotaForm').action = `/admin/provinsi/guru/${guruId}/quota`;
    document.getElementById('quotaModal').classList.remove('hidden');
}

function closeQuotaModal() {
    document.getElementById('quotaModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('quotaModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuotaModal();
    }
});
</script>
@endsection
