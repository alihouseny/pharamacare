<x-guest-layout>
  <h2 style="font-size:22px;font-weight:900;margin-bottom:24px;text-align:center">
    {{ app()->getLocale()==='ar'?'تسجيل الدخول':'Sign In' }}
  </h2>

  @if(session('status'))
    <div class="alert alert-success" style="margin-bottom:16px;font-size:14px">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email Address' }}</label>
      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email') }}" required autofocus autocomplete="username">
      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label class="form-label" style="display:flex;justify-content:space-between">
        <span>{{ app()->getLocale()==='ar'?'كلمة المرور':'Password' }}</span>
        @if(Route::has('password.request'))
          <a href="{{ route('password.request') }}" style="font-size:13px;color:var(--primary);text-decoration:none">
            {{ app()->getLocale()==='ar'?'نسيت كلمة المرور؟':'Forgot password?' }}
          </a>
        @endif
      </label>
      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
        required autocomplete="current-password">
      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px">
      <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;cursor:pointer">
      <label for="remember" style="font-size:14px;cursor:pointer;margin:0">{{ app()->getLocale()==='ar'?'تذكرني':'Remember me' }}</label>
    </div>
    <button type="submit" class="btn btn-primary btn-block btn-lg">
      <i class="fas fa-sign-in-alt"></i> {{ app()->getLocale()==='ar'?'دخول':'Sign In' }}
    </button>
  </form>

  <p style="text-align:center;margin-top:20px;font-size:14px;color:var(--text-muted)">
    {{ app()->getLocale()==='ar'?'ليس لديك حساب؟':'Don\'t have an account?' }}
    <a href="{{ route('register') }}" style="color:var(--primary);font-weight:700;text-decoration:none">
      {{ app()->getLocale()==='ar'?'سجّل الآن':'Register' }}
    </a>
  </p>
</x-guest-layout>
