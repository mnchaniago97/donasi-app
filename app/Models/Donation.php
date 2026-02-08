<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'campaign_title',
        'message',
        'payment_method',
        'status',
        'transaction_id',
        'payment_token',
        'payment_completed_at',
    ];

    protected $casts = [
        'payment_completed_at' => 'datetime',
    ];

    public function isSuccess(): bool
    {
        return $this->status === 'success';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'success');
    }
}
