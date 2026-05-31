<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">

      
      <div class="footer-col footer-brand">
        <div class="footer-logo">
          <div class="logo-icon"><i class="fas fa-capsules"></i></div>
          <div>
            <div style="font-size:20px;font-weight:900;color:#fff"><?php echo e(app()->getLocale()==='ar'?'فارماكير':'PharmaCare'); ?></div>
            <div style="font-size:12px;color:rgba(255,255,255,.6)"><?php echo e(app()->getLocale()==='ar'?'صحتك تبدأ هنا':'Your Health Starts Here'); ?></div>
          </div>
        </div>
        <p class="footer-desc">
          <?php echo e(app()->getLocale()==='ar'
            ? 'صيدلية فارماكير — نقدم لك أفضل الأدوية والمستلزمات الطبية بجودة عالية وأسعار مناسبة. صحتك أولويتنا.'
            : 'PharmaCare Pharmacy — We provide the best medicines and medical supplies with high quality and affordable prices.'); ?>

        </p>
        <div class="footer-social">
          <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-tiktok"></i></a>
        </div>
      </div>

      
      <div class="footer-col">
        <h4 class="footer-title"><?php echo e(app()->getLocale()==='ar'?'روابط سريعة':'Quick Links'); ?></h4>
        <ul class="footer-links">
          <li><a href="<?php echo e(route('home')); ?>"><i class="fas fa-chevron-left"></i> <?php echo e(app()->getLocale()==='ar'?'الرئيسية':'Home'); ?></a></li>
          <li><a href="<?php echo e(route('shop')); ?>"><i class="fas fa-chevron-left"></i> <?php echo e(app()->getLocale()==='ar'?'المتجر':'Shop'); ?></a></li>
          <li><a href="<?php echo e(route('prescriptions.create')); ?>"><i class="fas fa-chevron-left"></i> <?php echo e(__('main.upload_prescription')); ?></a></li>
          <?php if(auth()->guard()->check()): ?>
          <li><a href="<?php echo e(route('account.dashboard')); ?>"><i class="fas fa-chevron-left"></i> <?php echo e(__('main.my_account')); ?></a></li>
          <li><a href="<?php echo e(route('subscriptions.index')); ?>"><i class="fas fa-chevron-left"></i> <?php echo e(__('main.subscriptions')); ?></a></li>
          <?php else: ?>
          <li><a href="<?php echo e(route('login')); ?>"><i class="fas fa-chevron-left"></i> <?php echo e(__('main.login')); ?></a></li>
          <li><a href="<?php echo e(route('register')); ?>"><i class="fas fa-chevron-left"></i> <?php echo e(__('main.register')); ?></a></li>
          <?php endif; ?>
        </ul>
      </div>

      
      <div class="footer-col">
        <h4 class="footer-title"><?php echo e(app()->getLocale()==='ar'?'تواصل معنا':'Contact Us'); ?></h4>
        <ul class="footer-contact">
          <li>
            <i class="fas fa-map-marker-alt"></i>
            <span><?php echo e(app()->getLocale()==='ar'?'شارع التحرير، وسط البلد، القاهرة':'Tahrir St., Downtown, Cairo'); ?></span>
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
            <span><?php echo e(app()->getLocale()==='ar'?'السبت – الخميس: ٩ص – ١١م':'Sat – Thu: 9AM – 11PM'); ?></span>
          </li>
          <li>
            <i class="fab fa-whatsapp" style="color:#25D366"></i>
            <a href="https://wa.me/201000000000" target="_blank">WhatsApp</a>
          </li>
        </ul>
      </div>

      
      <div class="footer-col">
        <h4 class="footer-title"><?php echo e(app()->getLocale()==='ar'?'خدماتنا':'Our Services'); ?></h4>
        <ul class="footer-links">
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> <?php echo e(app()->getLocale()==='ar'?'توصيل سريع لباب البيت':'Fast Home Delivery'); ?></li>
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> <?php echo e(app()->getLocale()==='ar'?'صرف الروشيتات الطبية':'Prescription Dispensing'); ?></li>
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> <?php echo e(app()->getLocale()==='ar'?'اشتراك شهري للأدوية':'Monthly Medicine Subscription'); ?></li>
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> <?php echo e(app()->getLocale()==='ar'?'استشارة صيدلانية مجانية':'Free Pharmacist Consultation'); ?></li>
          <li><i class="fas fa-check-circle" style="color:var(--primary-light)"></i> <?php echo e(app()->getLocale()==='ar'?'منتجات أصلية 100%':'100% Authentic Products'); ?></li>
        </ul>
      </div>

    </div>

    <div class="footer-bottom">
      <span>© <?php echo e(date('Y')); ?> <?php echo e(app()->getLocale()==='ar'?'فارماكير — جميع الحقوق محفوظة':'PharmaCare — All Rights Reserved'); ?></span>
      <span><?php echo e(app()->getLocale()==='ar'?'مرخصة من وزارة الصحة':'Licensed by Ministry of Health'); ?> <i class="fas fa-shield-alt" style="color:var(--primary-light)"></i></span>
    </div>
  </div>
</footer>
<?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/layouts/footer.blade.php ENDPATH**/ ?>