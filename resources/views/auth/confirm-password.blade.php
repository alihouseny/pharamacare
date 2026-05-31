<x-guest-layout>
  <h2 style="font-size:20px;font-weight:900;margin-bottom:8px;text-align:center">{{ app()->getLocale()==='ar'?'تأكيد كلمة المرور':'Confirm Password' }}</h2>
  <p style="font-size:14px;color:var(--text-muted);text-align:center;margin-bottom:24px">{{ app()->getLocale()==='ar'?'يرجى تأكيد كلمة المرور للمتابعة':'Please confirm your password to continue.' }}</p>
  <form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'كلمة المرور':'Password' }}</label>
      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary btn-block">{{ app()->getLocale()==='ar'?'تأكيد':'Confirm' }}</button>
  </form>
</x-guest-layout>
