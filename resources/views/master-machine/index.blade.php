@extends('layouts.app')

@section('title', 'Master Data Mesin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
    <li class="breadcrumb-item active">Master Mesin</li>
@endsection

@section('content')
<div class="fade-in">
    <!-- Header + Button -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-0" style="color:var(--dark);">Master <span class="fw-normal text-muted" style="font-size:.95rem;">Master Machine</span></h5>
        </div>
        <button class="btn btn-entry-new" id="btnAddMachine">
            <i class="bi bi-plus-lg me-1"></i> Entry New Machine
        </button>
    </div>

    <!-- Entry Master Machine Card -->
    <div class="card-main">
        <div class="card-header-teal">
            <i class="bi bi-cpu me-2"></i>Entry Master Machine
        </div>
        <div class="card-body">
            <!-- Show entries + Search -->
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2" style="font-size:.85rem;">
                    <span>Show</span>
                    <select class="form-select form-select-sm" id="perPage" style="width:70px;">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entries</span>
                </div>
                <div class="input-group input-group-sm" style="width:220px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Search">
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-custom table-bordered mb-0" id="machineTable">
                    <thead>
                        <tr class="header-row">
                            <th style="width:50px;">#</th>
                            <th>ASSET NO</th>
                            <th>MFG NO</th>
                            <th>INVENT NO</th>
                            <th>NUMBER</th>
                            <th>NAME</th>
                            <th>SPEC</th>
                            <th>PLANT</th>
                            <th>STATUS</th>
                            <th style="width:100px;">ACTION</th>
                        </tr>
                        <!-- Filter Row -->
                        <tr class="filter-row">
                            <td></td>
                            <td><input type="text" class="form-control form-control-sm col-filter" data-col="asset_no" placeholder=""></td>
                            <td><input type="text" class="form-control form-control-sm col-filter" data-col="mfg_number" placeholder=""></td>
                            <td><input type="text" class="form-control form-control-sm col-filter" data-col="invent_number" placeholder=""></td>
                            <td><input type="text" class="form-control form-control-sm col-filter" data-col="machine_number" placeholder=""></td>
                            <td><input type="text" class="form-control form-control-sm col-filter" data-col="machine_name" placeholder=""></td>
                            <td><input type="text" class="form-control form-control-sm col-filter" data-col="machine_spec" placeholder=""></td>
                            <td><input type="text" class="form-control form-control-sm col-filter" data-col="plant" placeholder=""></td>
                            <td>
                                <select class="form-select form-select-sm col-filter" data-col="status">
                                    <option value=""></option>
                                    <option value="ACTIVE">Active</option>
                                    <option value="NOT ACTIVE">Not Active</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-clear-filter" id="btnClearFilter">Clear</button>
                            </td>
                        </tr>
                    </thead>
                    <tbody id="machineTableBody">
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                <div class="spinner-border spinner-border-sm text-primary me-2"></div> Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div class="text-muted" style="font-size:.82rem;" id="paginationInfo">-</div>
                <nav>
                    <ul class="pagination pagination-sm pagination-custom mb-0" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     MODAL: Create / Edit Machine (Full Page Style)
     ═══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalForm" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="border:none; border-radius:var(--radius);">
            <div class="modal-header" style="background:#fff; border-bottom:1px solid #dee2e6; padding:20px 24px;">
                <h5 class="modal-title fw-bold" id="modalFormTitle" style="color:var(--dark);">
                    Add Master Machine
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formMachine" enctype="multipart/form-data">
                <div class="modal-body" style="padding:24px; background:#f8f9fa;">
                    <input type="hidden" id="machineId" name="machine_id">

                    <!-- Detail Form (Grid Layout mirip referensi) -->
                    <div class="form-grid-container mb-4">
                        <table class="table table-form mb-0">
                            <tbody>
                                <tr>
                                    <td class="label-cell">Asset No</td>
                                    <td><input type="text" class="form-control form-control-sm" name="asset_no" maxlength="15"></td>
                                    <td class="label-cell">Dsc. Asset</td>
                                    <td><input type="text" class="form-control form-control-sm" name="descript_asset" maxlength="30"></td>
                                    <td class="label-cell">Sub No</td>
                                    <td><input type="number" class="form-control form-control-sm" name="sub_no"></td>
                                    <td class="label-cell">Location</td>
                                    <td><input type="text" class="form-control form-control-sm" name="machine_loc" maxlength="10"></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Mnt No</td>
                                    <td><input type="text" class="form-control form-control-sm" name="invent_number" maxlength="25"></td>
                                    <td class="label-cell">Machine Name <span class="text-danger">*</span></td>
                                    <td colspan="3"><input type="text" class="form-control form-control-sm" name="machine_name" maxlength="25" required></td>
                                    <td class="label-cell">Plant</td>
                                    <td><input type="text" class="form-control form-control-sm" name="plant" maxlength="5"></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">No Machine</td>
                                    <td><input type="text" class="form-control form-control-sm" name="machine_number" maxlength="20"></td>
                                    <td class="label-cell">No MFG</td>
                                    <td><input type="text" class="form-control form-control-sm" name="mfg_number" maxlength="30"></td>
                                    <td class="label-cell">Spec</td>
                                    <td><input type="text" class="form-control form-control-sm" name="machine_spec" maxlength="20"></td>
                                    <td class="label-cell">Input Daya</td>
                                    <td><input type="text" class="form-control form-control-sm" name="machine_power" maxlength="20"></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Brand</td>
                                    <td><input type="text" class="form-control form-control-sm" name="machine_brand" maxlength="20"></td>
                                    <td class="label-cell">Model</td>
                                    <td><input type="text" class="form-control form-control-sm" name="machine_type" maxlength="20"></td>
                                    <td class="label-cell">Made From</td>
                                    <td><input type="text" class="form-control form-control-sm" name="machine_made" maxlength="20"></td>
                                    <td class="label-cell">Information</td>
                                    <td><input type="text" class="form-control form-control-sm" name="machine_info" maxlength="30"></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Purchase Date</td>
                                    <td><input type="date" class="form-control form-control-sm" name="install_date"></td>
                                    <td class="label-cell">Made Date</td>
                                    <td><input type="date" class="form-control form-control-sm" name="production_date"></td>
                                    <td colspan="2"></td>
                                    <td class="label-cell">Note</td>
                                    <td><input type="text" class="form-control form-control-sm" name="note"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Section: Select Image -->
                    <div class="card-header-teal mb-0" style="border-radius:var(--radius-sm) var(--radius-sm) 0 0;">
                        <i class="bi bi-images me-1"></i> Select Image<span class="text-warning">*</span>
                    </div>
                    <div class="image-slots-container">
                        <!-- Existing images (edit mode) will be rendered here by JS -->
                        <div class="row g-3 p-3" id="imageSlotsRow">
                            <div class="col-md-3 col-sm-6">
                                <div class="image-slot" data-slot="0" id="imageSlot0">
                                    <div class="image-slot-empty" onclick="triggerImageSelect(0)">
                                        <i class="bi bi-image"></i>
                                        <span>Select Image 1</span>
                                        <small class="text-muted">Max 1MB</small>
                                    </div>
                                    <div class="image-slot-preview" style="display:none;">
                                        <img src="" alt="">
                                        <button type="button" class="btn-remove-slot" onclick="removeSlotImage(0)" title="Hapus gambar">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="file" class="slot-file-input" data-slot="0" accept="image/*" style="display:none;">
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="image-slot" data-slot="1" id="imageSlot1">
                                    <div class="image-slot-empty" onclick="triggerImageSelect(1)">
                                        <i class="bi bi-image"></i>
                                        <span>Select Image 2</span>
                                        <small class="text-muted">Max 1MB</small>
                                    </div>
                                    <div class="image-slot-preview" style="display:none;">
                                        <img src="" alt="">
                                        <button type="button" class="btn-remove-slot" onclick="removeSlotImage(1)" title="Hapus gambar">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="file" class="slot-file-input" data-slot="1" accept="image/*" style="display:none;">
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="image-slot" data-slot="2" id="imageSlot2">
                                    <div class="image-slot-empty" onclick="triggerImageSelect(2)">
                                        <i class="bi bi-image"></i>
                                        <span>Select Image 3</span>
                                        <small class="text-muted">Max 1MB</small>
                                    </div>
                                    <div class="image-slot-preview" style="display:none;">
                                        <img src="" alt="">
                                        <button type="button" class="btn-remove-slot" onclick="removeSlotImage(2)" title="Hapus gambar">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="file" class="slot-file-input" data-slot="2" accept="image/*" style="display:none;">
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="image-slot" data-slot="3" id="imageSlot3">
                                    <div class="image-slot-empty" onclick="triggerImageSelect(3)">
                                        <i class="bi bi-image"></i>
                                        <span>Select Image 4</span>
                                        <small class="text-muted">Max 1MB</small>
                                    </div>
                                    <div class="image-slot-preview" style="display:none;">
                                        <img src="" alt="">
                                        <button type="button" class="btn-remove-slot" onclick="removeSlotImage(3)" title="Hapus gambar">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="file" class="slot-file-input" data-slot="3" accept="image/*" style="display:none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background:#fff; border-top:1px solid #dee2e6;">
                    <button type="button" class="btn btn-dark px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Close
                    </button>
                    <button type="submit" class="btn btn-primary px-4" id="btnSave">
                        <i class="bi bi-check-lg me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     MODAL: View Machine Detail (mirip referensi)
     ═══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalView" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="border:none; border-radius:var(--radius);">
            <div class="modal-header" style="background:#fff; border-bottom:1px solid #dee2e6; padding:20px 24px;">
                <h5 class="modal-title fw-bold" style="color:var(--dark);">View Master Machine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:24px; background:#f8f9fa;" id="viewContent">
                <!-- Filled by JS -->
            </div>
            <div class="modal-footer" style="background:#fff;">
                <button type="button" class="btn btn-dark px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     MODAL: Input Note (Status Change / Void)
     ═══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalNote" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:var(--radius); border:none; box-shadow:var(--shadow-lg);">
            <div class="modal-header" style="background:var(--gradient-primary); color:#fff; border-radius:var(--radius) var(--radius) 0 0;">
                <h6 class="modal-title" id="modalNoteTitle">
                    <i class="bi bi-pencil-square me-2"></i>Input Note
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formNote">
                <div class="modal-body">
                    <input type="hidden" id="noteMachineId">
                    <input type="hidden" id="noteAction">
                    <p class="text-muted mb-3" id="noteDescription" style="font-size:.9rem;">
                        Masukkan alasan perubahan status mesin ini.
                    </p>
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Alasan / Note <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="noteText" rows="3" required placeholder="Tuliskan alasan di sini..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveNote">
                        <i class="bi bi-check-lg me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     MODAL: Log History
     ═══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalLog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border:none; border-radius:var(--radius);">
            <div class="modal-header" style="background:var(--gradient-primary); color:#fff; border-radius:var(--radius) var(--radius) 0 0;">
                <h5 class="modal-title">
                    <i class="bi bi-clock-history me-2"></i>Riwayat Log
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-bordered mb-0">
                        <thead>
                            <tr class="header-row">
                                <th>#</th>
                                <th>Status Change</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody id="logTableBody">
                            <tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada log.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ── Entry New Machine Button ── */
    .btn-entry-new {
        background: #e63946;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        font-size: .85rem;
        transition: all .2s;
    }
    .btn-entry-new:hover {
        background: #c1121f;
        color: #fff;
        transform: translateY(-1px);
    }

    /* ── Teal Card Header ── */
    .card-header-teal {
        background: linear-gradient(135deg, #1a8a7d 0%, #2196a6 100%);
        color: #fff;
        padding: 10px 20px;
        font-weight: 600;
        font-size: .9rem;
    }

    /* ── Table Header (Blue) ── */
    .header-row th {
        background: linear-gradient(135deg, #1e3a6e 0%, #2c5aa0 100%) !important;
        color: #fff !important;
        font-size: .78rem;
        font-weight: 600;
        text-align: center;
        padding: 10px 12px !important;
        border: 1px solid rgba(255,255,255,.15) !important;
        white-space: nowrap;
    }

    /* ── Filter Row ── */
    .filter-row td {
        background: #e8f0fe;
        padding: 6px 8px !important;
        border: 1px solid #cfd8e8 !important;
    }
    .filter-row .form-control,
    .filter-row .form-select {
        font-size: .78rem;
        border: 1px solid #b3c5e0;
        border-radius: 4px;
    }

    .btn-clear-filter {
        background: #4361ee;
        color: #fff;
        font-size: .75rem;
        font-weight: 600;
        border: none;
        border-radius: 4px;
        padding: 4px 12px;
    }
    .btn-clear-filter:hover { background: #3451d1; color: #fff; }

    /* ── Status Badge (di tabel) ── */
    .badge-status-active {
        background: #28a745;
        color: #fff;
        font-weight: 600;
        padding: 5px 16px;
        border-radius: 4px;
        font-size: .78rem;
        display: inline-block;
    }
    .badge-status-inactive {
        background: #f0ad4e;
        color: #fff;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: .78rem;
        display: inline-block;
    }
    .badge-status-void {
        background: #6c757d;
        color: #fff;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: .78rem;
        display: inline-block;
    }

    /* ── Dropdown Action Button ── */
    .btn-action-dropdown {
        display: inline-flex;
        align-items: center;
        gap: 0;
        border: none;
        border-radius: 4px;
        overflow: hidden;
        font-size: .82rem;
    }
    .btn-action-dropdown .action-chevron {
        background: #3451d1;
        color: #fff;
        padding: 5px 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        border: none;
        transition: background .2s;
    }
    .btn-action-dropdown .action-chevron:hover {
        background: #2a42b0;
    }

    /* ── Dropdown Menu Items ── */
    .dropdown-menu-action {
        border-radius: 8px;
        box-shadow: 0 6px 20px rgba(0,0,0,.15);
        border: 1px solid rgba(0,0,0,.08);
        padding: 6px 0;
        min-width: 180px;
    }
    .dropdown-menu-action .dropdown-item {
        font-size: .85rem;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: background .15s;
    }
    .dropdown-menu-action .dropdown-item:hover {
        background: #f0f4ff;
    }
    .dropdown-menu-action .dropdown-item i {
        width: 18px;
        text-align: center;
        font-size: .9rem;
    }
    .dropdown-menu-action .dropdown-item.text-view i { color: #f0ad4e; }
    .dropdown-menu-action .dropdown-item.text-edit i { color: #0d6efd; }
    .dropdown-menu-action .dropdown-item.text-log i { color: #6f42c1; }
    .dropdown-menu-action .dropdown-item.text-void i { color: #dc3545; }
    .dropdown-menu-action .dropdown-item.text-status i { color: #e63946; }
    .dropdown-menu-action .dropdown-item.text-activate i { color: #28a745; }

    /* ── Form Table (mirip referensi Add) ── */
    .form-grid-container {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: var(--radius-sm);
        overflow: hidden;
    }
    .table-form {
        font-size: .85rem;
    }
    .table-form td {
        padding: 8px 10px;
        vertical-align: middle;
        border: 1px solid #e9ecef;
    }
    .table-form .label-cell {
        background: #f8f9fa;
        font-weight: 600;
        white-space: nowrap;
        color: var(--dark);
        width: 120px;
        font-size: .8rem;
    }
    .table-form .form-control {
        border: 1px solid #ced4da;
    }

    /* ── Image Slot Cards ── */
    .image-slots-container {
        background: #fff;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 var(--radius-sm) var(--radius-sm);
    }
    .image-slot {
        border: 2px dashed #ced4da;
        border-radius: var(--radius-sm);
        aspect-ratio: 4/3;
        position: relative;
        overflow: hidden;
        transition: border-color .2s;
    }
    .image-slot:hover {
        border-color: var(--primary);
    }
    .image-slot-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        cursor: pointer;
        color: #6c757d;
        gap: 4px;
    }
    .image-slot-empty i {
        font-size: 2rem;
        color: #adb5bd;
    }
    .image-slot-empty span {
        font-size: .82rem;
        font-weight: 600;
        color: #0d6efd;
        border: 1px solid #0d6efd;
        padding: 3px 14px;
        border-radius: 4px;
    }
    .image-slot-empty small {
        font-size: .72rem;
    }
    .image-slot-preview {
        width: 100%;
        height: 100%;
    }
    .image-slot-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .btn-remove-slot {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(230,57,70,.9);
        color: #fff;
        border: none;
        font-size: .75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform .2s;
    }
    .btn-remove-slot:hover { transform: scale(1.1); }

    /* ── View Detail Table ── */
    .view-detail-table td {
        padding: 6px 12px;
        font-size: .85rem;
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }
    .view-detail-table .label-cell {
        background: #f8f9fa;
        font-weight: 600;
        white-space: nowrap;
        width: 130px;
    }
    .view-detail-table .value-cell {
        background: #e9ecef;
        min-width: 120px;
    }

    /* ── View Image Grid ── */
    .view-image-grid {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        padding: 16px;
    }
    .view-image-grid img {
        max-width: 220px;
        max-height: 180px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 2px solid #dee2e6;
        cursor: pointer;
        transition: transform .2s;
    }
    .view-image-grid img:hover {
        transform: scale(1.05);
    }

    /* ── Override table for this page ── */
    .table-custom tbody td {
        font-size: .82rem;
        text-align: center;
    }

    @media (max-width: 767.98px) {
        .table-form td { display: block; width: 100% !important; }
        .table-form .label-cell { background: #e9ecef; }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentPage = 1;
    let slotFiles = [null, null, null, null];
    let existingSlotImages = [null, null, null, null]; // {id, src} objects

    // ── Load Data ──
    function loadMachines(page = 1) {
        currentPage = page;
        const params = {
            page,
            per_page: $('#perPage').val(),
            search: $('#searchInput').val()
        };

        // Column filters
        $('.col-filter').each(function() {
            const col = $(this).data('col');
            const val = $(this).val();
            if (val) params['filter_' + col] = val;
        });

        // Status filter from column
        const statusFilter = $('.col-filter[data-col="status"]').val();
        if (statusFilter) params.filter_status = statusFilter;

        $.ajax({
            url: "{{ route('master-machine.index') }}",
            data: params,
            success: function(res) {
                renderTable(res);
                renderPagination(res);
            },
            error: function() {
                $('#machineTableBody').html('<tr><td colspan="10" class="text-center py-4 text-danger">Gagal memuat data.</td></tr>');
            }
        });
    }

    // ── Render Table ──
    function renderTable(res) {
        if (!res.data || res.data.length === 0) {
            $('#machineTableBody').html(`<tr><td colspan="10" class="text-center py-5 text-muted">
                <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>Belum ada data mesin.
            </td></tr>`);
            $('#paginationInfo').text('-');
            return;
        }

        let html = '';
        res.data.forEach((m, i) => {
            const no = (res.current_page - 1) * res.per_page + i + 1;
            const isActive = m.status === 'ACTIVE';
            const isVoided = m.voided_by !== null;

            let statusBadge = isActive
                ? '<span class="badge-status-active">Active</span>'
                : '<span class="badge-status-inactive">Not Active</span>';
            if (isVoided) statusBadge = '<span class="badge-status-void">Void</span>';

            // Build dropdown items sesuai business logic
            let dropdownItems = `
                <li><a class="dropdown-item text-view" href="#" onclick="event.preventDefault(); viewMachine(${m.id})"><i class="bi bi-eye-fill"></i> View</a></li>`;

            if (isActive && !isVoided) {
                dropdownItems += `
                <li><a class="dropdown-item text-edit" href="#" onclick="event.preventDefault(); editMachine(${m.id})"><i class="bi bi-pencil-fill"></i> Edit</a></li>`;
            }

            dropdownItems += `
                <li><a class="dropdown-item text-log" href="#" onclick="event.preventDefault(); viewLog(${m.id})"><i class="bi bi-clock-history"></i> Log</a></li>`;

            if (!isVoided) {
                dropdownItems += `
                <li><a class="dropdown-item text-void" href="#" onclick="event.preventDefault(); openNote(${m.id}, 'void')"><i class="bi bi-trash3-fill"></i> Void</a></li>`;

                if (isActive) {
                    dropdownItems += `
                    <li><a class="dropdown-item text-status" href="#" onclick="event.preventDefault(); openNote(${m.id}, 'non-active')"><i class="bi bi-x-circle-fill"></i> Non Active</a></li>`;
                } else {
                    dropdownItems += `
                    <li><a class="dropdown-item text-activate" href="#" onclick="event.preventDefault(); openNote(${m.id}, 'active')"><i class="bi bi-check-circle-fill"></i> Active</a></li>`;
                }
            }

            html += `
                <tr>
                    <td class="text-muted">${no}</td>
                    <td>${m.asset_no || '-'}</td>
                    <td>${m.mfg_number || '-'}</td>
                    <td>${m.invent_number || '-'}</td>
                    <td>${m.machine_number || '-'}</td>
                    <td class="text-start fw-semibold">${m.machine_name || '-'}</td>
                    <td>${m.machine_spec || '-'}</td>
                    <td>${m.plant || '-'}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="dropdown">
                            <button class="action-chevron dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-action dropdown-menu-end">
                                ${dropdownItems}
                            </ul>
                        </div>
                    </td>
                </tr>
            `;
        });

        $('#machineTableBody').html(html);
        $('#paginationInfo').text(`Showing ${res.from} to ${res.to} of ${res.total} entries`);
    }

    // ── Render Pagination ──
    function renderPagination(res) {
        if (res.last_page <= 1) { $('#pagination').html(''); return; }

        let html = `<li class="page-item ${res.current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="event.preventDefault(); loadPage(${res.current_page - 1})">‹</a></li>`;

        for (let i = 1; i <= res.last_page; i++) {
            if (i <= 3 || i >= res.last_page - 2 || Math.abs(i - res.current_page) <= 1) {
                html += `<li class="page-item ${i === res.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="event.preventDefault(); loadPage(${i})">${i}</a></li>`;
            } else if (i === 4 && res.current_page > 5) {
                html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
            }
        }

        html += `<li class="page-item ${res.current_page === res.last_page ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="event.preventDefault(); loadPage(${res.current_page + 1})">›</a></li>`;
        $('#pagination').html(html);
    }

    window.loadPage = function(page) { loadMachines(page); };

    // ── Search, Filter, Per Page ──
    let searchTimer;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadMachines(1), 400);
    });
    $('.col-filter').on('input change', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadMachines(1), 400);
    });
    $('#perPage').on('change', function() { loadMachines(1); });
    $('#btnClearFilter').click(function() {
        $('.col-filter').val('');
        $('#searchInput').val('');
        loadMachines(1);
    });

    // ── Open Create Modal ──
    $('#btnAddMachine').click(function() {
        $('#machineId').val('');
        $('#formMachine')[0].reset();
        $('#modalFormTitle').text('Add Master Machine');
        resetImageSlots();
        new bootstrap.Modal('#modalForm').show();
    });

    // ═══════ IMAGE SLOT LOGIC ═══════

    function resetImageSlots() {
        slotFiles = [null, null, null, null];
        existingSlotImages = [null, null, null, null];
        for (let i = 0; i < 4; i++) {
            const slot = $(`#imageSlot${i}`);
            slot.find('.image-slot-empty').show();
            slot.find('.image-slot-preview').hide();
            $(`.slot-file-input[data-slot="${i}"]`).val('');
        }
    }

    window.triggerImageSelect = function(slotIndex) {
        $(`.slot-file-input[data-slot="${slotIndex}"]`).click();
    };

    // File input change handler
    $('.slot-file-input').on('change', function() {
        const slotIndex = $(this).data('slot');
        const file = this.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            showToast('File harus berupa gambar!', 'danger');
            return;
        }
        if (file.size > 1024 * 1024) {
            showToast('Ukuran file max 1MB!', 'danger');
            this.value = '';
            return;
        }

        slotFiles[slotIndex] = file;
        existingSlotImages[slotIndex] = null; // replaced

        const reader = new FileReader();
        reader.onload = function(e) {
            const slot = $(`#imageSlot${slotIndex}`);
            slot.find('.image-slot-preview img').attr('src', e.target.result);
            slot.find('.image-slot-empty').hide();
            slot.find('.image-slot-preview').show();
        };
        reader.readAsDataURL(file);
    });

    window.removeSlotImage = function(slotIndex) {
        // Cek kalau ini existing image (edit mode), perlu cek jumlah total
        const totalImages = countTotalImages();
        if (totalImages <= 1) {
            showToast('Tidak bisa menghapus gambar terakhir! Minimal 1 gambar harus ada.', 'danger');
            return;
        }

        // Kalau existing image, hapus via API
        if (existingSlotImages[slotIndex]) {
            const imageId = existingSlotImages[slotIndex].id;
            $.ajax({
                url: `/master-machine/image/${imageId}`,
                method: 'DELETE',
                success: function(res) {
                    if (res.success) {
                        clearSlot(slotIndex);
                        showToast(res.message);
                    } else {
                        showToast(res.message, 'danger');
                    }
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Gagal menghapus gambar.';
                    showToast(msg, 'danger');
                }
            });
        } else {
            clearSlot(slotIndex);
        }
    };

    function clearSlot(slotIndex) {
        slotFiles[slotIndex] = null;
        existingSlotImages[slotIndex] = null;
        const slot = $(`#imageSlot${slotIndex}`);
        slot.find('.image-slot-empty').show();
        slot.find('.image-slot-preview').hide();
        $(`.slot-file-input[data-slot="${slotIndex}"]`).val('');
    }

    function countTotalImages() {
        let count = 0;
        for (let i = 0; i < 4; i++) {
            if (slotFiles[i] || existingSlotImages[i]) count++;
        }
        return count;
    }

    // ── Form Submit (Create / Update) ──
    $('#formMachine').on('submit', function(e) {
        e.preventDefault();

        // Validate minimal 1 image
        const totalImages = countTotalImages();
        if (totalImages < 1) {
            showToast('Minimal 1 gambar harus diupload!', 'danger');
            return;
        }

        const id = $('#machineId').val();
        const url = id ? `/master-machine/${id}` : "{{ route('master-machine.store') }}";

        const formData = new FormData(this);

        // Remove slot file inputs and add actual selected files
        for (let i = 0; i < 4; i++) {
            // Remove default file input entries
        }

        // Build images array from slots
        const fileInputs = document.querySelectorAll('.slot-file-input');
        fileInputs.forEach(input => {
            formData.delete(input.name);
        });

        slotFiles.forEach((file) => {
            if (file) formData.append('images[]', file);
        });

        $('#btnSave').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    bootstrap.Modal.getInstance(document.getElementById('modalForm'))?.hide();
                    showToast(res.message);
                    loadMachines(currentPage);
                } else {
                    showToast(res.message, 'danger');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let msg = '';
                    for (let field in errors) {
                        msg += errors[field].join('<br>') + '<br>';
                    }
                    showToast(msg, 'danger');
                } else {
                    showToast('Terjadi kesalahan server.', 'danger');
                }
            },
            complete: function() {
                $('#btnSave').prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Save');
            }
        });
    });

    // ── View Machine ──
    window.viewMachine = function(id) {
        $.get(`/master-machine/${id}`, function(m) {
            let statusBadge = m.status === 'ACTIVE'
                ? '<span class="badge-status-active">ACTIVE</span>'
                : '<span class="badge-status-inactive">NOT ACTIVE</span>';

            let imagesHtml = '';
            if (m.images && m.images.length > 0) {
                m.images.forEach(img => {
                    imagesHtml += `<img src="/storage/${img.file_image}" alt="${img.file_name}" onclick="window.open(this.src)">`;
                });
            }

            $('#viewContent').html(`
                <div class="form-grid-container mb-4">
                    <table class="table view-detail-table mb-0">
                        <tbody>
                            <tr>
                                <td class="label-cell">Asset No</td>
                                <td class="value-cell">${m.asset_no || '-'}</td>
                                <td class="label-cell">Dsc. Asset</td>
                                <td class="value-cell">${m.descript_asset || '-'}</td>
                                <td class="label-cell">Sub No</td>
                                <td class="value-cell">${m.sub_no || '-'}</td>
                                <td class="label-cell">Location</td>
                                <td class="value-cell">${m.machine_loc || '-'}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Mnt No</td>
                                <td class="value-cell">${m.invent_number || '-'}</td>
                                <td class="label-cell">Machine Name</td>
                                <td class="value-cell" colspan="3"><strong>${m.machine_name || '-'}</strong></td>
                                <td class="label-cell">Plant</td>
                                <td class="value-cell">${m.plant || '-'}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">No Machine</td>
                                <td class="value-cell">${m.machine_number || '-'}</td>
                                <td class="label-cell">No MFG</td>
                                <td class="value-cell">${m.mfg_number || '-'}</td>
                                <td class="label-cell">Spec</td>
                                <td class="value-cell">${m.machine_spec || '-'}</td>
                                <td class="label-cell">Input Daya</td>
                                <td class="value-cell">${m.machine_power || '-'}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Brand</td>
                                <td class="value-cell">${m.machine_brand || '-'}</td>
                                <td class="label-cell">Model</td>
                                <td class="value-cell">${m.machine_type || '-'}</td>
                                <td class="label-cell">Made From</td>
                                <td class="value-cell">${m.machine_made || '-'}</td>
                                <td class="label-cell">Information</td>
                                <td class="value-cell">${m.machine_info || '-'}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Purchase Date</td>
                                <td class="value-cell">${m.install_date || '-'}</td>
                                <td class="label-cell">Made Date</td>
                                <td class="value-cell">${m.production_date || '-'}</td>
                                <td colspan="2" class="text-center">${statusBadge}</td>
                                <td class="label-cell">Note</td>
                                <td class="value-cell">${m.note || '-'}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                ${imagesHtml ? `
                <div class="card-header-teal" style="border-radius:var(--radius-sm) var(--radius-sm) 0 0;">
                    <i class="bi bi-images me-1"></i> View Image
                </div>
                <div class="view-image-grid" style="border:1px solid #dee2e6; border-top:none; border-radius:0 0 var(--radius-sm) var(--radius-sm);">${imagesHtml}</div>
                ` : ''}
            `);

            new bootstrap.Modal('#modalView').show();
        });
    };

    // ── Edit Machine ──
    window.editMachine = function(id) {
        $.get(`/master-machine/${id}`, function(m) {
            if (m.status !== 'ACTIVE') {
                showToast('Mesin NON ACTIVE tidak bisa diedit!', 'danger');
                return;
            }

            $('#machineId').val(m.id);
            $('#modalFormTitle').text('Edit Master Machine');
            resetImageSlots();

            // Fill form fields
            $('input[name="asset_no"]').val(m.asset_no);
            $('input[name="sub_no"]').val(m.sub_no);
            $('input[name="plant"]').val(m.plant);
            $('input[name="descript_asset"]').val(m.descript_asset);
            $('input[name="invent_number"]').val(m.invent_number);
            $('input[name="machine_number"]').val(m.machine_number);
            $('input[name="machine_name"]').val(m.machine_name);
            $('input[name="machine_brand"]').val(m.machine_brand);
            $('input[name="machine_type"]').val(m.machine_type);
            $('input[name="machine_spec"]').val(m.machine_spec);
            $('input[name="machine_power"]').val(m.machine_power);
            $('input[name="machine_made"]').val(m.machine_made);
            $('input[name="machine_info"]').val(m.machine_info);
            $('input[name="machine_loc"]').val(m.machine_loc);
            $('input[name="mfg_number"]').val(m.mfg_number);
            $('input[name="install_date"]').val(m.install_date);
            $('input[name="production_date"]').val(m.production_date);
            $('input[name="note"]').val(m.note);

            // Load existing images into slots
            if (m.images && m.images.length > 0) {
                m.images.forEach((img, i) => {
                    if (i >= 4) return;
                    existingSlotImages[i] = { id: img.id, src: `/storage/${img.file_image}` };
                    const slot = $(`#imageSlot${i}`);
                    slot.find('.image-slot-preview img').attr('src', `/storage/${img.file_image}`);
                    slot.find('.image-slot-empty').hide();
                    slot.find('.image-slot-preview').show();
                });
            }

            new bootstrap.Modal('#modalForm').show();
        });
    };

    // ── Open Note Modal ──
    window.openNote = function(id, action) {
        $('#noteMachineId').val(id);
        $('#noteAction').val(action);
        $('#noteText').val('');

        let title = '', desc = '';
        if (action === 'void') {
            title = '<i class="bi bi-trash3 me-2"></i>Void Mesin';
            desc = 'Mesin yang di-void tidak bisa digunakan lagi. Masukkan alasan void:';
        } else if (action === 'non-active') {
            title = '<i class="bi bi-toggle-off me-2"></i>Non Aktifkan Mesin';
            desc = 'Mesin akan diubah statusnya menjadi NON ACTIVE. Masukkan alasan:';
        } else if (action === 'active') {
            title = '<i class="bi bi-toggle-on me-2"></i>Aktifkan Mesin';
            desc = 'Mesin akan diubah statusnya menjadi ACTIVE. Masukkan alasan:';
        }

        $('#modalNoteTitle').html(title);
        $('#noteDescription').text(desc);
        new bootstrap.Modal('#modalNote').show();
    };

    // ── Submit Note ──
    $('#formNote').on('submit', function(e) {
        e.preventDefault();
        const id = $('#noteMachineId').val();
        const action = $('#noteAction').val();
        const note = $('#noteText').val();

        if (!note.trim()) { showToast('Alasan wajib diisi!', 'danger'); return; }

        const url = action === 'void'
            ? `/master-machine/${id}/void`
            : `/master-machine/${id}/change-status`;

        $('#btnSaveNote').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

        $.ajax({
            url, method: 'POST', data: { note },
            success: function(res) {
                if (res.success) {
                    bootstrap.Modal.getInstance(document.getElementById('modalNote'))?.hide();
                    showToast(res.message);
                    loadMachines(currentPage);
                } else {
                    showToast(res.message, 'danger');
                }
            },
            error: function() { showToast('Terjadi kesalahan server.', 'danger'); },
            complete: function() {
                $('#btnSaveNote').prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Simpan');
            }
        });
    });

    // ── View Log ──
    window.viewLog = function(id) {
        $.get(`/master-machine/${id}/logs`, function(logs) {
            if (!logs || logs.length === 0) {
                $('#logTableBody').html('<tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada log perubahan.</td></tr>');
            } else {
                let html = '';
                logs.forEach((log, i) => {
                    let badge = '';
                    switch(log.status_change) {
                        case 'ACTIVE':     badge = '<span class="badge-status-active">ACTIVE</span>'; break;
                        case 'NOT ACTIVE': badge = '<span class="badge-status-inactive">NOT ACTIVE</span>'; break;
                        case 'VOID':       badge = '<span class="badge-status-void">VOID</span>'; break;
                        case 'CREATED':    badge = '<span class="badge bg-info text-white" style="border-radius:4px;font-size:.78rem;">CREATED</span>'; break;
                        default:           badge = `<span class="badge bg-secondary" style="border-radius:4px;">${log.status_change}</span>`;
                    }
                    const d = log.date ? new Date(log.date).toLocaleString('id-ID') : '-';
                    html += `<tr><td>${i+1}</td><td>${badge}</td><td>${d}</td><td>${log.user||'-'}</td><td class="text-start">${log.note||'-'}</td></tr>`;
                });
                $('#logTableBody').html(html);
            }
            new bootstrap.Modal('#modalLog').show();
        });
    };

    // ── Initial Load ──
    loadMachines();
});
</script>
@endpush
