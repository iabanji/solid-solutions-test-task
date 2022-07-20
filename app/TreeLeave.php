<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TreeLeave extends Model
{
    protected $table = 'tree_leaves';

    protected $fillable = [
        'parent_id',
        'title',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(TreeLeave::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(TreeLeave::class, 'parent_id')->orderBy('created_at', 'desc');
    }
}
