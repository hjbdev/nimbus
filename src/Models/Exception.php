<?php

namespace Hjbdev\Nimbus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exception extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setConnection(config('nimbus.database.connection'));
        $this->setTable(config('nimbus.database.tables.exceptions'));
    }

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function traceLines(): HasMany
    {
        return $this->hasMany(TraceLine::class, 'exception_id')
            ->orderBy('index', 'asc');
    }
}
