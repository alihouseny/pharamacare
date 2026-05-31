@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'عناوين التوصيل':'Delivery Addresses')

@section('content')
<div class="container" style="max-width:700px;padding:40px 20px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:24px;font-weight:900;"><i class="fas fa-map-marker-alt" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'عناوين التوصيل':'Delivery Addresses' }}</h1>
    <a href="{{ route('account.dashboard') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> {{ __('main.back') }}</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success" style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--success)">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- EXISTING ADDRESSES --}}
  @if($addresses->count())
  <div style="display:grid;gap:14px;margin-bottom:32px;">
    @foreach($addresses as $addr)
    <div class="card" style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap;">
      <div>
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
          <span style="font-weight:800;font-size:16px;">{{ $addr->label }}</span>
          @if($addr->is_default)
            <span class="badge badge-green">{{ app()->getLocale()==='ar'?'افتراضي':'Default' }}</span>
          @endif
        </div>
        <div style="font-size:14px;color:var(--text-muted)">{{ $addr->recipient_name }} · {{ $addr->phone }}</div>
        <div style="font-size:14px">{{ $addr->street }}, {{ $addr->city }}@if($addr->area), {{ $addr->area }}@endif</div>
      </div>
    </div>
    @endforeach
  </div>
  @endif

  {{-- ADD NEW ADDRESS --}}
  <div class="card">
    <div class="card-header"><i class="fas fa-plus"></i> {{ app()->getLocale()==='ar'?'إضافة عنوان جديد':'Add New Address' }}</div>
    <form action="{{ route('account.addresses.store') }}" method="POST">
      @csrf
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'التسمية':'Label' }} *</label>
          <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" placeholder="{{ app()->getLocale()==='ar'?'البيت / العمل':'Home / Work' }}" value="{{ old('label') }}">
          @error('label')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'اسم المستلم':'Recipient Name' }} *</label>
          <input type="text" name="recipient_name" class="form-control @error('recipient_name') is-invalid @enderror" value="{{ old('recipient_name') }}">
          @error('recipient_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'رقم الهاتف':'Phone' }} *</label>
          <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
          @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'المدينة':'City' }} *</label>
          <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
          @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group" style="grid-column:1/-1">
          <label class="form-label">{{ app()->getLocale()==='ar'?'العنوان التفصيلي':'Street Address' }} *</label>
          <input type="text" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}">
          @error('street')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'الحي (اختياري)':'Area (optional)' }}</label>
          <input type="text" name="area" class="form-control" value="{{ old('area') }}">
        </div>
        <div class="form-group" style="display:flex;align-items:center;gap:8px;margin-top:32px">
          <input type="checkbox" name="is_default" value="1" id="is_default" {{ old('is_default')?'checked':'' }}>
          <label for="is_default" style="margin:0;cursor:pointer">{{ app()->getLocale()==='ar'?'تعيين كعنوان افتراضي':'Set as default' }}</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top:8px">
        <i class="fas fa-save"></i> {{ __('main.save') }}
      </button>
    </form>
  </div>
</div>
@endsection
