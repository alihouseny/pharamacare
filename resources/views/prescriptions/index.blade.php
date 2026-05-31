@extends('layouts.app')
@section('title', __('main.prescriptions'))

@section('content')
<div class="container" style="padding:40px 20px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:24px;font-weight:900;"><i class="fas fa-file-prescription" style="color:var(--info)"></i> {{ __('main.prescriptions') }}</h1>
    <a href="{{ route('prescriptions.create') }}" class="btn btn-primary btn-sm">
      <i class="fas fa-upload"></i> {{ __('main.upload_prescription') }}
    </a>
  </div>

  @if($prescriptions->isEmpty())
    <div class="empty-state">
      <div class="empty-state-icon">📋</div>
      <h3>{{ app()->getLocale()==='ar'?'لا توجد روشيتات بعد':'No prescriptions yet' }}</h3>
      <a href="{{ route('prescriptions.create') }}" class="btn btn-primary" style="margin-top:20px">{{ __('main.upload_prescription') }}</a>
    </div>
  @else
    <div style="display:grid;gap:16px">
      @foreach($prescriptions as $rx)
      <div class="card" style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        <a href="{{ asset('storage/'.$rx->image) }}" target="_blank">
          <img src="{{ asset('storage/'.$rx->image) }}" style="width:80px;height:80px;object-fit:cover;border-radius:10px;flex-shrink:0">
        </a>
        <div style="flex:1">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
            <span style="font-weight:700">{{ app()->getLocale()==='ar'?'روشيتة':'Prescription' }} #{{ $rx->id }}</span>
            @php $cls=['pending'=>'badge-orange','approved'=>'badge-green','rejected'=>'badge-red','used'=>'badge-gray']; @endphp
            <span class="badge {{ $cls[$rx->status]??'badge-gray' }}">
              {{ ['pending'=>__('main.pending_review'),'approved'=>__('main.approved'),'rejected'=>__('main.rejected')][$rx->status] ?? $rx->status }}
            </span>
          </div>
          <div style="font-size:13px;color:var(--text-muted)">{{ $rx->created_at->format('d/m/Y H:i') }}</div>
          @if($rx->notes)
            <div style="font-size:13px;margin-top:4px"><i class="fas fa-comment"></i> {{ $rx->notes }}</div>
          @endif
          @if($rx->pharmacist_notes)
            <div style="font-size:13px;margin-top:4px;color:var(--info)"><i class="fas fa-user-md"></i> {{ $rx->pharmacist_notes }}</div>
          @endif
        </div>
        @if($rx->status === 'approved')
        <a href="{{ route('shop', ['filter'=>'rx']) }}" class="btn btn-primary btn-sm">
          <i class="fas fa-shopping-cart"></i> {{ __('main.shop') }}
        </a>
        @endif
      </div>
      @endforeach
    </div>
    <div style="margin-top:20px">{{ $prescriptions->links() }}</div>
  @endif
</div>
@endsection
