<?php $__env->startSection('title', app()->getLocale()==='ar'?'إدارة المنتجات':'Manage Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-layout">
  <?php echo $__env->make('admin._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-pills"></i> <?php echo e(app()->getLocale()==='ar'?'المنتجات':'Products'); ?></h1>
      <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <?php echo e(app()->getLocale()==='ar'?'منتج جديد':'New Product'); ?></a>
    </div>
    <div class="admin-content">

      
      <form method="GET" style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;">
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control" style="max-width:280px" placeholder="<?php echo e(app()->getLocale()==='ar'?'بحث بالاسم أو المادة الفعالة...':'Search name or ingredient...'); ?>">
        <select name="category" class="form-select" style="max-width:200px">
          <option value=""><?php echo e(app()->getLocale()==='ar'?'كل الأقسام':'All Categories'); ?></option>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category')==$cat->id?'selected':''); ?>><?php echo e($cat->name_ar); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="stock" class="form-select" style="max-width:180px">
          <option value=""><?php echo e(app()->getLocale()==='ar'?'كل المخزون':'All Stock'); ?></option>
          <option value="low" <?php echo e(request('stock')==='low'?'selected':''); ?>><?php echo e(app()->getLocale()==='ar'?'مخزون منخفض':'Low Stock'); ?></option>
        </select>
        <button class="btn btn-primary"><?php echo e(app()->getLocale()==='ar'?'بحث':'Search'); ?></button>
        <?php if(request()->hasAny(['q','category','stock'])): ?>
          <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline"><?php echo e(app()->getLocale()==='ar'?'مسح':'Clear'); ?></a>
        <?php endif; ?>
      </form>

      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th><?php echo e(app()->getLocale()==='ar'?'المنتج':'Product'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'المادة الفعالة':'Ingredient'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'السعر':'Price'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'المخزون':'Stock'); ?></th>
            <th>Rx</th>
            <th><?php echo e(app()->getLocale()==='ar'?'الحالة':'Status'); ?></th>
            <th></th>
          </tr></thead>
          <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <?php if($p->image): ?>
                    <img src="<?php echo e(asset('storage/'.$p->image)); ?>" style="width:40px;height:40px;object-fit:cover;border-radius:8px">
                  <?php else: ?>
                    <div style="width:40px;height:40px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary)"><i class="fas fa-pills"></i></div>
                  <?php endif; ?>
                  <div>
                    <div style="font-weight:700;font-size:14px"><?php echo e($p->name_ar); ?></div>
                    <div style="font-size:12px;color:var(--text-muted)"><?php echo e($p->category->name_ar); ?></div>
                  </div>
                </div>
              </td>
              <td style="font-size:13px;color:var(--info)"><?php echo e($p->active_ingredient ?: '—'); ?></td>
              <td>
                <span style="font-weight:700"><?php echo e(number_format($p->current_price,2)); ?></span>
                <?php if($p->sale_price): ?><span style="font-size:12px;color:var(--text-muted);text-decoration:line-through;margin-start:4px"><?php echo e(number_format($p->price,2)); ?></span><?php endif; ?>
              </td>
              <td>
                <span class="<?php echo e($p->isLowStock() ? 'expiry-danger' : ''); ?>" style="font-weight:700"><?php echo e($p->stock); ?></span>
                <?php if($p->isLowStock()): ?><span class="badge badge-red" style="font-size:11px;margin-start:4px"><?php echo e(app()->getLocale()==='ar'?'منخفض':'Low'); ?></span><?php endif; ?>
              </td>
              <td>
                <?php if($p->requires_prescription): ?>
                  <span class="badge badge-blue">Rx</span>
                <?php else: ?>
                  <span class="badge badge-green">OTC</span>
                <?php endif; ?>
              </td>
              <td><span class="badge <?php echo e($p->is_active?'badge-green':'badge-gray'); ?>"><?php echo e($p->is_active?'Active':'Inactive'); ?></span></td>
              <td>
                <div style="display:flex;gap:6px">
                  <a href="<?php echo e(route('admin.products.analytics',$p)); ?>" class="btn btn-outline btn-sm" title="<?php echo e(app()->getLocale()==='ar'?'تحليل':'Analytics'); ?>"><i class="fas fa-chart-bar"></i></a><a href="<?php echo e(route('admin.products.edit',$p)); ?>" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
                  <a href="<?php echo e(route('admin.products.expiry',$p)); ?>" class="btn btn-outline btn-sm" title="<?php echo e(app()->getLocale()==='ar'?'الصلاحية':'Expiry'); ?>"><i class="fas fa-calendar-times"></i></a>
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <div style="padding:16px"><?php echo e($products->links()); ?></div>
      </div>
    </div>
  </main>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/admin/products/index.blade.php ENDPATH**/ ?>