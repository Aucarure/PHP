<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'is_favorite',
        'purchased_at',
        'current_page',
        'total_pages',
        'progress_percentage',
        'last_read_at',
        'completed_at',  // ✅ Campo agregado
        'bookmarks',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
        'purchased_at' => 'datetime',
        'last_read_at' => 'datetime',
        'completed_at' => 'datetime',  // ✅ Cast agregado
        'bookmarks' => 'array',
        'progress_percentage' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Actualizar progreso de lectura
     */
    public function updateProgress($currentPage, $totalPages = null)
    {
        $this->current_page = $currentPage;
        
        if ($totalPages) {
            $this->total_pages = $totalPages;
        }

        if ($this->total_pages > 0) {
            $this->progress_percentage = ($currentPage / $this->total_pages) * 100;
            
            // Auto-marcar como leído si está al 95% o más
            if ($this->progress_percentage >= 95 && $this->status !== 'read') {
                $this->status = 'read';
                $this->completed_at = now();  // ✅ Guardar fecha de completado
            }
        }

        $this->last_read_at = now();
        $this->save();
    }

    /**
     * Obtener estado de lectura legible
     */
    public function getReadingStatusAttribute()
    {
        if ($this->progress_percentage == 0) {
            return 'No iniciado';
        } elseif ($this->progress_percentage < 100) {
            return 'Leyendo (' . round($this->progress_percentage) . '%)';
        } else {
            return 'Terminado';
        }
    }

    /**
     * Verificar si el libro está completado
     */
    public function isCompleted(): bool
    {
        return $this->status === 'read' && $this->completed_at !== null;
    }

    /**
     * Obtener tiempo estimado de lectura restante
     */
    public function getEstimatedReadingTimeAttribute(): string
    {
        if ($this->progress_percentage >= 100) {
            return 'Completado';
        }

        $remainingPercentage = 100 - $this->progress_percentage;
        $averageReadingTime = 30; // minutos por 10% del libro (ajustable)
        
        $estimatedMinutes = ($remainingPercentage / 10) * $averageReadingTime;
        
        if ($estimatedMinutes < 60) {
            return round($estimatedMinutes) . ' min';
        } else {
            $hours = floor($estimatedMinutes / 60);
            $minutes = $estimatedMinutes % 60;
            return $hours . 'h ' . round($minutes) . 'm';
        }
    }
}