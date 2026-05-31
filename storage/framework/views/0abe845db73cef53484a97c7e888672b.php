<?php $__env->startSection('title', isset($product) ? (app()->getLocale()==='ar'?'تعديل منتج':'Edit Product') : (app()->getLocale()==='ar'?'منتج جديد':'New Product')); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-layout">
  <?php echo $__env->make('admin._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <div style="display:flex;align-items:center;gap:12px;">
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        <h1 style="font-size:20px;font-weight:800">
          <?php echo e(isset($product) ? (app()->getLocale()==='ar'?'تعديل: ':'Edit: ').$product->name_ar : (app()->getLocale()==='ar'?'منتج جديد':'New Product')); ?>

        </h1>
      </div>
    </div>
    <div class="admin-content">

      <?php if(session('success')): ?>
        <div class="alert" style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--success)">
          <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
      <?php endif; ?>

      <form action="<?php echo e(isset($product) ? route('admin.products.update',$product) : route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if(isset($product)): ?> <?php echo method_field('PATCH'); ?> <?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start;">

          
          <div>
            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-language"></i> <?php echo e(app()->getLocale()==='ar'?'الأسماء':'Names'); ?></div>
              <div class="form-group">
                <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'الاسم بالعربية':'Name (Arabic)'); ?> *</label>
                <input type="text" name="name_ar" class="form-control <?php $__errorArgs = ['name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                  value="<?php echo e(old('name_ar', $product->name_ar ?? '')); ?>">
                <?php $__errorArgs = ['name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
              <div class="form-group">
                <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'الاسم بالإنجليزية':'Name (English)'); ?> *</label>
                <input type="text" name="name_en" class="form-control <?php $__errorArgs = ['name_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                  value="<?php echo e(old('name_en', $product->name_en ?? '')); ?>">
                <?php $__errorArgs = ['name_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
              <div class="form-group">
                <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'القسم':'Category'); ?> *</label>
                <select name="category_id" class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                  <option value=""><?php echo e(app()->getLocale()==='ar'?'اختر قسماً...':'Select category...'); ?></option>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : ''); ?>>
                      <?php echo e($cat->name_ar); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
              <div class="form-group">
                <label class="form-label"><?php echo e(__('main.active_ingredient')); ?></label>
                <input type="text" name="active_ingredient" class="form-control"
                  value="<?php echo e(old('active_ingredient', $product->active_ingredient ?? '')); ?>">
              </div>
              <div class="form-group">
                <label class="form-label"><?php echo e(__('main.manufacturer')); ?></label>
                <input type="text" name="manufacturer" class="form-control"
                  value="<?php echo e(old('manufacturer', $product->manufacturer ?? '')); ?>">
              </div>
              <div class="form-group">
                <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'الباركود':'Barcode'); ?></label>
                <input type="text" name="barcode" class="form-control"
                  value="<?php echo e(old('barcode', $product->barcode ?? '')); ?>">
              </div>
            </div>

            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-align-right"></i> <?php echo e(app()->getLocale()==='ar'?'الوصف':'Description'); ?></div>
              <div class="form-group">
                <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'وصف عربي':'Description (Arabic)'); ?></label>
                <textarea name="description_ar" class="form-control" rows="3"><?php echo e(old('description_ar', $product->description_ar ?? '')); ?></textarea>
              </div>
              <div class="form-group">
                <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'وصف إنجليزي':'Description (English)'); ?></label>
                <textarea name="description_en" class="form-control" rows="3"><?php echo e(old('description_en', $product->description_en ?? '')); ?></textarea>
              </div>
            </div>
          </div>

          
          <div>
            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-pound-sign"></i> <?php echo e(app()->getLocale()==='ar'?'التسعير والمخزون':'Pricing & Stock'); ?></div>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div class="form-group">
                  <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'السعر':'Price'); ?> *</label>
                  <input type="number" step="0.01" name="price" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('price', $product->price ?? '')); ?>">
                  <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                  <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'سعر الخصم':'Sale Price'); ?></label>
                  <input type="number" step="0.01" name="sale_price" class="form-control"
                    value="<?php echo e(old('sale_price', $product->sale_price ?? '')); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'المخزون':'Stock'); ?> *</label>
                  <input type="number" name="stock" class="form-control <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('stock', $product->stock ?? '0')); ?>">
                  <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                  <label class="form-label"><?php echo e(app()->getLocale()==='ar'?'حد التنبيه':'Alert At'); ?></label>
                  <input type="number" name="min_stock_alert" class="form-control"
                    value="<?php echo e(old('min_stock_alert', $product->min_stock_alert ?? '10')); ?>">
                </div>
              </div>
            </div>

            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-capsules"></i> <?php echo e(app()->getLocale()==='ar'?'التفاصيل الصيدلانية':'Pharmaceutical Details'); ?></div>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div class="form-group">
                  <label class="form-label"><?php echo e(__('main.dosage_form')); ?></label>
                  <select name="dosage_form" class="form-select">
                    <option value=""><?php echo e(app()->getLocale()==='ar'?'اختر...':'Select...'); ?></option>
                    <?php $__currentLoopData = ['Tablet','Capsule','Syrup','Injection','Cream','Drops','Spray','Suppository']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($form); ?>" <?php echo e(old('dosage_form', $product->dosage_form ?? '') == $form ? 'selected' : ''); ?>><?php echo e($form); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label"><?php echo e(__('main.strength')); ?></label>
                  <input type="text" name="strength" class="form-control" placeholder="500mg"
                    value="<?php echo e(old('strength', $product->strength ?? '')); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label"><?php echo e(__('main.package_size')); ?></label>
                  <input type="text" name="package_size" class="form-control" placeholder="20 tablets"
                    value="<?php echo e(old('package_size', $product->package_size ?? '')); ?>">
                </div>
              </div>
            </div>

            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-cog"></i> <?php echo e(app()->getLocale()==='ar'?'الإعدادات':'Settings'); ?></div>
              <div style="display:grid;gap:12px">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                  <input type="hidden" name="requires_prescription" value="0">
                  <input type="checkbox" name="requires_prescription" value="1" <?php echo e(old('requires_prescription', $product->requires_prescription ?? false) ? 'checked' : ''); ?>>
                  <span><?php echo e(app()->getLocale()==='ar'?'يستلزم روشيتة طبية':'Requires Prescription'); ?></span>
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                  <input type="hidden" name="is_featured" value="0">
                  <input type="checkbox" name="is_featured" value="1" <?php echo e(old('is_featured', $product->is_featured ?? false) ? 'checked' : ''); ?>>
                  <span><?php echo e(app()->getLocale()==='ar'?'منتج مميز':'Featured Product'); ?></span>
                </label>
                <?php if(isset($product)): ?>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                  <input type="hidden" name="is_active" value="0">
                  <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $product->is_active ?? true) ? 'checked' : ''); ?>>
                  <span><?php echo e(app()->getLocale()==='ar'?'منتج نشط':'Active Product'); ?></span>
                </label>
                <?php endif; ?>
              </div>
            </div>

            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-image"></i> <?php echo e(app()->getLocale()==='ar'?'صورة المنتج':'Product Image'); ?></div>
              <?php if(isset($product) && $product->image): ?>
                <img src="<?php echo e(asset('storage/'.$product->image)); ?>" style="max-width:120px;border-radius:8px;margin-bottom:12px">
              <?php endif; ?>
              <input type="file" name="image" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
              <div class="form-text">JPG, PNG — Max 2MB</div>
              <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">
              <i class="fas fa-save"></i>
              <?php echo e(isset($product) ? __('main.save') : (app()->getLocale()==='ar'?'إنشاء المنتج':'Create Product')); ?>

            </button>
          </div>
        </div>
      </form>
    </div>
  </main>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/admin/products/form.blade.php ENDPATH**/ ?>