<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Support extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'priority',
        'status',
        'user_id',
        'admin_response',
        'responded_at',
        'responded_by',
        'updated_by',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship with User (if user is logged in)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Admin who responded to the support ticket
     */
    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    /**
     * Admin who last updated the ticket
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Get priority label with color
     */
    public function getPriorityLabelAttribute()
    {
        $labels = [
            'low' => ['text' => 'منخفض', 'class' => 'badge bg-success'],
            'medium' => ['text' => 'متوسط', 'class' => 'badge bg-warning'],
            'high' => ['text' => 'عالي', 'class' => 'badge bg-danger'],
            'urgent' => ['text' => 'عاجل', 'class' => 'badge bg-dark']
        ];

        return $labels[$this->priority] ?? ['text' => 'غير محدد', 'class' => 'badge bg-secondary'];
    }

    /**
     * Get status label with color
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'open' => ['text' => 'مفتوح', 'class' => 'badge bg-primary'],
            'in_progress' => ['text' => 'قيد المعالجة', 'class' => 'badge bg-warning'],
            'responded' => ['text' => 'تم الرد', 'class' => 'badge bg-info'],
            'resolved' => ['text' => 'تم الحل', 'class' => 'badge bg-success'],
            'closed' => ['text' => 'مغلق', 'class' => 'badge bg-secondary']
        ];

        return $labels[$this->status] ?? ['text' => 'غير محدد', 'class' => 'badge bg-secondary'];
    }

    /**
     * Check if support ticket is still active
     */
    public function getIsActiveAttribute()
    {
        return !in_array($this->status, ['resolved', 'closed']);
    }
}
