<?php

namespace Hjbdev\Nimbus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraceLine extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setConnection(config('nimbus.database.connection'));
        $this->setTable(config('nimbus.database.tables.trace_lines'));
    }

    protected $guarded = [];

    protected $casts = [
        'args' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function exception(): BelongsTo
    {
        return $this->belongsTo(Exception::class, 'exception_id');
    }
}