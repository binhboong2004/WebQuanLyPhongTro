<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['room_id', 'service_reading_id', 'month_year', 'total_amount', 'status', 'payment_method', 'payment_date', 'qr_code_link'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function reading()
    {
        return $this->belongsTo(ServiceReading::class, 'service_reading_id');
    }
    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
