<?php $__env->startSection('title', app()->getLocale()==='ar'?'الطلبات':'Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-layout">
  <?php echo $__env->make('admin._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-shopping-bag"></i> <?php echo e(app()->getLocale()==='ar'?'الطلبات':'Orders'); ?></h1>
    </div>
    <div class="admin-content">
      <form method="GET" style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control" style="max-width:240px" placeholder="<?php echo e(app()->getLocale()==='ar'?'رقم الطلب أو اسم العميل...':'Order # or customer...'); ?>">
        <select name="status" class="form-select" style="max-width:180px">
          <option value=""><?php echo e(app()->getLocale()==='ar'?'كل الحالات':'All Status'); ?></option>
          <?php $__currentLoopData = ['pending','confirmed','preparing','shipped','delivered','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($s); ?>" <?php echo e(request('status')===$s?'selected':''); ?>><?php echo e($s); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn btn-primary"><?php echo e(app()->getLocale()==='ar'?'بحث':'Search'); ?></button>
      </form>

      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th><?php echo e(app()->getLocale()==='ar'?'رقم الطلب':'Order #'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'العميل':'Customer'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'الإجمالي':'Total'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'الحالة':'Status'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'التاريخ':'Date'); ?></th>
            <th></th>
          </tr></thead>
          <tbody>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td style="font-weight:700;font-family:monospace"><a href="<?php echo e(route('admin.orders.show',$order)); ?>" style="color:var(--primary)"><?php echo e($order->order_number); ?></a></td>
              <td>
                <div style="font-weight:600"><?php echo e($order->user->name); ?></div>
                <div style="font-size:12px;color:var(--text-muted)"><?php echo e($order->user->phone); ?></div>
              </td>
              <td style="font-weight:700"><?php echo e(number_format($order->total,2)); ?> <?php echo e(__('main.sar')); ?></td>
              <td>
                <?php $cls=['pending'=>'badge-orange','confirmed'=>'badge-blue','preparing'=>'badge-blue','shipped'=>'badge-blue','delivered'=>'badge-green','cancelled'=>'badge-red']; ?>
                <span class="badge <?php echo e($cls[$order->status]??'badge-gray'); ?>"><?php echo e($order->status_label[app()->getLocale()]); ?></span>
              </td>
              <td style="font-size:13px"><?php echo e($order->created_at->format('d/m/Y')); ?></td>
              <td><a href="<?php echo e(route('admin.orders.show',$order)); ?>" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <div style="padding:16px"><?php echo e($orders->links()); ?></div>
      </div>
    </div>
  </main>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>