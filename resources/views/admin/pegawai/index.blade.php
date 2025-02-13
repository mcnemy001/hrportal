@extends('layouts.app')

@section('title', 'Manajemen Pegawai')
@section('header', 'Manajemen Pegawai')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center mt-6">
        <div>
            <h1 class="text-2xl font-semibold">Daftar Pegawai</h1>
            <p class="text-gray-400 mt-1">Kelola data pegawai perusahaan</p>
        </div>
        <a href="{{ route('admin.pegawai.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Tambah Pegawai
        </a>
    </div>

    <!-- Search Boxes -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="relative flex items-center">
            <input type="text" 
                   id="searchNama" 
                   placeholder="Cari berdasarkan nama..." 
                   class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                   onkeyup="searchPegawai()">
            <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
        <div class="relative flex items-center">
            <input type="text" 
                   id="searchNIP" 
                   placeholder="Cari berdasarkan NIP..." 
                   class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                   onkeyup="searchPegawai()">
            <i class="fas fa-id-card absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
        <div class="relative flex items-center">
            <input type="text" 
                   id="searchEmail" 
                   placeholder="Cari berdasarkan email..." 
                   class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                   onkeyup="searchPegawai()">
            <i class="fas fa-envelope absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-500 bg-opacity-10 text-green-500 p-4 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Table -->
    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr class="text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">NIP</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700" id="employeeTableBody">
                    @forelse($pegawai as $p)
                    <tr class="hover:bg-gray-700 cursor-pointer transition-colors employee-row"
                        data-nama="{{ strtolower($p->nama_lengkap) }}"
                        data-nip="{{ strtolower($p->nip) }}"
                        data-email="{{ strtolower($p->email ?? '') }}"
                        onclick="showDetail({{ json_encode([
                            'nip' => $p->nip,
                            'nama_lengkap' => $p->nama_lengkap,
                            'tempat_lahir' => $p->tempat_lahir,
                            'tanggal_lahir' => $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '-',
                            'jenis_kelamin' => $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                            'alamat' => $p->alamat,
                            'nomor_telepon' => $p->nomor_telepon,
                            'email' => $p->email,
                            'status_pegawai' => ucfirst($p->status_pegawai)
                        ]) }})">
                        <td class="px-6 py-4 text-gray-200">{{ $p->nip }}</td>
                        <td class="px-6 py-4 text-gray-200">{{ $p->nama_lengkap }}</td>
                        <td class="px-6 py-4 text-gray-200">{{ $p->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-200">{{ $p->nomor_telepon ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-sm rounded-full 
                                {{ $p->status_pegawai === 'aktif' ? 'bg-green-500 bg-opacity-20 text-green-500' : 'bg-red-500 bg-opacity-20 text-red-500' }}">
                                {{ ucfirst($p->status_pegawai) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3" onclick="event.stopPropagation()">
                                <a href="{{ route('admin.pegawai.edit', $p->id) }}" 
                                   class="text-primary hover:text-primary/80"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete({{ $p->id }}, '{{ $p->nama_lengkap }}')"
                                        class="text-red-500 hover:text-red-400"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $p->id }}" 
                                      action="{{ route('admin.pegawai.destroy', $p->id) }}" 
                                      method="POST" 
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="noDataRow">
                        <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                            Belum ada data pegawai
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-dark-50 rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold mb-4">Konfirmasi Hapus</h3>
        <p class="text-gray-300 mb-6">Apakah Anda yakin ingin menghapus data pegawai <span id="employeeName" class="font-semibold"></span>?</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" 
                    class="px-4 py-2 bg-dark-200 text-gray-300 rounded-lg hover:bg-dark-300">
                Batal
            </button>
            <button onclick="deleteEmployee()" 
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-dark-50 rounded-lg p-6 max-w-2xl w-full mx-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold">Detail Pegawai</h3>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-primary mb-4">Informasi Pribadi</h4>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm text-gray-400">NIP</label>
                        <p id="detail-nip" class="text-gray-100"></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Nama Lengkap</label>
                        <p id="detail-nama_lengkap" class="text-gray-100"></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Tempat, Tanggal Lahir</label>
                        <p id="detail-ttl" class="text-gray-100"></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Jenis Kelamin</label>
                        <p id="detail-jenis_kelamin" class="text-gray-100"></p>
                    </div>
                </div>
            </div>
            
            <div>
                <h4 class="font-medium text-primary mb-4">Informasi Kontak</h4>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm text-gray-400">Alamat</label>
                        <p id="detail-alamat" class="text-gray-100"></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">No. Telepon</label>
                        <p id="detail-nomor_telepon" class="text-gray-100"></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Email</label>
                        <p id="detail-email" class="text-gray-100"></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Status</label>
                        <p id="detail-status_pegawai" class="text-gray-100"></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end mt-6">
            <button onclick="closeDetailModal()" 
                    class="px-4 py-2 bg-dark-200 text-gray-300 rounded-lg hover:bg-dark-300">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function searchPegawai() {
        const searchNama = document.getElementById('searchNama').value.toLowerCase();
        const searchNIP = document.getElementById('searchNIP').value.toLowerCase();
        const searchEmail = document.getElementById('searchEmail').value.toLowerCase();
        const rows = document.getElementsByClassName('employee-row');
        let visibleCount = 0;

        for (let row of rows) {
            const nama = row.getAttribute('data-nama');
            const nip = row.getAttribute('data-nip');
            const email = row.getAttribute('data-email');

            // Mencocokkan berdasarkan semua kriteria pencarian
            const matchNama = nama.includes(searchNama);
            const matchNIP = nip.includes(searchNIP);
            const matchEmail = email.includes(searchEmail);

            // Tampilkan baris jika memenuhi semua kriteria pencarian yang diisi
            if (matchNama && matchNIP && matchEmail) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }

        // Show/hide no results message
        const noDataRow = document.getElementById('noDataRow');
        if (visibleCount === 0) {
            if (!noDataRow) {
                const tbody = document.getElementById('employeeTableBody');
                const newNoDataRow = document.createElement('tr');
                newNoDataRow.id = 'noDataRow';
                newNoDataRow.innerHTML = `
                    <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                        Tidak ada hasil pencarian
                    </td>
                `;
                tbody.appendChild(newNoDataRow);
            } else {
                noDataRow.style.display = '';
                noDataRow.querySelector('td').textContent = 'Tidak ada hasil pencarian';
            }
        } else if (noDataRow) {
            noDataRow.style.display = 'none';
        }
    }
    
    // Existing functions remain the same
    let deleteId = null;
    
    function confirmDelete(id, name) {
        deleteId = id;
        document.getElementById('employeeName').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }
    
    function closeDeleteModal() {
        deleteId = null;
        document.getElementById('deleteModal').classList.remove('flex');
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    function deleteEmployee() {
        if (deleteId) {
            document.getElementById(`delete-form-${deleteId}`).submit();
        }
    }

    function showDetail(data) {
        document.getElementById('detail-nip').textContent = data.nip;
        document.getElementById('detail-nama_lengkap').textContent = data.nama_lengkap;
        document.getElementById('detail-ttl').textContent = `${data.tempat_lahir}, ${data.tanggal_lahir}`;
        document.getElementById('detail-jenis_kelamin').textContent = data.jenis_kelamin;
        document.getElementById('detail-alamat').textContent = data.alamat;
        document.getElementById('detail-nomor_telepon').textContent = data.nomor_telepon;
        document.getElementById('detail-email').textContent = data.email;
        document.getElementById('detail-status_pegawai').textContent = data.status_pegawai;
        
        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
    }
    
    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('flex');
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
