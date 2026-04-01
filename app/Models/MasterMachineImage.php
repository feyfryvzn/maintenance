<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMachineImage extends Model
{
    protected $table = 'master_machine_image_tbl';
    public $timestamps = false;

    protected $fillable = [
        'id_machine', 'file_image', 'file_name',
        'created_by', 'created_date', 'status',
    ];

    protected $casts = [
        'created_date' => 'datetime',
    ];

    /**
     * Relasi ke mesin
     */
    public function machine()
    {
        return $this->belongsTo(MasterMachine::class, 'id_machine');
    }
}
