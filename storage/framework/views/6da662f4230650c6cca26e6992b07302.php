<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
  <h2 style="font-size:22px;font-weight:900;margin-bottom:24px;text-align:center">
    <?php echo e(app()->getLocale()==='ar'?'تسجيل الدخول':'Sign In'); ?>

  </h2>

  <?php if(session('status')): ?>
    <div class="alert alert-success" style="margin-bottom:16px;font-size:14px"><?php echo e(session('status')); ?></div>
  <?php endif; ?>

  <form method="POST" action="<?php echo e(route('login')); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group">
      <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'البريد الإلكتروني':'Email Address'); ?></label>
      <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username">
      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="form-group">
      <label class="form-label" style="display:flex;justify-content:space-between">
        <span><?php echo e(app()->getLocale()==='ar'?'كلمة المرور':'Password'); ?></span>
        <?php if(Route::has('password.request')): ?>
          <a href="<?php echo e(route('password.request')); ?>" style="font-size:13px;color:var(--primary);text-decoration:none">
            <?php echo e(app()->getLocale()==='ar'?'نسيت كلمة المرور؟':'Forgot password?'); ?>

          </a>
        <?php endif; ?>
      </label>
      <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        required autocomplete="current-password">
      <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px">
      <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;cursor:pointer">
      <label for="remember" style="font-size:14px;cursor:pointer;margin:0"><?php echo e(app()->getLocale()==='ar'?'تذكرني':'Remember me'); ?></label>
    </div>
    <button type="submit" class="btn btn-primary btn-block btn-lg">
      <i class="fas fa-sign-in-alt"></i> <?php echo e(app()->getLocale()==='ar'?'دخول':'Sign In'); ?>

    </button>
  </form>

  <p style="text-align:center;margin-top:20px;font-size:14px;color:var(--text-muted)">
    <?php echo e(app()->getLocale()==='ar'?'ليس لديك حساب؟':'Don\'t have an account?'); ?>

    <a href="<?php echo e(route('register')); ?>" style="color:var(--primary);font-weight:700;text-decoration:none">
      <?php echo e(app()->getLocale()==='ar'?'سجّل الآن':'Register'); ?>

    </a>
  </p>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/auth/login.blade.php ENDPATH**/ ?>