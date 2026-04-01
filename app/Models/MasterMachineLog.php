<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMachineLog extends Model
{
    protected $table = 'master_machine_tbl_log';
    public $timestamps = false;

    protected $fillable = [
        'id_machine', 'status_change', 'date', 'note', 'user',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Relasi ke mesin
     */
    public function machine()
    {
        return $this->belongsTo(MasterMachine::class, 'id_machine');
    }
}
