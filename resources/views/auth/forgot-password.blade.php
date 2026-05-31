<x-guest-layout>
  <h2 style="font-size:20px;font-weight:900;margin-bottom:8px;text-align:center">{{ app()->getLocale()==='ar'?'نسيت كلمة المرور؟':'Forgot Password?' }}</h2>
  <p style="font-size:14px;color:var(--text-muted);text-align:center;margin-bottom:24px">{{ app()->getLocale()==='ar'?'أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين':'Enter your email and we\'ll send you a reset link' }}</p>

  @if(session('status'))
    <div class="alert alert-success" style="margin-bottom:16px;font-size:14px">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email Address' }}</label>
      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email') }}" required autofocus>
      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary btn-block">
      <i class="fas fa-paper-plane"></i> {{ app()->getLocale()==='ar'?'إرسال رابط الاستعادة':'Send Reset Link' }}
    </button>
  </form>

  <p style="text-align:center;margin-top:20px;font-size:14px">
    <a href="{{ route('login') }}" style="color:var(--primary);text-decoration:none">
      <i class="fas fa-arrow-left"></i> {{ app()->getLocale()==='ar'?'العودة لتسجيل الدخول':'Back to Sign In' }}
    </a>
  </p>
</x-guest-layout>
