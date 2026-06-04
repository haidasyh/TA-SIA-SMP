@extends('layouts.app')

@section('title', 'Input Nilai - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Input Nilai</h1>
                    <p class="text-muted">Masukkan dan edit nilai siswa</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('guru.store-nilai') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Jadwal</label>
                                    <select name="jadwal_id" class="form-select" required id="jadwalSelect">
                                        <option value="">Pilih Jadwal</option>
                                        @foreach($jadwals as $jadwal)
                                            <option value="{{ $jadwal->id }}" data-kelas-id="{{ $jadwal->kelas_id }}" data-jadwal-id="{{ $jadwal->id }}">
                                                {{ $jadwal->hari }} - {{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->mataPelajaran->nama_mapel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Siswa</label>
                                    <select name="siswa_id" class="form-select" required id="siswaSelect">
                                        <option value="">Pilih Siswa</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="kategori_id" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tugas (Opsional)</label>
                                    <select name="tugas_id" class="form-select" id="tugasSelect">
                                        <option value="">Pilih Tugas</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Skor Nilai</label>
                                    <input type="number" name="skor_nilai" class="form-control" min="0" max="100" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const jadwalSelect = document.getElementById('jadwalSelect');
    const siswaSelect = document.getElementById('siswaSelect');
    const tugasSelect = document.getElementById('tugasSelect');
    const siswas = @json($siswas ?? []);
    const tugases = @json($tugases ?? []);

    jadwalSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const kelasId = selectedOption.dataset.kelasId;
        const jadwalId = selectedOption.dataset.jadwalId;
        
        siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
        tugasSelect.innerHTML = '<option value="">Pilih Tugas</option>';
        
        if (kelasId) {
            const filteredSiswas = siswas.filter(s => s.kelas_id == kelasId);
            filteredSiswas.forEach(siswa => {
                const option = document.createElement('option');
                option.value = siswa.id;
                option.textContent = siswa.nama;
                siswaSelect.appendChild(option);
            });
        }
        
        if (jadwalId) {
            const filteredTugases = tugases.filter(t => t.jadwal_id == jadwalId);
            filteredTugases.forEach(tugas => {
                const option = document.createElement('option');
                option.value = tugas.id;
                option.textContent = tugas.judul_tugas;
                tugasSelect.appendChild(option);
            });
        }
    });
</script>
@endpush
