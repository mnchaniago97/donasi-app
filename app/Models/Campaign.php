<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'target_amount',
        'current_amount',
        'image',
        'deadline',
        'status',
        'story',
        'recipient_name',
        'recipient_info',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'deadline' => 'datetime',
    ];

    /**
     * Get the donations for the campaign.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the updates for the campaign.
     */
    public function updates(): HasMany
    {
        return $this->hasMany(CampaignUpdate::class);
    }

    /**
     * Get successful donations only.
     */
    public function successfulDonations(): HasMany
    {
        return $this->hasMany(Donation::class)->where('status', 'success');
    }

    /**
     * Scope to get active campaigns.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if campaign goal is reached.
     */
    public function isGoalReached(): bool
    {
        return $this->current_amount >= $this->target_amount;
    }

    /**
     * Get progress percentage.
     */
    public function getProgressPercentage(): float
    {
        if ($this->target_amount == 0) {
            return 0;
        }
        return min(($this->current_amount / $this->target_amount) * 100, 100);
    }

    /**
     * Get remaining amount needed.
     */
    public function getRemainingAmount(): float
    {
        return max($this->target_amount - $this->current_amount, 0);
    }

    /**
     * Get top donors for this campaign.
     */
    public function getTopDonors($limit = 10)
    {
        return $this->successfulDonations()
            ->select('donor_name', 'donor_email', 'amount', 'payment_completed_at')
            ->orderBy('amount', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get donor count.
     */
    public function getDonorCount(): int
    {
        return $this->successfulDonations()->distinct('donor_email')->count();
    }
}
