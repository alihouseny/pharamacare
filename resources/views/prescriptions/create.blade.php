@extends('layouts.app')
@section('title', __('main.upload_prescription'))

@section('content')
<div class="container" style="max-width:600px;padding:40px 20px;">
  <div class="card">
    <div class="card-header"><i class="fas fa-file-prescription" style="color:var(--info)"></i> {{ __('main.upload_prescription') }}</div>

    <div style="background:var(--accent-light);border:1.5px solid #FFB74D;border-radius:10px;padding:16px;margin-bottom:24px;font-size:14px">
      <strong><i class="fas fa-exclamation-triangle" style="color:var(--accent)"></i>
      {{ app()->getLocale()==='ar'?'تنبيه:':'Note:' }}</strong>
      {{ app()->getLocale()==='ar'
        ? 'يجب أن تكون الروشيتة واضحة وتحتوي على ختم الطبيب وتاريخ الكتابة'
        : 'Prescription must be clear, include doctor stamp and date' }}
    </div>

    <form action="{{ route('prescriptions.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label class="form-label">{{ app()->getLocale()==='ar'?'صورة الروشيتة':'Prescription Image' }} *</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
        <div class="form-text">{{ app()->getLocale()==='ar'?'JPG, PNG — حد أقصى 5MB':'JPG, PNG — Max 5MB' }}</div>
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">{{ app()->getLocale()==='ar'?'ملاحظات (اختياري)':'Notes (optional)' }}</label>
        <textarea name="notes" class="form-control" rows="3" placeholder="{{ app()->getLocale()==='ar'?'أي ملاحظات للصيدلاني...':'Any notes for the pharmacist...' }}"></textarea>
      </div>
      <button type="submit" class="btn btn-primary btn-block">
        <i class="fas fa-upload"></i> {{ __('main.upload_prescription') }}
      </button>
    </form>
  </div>
</div>
@endsection
