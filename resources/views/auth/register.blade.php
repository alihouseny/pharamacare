<x-guest-layout>
  <h2 style="font-size:22px;font-weight:900;margin-bottom:24px;text-align:center">
    {{ app()->getLocale()==='ar'?'إنشاء حساب جديد':'Create Account' }}
  </h2>

  <form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'الاسم الكامل':'Full Name' }}</label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name') }}" required autofocus autocomplete="name">
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email Address' }}</label>
      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email') }}" required autocomplete="username">
      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'رقم الهاتف (اختياري)':'Phone (optional)' }}</label>
      <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" autocomplete="tel">
    </div>
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'كلمة المرور':'Password' }}</label>
      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
        required autocomplete="new-password">
      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'تأكيد كلمة المرور':'Confirm Password' }}</label>
      <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
    </div>
    <button type="submit" class="btn btn-primary btn-block btn-lg">
      <i class="fas fa-user-plus"></i> {{ app()->getLocale()==='ar'?'إنشاء الحساب':'Create Account' }}
    </button>
  </form>

  <p style="text-align:center;margin-top:20px;font-size:14px;color:var(--text-muted)">
    {{ app()->getLocale()==='ar'?'لديك حساب بالفعل؟':'Already have an account?' }}
    <a href="{{ route('login') }}" style="color:var(--primary);font-weight:700;text-decoration:none">
      {{ app()->getLocale()==='ar'?'سجّل دخولك':'Sign In' }}
    </a>
  </p>
</x-guest-layout>
