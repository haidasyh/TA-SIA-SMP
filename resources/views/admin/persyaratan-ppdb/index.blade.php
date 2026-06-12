@extends('layouts.app')

@section('title', 'Kelola Persyaratan PPDB - Admin')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Persyaratan Pendaftaran</h1>
                    <p class="text-muted">Atur kriteria persyaratan umum, khusus, dan alur pendaftaran siswa</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.persyaratan-ppdb.update') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label mb-0 fw-bold">Persyaratan Umum</label>
                                        <button type="button" class="btn btn-xs btn-outline-primary py-1 px-2" onclick="addRequirementRow('umum')">
                                            <i class="bi bi-plus-lg"></i> Poin
                                        </button>
                                    </div>
                                    <div id="umum-list-container" class="d-flex flex-column gap-2">
                                        @php $umumPoints = explode("\n", $persyaratan->umum ?? ''); @endphp
                                        @forelse($umumPoints as $point)
                                            @if(trim($point))
                                                <div class="input-group input-group-sm requirement-row">
                                                    <span class="input-group-text"><i class="bi bi-dot"></i></span>
                                                    <input type="text" name="umum[]" class="form-control" value="{{ $point }}" required>
                                                    <button type="button" class="btn btn-outline-danger" onclick="removeRequirementRow(this, 'umum')"><i class="bi bi-trash"></i></button>
                                                </div>
                                            @endif
                                        @empty
                                            <div class="text-muted small py-2 px-1 text-center border rounded bg-light" id="umum-empty-msg">Belum ada poin.</div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label mb-0 fw-bold">Persyaratan Khusus</label>
                                        <button type="button" class="btn btn-xs btn-outline-primary py-1 px-2" onclick="addRequirementRow('khusus')">
                                            <i class="bi bi-plus-lg"></i> Poin
                                        </button>
                                    </div>
                                    <div id="khusus-list-container" class="d-flex flex-column gap-2">
                                        @php $khususPoints = explode("\n", $persyaratan->khusus ?? ''); @endphp
                                        @forelse($khususPoints as $point)
                                            @if(trim($point))
                                                <div class="input-group input-group-sm requirement-row">
                                                    <span class="input-group-text"><i class="bi bi-dot"></i></span>
                                                    <input type="text" name="khusus[]" class="form-control" value="{{ $point }}" required>
                                                    <button type="button" class="btn btn-outline-danger" onclick="removeRequirementRow(this, 'khusus')"><i class="bi bi-trash"></i></button>
                                                </div>
                                            @endif
                                        @empty
                                            <div class="text-muted small py-2 px-1 text-center border rounded bg-light" id="khusus-empty-msg">Belum ada poin.</div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label mb-0 fw-bold">Alur Pendaftaran</label>
                                        <button type="button" class="btn btn-xs btn-outline-primary py-1 px-2" onclick="addRequirementRow('alur')">
                                            <i class="bi bi-plus-lg"></i> Poin
                                        </button>
                                    </div>
                                    <div id="alur-list-container" class="d-flex flex-column gap-2">
                                        @php $alurPoints = explode("\n", $persyaratan->alur ?? ''); $stepIdx = 1; @endphp
                                        @forelse($alurPoints as $point)
                                            @if(trim($point))
                                                <div class="input-group input-group-sm requirement-row">
                                                    <span class="input-group-text fw-bold step-number">{{ $stepIdx++ }}.</span>
                                                    <input type="text" name="alur[]" class="form-control" value="{{ $point }}" required>
                                                    <button type="button" class="btn btn-outline-danger" onclick="removeRequirementRow(this, 'alur')"><i class="bi bi-trash"></i></button>
                                                </div>
                                            @endif
                                        @empty
                                            <div class="text-muted small py-2 px-1 text-center border rounded bg-light" id="alur-empty-msg">Belum ada poin.</div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addRequirementRow(type) {
            const container = document.getElementById(`${type}-list-container`);
            const emptyMsg = document.getElementById(`${type}-empty-msg`);
            if (emptyMsg) emptyMsg.remove();

            const isAlur = type === 'alur';
            const currentCount = container.querySelectorAll('.requirement-row').length + 1;
            const indicator = isAlur ? `<span class="input-group-text fw-bold step-number">${currentCount}.</span>` : `<span class="input-group-text"><i class="bi bi-dot"></i></span>`;

            const row = document.createElement('div');
            row.className = 'input-group input-group-sm requirement-row';
            row.innerHTML = `${indicator}<input type="text" name="${type}[]" class="form-control" placeholder="Poin baru..." required><button type="button" class="btn btn-outline-danger" onclick="removeRequirementRow(this, '${type}')"><i class="bi bi-trash"></i></button>`;
            container.appendChild(row);
            if (isAlur) updateStepNumbers();
        }

        function removeRequirementRow(button, type) {
            const container = document.getElementById(`${type}-list-container`);
            button.closest('.requirement-row').remove();
            if (container.querySelectorAll('.requirement-row').length === 0) {
                container.innerHTML = `<div class="text-muted small py-2 px-1 text-center border rounded bg-light" id="${type}-empty-msg">Belum ada poin.</div>`;
            }
            if (type === 'alur') updateStepNumbers();
        }

        function updateStepNumbers() {
            const container = document.getElementById('alur-list-container');
            container.querySelectorAll('.step-number').forEach((el, index) => el.textContent = `${index + 1}.`);
        }
    </script>
@endsection