<?php $__env->startSection('title', app()->getLocale()==='ar'?'الرئيسية':'Home'); ?>

<?php $__env->startSection('content'); ?>


<section class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-badge"><i class="fas fa-shield-alt"></i> <?php echo e(app()->getLocale()==='ar'?'موثوق ومعتمد':'Trusted & Certified'); ?></div>
      <h1><?php echo e(app()->getLocale()==='ar'?'صحتك تبدأ من هنا':'Your Health Starts Here'); ?></h1>
      <p><?php echo e(app()->getLocale()==='ar'?'أدوية أصلية، عناية متكاملة، توصيل سريع لباب بيتك':'Authentic medicines, complete care, fast delivery to your door'); ?></p>
      <div class="hero-actions">
        <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary btn-lg">
          <i class="fas fa-pills"></i> <?php echo e(app()->getLocale()==='ar'?'تسوق الآن':'Shop Now'); ?>

        </a>
        <?php if(auth()->guard()->check()): ?>
          <a href="<?php echo e(route('prescriptions.create')); ?>" class="btn btn-outline-light btn-lg">
            <i class="fas fa-file-prescription"></i> <?php echo e(__('main.upload_prescription')); ?>

          </a>
        <?php else: ?>
          <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-light btn-lg">
            <i class="fas fa-user-plus"></i> <?php echo e(__('main.register')); ?>

          </a>
        <?php endif; ?>
      </div>
      <div class="hero-stats">
        <div><strong>+1000</strong><span><?php echo e(app()->getLocale()==='ar'?'منتج':'Products'); ?></span></div>
        <div><strong>24/7</strong><span><?php echo e(app()->getLocale()==='ar'?'دعم':'Support'); ?></span></div>
        <div><strong>100%</strong><span><?php echo e(app()->getLocale()==='ar'?'أصلي':'Authentic'); ?></span></div>
      </div>
    </div>
    <div class="hero-image" style="display:flex;align-items:center;justify-content:center">
      <div style="position:relative;width:280px;height:280px">
        
        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center">
          <div style="width:120px;height:120px;background:rgba(255,255,255,.18);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:54px;backdrop-filter:blur(4px)">
            💊
          </div>
        </div>
        
        <div style="position:absolute;top:10px;left:50%;transform:translateX(-50%);width:60px;height:60px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;animation:float 3s ease-in-out infinite">❤️</div>
        <div style="position:absolute;bottom:10px;left:50%;transform:translateX(-50%);width:56px;height:56px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;animation:float 3s ease-in-out infinite .8s">🩺</div>
        <div style="position:absolute;top:50%;left:10px;transform:translateY(-50%);width:52px;height:52px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;animation:float 3s ease-in-out infinite 1.4s">🔬</div>
        <div style="position:absolute;top:50%;right:10px;transform:translateY(-50%);width:52px;height:52px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;animation:float 3s ease-in-out infinite 2s">💉</div>
      </div>
    </div>
  </div>
</section>

<div class="container" style="padding-bottom:60px">

  
  <?php if($categories->count()): ?>
  <section style="margin-top:48px">
    <div class="section-header">
      <h2 class="section-title"><?php echo e(app()->getLocale()==='ar'?'تصفح الأقسام':'Browse Categories'); ?></h2>
    </div>
    <div class="cats-grid">
      <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(route('shop', ['category' => $cat->slug])); ?>" class="cat-card">
        <div class="cat-icon"><?php echo e($cat->icon ?? '💊'); ?></div>
        <h4><?php echo e($cat->name); ?></h4>
        <?php if($cat->products_count ?? null): ?>
          <span><?php echo e($cat->products_count); ?> <?php echo e(app()->getLocale()==='ar'?'منتج':'items'); ?></span>
        <?php endif; ?>
      </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
  <?php endif; ?>

  
  <?php if($featured->count()): ?>
  <section style="margin-top:56px">
    <div class="section-header">
      <h2 class="section-title"><?php echo e(app()->getLocale()==='ar'?'منتجات مميزة':'Featured Products'); ?></h2>
      <a href="<?php echo e(route('shop', ['filter' => 'featured'])); ?>" class="view-all"><?php echo e(__('main.view_all')); ?> ←</a>
    </div>
    <div class="products-grid">
      <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('shop._product_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
  <?php endif; ?>

  
  <section style="margin-top:56px;background:linear-gradient(135deg,var(--primary-dark),var(--primary));border-radius:24px;padding:40px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:24px;color:#fff">
    <div>
      <div style="font-size:13px;font-weight:700;opacity:.8;margin-bottom:8px;text-transform:uppercase;letter-spacing:1px"><?php echo e(app()->getLocale()==='ar'?'اشتراك شهري':'Monthly Subscription'); ?></div>
      <h3 style="font-size:24px;font-weight:900;margin-bottom:8px"><?php echo e(app()->getLocale()==='ar'?'أدويتك كل شهر على باب بيتك':'Your medicines delivered monthly'); ?></h3>
      <p style="opacity:.85;font-size:15px"><?php echo e(app()->getLocale()==='ar'?'وفّر 10% على أدوية الأمراض المزمنة مع الاشتراك الشهري':'Save 10% on chronic disease medications with monthly subscription'); ?></p>
    </div>
    <a href="<?php echo e(route('subscriptions.index')); ?>" class="btn btn-white btn-lg">
      <i class="fas fa-sync-alt"></i> <?php echo e(app()->getLocale()==='ar'?'اشترك الآن':'Subscribe Now'); ?>

    </a>
  </section>

  
  <?php if($newArrivals->count()): ?>
  <section style="margin-top:56px">
    <div class="section-header">
      <h2 class="section-title"><?php echo e(app()->getLocale()==='ar'?'وصل حديثاً':'New Arrivals'); ?></h2>
      <a href="<?php echo e(route('shop')); ?>" class="view-all"><?php echo e(__('main.view_all')); ?> ←</a>
    </div>
    <div class="products-grid">
      <?php $__currentLoopData = $newArrivals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('shop._product_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
  <?php endif; ?>

  
  <?php if($onSale->count()): ?>
  <section style="margin-top:56px">
    <div class="section-header">
      <h2 class="section-title">🔥 <?php echo e(app()->getLocale()==='ar'?'عروض وتخفيضات':'Sales & Offers'); ?></h2>
      <a href="<?php echo e(route('shop', ['filter' => 'sale'])); ?>" class="view-all"><?php echo e(__('main.view_all')); ?> ←</a>
    </div>
    <div class="products-grid">
      <?php $__currentLoopData = $onSale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('shop._product_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
  <?php endif; ?>

  
  <section style="margin-top:56px;background:linear-gradient(135deg,#01579B,#0277BD);border-radius:24px;padding:36px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:24px;color:#fff">
    <div style="display:flex;align-items:center;gap:20px">
      <div style="font-size:52px">📋</div>
      <div>
        <h3 style="font-size:22px;font-weight:900;margin-bottom:6px"><?php echo e(app()->getLocale()==='ar'?'لديك روشيتة طبية؟':'Have a Prescription?'); ?></h3>
        <p style="opacity:.85;font-size:14px"><?php echo e(app()->getLocale()==='ar'?'ارفع روشيتتك وسنجهّز طلبك فوراً وتصلك في أسرع وقت':'Upload your prescription and we\'ll prepare your order immediately'); ?></p>
      </div>
    </div>
    <?php if(auth()->guard()->check()): ?>
      <a href="<?php echo e(route('prescriptions.create')); ?>" class="btn btn-white btn-lg">
        <i class="fas fa-upload"></i> <?php echo e(__('main.upload_prescription')); ?>

      </a>
    <?php else: ?>
      <a href="<?php echo e(route('login')); ?>" class="btn btn-white btn-lg">
        <i class="fas fa-sign-in-alt"></i> <?php echo e(__('main.login')); ?>

      </a>
    <?php endif; ?>
  </section>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/shop/home.blade.php ENDPATH**/ ?>