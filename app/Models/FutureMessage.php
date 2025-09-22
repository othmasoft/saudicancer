<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class FutureMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'message',
        'email',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'send_email' => 'boolean',
        'custom_fields' => 'array',
        'view_count' => 'integer',
        'share_count' => 'integer',
        'like_count' => 'integer'
    ];

    /**
     * Relationship with User (creator)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for scheduled messages
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope for sent messages
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }


    /**
     * Scope for messages ready to be sent
     */
    public function scopeReadyToSend($query)
    {
        return $query->where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->where('send_email', true);
    }

    /**
     * Get status label with styling
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => ['text' => 'مسودة', 'class' => 'badge bg-secondary'],
            'scheduled' => ['text' => 'مجدولة', 'class' => 'badge bg-primary'],
            'sent' => ['text' => 'تم الإرسال', 'class' => 'badge bg-success'],
            'published' => ['text' => 'منشورة', 'class' => 'badge bg-info'],
            'archived' => ['text' => 'مؤرشفة', 'class' => 'badge bg-dark']
        ];

        return $labels[$this->status] ?? ['text' => 'غير محدد', 'class' => 'badge bg-warning'];
    }

    /**
     * Get type label with styling
     */
    public function getTypeLabelAttribute()
    {
        $labels = [
            'personal' => ['text' => 'شخصية', 'class' => 'badge bg-primary'],
            'motivational' => ['text' => 'تحفيزية', 'class' => 'badge bg-success'],
            'reminder' => ['text' => 'تذكير', 'class' => 'badge bg-warning'],
            'celebration' => ['text' => 'احتفال', 'class' => 'badge bg-info'],
            'announcement' => ['text' => 'إعلان', 'class' => 'badge bg-danger'],
            'event' => ['text' => 'فعالية', 'class' => 'badge bg-dark']
        ];

        return $labels[$this->type] ?? ['text' => 'عام', 'class' => 'badge bg-secondary'];
    }

    /**
     * Check if message is due to be sent
     */
    public function getIsDueAttribute()
    {
        return $this->status === 'scheduled' && $this->scheduled_at <= now();
    }

    /**
     * Check if message can be edited
     */
    public function getCanEditAttribute()
    {
        return $this->status === 'scheduled' && $this->scheduled_at > now();
    }

    /**
     * Get formatted scheduled date
     */
    public function getFormattedScheduledDateAttribute()
    {
        if (!$this->scheduled_at) return 'غير محدد';

        return $this->scheduled_at->format('Y/m/d H:i');
    }

    /**
     * Get time remaining until sending
     */
    public function getTimeRemainingAttribute()
    {
        if (!$this->scheduled_at || $this->status !== 'scheduled') {
            return null;
        }

        $now = now();
        if ($this->scheduled_at <= $now) {
            return 'مستحقة الإرسال';
        }

        return $this->scheduled_at->diffForHumans($now);
    }

    /**
     * Get excerpt from content
     */
    public function getExcerptAttribute()
    {
        return \Str::limit(strip_tags($this->content), 150);
    }

    /**
     * Get reading time estimate
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average 200 words per minute for Arabic

        if ($minutes < 1) {
            return 'أقل من دقيقة';
        } elseif ($minutes == 1) {
            return 'دقيقة واحدة';
        } elseif ($minutes == 2) {
            return 'دقيقتان';
        } elseif ($minutes <= 10) {
            return $minutes . ' دقائق';
        } else {
            return $minutes . ' دقيقة';
        }
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('view_count');
    }

    /**
     * Increment share count
     */
    public function incrementShares()
    {
        $this->increment('share_count');
    }

    /**
     * Increment like count
     */
    public function incrementLikes()
    {
        $this->increment('like_count');
    }

    /**
     * Check if message has expired
     */
    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at < now();
    }

    /**
     * Get days until expiration
     */
    public function getDaysUntilExpirationAttribute()
    {
        if (!$this->expires_at) return null;

        $days = now()->diffInDays($this->expires_at, false);
        return $days > 0 ? $days : 0;
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Set default values when creating
        static::creating(function ($message) {
            if (!$message->status) {
                $message->status = 'scheduled';
            }


        });
    }
}
