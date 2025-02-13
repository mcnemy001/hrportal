@extends('layouts.app')

@section('title', 'Daftar Kontrak')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center mt-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-200">Daftar Kontrak</h1>
            <p class="text-gray-400 mt-1">Kelola data kontrak pegawai</p>
        </div>
        <a href="{{ route('admin.kontrak.create') }}"
            class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Tambah Kontrak
        </a>
    </div>

    <!-- Search Box -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="relative flex items-center">
            <input type="text" 
                   id="searchNama" 
                   placeholder="Cari berdasarkan nama pegawai..." 
                   class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                   onkeyup="searchKontrak()">
            <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
        <div class="relative flex items-center">
            <input type="text" 
                   id="searchNIP" 
                   placeholder="Cari berdasarkan NIP..." 
                   class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                   onkeyup="searchKontrak()">
            <i class="fas fa-id-card absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
        <div class="relative flex items-center">
            <input type="text" 
                   id="searchNomor" 
                   placeholder="Cari berdasarkan nomor kontrak..." 
                   class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                   onkeyup="searchKontrak()">
            <i class="fas fa-file-contract absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>

    @if (session('success'))
    <div class="bg-green-500 bg-opacity-10 text-green-500 p-4 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-500 bg-opacity-10 text-red-500 p-4 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    <!-- Tabel Kontrak -->
    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-auto divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nomor Kontrak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Gaji Pokok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Mulai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Berakhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse ($kontrak as $k)
                    <tr class="hover:bg-gray-700 transition-colors cursor-pointer kontrak-row"
                        data-nama-pegawai="{{ $k->pegawai->nama_lengkap }}"
                        data-nip="{{ $k->pegawai->nip }}"
                        data-nomor-kontrak="{{ $k->nomor_kontrak }}"
                        data-tanggal-mulai="{{ $k->tanggal_mulai->format('d/m/Y') }}"
                        data-tanggal-berakhir="{{ $k->tanggal_berakhir->format('d/m/Y') }}"
                        data-gaji-pokok="Rp {{ number_format($k->gaji_pokok, 0, ',', '.') }}"
                        data-status="{{ $k->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}"
                        data-keterangan="{{ $k->keterangan ?? '-' }}">
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-200">
                                {{ $k->pegawai->nama_lengkap }}
                                <div class="text-xs text-gray-400">{{ $k->pegawai->nip }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-200">{{ $k->nomor_kontrak }}</td>
                        <td class="px-6 py-4 text-sm text-gray-200">Rp {{ number_format($k->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-200">{{ $k->tanggal_mulai->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-200">{{ $k->tanggal_berakhir->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-sm rounded-full 
                                {{ $k->status === 'active' ? 'bg-green-500 bg-opacity-20 text-green-500' : 'bg-red-500 bg-opacity-20 text-red-500' }}">
                                {{ $k->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.kontrak.edit', $k->id) }}" 
                                   class="text-primary hover:text-primary/80"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.kontrak.destroy', $k->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontrak ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-400"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                            Belum ada data kontrak
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<!-- Detail Modal -->
<div id="detailModal" tabindex="-1" aria-hidden="true" 
     class="fixed inset-0 z-50 hidden w-full p-4 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="relative w-full max-w-2xl bg-gray-800 rounded-lg shadow-lg">
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-gray-200">Detail Kontrak</h3>
            <button type="button" 
                    class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" 
                    onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-400 text-sm">Nama Pegawai</label>
                    <p id="modal-nama-pegawai" class="text-gray-200"></p>
                </div>
                <div>
                    <label class="text-gray-400 text-sm">NIP</label>
                    <p id="modal-nip" class="text-gray-200"></p>
                </div>
                <div>
                    <label class="text-gray-400 text-sm">Nomor Kontrak</label>
                    <p id="modal-nomor-kontrak" class="text-gray-200"></p>
                </div>
                <div>
                    <label class="text-gray-400 text-sm">Tanggal Mulai</label>
                    <p id="modal-tanggal-mulai" class="text-gray-200"></p>
                </div>
                <div>
                    <label class="text-gray-400 text-sm">Tanggal Berakhir</label>
                    <p id="modal-tanggal-berakhir" class="text-gray-200"></p>
                </div>
                <div>
                    <label class="text-gray-400 text-sm">Gaji Pokok</label>
                    <p id="modal-gaji-pokok" class="text-gray-200"></p>
                </div>
                <div>
                    <label class="text-gray-400 text-sm">Status</label>
                    <p id="modal-status" class="text-gray-200"></p>
                </div>
                <div class="col-span-2">
                    <label class="text-gray-400 text-sm">Keterangan</label>
                    <p id="modal-keterangan" class="text-gray-200"></p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
        function searchKontrak() {
        const searchNama = document.getElementById('searchNama').value.toLowerCase();
        const searchNIP = document.getElementById('searchNIP').value.toLowerCase();
        const searchNomor = document.getElementById('searchNomor').value.toLowerCase();
        const rows = document.querySelectorAll('.kontrak-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const namaPegawai = row.getAttribute('data-nama-pegawai').toLowerCase();
            const nip = row.getAttribute('data-nip').toLowerCase();
            const nomorKontrak = row.getAttribute('data-nomor-kontrak').toLowerCase();

            // Mencocokkan berdasarkan semua kriteria pencarian
            const matchNama = namaPegawai.includes(searchNama);
            const matchNIP = nip.includes(searchNIP);
            const matchNomor = nomorKontrak.includes(searchNomor);

            // Tampilkan baris jika memenuhi semua kriteria pencarian yang diisi
            if (matchNama && matchNIP && matchNomor) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update pesan "Tidak ada hasil" jika tidak ada yang cocok
        const noDataRow = document.querySelector('tbody tr:last-child');
        if (visibleCount === 0) {
            if (rows.length > 0) {
                // Jika ada data tapi tidak ada yang cocok dengan pencarian
                if (!document.getElementById('noResultsRow')) {
                    const tbody = document.querySelector('tbody');
                    const newRow = document.createElement('tr');
                    newRow.id = 'noResultsRow';
                    newRow.innerHTML = `
                        <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                            Tidak ada hasil pencarian
                        </td>
                    `;
                    tbody.appendChild(newRow);
                }
                document.getElementById('noResultsRow').style.display = '';
            }
        } else {
            // Sembunyikan pesan "Tidak ada hasil" jika ada yang cocok
            const noResultsRow = document.getElementById('noResultsRow');
            if (noResultsRow) {
                noResultsRow.style.display = 'none';
            }
        }
    }
    
    function openModal(row) {
        const modal = document.getElementById('detailModal');
        
        // Populate modal with data from row's data attributes
        document.getElementById('modal-nama-pegawai').textContent = row.dataset.namaPegawai;
        document.getElementById('modal-nip').textContent = row.dataset.nip;
        document.getElementById('modal-nomor-kontrak').textContent = row.dataset.nomorKontrak;
        document.getElementById('modal-tanggal-mulai').textContent = row.dataset.tanggalMulai;
        document.getElementById('modal-tanggal-berakhir').textContent = row.dataset.tanggalBerakhir;
        document.getElementById('modal-gaji-pokok').textContent = row.dataset.gajiPokok;
        document.getElementById('modal-status').textContent = row.dataset.status;
        document.getElementById('modal-keterangan').textContent = row.dataset.keterangan;

        // Show modal with fade effect
        modal.classList.remove('hidden');
        modal.classList.add('animate-fade-in');
    }

    function closeModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        modal.classList.remove('animate-fade-in');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.kontrak-row');
        
        rows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Prevent modal from opening if clicking action buttons
                if (e.target.closest('.text-primary') || e.target.closest('.text-red-500')) {
                    return;
                }
                
                openModal(row);
            });
        });

        // Close modal when clicking outside
        const modal = document.getElementById('detailModal');
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    });
</script>
@endpush