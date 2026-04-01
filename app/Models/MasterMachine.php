<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMachine extends Model
{
    protected $table = 'master_machine_tbl';
    public $timestamps = false;

    protected $fillable = [
        'asset_no', 'sub_no', 'plant', 'descript_asset', 'image',
        'invent_number', 'machine_number', 'machine_name', 'machine_brand',
        'machine_type', 'machine_spec', 'machine_power', 'machine_made',
        'machine_status', 'machine_info', 'machine_loc', 'mfg_number',
        'install_date', 'production_date', 'status',
        'created_by', 'created_date', 'updated_by', 'updated_date',
        'voided_by', 'voided_date', 'note',
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'voided_date'  => 'datetime',
    ];

    /**
     * Relasi ke tabel gambar (1 mesin max 4 gambar)
     */
    public function images()
    {
        return $this->hasMany(MasterMachineImage::class, 'id_machine');
    }

    /**
     * Relasi ke tabel log perubahan status
     */
    public function logs()
    {
        return $this->hasMany(MasterMachineLog::class, 'id_machine');
    }
}
