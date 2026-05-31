<?php $__env->startSection('title', app()->getLocale()==='ar'?'الرئيسية':'Home'); ?>

<?php $__env->startSection('content'); ?>


<section class="hero">
  <div class="hero-content">
    <div class="hero-badge"><i class="fas fa-shield-alt"></i> <?php echo e(app()->getLocale()==='ar'?'موثوق ومعتمد':'Trusted & Certified'); ?></div>
    <h1><?php echo e(app()->getLocale()==='ar'?'صحتك تبدأ من هنا':'Your Health Starts Here'); ?></h1>
    <p><?php echo e(app()->getLocale()==='ar'
      ? 'أدوية أصلية، عناية متكاملة، توصيل سريع لباب بيتك'
      : 'Authentic medicines, complete care, fast delivery to your door'); ?></p>
    <div class="hero-actions">
      <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary btn-lg">
        <i class="fas fa-pills"></i> <?php echo e(app()->getLocale()==='ar'?'تسوق الآن':'Shop Now'); ?>

      </a>
      <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('prescriptions.create')); ?>" class="btn btn-outline-light btn-lg">
          <i class="fas fa-file-prescription"></i> <?php echo e(__('main.upload_prescription')); ?>

        </a>
      <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-lg">
          <i class="fas fa-user"></i> <?php echo e(__('main.login')); ?>

        </a>
      <?php endif; ?>
    </div>
    <div class="hero-stats">
      <div><strong>+5000</strong><span><?php echo e(app()->getLocale()==='ar'?'منتج':'Products'); ?></span></div>
      <div><strong>24/7</strong><span><?php echo e(app()->getLocale()==='ar'?'دعم':'Support'); ?></span></div>
      <div><strong>100%</strong><span><?php echo e(app()->getLocale()==='ar'?'أصلي':'Authentic'); ?></span></div>
    </div>
  </div>
  <div class="hero-image">
    <div class="hero-circles">
      <div class="circle c1"><i class="fas fa-capsules"></i></div>
      <div class="circle c2"><i class="fas fa-heartbeat"></i></div>
      <div class="circle c3"><i class="fas fa-stethoscope"></i></div>
      <div class="circle c4"><i class="fas fa-syringe"></i></div>
    </div>
  </div>
</section>


<section class="section">
  <div class="container">
    <div class="section-header">
      <h2><?php echo e(app()->getLocale()==='ar'?'تصفح الأقسام':'Browse Categories'); ?></h2>
    </div>
    <div class="cat-grid">
      <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('shop', ['category' => $cat->slug])); ?>" class="cat-card">
          <div class="cat-icon"><?php echo e($cat->icon ?? '💊'); ?></div>
          <h4><?php echo e($cat->name); ?></h4>
          <span><?php echo e($cat->products_count ?? ''); ?></span>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<?php if($featured->count()): ?>
<section class="section bg-light-blue">
  <div class="container">
    <div class="section-header">
      <h2><?php echo e(app()->getLocale()==='ar'?'منتجات مميزة':'Featured Products'); ?></h2>
      <a href="<?php echo e(route('shop',['filter'=>'featured'])); ?>" class="view-all"><?php echo e(__('main.view_all')); ?></a>
    </div>
    <div class="product-grid">
      <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('shop._product_card', ['product' => $p], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>


<section class="rx-banner">
  <div class="container">
    <div class="rx-content">
      <div class="rx-icon"><i class="fas fa-file-prescription"></i></div>
      <div>
        <h3><?php echo e(app()->getLocale()==='ar'?'عندك روشيتة؟':'Got a Prescription?'); ?></h3>
        <p><?php echo e(app()->getLocale()==='ar'
          ? 'ارفع الروشيتة الطبية وسيقوم فريق الصيادلة بمراجعتها وتجهيز طلبك فوراً'
          : 'Upload your prescription and our pharmacists will review it and prepare your order right away'); ?></p>
      </div>
      <a href="<?php echo e(route('prescriptions.create')); ?>" class="btn btn-white">
        <?php echo e(__('main.upload_prescription')); ?>

      </a>
    </div>
  </div>
</section>


<?php if($newArrivals->count()): ?>
<section class="section">
  <div class="container">
    <div class="section-header">
      <h2><?php echo e(app()->getLocale()==='ar'?'وصل حديثاً':'New Arrivals'); ?></h2>
      <a href="<?php echo e(route('shop')); ?>" class="view-all"><?php echo e(__('main.view_all')); ?></a>
    </div>
    <div class="product-grid">
      <?php $__currentLoopData = $newArrivals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('shop._product_card', ['product' => $p], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>


<?php if($onSale->count()): ?>
<section class="section sale-section">
  <div class="container">
    <div class="section-header">
      <h2>🔥 <?php echo e(app()->getLocale()==='ar'?'عروض خاصة':'Special Deals'); ?></h2>
      <a href="<?php echo e(route('shop',['filter'=>'sale'])); ?>" class="view-all"><?php echo e(__('main.view_all')); ?></a>
    </div>
    <div class="product-grid">
      <?php $__currentLoopData = $onSale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('shop._product_card', ['product' => $p], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>


<section class="subscription-cta">
  <div class="container">
    <div class="sub-cta-inner">
      <div>
        <span class="badge-pill"><?php echo e(app()->getLocale()==='ar'?'جديد':'New'); ?></span>
        <h2><?php echo e(app()->getLocale()==='ar'?'اشتراك الأدوية الشهري':'Monthly Medicine Subscription'); ?></h2>
        <p><?php echo e(app()->getLocale()==='ar'
          ? 'اشترك واستلم أدويتك المزمنة تلقائياً كل شهر بسعر خاص وتوصيل مجاني'
          : 'Subscribe and receive your chronic medicines automatically every month at a special price with free delivery'); ?></p>
        <ul class="sub-features">
          <li><i class="fas fa-check"></i> <?php echo e(app()->getLocale()==='ar'?'توصيل أوتوماتيكي':'Automatic delivery'); ?></li>
          <li><i class="fas fa-check"></i> <?php echo e(app()->getLocale()==='ar'?'خصم 10% على كل طلب':'10% off every order'); ?></li>
          <li><i class="fas fa-check"></i> <?php echo e(app()->getLocale()==='ar'?'إلغاء في أي وقت':'Cancel anytime'); ?></li>
        </ul>
        <a href="<?php echo e(route('subscriptions.index')); ?>" class="btn btn-primary">
          <?php echo e(__('main.subscribe_now')); ?>

        </a>
      </div>
      <div class="sub-cta-img">
        <i class="fas fa-sync-alt"></i>
      </div>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/shop/home.blade.php ENDPATH**/ ?>