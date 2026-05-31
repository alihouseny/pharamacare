<?php $__env->startSection('title', app()->getLocale()==='ar'?'إدارة المستخدمين':'Users Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-layout">
  <?php echo $__env->make('admin._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:900"><i class="fas fa-users"></i> <?php echo e(app()->getLocale()==='ar'?'إدارة المستخدمين':'Users Management'); ?></h1>
    </div>
    <div class="admin-content">

      <?php if(session('success')): ?>
        <div style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--success)">
          <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
      <?php endif; ?>
      <?php if(session('error')): ?>
        <div style="background:#FFEBEE;border:1.5px solid var(--danger);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--danger)">
          <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

        </div>
      <?php endif; ?>

      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th><?php echo e(app()->getLocale()==='ar'?'المستخدم':'User'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'البريد الإلكتروني':'Email'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'الهاتف':'Phone'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'الطلبات':'Orders'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'الدور الحالي':'Current Role'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'تغيير الدور':'Change Role'); ?></th>
            <th><?php echo e(app()->getLocale()==='ar'?'تاريخ التسجيل':'Joined'); ?></th>
          </tr></thead>
          <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td>
                <div style="font-weight:700"><?php echo e($user->name); ?></div>
                <?php if($user->id === auth()->id()): ?>
                  <span style="font-size:11px;color:var(--text-muted)">(<?php echo e(app()->getLocale()==='ar'?'أنت':'You'); ?>)</span>
                <?php endif; ?>
              </td>
              <td style="font-size:13px"><?php echo e($user->email); ?></td>
              <td style="font-size:13px"><?php echo e($user->phone ?? '—'); ?></td>
              <td style="font-weight:700;text-align:center"><?php echo e($user->orders_count); ?></td>
              <td>
                <?php $roleColors = ['admin'=>'badge-red','pharmacist'=>'badge-blue','customer'=>'badge-green']; ?>
                <span class="badge <?php echo e($roleColors[$user->role]??'badge-gray'); ?>">
                  <?php echo e(['admin'=>'أدمن','pharmacist'=>'صيدلاني','customer'=>'عميل'][$user->role] ?? $user->role); ?>

                </span>
              </td>
              <td>
                <?php if($user->id !== auth()->id()): ?>
                <form action="<?php echo e(route('admin.users.role',$user)); ?>" method="POST" style="display:flex;gap:6px;align-items:center">
                  <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                  <select name="role" class="form-select" style="font-size:13px;padding:5px 10px;min-width:120px">
                    <option value="customer" <?php echo e($user->role==='customer'?'selected':''); ?>><?php echo e(app()->getLocale()==='ar'?'عميل':'Customer'); ?></option>
                    <option value="pharmacist" <?php echo e($user->role==='pharmacist'?'selected':''); ?>><?php echo e(app()->getLocale()==='ar'?'صيدلاني':'Pharmacist'); ?></option>
                    <option value="admin" <?php echo e($user->role==='admin'?'selected':''); ?>><?php echo e(app()->getLocale()==='ar'?'أدمن':'Admin'); ?></option>
                  </select>
                  <button type="submit" class="btn btn-primary btn-sm"><?php echo e(__('main.save')); ?></button>
                </form>
                <?php else: ?>
                  <span style="font-size:12px;color:var(--text-muted)">—</span>
                <?php endif; ?>
              </td>
              <td style="font-size:13px;color:var(--text-muted)"><?php echo e($user->created_at->format('d/m/Y')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <div style="padding:16px"><?php echo e($users->links()); ?></div>
      </div>

    </div>
  </main>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/admin/users/index.blade.php ENDPATH**/ ?>