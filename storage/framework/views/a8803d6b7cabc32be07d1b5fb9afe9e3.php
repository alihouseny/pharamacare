<?php $__env->startSection('title', $activeCategory ? $activeCategory->name : __('main.shop')); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="padding:32px 20px;">
  <div style="display:flex;gap:28px;align-items:flex-start;">

    
    <aside style="width:220px;flex-shrink:0;position:sticky;top:90px;">
      <div class="card" style="padding:20px;">
        <div style="font-size:15px;font-weight:800;margin-bottom:16px;">
          <i class="fas fa-filter" style="color:var(--primary)"></i>
          <?php echo e(app()->getLocale()==='ar'?'تصفية النتائج':'Filter'); ?>

        </div>

        <div style="margin-bottom:16px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px">
            <?php echo e(app()->getLocale()==='ar'?'القسم':'Category'); ?>

          </div>
          <a href="<?php echo e(route('shop')); ?>" class="filter-link <?php echo e(!request('category') ? 'active' : ''); ?>">
            <?php echo e(app()->getLocale()==='ar'?'جميع المنتجات':'All Products'); ?>

          </a>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('shop',['category'=>$cat->slug])); ?>" class="filter-link <?php echo e(request('category')===$cat->slug ? 'active' : ''); ?>">
              <?php echo e($cat->icon ?? '💊'); ?> <?php echo e($cat->name); ?>

            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div>
          <div style="font-size:12px;font-weight:700;color:var(--text-muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px">
            <?php echo e(app()->getLocale()==='ar'?'النوع':'Type'); ?>

          </div>
          <a href="<?php echo e(route('shop',array_merge(request()->query(), ['filter'=>'otc']))); ?>" class="filter-link <?php echo e(request('filter')==='otc'?'active':''); ?>">
            <i class="fas fa-check-circle" style="color:var(--success)"></i> <?php echo e(app()->getLocale()==='ar'?'بدون روشيتة':'Without Rx'); ?>

          </a>
          <a href="<?php echo e(route('shop',array_merge(request()->query(), ['filter'=>'rx']))); ?>" class="filter-link <?php echo e(request('filter')==='rx'?'active':''); ?>">
            <i class="fas fa-prescription" style="color:var(--info)"></i> <?php echo e(app()->getLocale()==='ar'?'يستلزم روشيتة':'Requires Rx'); ?>

          </a>
          <a href="<?php echo e(route('shop',array_merge(request()->query(), ['filter'=>'sale']))); ?>" class="filter-link <?php echo e(request('filter')==='sale'?'active':''); ?>">
            🔥 <?php echo e(app()->getLocale()==='ar'?'عروض':'On Sale'); ?>

          </a>
          <a href="<?php echo e(route('shop',array_merge(request()->query(), ['filter'=>'featured']))); ?>" class="filter-link <?php echo e(request('filter')==='featured'?'active':''); ?>">
            ⭐ <?php echo e(app()->getLocale()==='ar'?'مميزة':'Featured'); ?>

          </a>
        </div>
      </div>
    </aside>

    
    <div style="flex:1;min-width:0;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
        <div>
          <h1 style="font-size:20px;font-weight:900;">
            <?php echo e($activeCategory ? $activeCategory->name : (app()->getLocale()==='ar'?'جميع المنتجات':'All Products')); ?>

          </h1>
          <div style="font-size:13px;color:var(--text-muted)"><?php echo e($products->total()); ?> <?php echo e(app()->getLocale()==='ar'?'منتج':'products'); ?></div>
        </div>
        <form action="<?php echo e(route('shop')); ?>" method="GET" style="display:flex;gap:8px;flex-wrap:wrap">
          <?php if(request('category')): ?><input type="hidden" name="category" value="<?php echo e(request('category')); ?>"><?php endif; ?>
          <?php if(request('filter')): ?><input type="hidden" name="filter" value="<?php echo e(request('filter')); ?>"><?php endif; ?>
          <select name="sort" class="form-select" style="font-size:13px;padding:6px 12px" onchange="this.form.submit()">
            <option value="" <?php echo e(!request('sort')?'selected':''); ?>><?php echo e(app()->getLocale()==='ar'?'الأحدث':'Latest'); ?></option>
            <option value="price_asc" <?php echo e(request('sort')==='price_asc'?'selected':''); ?>><?php echo e(app()->getLocale()==='ar'?'السعر: الأقل':'Price: Low'); ?></option>
            <option value="price_desc" <?php echo e(request('sort')==='price_desc'?'selected':''); ?>><?php echo e(app()->getLocale()==='ar'?'السعر: الأعلى':'Price: High'); ?></option>
            <option value="name" <?php echo e(request('sort')==='name'?'selected':''); ?>><?php echo e(app()->getLocale()==='ar'?'الاسم':'Name'); ?></option>
          </select>
        </form>
      </div>

      <?php if($products->isEmpty()): ?>
        <div class="empty-state">
          <div class="empty-state-icon">🔍</div>
          <h3><?php echo e(app()->getLocale()==='ar'?'لا توجد نتائج':'No products found'); ?></h3>
          <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary" style="margin-top:16px"><?php echo e(app()->getLocale()==='ar'?'عرض الكل':'View All'); ?></a>
        </div>
      <?php else: ?>
        <div class="products-grid">
          <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('shop._product_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div style="margin-top:32px;"><?php echo e($products->withQueryString()->links()); ?></div>
      <?php endif; ?>
    </div>

    
    <div id="cart-sidebar" style="width:280px;flex-shrink:0;position:sticky;top:90px;display:none;">
      <div class="card" style="padding:0;overflow:hidden">
        <div class="card-header" style="padding:16px 20px;display:flex;justify-content:space-between;align-items:center">
          <span><i class="fas fa-shopping-cart" style="color:var(--primary)"></i> <?php echo e(app()->getLocale()==='ar'?'سلة الشراء':'Cart'); ?></span>
          <span id="cart-sidebar-count" class="badge badge-green">0</span>
        </div>
        <div id="cart-sidebar-items" style="max-height:400px;overflow-y:auto;padding:12px 16px;">
          <div style="text-align:center;padding:20px;color:var(--text-muted)">
            <i class="fas fa-shopping-cart" style="font-size:28px;opacity:.3"></i>
            <p style="font-size:13px;margin-top:8px"><?php echo e(app()->getLocale()==='ar'?'السلة فارغة':'Cart is empty'); ?></p>
          </div>
        </div>
        <div id="cart-sidebar-footer" style="padding:16px;border-top:1px solid var(--border);display:none">
          <div style="display:flex;justify-content:space-between;font-weight:800;font-size:15px;margin-bottom:12px">
            <span><?php echo e(app()->getLocale()==='ar'?'الإجمالي':'Total'); ?></span>
            <span id="cart-sidebar-total" style="color:var(--primary)">0 <?php echo e(__('main.sar')); ?></span>
          </div>
          <a href="<?php echo e(route('cart')); ?>" class="btn btn-outline btn-block" style="margin-bottom:8px">
            <i class="fas fa-eye"></i> <?php echo e(app()->getLocale()==='ar'?'عرض السلة':'View Cart'); ?>

          </a>
          <a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary btn-block">
            <i class="fas fa-credit-card"></i> <?php echo e(app()->getLocale()==='ar'?'إتمام الشراء':'Checkout'); ?>

          </a>
        </div>
      </div>
    </div>

  </div>
</div>


<div id="cart-toast" style="position:fixed;bottom:24px;<?php echo e(app()->getLocale()==='ar'?'left':'right'); ?>:24px;background:var(--primary);color:#fff;padding:12px 20px;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.2);font-weight:600;font-size:14px;display:none;align-items:center;gap:10px;z-index:9999;transition:all .3s">
  <i class="fas fa-check-circle"></i> <span id="cart-toast-msg"></span>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
const CART_ADD_URL   = "<?php echo e(route('cart.add')); ?>";
const CART_REM_URL   = "<?php echo e(url('cart')); ?>";
const CSRF_TOKEN     = "<?php echo e(csrf_token()); ?>";
const LANG_SAR       = "<?php echo e(__('main.sar')); ?>";
const LANG_EMPTY     = "<?php echo e(app()->getLocale()==='ar'?'السلة فارغة':'Cart is empty'); ?>";
const LANG_ADDED     = "<?php echo e(app()->getLocale()==='ar'?'تمت الإضافة للسلة':'Added to cart'); ?>";

// Add to cart via AJAX
async function addToCart(productId, btn) {
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

  const res = await fetch(CART_ADD_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
    body: JSON.stringify({ product_id: productId, qty: 1 })
  });
  const data = await res.json();

  btn.disabled = false;
  btn.innerHTML = '<i class="fas fa-check"></i>';
  setTimeout(() => { btn.innerHTML = '<i class="fas fa-cart-plus"></i>'; }, 1500);

  if (data.success) {
    updateCartSidebar(data);
    updateCartBadge(data.count);
    showToast(LANG_ADDED + ': ' + btn.dataset.name);
  }
}

// Remove from sidebar
async function removeFromSidebar(productId) {
  const res = await fetch(CART_REM_URL + '/' + productId, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
  });
  const data = await res.json();
  if (data.success) {
    updateCartSidebar(data);
    updateCartBadge(data.count);
  }
}

// Update sidebar UI
function updateCartSidebar(data) {
  const sidebar    = document.getElementById('cart-sidebar');
  const itemsEl    = document.getElementById('cart-sidebar-items');
  const footerEl   = document.getElementById('cart-sidebar-footer');
  const countEl    = document.getElementById('cart-sidebar-count');
  const totalEl    = document.getElementById('cart-sidebar-total');

  if (data.count > 0) {
    sidebar.style.display = 'block';
    footerEl.style.display = 'block';
    countEl.textContent = data.count;
    totalEl.textContent = parseFloat(data.total).toFixed(2) + ' ' + LANG_SAR;

    let html = '';
    data.items.forEach(item => {
      html += `<div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border)">
        ${item.image ? `<img src="${item.image}" style="width:42px;height:42px;object-fit:cover;border-radius:8px;flex-shrink:0">` : '<div style="width:42px;height:42px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary);flex-shrink:0"><i class="fas fa-pills"></i></div>'}
        <div style="flex:1;min-width:0">
          <div style="font-size:13px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${item.name}</div>
          <div style="font-size:12px;color:var(--text-muted)">${item.qty} × ${parseFloat(item.price).toFixed(2)} ${LANG_SAR}</div>
        </div>
        <button onclick="removeFromSidebar(${item.id})" style="background:none;border:none;color:var(--danger);cursor:pointer;padding:4px;font-size:14px"><i class="fas fa-times"></i></button>
      </div>`;
    });
    itemsEl.innerHTML = html;
  } else {
    sidebar.style.display = 'none';
    countEl.textContent = '0';
  }
}

// Update header cart badge
function updateCartBadge(count) {
  const badges = document.querySelectorAll('.cart-badge');
  badges.forEach(b => {
    b.textContent = count;
    b.style.display = count > 0 ? 'flex' : 'none';
  });
}

// Show toast
function showToast(msg) {
  const toast = document.getElementById('cart-toast');
  document.getElementById('cart-toast-msg').textContent = msg;
  toast.style.display = 'flex';
  setTimeout(() => { toast.style.display = 'none'; }, 2500);
}

// Load cart on page load
window.addEventListener('DOMContentLoaded', async () => {
  const res = await fetch("<?php echo e(route('cart.sidebar')); ?>", { headers: { 'Accept': 'application/json' } });
  const data = await res.json();
  if (data.count > 0) updateCartSidebar(data);
  updateCartBadge(data.count);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/shop/index.blade.php ENDPATH**/ ?>