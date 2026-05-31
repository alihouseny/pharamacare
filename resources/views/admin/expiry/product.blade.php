@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'صلاحية المنتج':'Product Expiry')

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar">
      <div style="display:flex;align-items:center;gap:12px;">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        <div>
          <h1 style="font-size:20px;font-weight:800">{{ $product->name_ar }}</h1>
          <div style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'إدارة دفعات الصلاحية':'Manage expiry batches' }}</div>
        </div>
      </div>
    </div>
    <div class="admin-content">
      <div style="display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start;">

        {{-- BATCHES TABLE --}}
        <div class="card" style="padding:0;overflow:hidden">
          <div class="card-header" style="padding:16px"><i class="fas fa-boxes"></i> {{ app()->getLocale()==='ar'?'الدفعات':'Batches' }} ({{ $batches->count() }})</div>
          @if($batches->isEmpty())
            <div style="padding:32px;text-align:center;color:var(--text-muted)">
              {{ app()->getLocale()==='ar'?'لا توجد دفعات بعد':'No batches yet' }}
            </div>
          @else
          <table class="table">
            <thead><tr>
              <th>{{ app()->getLocale()==='ar'?'رقم الدفعة':'Batch #' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الإنتاج':'Manufacture' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الانتهاء':'Expiry' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الأيام':'Days' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الكمية':'Qty' }}</th>
              <th>{{ app()->getLocale()==='ar'?'المتبقي':'Remaining' }}</th>
            </tr></thead>
            <tbody>
              @foreach($batches as $batch)
              <tr>
                <td style="font-family:monospace;font-weight:700">{{ $batch->batch_number }}</td>
                <td style="font-size:13px">{{ $batch->manufacture_date?->format('d/m/Y') ?? '—' }}</td>
                <td>
                  <span class="{{ $batch->is_expired() ? 'expiry-danger' : ($batch->is_near_expiry() ? 'expiry-near' : 'expiry-ok') }}" style="font-weight:700">
                    {{ $batch->expiry_date->format('d/m/Y') }}
                  </span>
                </td>
                <td>
                  <span class="{{ $batch->days_until_expiry < 0 ? 'expiry-danger' : ($batch->days_until_expiry <= 90 ? 'expiry-near' : 'expiry-ok') }}" style="font-weight:700">
                    {{ $batch->days_until_expiry < 0 ? (app()->getLocale()==='ar'?'منتهية':'Expired') : $batch->days_until_expiry }}
                  </span>
                </td>
                <td>{{ $batch->quantity }}</td>
                <td style="font-weight:700">{{ $batch->remaining_quantity }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @endif
        </div>

        {{-- ADD BATCH FORM --}}
        <div class="card">
          <div class="card-header"><i class="fas fa-plus"></i> {{ app()->getLocale()==='ar'?'إضافة دفعة جديدة':'Add New Batch' }}</div>
          @if(session('success'))
            <div style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:8px;padding:10px;margin-bottom:16px;font-size:14px;color:var(--success)">
              <i class="fas fa-check"></i> {{ session('success') }}
            </div>
          @endif
          <form action="{{ route('admin.products.expiry.store', $product) }}" method="POST">
            @csrf
            <div class="form-group">
              <label class="form-label">{{ app()->getLocale()==='ar'?'رقم الدفعة':'Batch Number' }} *</label>
              <input type="text" name="batch_number" class="form-control @error('batch_number') is-invalid @enderror" value="{{ old('batch_number') }}">
              @error('batch_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label class="form-label">{{ app()->getLocale()==='ar'?'تاريخ الإنتاج':'Manufacture Date' }}</label>
              <input type="date" name="manufacture_date" class="form-control" value="{{ old('manufacture_date') }}">
            </div>
            <div class="form-group">
              <label class="form-label">{{ app()->getLocale()==='ar'?'تاريخ الانتهاء':'Expiry Date' }} *</label>
              <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}">
              @error('expiry_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label class="form-label">{{ app()->getLocale()==='ar'?'الكمية':'Quantity' }} *</label>
              <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" min="1" value="{{ old('quantity') }}">
              @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">
              <i class="fas fa-plus"></i> {{ app()->getLocale()==='ar'?'إضافة الدفعة':'Add Batch' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection
