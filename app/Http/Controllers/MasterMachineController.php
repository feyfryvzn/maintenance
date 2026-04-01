<?php

namespace App\Http\Controllers;

use App\Models\MasterMachine;
use App\Models\MasterMachineImage;
use App\Models\MasterMachineLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MasterMachineController extends Controller
{
    /**
     * Halaman utama — daftar mesin
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MasterMachine::where('status', '!=', 'VOID')
                ->orderBy('id', 'desc');

            // Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('machine_name', 'like', "%{$search}%")
                      ->orWhere('machine_number', 'like', "%{$search}%")
                      ->orWhere('asset_no', 'like', "%{$search}%")
                      ->orWhere('machine_brand', 'like', "%{$search}%")
                      ->orWhere('machine_type', 'like', "%{$search}%")
                      ->orWhere('machine_loc', 'like', "%{$search}%");
                });
            }

            // Filter status
            if ($request->filled('filter_status')) {
                $query->where('status', $request->filter_status);
            }

            // Column-specific filters
            $filterColumns = [
                'filter_asset_no'       => 'asset_no',
                'filter_mfg_number'     => 'mfg_number',
                'filter_invent_number'  => 'invent_number',
                'filter_machine_number' => 'machine_number',
                'filter_machine_name'   => 'machine_name',
                'filter_machine_spec'   => 'machine_spec',
                'filter_plant'          => 'plant',
            ];
            foreach ($filterColumns as $param => $column) {
                if ($request->filled($param)) {
                    $query->where($column, 'like', '%' . $request->input($param) . '%');
                }
            }

            $machines = $query->paginate($request->get('per_page', 10));

            return response()->json($machines);
        }

        return view('master-machine.index');
    }

    /**
     * Simpan mesin baru + upload gambar
     */
    public function store(Request $request)
    {
        $request->validate([
            'machine_name'   => 'required|string|max:25',
            'machine_number' => 'nullable|string|max:20',
            'images'         => 'required|array|min:1|max:4',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif|max:1024',
        ], [
            'images.required' => 'Minimal 1 gambar harus diupload!',
            'images.min'      => 'Minimal 1 gambar harus diupload!',
        ]);

        DB::beginTransaction();
        try {
            $machine = MasterMachine::create([
                'asset_no'        => $request->asset_no,
                'sub_no'          => $request->sub_no,
                'plant'           => $request->plant,
                'descript_asset'  => $request->descript_asset,
                'invent_number'   => $request->invent_number,
                'machine_number'  => $request->machine_number,
                'machine_name'    => $request->machine_name,
                'machine_brand'   => $request->machine_brand,
                'machine_type'    => $request->machine_type,
                'machine_spec'    => $request->machine_spec,
                'machine_power'   => $request->machine_power,
                'machine_made'    => $request->machine_made,
                'machine_status'  => $request->machine_status ?? '1',
                'machine_info'    => $request->machine_info,
                'machine_loc'     => $request->machine_loc,
                'mfg_number'      => $request->mfg_number,
                'install_date'    => $request->install_date,
                'production_date' => $request->production_date,
                'status'          => 'ACTIVE',
                'created_by'      => $request->user_name ?? 'SYSTEM',
                'created_date'    => now(),
                'note'            => $request->note,
            ]);

            // Upload gambar (max 4)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    if ($index >= 4) break;

                    $fileName = 'machine_' . $machine->id . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('machines', $fileName, 'public');

                    MasterMachineImage::create([
                        'id_machine'   => $machine->id,
                        'file_image'   => $path,
                        'file_name'    => $image->getClientOriginalName(),
                        'created_by'   => $request->user_name ?? 'SYSTEM',
                        'created_date' => now(),
                        'status'       => 'ACTIVE',
                    ]);
                }
            }

            // Log pembuatan
            MasterMachineLog::create([
                'id_machine'    => $machine->id,
                'status_change' => 'CREATED',
                'date'          => now(),
                'note'          => 'Mesin baru ditambahkan',
                'user'          => $request->user_name ?? 'SYSTEM',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data mesin berhasil disimpan!',
                'data'    => $machine->load('images'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get detail mesin (JSON) — untuk modal View/Edit
     */
    public function show($id)
    {
        $machine = MasterMachine::with(['images' => function ($q) {
            $q->where('status', 'ACTIVE');
        }])->findOrFail($id);

        return response()->json($machine);
    }

    /**
     * Update data mesin
     */
    public function update(Request $request, $id)
    {
        $machine = MasterMachine::findOrFail($id);

        // Cek apakah mesin ACTIVE (hanya ACTIVE yang bisa di-edit)
        if ($machine->status !== 'ACTIVE') {
            return response()->json([
                'success' => false,
                'message' => 'Mesin dengan status NON ACTIVE tidak bisa diedit!',
            ], 403);
        }

        $request->validate([
            'machine_name'   => 'required|string|max:25',
            'images'         => 'nullable|array|max:4',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $machine->update([
                'asset_no'        => $request->asset_no,
                'sub_no'          => $request->sub_no,
                'plant'           => $request->plant,
                'descript_asset'  => $request->descript_asset,
                'invent_number'   => $request->invent_number,
                'machine_number'  => $request->machine_number,
                'machine_name'    => $request->machine_name,
                'machine_brand'   => $request->machine_brand,
                'machine_type'    => $request->machine_type,
                'machine_spec'    => $request->machine_spec,
                'machine_power'   => $request->machine_power,
                'machine_made'    => $request->machine_made,
                'machine_status'  => $request->machine_status ?? $machine->machine_status,
                'machine_info'    => $request->machine_info,
                'machine_loc'     => $request->machine_loc,
                'mfg_number'      => $request->mfg_number,
                'install_date'    => $request->install_date,
                'production_date' => $request->production_date,
                'updated_by'      => $request->user_name ?? 'SYSTEM',
                'updated_date'    => now(),
                'note'            => $request->note,
            ]);

            // Upload gambar baru (max 4 total)
            if ($request->hasFile('images')) {
                $currentImageCount = $machine->images()->where('status', 'ACTIVE')->count();
                $maxNewImages = 4 - $currentImageCount;

                foreach ($request->file('images') as $index => $image) {
                    if ($index >= $maxNewImages) break;

                    $fileName = 'machine_' . $machine->id . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('machines', $fileName, 'public');

                    MasterMachineImage::create([
                        'id_machine'   => $machine->id,
                        'file_image'   => $path,
                        'file_name'    => $image->getClientOriginalName(),
                        'created_by'   => $request->user_name ?? 'SYSTEM',
                        'created_date' => now(),
                        'status'       => 'ACTIVE',
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data mesin berhasil diperbarui!',
                'data'    => $machine->load('images'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ubah status Active <-> Non Active (dengan DB Transaction + log)
     */
    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string',
        ]);

        $machine = MasterMachine::findOrFail($id);

        DB::beginTransaction();
        try {
            $oldStatus = $machine->status;
            $newStatus = ($oldStatus === 'ACTIVE') ? 'NOT ACTIVE' : 'ACTIVE';

            $machine->update([
                'status'       => $newStatus,
                'updated_by'   => $request->user_name ?? 'SYSTEM',
                'updated_date' => now(),
            ]);

            MasterMachineLog::create([
                'id_machine'    => $machine->id,
                'status_change' => $newStatus,
                'date'          => now(),
                'note'          => $request->note,
                'user'          => $request->user_name ?? 'SYSTEM',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Status mesin berhasil diubah menjadi {$newStatus}!",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Void mesin (dengan DB Transaction + log)
     */
    public function void(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string',
        ]);

        $machine = MasterMachine::findOrFail($id);

        DB::beginTransaction();
        try {
            $machine->update([
                'status'      => 'NOT ACTIVE',
                'voided_by'   => $request->user_name ?? 'SYSTEM',
                'voided_date' => now(),
            ]);

            MasterMachineLog::create([
                'id_machine'    => $machine->id,
                'status_change' => 'VOID',
                'date'          => now(),
                'note'          => $request->note,
                'user'          => $request->user_name ?? 'SYSTEM',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mesin berhasil di-void!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal void mesin: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get log riwayat perubahan status (JSON)
     */
    public function logs($id)
    {
        $logs = MasterMachineLog::where('id_machine', $id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($logs);
    }

    /**
     * Hapus gambar individual (tidak bisa hapus kalau tinggal 1)
     */
    public function deleteImage($id)
    {
        $image = MasterMachineImage::findOrFail($id);

        // Cek apakah masih ada lebih dari 1 gambar aktif
        $activeCount = MasterMachineImage::where('id_machine', $image->id_machine)
            ->where('status', 'ACTIVE')
            ->count();

        if ($activeCount <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa menghapus gambar terakhir! Minimal 1 gambar harus ada.',
            ], 422);
        }

        // Hapus file dari storage
        if (Storage::disk('public')->exists($image->file_image)) {
            Storage::disk('public')->delete($image->file_image);
        }

        $image->update(['status' => 'NOT ACTIVE']);

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil dihapus!',
        ]);
    }
}
