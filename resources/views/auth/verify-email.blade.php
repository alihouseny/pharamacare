<x-guest-layout>
  <div style="text-align:center;padding:8px 0">
    <div style="font-size:48px;margin-bottom:16px">📧</div>
    <h2 style="font-size:20px;font-weight:900;margin-bottom:8px">{{ app()->getLocale()==='ar'?'تحقق من بريدك الإلكتروني':'Verify Your Email' }}</h2>
    <p style="font-size:14px;color:var(--text-muted);margin-bottom:24px">{{ app()->getLocale()==='ar'?'أرسلنا لك رابط التحقق. يرجى التحقق من بريدك الإلكتروني':'We sent you a verification link. Please check your email.' }}</p>

    @if(session('status') === 'verification-link-sent')
      <div class="alert alert-success" style="margin-bottom:16px;font-size:14px">{{ app()->getLocale()==='ar'?'تم إرسال رابط جديد للتحقق':'A new verification link has been sent.' }}</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom:12px">
      @csrf
      <button type="submit" class="btn btn-primary btn-block">{{ app()->getLocale()==='ar'?'إعادة إرسال الرابط':'Resend Verification Email' }}</button>
    </form>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-outline btn-block">{{ app()->getLocale()==='ar'?'تسجيل الخروج':'Log Out' }}</button>
    </form>
  </div>
</x-guest-layout>
