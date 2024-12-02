<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_cost',
        'shipping_price',
        'shipping_voucher',
        'voucher',
        'tax',
        'total_payment',
        'full_name',
        'phone_number',
        'address',
        'payment_method',
        'payment_id',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function order_details()
    {
        return $this->hasMany(Order_detail::class, 'order_id', 'id');
    }
    public function status_orders()
    {
        return $this->hasMany(Status_order::class);
    }

    //Thống kê doanh thu cửa hàng
    public static function getRevenueByIntervals($intervals)
    {
        $caseStatements = [];
        $labels = [];

        foreach ($intervals as $index => $range) {
            $label = $range[0]->format('d/m');
            if ($range[0]->format('Y-m-d') !== $range[1]->format('Y-m-d')) {
                $label = $range[0]->format('d/m') . '-' . $range[1]->format('d/m');
            }
            // Xử lý trường hợp tháng
            if (
                $range[0]->format('Y-m') === $range[1]->format('Y-m') &&
                $range[0]->format('d') === '01' &&
                $range[1]->format('d') === $range[1]->copy()->endOfMonth()->format('d')
            ) {
                $label = $range[0]->format('m/Y');
            }
            $labels[] = $label;
            $caseStatements[] = "
            WHEN orders.created_at BETWEEN '{$range[0]->format('Y-m-d')} 00:00:00'
            AND '{$range[1]->format('Y-m-d')} 23:59:59'
            THEN '{$label}'";
        }

        $query = self::selectRaw("
            CASE " . implode("\n", $caseStatements) . "
            END as label,
            COALESCE(SUM(orders.total_payment), 0) as total_revenue")
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->where('status_orders.status_id', 3)
            ->whereBetween('orders.created_at', [$intervals[0][0]->startOfDay(), end($intervals)[1]->endOfDay()])
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        return $query->toArray();
    }
}
