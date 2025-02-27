<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GT_EXP extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'FIN_REPORTING.GT_EXP';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected function casts() : Array {
        return [
            'amount' => 'double',
            'total' => 'double'
        ];
    }
}
