<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'description',
        'price',
        'isbn',
        'category',
        'cover_image',
        'pdf_path',  // ✅ Campo para la ruta del PDF
        'status',
        'publication_date',
        'publisher',
        'language',
        'pages',
        'rating',
        'downloads_count',
        'views_count'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'price' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function userBooks()
    {
        return $this->hasMany(UserBook::class);
    }

    /**
     * Verificar si el libro tiene PDF disponible
     */
    public function hasPdf(): bool
    {
        if (empty($this->pdf_path)) {
            return false;
        }
        
        // Verificar si el archivo existe físicamente
        $fullPath = public_path($this->pdf_path);
        return file_exists($fullPath);
    }

    /**
     * Obtener la URL del PDF
     */
    public function getPdfUrl(): string
    {
        if (empty($this->pdf_path)) {
            return '';
        }
        
        return asset($this->pdf_path);
    }

    /**
     * Obtener el tamaño del archivo PDF en MB
     */
    public function getPdfSize(): string
    {
        if (!$this->hasPdf()) {
            return 'N/A';
        }
        
        $fullPath = public_path($this->pdf_path);
        $sizeInBytes = filesize($fullPath);
        $sizeInMB = round($sizeInBytes / (1024 * 1024), 2);
        
        return $sizeInMB . ' MB';
    }

    /**
     * Verificar si el archivo PDF es accesible
     */
    public function isPdfAccessible(): bool
    {
        if (!$this->hasPdf()) {
            return false;
        }
        
        $fullPath = public_path($this->pdf_path);
        return is_readable($fullPath);
    }
}