<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['product_id', 'quantity', 'notes', 'customer_name', 'customer_phone', 'total', 'status'])]
#[Hidden([])]
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    const STATUSES = ['menunggu', 'baru', 'diproses', 'selesai', 'ditolak'];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->order_number = 'ORD-'.now()->format('ymd').'-'
                .str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function calculateTotal(): int
    {
        if ($this->product->price === null) {
            return 0;
        }

        return (int) round($this->product->price * $this->quantity);
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'menunggu' => 'text-bg-secondary',
            'baru' => 'text-bg-primary',
            'diproses' => 'text-bg-warning',
            'selesai' => 'text-bg-success',
            'ditolak' => 'text-bg-danger',
            default => 'text-bg-secondary',
        };
    }

    public function whatsappMessage(): string
    {
        $lines = [
            'Halo Batik Nusantara! Saya mau pesan:',
            '',
            'No. Order : '.$this->order_number,
            'Nama      : '.$this->customer_name,
            'Produk    : '.$this->product->name,
            'Jumlah    : '.$this->quantity,
        ];

        if ($this->notes) {
            $lines[] = 'Catatan   : '.$this->notes;
        }

        $lines[] = '';
        $lines[] = 'Estimasi Total : '.($this->total > 0
            ? 'Rp '.number_format($this->total, 0, ',', '.')
            : 'Konsultasi');

        return implode("\n", $lines);
    }

    public function whatsappUrl(): string
    {
        $number = Setting::first()?->whatsapp_number ?: '6281234567890';

        return 'https://wa.me/'.$number.'?text='.urlencode($this->whatsappMessage());
    }

    public function customerWhatsAppUrl(): ?string
    {
        if (! $this->customer_phone) {
            return null;
        }

        $number = str_starts_with($this->customer_phone, '0')
            ? '62'.substr($this->customer_phone, 1)
            : $this->customer_phone;

        return 'https://wa.me/'.$number;
    }

    public function scopeStatus($query, ?string $status)
    {
        return $query->when($status, fn ($q) => $q->where('status', $status));
    }

    public function scopeSearch($query, ?string $term)
    {
        return $query->when($term, fn ($q) => $q->where('order_number', 'like', "%{$term}%"));
    }

    // Hanya pesanan yang benar-benar terkonfirmasi
    public function scopeValid($query)
    {
        return $query->whereIn('status', ['baru', 'diproses', 'selesai']);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'total' => 'decimal:2',
        ];
    }
}
