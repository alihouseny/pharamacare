<div class="product-card" id="pcard-<?php echo e($product->id); ?>">
  <?php if($product->sale_price): ?>
    <span class="badge-sale"><?php echo e(app()->getLocale()==='ar'?'خصم':'Sale'); ?></span>
  <?php endif; ?>
  <?php if($product->is_featured): ?>
    <span class="badge-featured">⭐</span>
  <?php endif; ?>
  <?php if($product->requires_prescription): ?>
    <span class="badge-rx"><i class="fas fa-prescription"></i> Rx</span>
  <?php endif; ?>

  <a href="<?php echo e(route('shop.product', $product->slug)); ?>" class="card-img-link">
    <?php if($product->image): ?>
      <img src="<?php echo e(asset('storage/'.$product->image)); ?>" alt="<?php echo e($product->name); ?>" loading="lazy">
    <?php else: ?>
      <div class="card-img-placeholder"><i class="fas fa-pills"></i></div>
    <?php endif; ?>
  </a>

  <div class="card-body">
    <div class="card-category"><?php echo e($product->category->name ?? ''); ?></div>
    <h3 class="card-title">
      <a href="<?php echo e(route('shop.product', $product->slug)); ?>"><?php echo e($product->name); ?></a>
    </h3>
    <?php if($product->active_ingredient): ?>
      <div class="card-ingredient"><i class="fas fa-atom"></i> <?php echo e($product->active_ingredient); ?></div>
    <?php endif; ?>
    <?php if($product->strength): ?>
      <div class="card-strength"><?php echo e($product->strength); ?></div>
    <?php endif; ?>

    <div class="card-footer">
      <div class="card-price">
        <span class="price-current"><?php echo e(number_format($product->current_price, 2)); ?> <?php echo e(__('main.sar')); ?></span>
        <?php if($product->sale_price): ?>
          <span class="price-old"><?php echo e(number_format($product->price, 2)); ?></span>
        <?php endif; ?>
      </div>

      <?php if($product->stock < 1): ?>
        <span class="btn-disabled"><?php echo e(__('main.out_of_stock')); ?></span>
      <?php elseif($product->requires_prescription): ?>
        <a href="<?php echo e(route('prescriptions.create')); ?>" class="btn btn-rx btn-sm">
          <i class="fas fa-file-prescription"></i> Rx
        </a>
      <?php else: ?>
        <button class="btn btn-primary btn-sm add-to-cart-btn"
                data-id="<?php echo e($product->id); ?>"
                data-name="<?php echo e($product->name); ?>"
                onclick="addToCart(<?php echo e($product->id); ?>, this)">
          <i class="fas fa-cart-plus"></i>
        </button>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php /**PATH D:\Computer\New folder (2)\New folder (2)\pharmacare\resources\views/shop/_product_card.blade.php ENDPATH**/ ?>