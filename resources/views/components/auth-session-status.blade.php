@props(['status'])
@if($status)
<div style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:10px 14px;font-size:14px;color:var(--success)" {{ $attributes }}>
    {{ $status }}
</div>
@endif
