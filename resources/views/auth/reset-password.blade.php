<x-guest-layout>
  <h2 style="font-size:20px;font-weight:900;margin-bottom:24px;text-align:center">{{ app()->getLocale()==='ar'?'إعادة تعيين كلمة المرور':'Reset Password' }}</h2>
  <form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email' }}</label>
      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $request->email) }}" required>
      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'كلمة المرور الجديدة':'New Password' }}</label>
      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label class="form-label">{{ app()->getLocale()==='ar'?'تأكيد كلمة المرور':'Confirm Password' }}</label>
      <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">{{ app()->getLocale()==='ar'?'حفظ كلمة المرور':'Save Password' }}</button>
  </form>
</x-guest-layout>
