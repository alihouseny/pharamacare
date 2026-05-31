<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">

      {{-- BRAND --}}
      <div class="footer-col footer-brand">
        <div class="footer-logo">
          <div class="logo-icon"><i class="fas fa-capsules"></i></div>
          <div>
            <div style="font-size:20px;font-weight:900;color:#fff">{{ app()->getLocale()==='ar'?'فارماكير':'PharmaCare' }}</div>
            <div style="font-size:12px;color:rgba(255,255,255,.6)">{{ app()->getLocale()==='ar'?'صحتك تبدأ هنا':'Your Health Starts Here' }}</div>
          </div>
        </div>
        <p class="footer-desc">
          {{ app()->getLocale()==='ar'
            ? 'صيدلية فارماكير — نقدم لك أفضل الأدوية والمستلزمات الطبية بجودة عالية وأسعار مناسبة. صحتك أولويتنا.'
            : 'PharmaCare Pharmacy — We provide the best medicines and medical supplies with high quality and affordable prices.' }}
        </p>
        <div class="footer-social">
          <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-tiktok"></i></a>
        </div>
      </div>

      {{-- QUICK LINKS --}}
      <div class="footer-col">
        <h4 class="footer-title">{{ app()->getLocale()==='ar'?'روابط سريعة':'Quick Links' }}</h4>
        <ul class="footer-links">
          <li><a href="{{ route('home') }}"><i class="fas fa-chevron-left"></i> {{ app()->getLocale()==='ar'?'الرئيسية':'Home' }}</a></li>
          <li><a href="{{ route('shop') }}"><i class="fas fa-chevron-left"></i> {{ app()->getLocale()==='ar'?'المتجر':'Shop' }}</a></li>
          <li><a href="{{ route('prescriptions.create') }}"><i class="fas fa-chevron-left"></i> {{ __('main.upload_prescription') }}</a></li>
          @auth
          <li><a href="{{ route('account.dashboard') }}"><i class="fas fa-chevron-left"></i> {{ __('main.my_account') }}</a></li>
          <li><a href="{{ route('subscriptions.index') }}"><i class="fas fa-chevron-left"></i> {{ __('main.subscriptions') }}</a></li>
          @else
          <li><a href="{{ route('login') }}"><i class="fas fa-chevron-left"></i> {{ __('main.login') }}</a></li>
          <li><a href="{{ route('register') }}"><i class="fas fa-chevron-left"></i> {{ __('main.register') }}</a></li>
          @endauth
        </ul>
      </div>

      {{-- CONTACT --}}
      <div class="footer-col">
        <h4 class="footer-title">{{ app()->getLocale()==='ar'?'تواصل معنا':'Contact Us' }}</h4>
        <ul class="footer-contact">
          <li>
            <i class="fas fa-map-marker-alt"></i>
            <span>{{ app()->getLocale()==='ar'?'شارع التحرير، وسط البلد، القاهرة':'Tahrir St., Downtown, Cairo' }}</span>
          </li>
          <li>
            <i class="fas fa-phone-alt"></i>
            <a href="tel:+201000000000">01000000000</a>
          </li>
          <li>
            <i class="fas fa-envelope"></i>
            <a href="mailto:info@pharmacare.com">info@pharmacare.com</a>
          </li>
          <li>
            <i class="fas fa-clock"></i>
            <span>{{ app()->getLocale()==='ar'?'السبت – الخميس: ٩ص – ١١م':'Sat – Thu: 9AM – 11PM' }}</span>
          </li>
          <li>
            <i class="fab fa-whatsapp" style="color:#25D366"></i>
            <a href="https://wa.me/201000000000" target="_blank">WhatsApp</a>
          </li>
        </ul>
      </div>

      {{-- WORKING HOURS + APP --}}
      <div class="footer-col">
        <h4 class="footer-title">{{ app()->getLocale()==='ar'?'خدماتنا':'Our Services' }}</h4>
        <ul class="footer-links">
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> {{ app()->getLocale()==='ar'?'توصيل سريع لباب البيت':'Fast Home Delivery' }}</li>
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> {{ app()->getLocale()==='ar'?'صرف الروشيتات الطبية':'Prescription Dispensing' }}</li>
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> {{ app()->getLocale()==='ar'?'اشتراك شهري للأدوية':'Monthly Medicine Subscription' }}</li>
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> {{ app()->getLocale()==='ar'?'استشارة صيدلانية مجانية':'Free Pharmacist Consultation' }}</li>
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> {{ app()->getLocale()==='ar'?'منتجات أصلية 100%':'100% Authentic Products' }}</li>
        </ul>
      </div>

    </div>

    <div class="footer-bottom">
      <span>© {{ date('Y') }} {{ app()->getLocale()==='ar'?'فارماكير — جميع الحقوق محفوظة':'PharmaCare — All Rights Reserved' }}</span>
      <span>{{ app()->getLocale()==='ar'?'مرخصة من وزارة الصحة':'Licensed by Ministry of Health' }} <i class="fas fa-shield-alt" style="color:var(--primary-light)"></i></span>
    </div>
  </div>
</footer>
