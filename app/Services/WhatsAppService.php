<?php
namespace App\Services;

use App\Models\Order;

class WhatsAppService {

    public static function orderConfirmationUrl(Order $order): string {
        $phone = $order->user->phone ?? $order->address?->phone ?? '';
        if (!$phone) return '';
        $phone = preg_replace('/\D/', '', $phone);
        if (str_starts_with($phone, '0')) $phone = '20' . substr($phone, 1);
        return 'https://wa.me/' . $phone . '?text=' . urlencode(self::orderMessage($order));
    }

    public static function orderMessage(Order $order): string {
        $items = $order->items->map(fn($i) => "• {$i->product?->name_ar} × {$i->quantity}")->join("\n");
        return "مرحباً {$order->user->name} 👋\n\n" .
               "✅ طلبك رقم: *{$order->order_number}*\n\n" .
               "🛒 المنتجات:\n{$items}\n\n" .
               "💰 الإجمالي: *" . number_format($order->total, 2) . " ج.م*\n" .
               "📍 الحالة: *{$order->status_label['ar']}*\n\n" .
               "شكراً لتعاملك مع فارماكير 💊";
    }
}
