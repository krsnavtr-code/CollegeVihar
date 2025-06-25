<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $table = 'states';
    public $timestamps = true;

    protected $fillable = [
        'state_name',
        'state_short',
        'country_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the country that owns the state.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the cities for the state.
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get the universities in this state.
     */
    public function universities(): HasMany
    {
        return $this->hasMany(University::class)->with(['metadata','courses']);
    }

    /**
     * Get the employees in this state.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'emp_state');
    }
}
