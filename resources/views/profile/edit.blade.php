@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'تعديل الملف الشخصي':'Edit Profile')

@section('content')
<div class="container" style="max-width:720px;padding:40px 20px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:24px;font-weight:900;">
      <i class="fas fa-user-edit" style="color:var(--primary)"></i>
      {{ app()->getLocale()==='ar'?'الملف الشخصي':'My Profile' }}
    </h1>
    <a href="{{ route('account.dashboard') }}" class="btn btn-outline btn-sm">
      <i class="fas fa-arrow-left"></i> {{ __('main.back') }}
    </a>
  </div>

  @if(session('status') === 'profile-updated')
    <div style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--success)">
      <i class="fas fa-check-circle"></i> {{ app()->getLocale()==='ar'?'تم تحديث بياناتك بنجاح':'Profile updated successfully' }}
    </div>
  @endif
  @if(session('status') === 'password-updated')
    <div style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--success)">
      <i class="fas fa-check-circle"></i> {{ app()->getLocale()==='ar'?'تم تغيير كلمة المرور بنجاح':'Password changed successfully' }}
    </div>
  @endif

  {{-- UPDATE PROFILE --}}
  <div class="card" style="margin-bottom:20px">
    <div class="card-header"><i class="fas fa-id-card"></i> {{ app()->getLocale()==='ar'?'البيانات الشخصية':'Personal Information' }}</div>
    <form action="{{ route('profile.update') }}" method="POST">
      @csrf @method('patch')
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="form-group" style="grid-column:1/-1">
          <label class="form-label">{{ app()->getLocale()==='ar'?'الاسم الكامل':'Full Name' }} *</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}" required>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email Address' }} *</label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email) }}" required>
          @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'رقم الهاتف':'Phone Number' }}</label>
          <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ __('main.save') }}
      </button>
    </form>
  </div>

  {{-- CHANGE PASSWORD --}}
  <div class="card" style="margin-bottom:20px">
    <div class="card-header"><i class="fas fa-lock"></i> {{ app()->getLocale()==='ar'?'تغيير كلمة المرور':'Change Password' }}</div>
    <form action="{{ route('password.update') }}" method="POST">
      @csrf @method('put')
      <div style="display:grid;gap:16px;">
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'كلمة المرور الحالية':'Current Password' }} *</label>
          <input type="password" name="current_password" class="form-control @error('current_password','updatePassword') is-invalid @enderror" autocomplete="current-password">
          @error('current_password','updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'كلمة المرور الجديدة':'New Password' }} *</label>
          <input type="password" name="password" class="form-control @error('password','updatePassword') is-invalid @enderror" autocomplete="new-password">
          @error('password','updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">{{ app()->getLocale()==='ar'?'تأكيد كلمة المرور الجديدة':'Confirm New Password' }} *</label>
          <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-key"></i> {{ app()->getLocale()==='ar'?'تغيير كلمة المرور':'Change Password' }}
      </button>
    </form>
  </div>

  {{-- DELETE ACCOUNT --}}
  <div class="card" style="border-color:var(--danger)" x-data="{ confirm: false }">
    <div class="card-header" style="color:var(--danger)"><i class="fas fa-exclamation-triangle"></i> {{ app()->getLocale()==='ar'?'حذف الحساب':'Delete Account' }}</div>
    <p style="font-size:14px;color:var(--text-muted);margin-bottom:16px">
      {{ app()->getLocale()==='ar'?'سيؤدي هذا إلى حذف حسابك بشكل نهائي لا يمكن التراجع عنه.':'This will permanently delete your account. This action cannot be undone.' }}
    </p>
    <button @click="confirm = true" class="btn" style="background:var(--danger);color:#fff;border-color:var(--danger)">
      <i class="fas fa-trash"></i> {{ app()->getLocale()==='ar'?'حذف حسابي':'Delete My Account' }}
    </button>
    <div x-show="confirm" style="margin-top:16px;padding:16px;background:#FFEBEE;border-radius:10px">
      <p style="font-size:14px;font-weight:700;margin-bottom:12px;color:var(--danger)">
        {{ app()->getLocale()==='ar'?'هل أنت متأكد تماماً؟ أدخل كلمة المرور للتأكيد:':'Are you sure? Enter your password to confirm:' }}
      </p>
      <form action="{{ route('profile.destroy') }}" method="POST">
        @csrf @method('delete')
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <input type="password" name="password" class="form-control @error('password','userDeletion') is-invalid @enderror"
            placeholder="{{ app()->getLocale()==='ar'?'كلمة المرور':'Password' }}" style="max-width:240px">
          @error('password','userDeletion')<div class="invalid-feedback">{{ $message }}</div>@enderror
          <button type="submit" class="btn" style="background:var(--danger);color:#fff">
            {{ app()->getLocale()==='ar'?'تأكيد الحذف':'Confirm Delete' }}
          </button>
          <button type="button" @click="confirm = false" class="btn btn-outline">{{ __('main.cancel') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
