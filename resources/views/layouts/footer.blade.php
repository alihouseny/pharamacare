<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">

      {{-- BRAND --}}
      <div>
        <div class="footer-logo">
          <div class="logo-icon"><i class="fas fa-capsules"></i></div>
          <div>
            <div style="font-size:20px;font-weight:900;color:#fff">{{ app()->getLocale()==='ar'?'فارماكير':'PharmaCare' }}</div>
            <div style="font-size:12px;color:rgba(255,255,255,.5)">{{ app()->getLocale()==='ar'?'صحتك تبدأ هنا':'Your Health Starts Here' }}</div>
          </div>
        </div>
        <p class="footer-desc">{{ app()->getLocale()==='ar'?'صيدلية فارماكير — أدوية أصلية، عناية متكاملة، توصيل سريع لباب بيتك بأسعار مناسبة.':'PharmaCare — Authentic medicines, complete care, fast delivery to your door at affordable prices.' }}</p>
        <div class="footer-social">
          <a href="https://wa.me/201229662819" target="_blank" class="social-btn"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-tiktok"></i></a>
        </div>
      </div>

      {{-- QUICK LINKS --}}
      <div>
        <h4 class="footer-title">{{ app()->getLocale()==='ar'?'روابط سريعة':'Quick Links' }}</h4>
        <ul class="footer-links">
          <li><a href="{{ route('home') }}"><i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}"></i> {{ app()->getLocale()==='ar'?'الرئيسية':'Home' }}</a></li>
          <li><a href="{{ route('shop') }}"><i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}"></i> {{ app()->getLocale()==='ar'?'المتجر':'Shop' }}</a></li>
          @auth
          <li><a href="{{ route('account.dashboard') }}"><i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}"></i> {{ __('main.my_account') }}</a></li>
          <li><a href="{{ route('prescriptions.create') }}"><i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}"></i> {{ __('main.upload_prescription') }}</a></li>
          <li><a href="{{ route('subscriptions.index') }}"><i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}"></i> {{ __('main.subscriptions') }}</a></li>
          @else
          <li><a href="{{ route('login') }}"><i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}"></i> {{ __('main.login') }}</a></li>
          <li><a href="{{ route('register') }}"><i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}"></i> {{ __('main.register') }}</a></li>
          @endauth
        </ul>
      </div>

      {{-- CONTACT --}}
      <div>
        <h4 class="footer-title">{{ app()->getLocale()==='ar'?'تواصل معنا':'Contact Us' }}</h4>
        <ul class="footer-contact">
          <li><i class="fas fa-map-marker-alt"></i><span>{{ app()->getLocale()==='ar'?'شارع التحرير، وسط البلد، القاهرة':'Tahrir St., Downtown, Cairo' }}</span></li>
          <li><i class="fas fa-phone-alt"></i><a href="tel:+201229662819">01229662819</a></li>
          <li><i class="fab fa-whatsapp" style="color:#25D366"></i><a href="https://wa.me/201229662819" target="_blank">01229662819 (WhatsApp)</a></li>
          <li><i class="fas fa-envelope"></i><a href="mailto:info@pharmacare.com">info@pharmacare.com</a></li>
          <li><i class="fas fa-clock"></i><span>{{ app()->getLocale()==='ar'?'السبت – الخميس: ٩ص – ١١م':'Sat – Thu: 9AM – 11PM' }}</span></li>
        </ul>
      </div>

      {{-- SERVICES --}}
      <div>
        <h4 class="footer-title">{{ app()->getLocale()==='ar'?'خدماتنا':'Our Services' }}</h4>
        <ul class="footer-links">
          <li><i class="fas fa-check-circle" style="color:var(--primary);font-size:13px"></i> {{ app()->getLocale()==='ar'?'توصيل سريع لباب البيت':'Fast Home Delivery' }}</li>
          <li><i class="fas fa-check-circle" style="color:var(--primary);font-size:13px"></i> {{ app()->getLocale()==='ar'?'صرف الروشيتات الطبية':'Prescription Dispensing' }}</li>
          <li><i class="fas fa-check-circle" style="color:var(--primary);font-size:13px"></i> {{ app()->getLocale()==='ar'?'اشتراك شهري للأدوية':'Monthly Medicine Subscription' }}</li>
          <li><i class="fas fa-check-circle" style="color:var(--primary);font-size:13px"></i> {{ app()->getLocale()==='ar'?'استشارة صيدلانية مجانية':'Free Pharmacist Consultation' }}</li>
          <li><i class="fas fa-check-circle" style="color:var(--primary);font-size:13px"></i> {{ app()->getLocale()==='ar'?'منتجات أصلية 100%':'100% Authentic Products' }}</li>
          <li><i class="fas fa-shield-alt" style="color:var(--primary);font-size:13px"></i> {{ app()->getLocale()==='ar'?'مرخصة من وزارة الصحة':'Licensed by Ministry of Health' }}</li>
        </ul>
      </div>

    </div>

    <div class="footer-bottom">
      <span>© {{ date('Y') }} {{ app()->getLocale()==='ar'?'فارماكير — جميع الحقوق محفوظة':'PharmaCare — All Rights Reserved' }}</span>
      <span style="display:flex;align-items:center;gap:8px">
        <a href="tel:+201229662819" style="color:rgba(255,255,255,.5);text-decoration:none">
          <i class="fas fa-phone-alt"></i> 01229662819
        </a>
      </span>
    </div>
  </div>
</footer>
