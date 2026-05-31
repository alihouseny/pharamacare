<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<title>فاتورة {{ $order->order_number }}</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: Arial, sans-serif; font-size:14px; color:#222; background:#fff; padding:40px; }
.invoice-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:32px; padding-bottom:20px; border-bottom:3px solid #00897B; }
.brand-name { font-size:28px; font-weight:900; color:#00897B; }
.brand-sub { font-size:13px; color:#666; margin-top:2px; }
.invoice-title { font-size:22px; font-weight:700; color:#333; text-align:end; }
.invoice-meta { font-size:13px; color:#666; text-align:end; margin-top:6px; }
.parties { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:28px; }
.party-box { background:#F5F5F5; border-radius:8px; padding:16px; }
.party-label { font-size:11px; font-weight:700; color:#888; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; }
.party-name { font-size:16px; font-weight:700; margin-bottom:4px; }
table { width:100%; border-collapse:collapse; margin-bottom:24px; }
thead tr { background:#00897B; color:#fff; }
th, td { padding:10px 14px; text-align:right; border-bottom:1px solid #eee; }
th { font-size:13px; font-weight:700; }
.totals { width:280px; margin-right:auto; }
.total-row { display:flex; justify-content:space-between; padding:6px 0; font-size:14px; border-bottom:1px solid #eee; }
.total-final { font-size:18px; font-weight:900; color:#00897B; margin-top:8px; padding-top:8px; border-top:2px solid #00897B; }
.status-badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;
  background:{{ ['delivered'=>'#E8F5E9','pending'=>'#FFF3E0','cancelled'=>'#FFEBEE'][$order->status]??'#F5F5F5' }};
  color:{{ ['delivered'=>'#2E7D32','pending'=>'#E65100','cancelled'=>'#C62828'][$order->status]??'#666' }}; }
.footer { margin-top:40px; padding-top:16px; border-top:1px solid #eee; text-align:center; font-size:12px; color:#999; }
@media print {
  body { padding:20px; }
  .no-print { display:none; }
}
</style>
</head>
<body>

<div class="no-print" style="margin-bottom:20px;display:flex;gap:10px">
  <button onclick="window.print()" style="background:#00897B;color:#fff;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;font-size:14px;font-weight:700">
    🖨️ طباعة / Print
  </button>
  <button onclick="window.close()" style="background:#f5f5f5;border:1px solid #ddd;padding:10px 20px;border-radius:8px;cursor:pointer;font-size:14px">
    ✕ إغلاق
  </button>
</div>

<div class="invoice-header">
  <div>
    <div class="brand-name">💊 فارماكير</div>
    <div class="brand-sub">PharmaCare Pharmacy</div>
    <div class="brand-sub" style="margin-top:4px">📍 شارع التحرير، القاهرة | 📞 01000000000</div>
  </div>
  <div style="text-align:end">
    <div class="invoice-title">فاتورة ضريبية</div>
    <div class="invoice-meta">رقم الطلب: <strong>{{ $order->order_number }}</strong></div>
    <div class="invoice-meta">التاريخ: <strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong></div>
    <div class="invoice-meta" style="margin-top:6px"><span class="status-badge">{{ $order->status_label['ar'] }}</span></div>
  </div>
</div>

<div class="parties">
  <div class="party-box">
    <div class="party-label">بيانات العميل</div>
    <div class="party-name">{{ $order->user->name }}</div>
    <div style="font-size:13px;color:#666">{{ $order->user->email }}</div>
    <div style="font-size:13px;color:#666">{{ $order->user->phone ?? '—' }}</div>
  </div>
  <div class="party-box">
    <div class="party-label">عنوان التوصيل</div>
    @if($order->address)
      <div class="party-name">{{ $order->address->recipient_name }}</div>
      <div style="font-size:13px;color:#666">{{ $order->address->phone }}</div>
      <div style="font-size:13px;color:#666">{{ $order->address->street }}, {{ $order->address->city }}</div>
    @else
      <div style="color:#999">—</div>
    @endif
  </div>
</div>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>المنتج</th>
      <th>الكمية</th>
      <th>سعر الوحدة</th>
      <th>الإجمالي</th>
    </tr>
  </thead>
  <tbody>
    @foreach($order->items as $i => $item)
    <tr>
      <td>{{ $i+1 }}</td>
      <td style="font-weight:600">{{ $item->product?->name_ar ?? 'منتج محذوف' }}</td>
      <td>{{ $item->quantity }}</td>
      <td>{{ number_format($item->price, 2) }} ج.م</td>
      <td style="font-weight:700">{{ number_format($item->total, 2) }} ج.م</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="totals">
  <div class="total-row"><span>المجموع الفرعي:</span><span>{{ number_format($order->subtotal, 2) }} ج.م</span></div>
  <div class="total-row"><span>رسوم التوصيل:</span><span>{{ $order->delivery_fee == 0 ? 'مجاناً' : number_format($order->delivery_fee,2).' ج.م' }}</span></div>
  @if($order->discount)<div class="total-row"><span>الخصم:</span><span style="color:#C62828">- {{ number_format($order->discount,2) }} ج.م</span></div>@endif
  <div class="total-row total-final"><strong>الإجمالي:</strong><strong>{{ number_format($order->total, 2) }} ج.م</strong></div>
</div>

<div style="margin-top:20px;font-size:13px">
  <strong>طريقة الدفع:</strong>
  {{ ['cod'=>'الدفع عند الاستلام','card'=>'بطاقة ائتمان','wallet'=>'محفظة إلكترونية'][$order->payment_method] ?? $order->payment_method }}
</div>
@if($order->notes)
<div style="margin-top:12px;font-size:13px"><strong>ملاحظات:</strong> {{ $order->notes }}</div>
@endif

<div class="footer">
  <p>شكراً لتعاملكم مع فارماكير | info@pharmacare.com | www.pharmacare.com</p>
  <p style="margin-top:4px">هذه الفاتورة صادرة إلكترونياً ولا تحتاج توقيعاً</p>
</div>

</body>
</html>
