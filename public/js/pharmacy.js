// ================================
// PHARMACY.JS — Main Script
// ================================

document.addEventListener('DOMContentLoaded', function () {

  // ===== FLASH MESSAGE AUTO-HIDE =====
  document.querySelectorAll('.alert').forEach(function (el) {
    setTimeout(function () {
      el.style.transition = 'opacity .5s';
      el.style.opacity = '0';
      setTimeout(function () { el.remove(); }, 500);
    }, 4000);
  });

  // ===== CART QUANTITY BUTTONS =====
  document.querySelectorAll('.qty-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = this.closest('.qty-wrap').querySelector('.qty-input');
      var val   = parseInt(input.value) || 1;
      if (this.dataset.dir === 'up')   input.value = val + 1;
      if (this.dataset.dir === 'down') input.value = Math.max(1, val - 1);
    });
  });

  // ===== IMAGE PREVIEW (Prescription Upload) =====
  var fileInput = document.querySelector('input[type="file"][accept="image/*"]');
  if (fileInput) {
    fileInput.addEventListener('change', function () {
      var preview = document.getElementById('img-preview');
      if (!preview) {
        preview = document.createElement('img');
        preview.id = 'img-preview';
        preview.style.cssText = 'max-width:100%;border-radius:10px;margin-top:12px;border:2px solid var(--border)';
        fileInput.parentNode.appendChild(preview);
      }
      var file = this.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function (e) { preview.src = e.target.result; };
        reader.readAsDataURL(file);
      }
    });
  }

  // ===== ACTIVE NAV LINK =====
  var path = window.location.pathname;
  document.querySelectorAll('.cat-link').forEach(function (link) {
    if (link.getAttribute('href') === path) link.classList.add('active');
  });

  // ===== MOBILE SIDEBAR TOGGLE (Admin) =====
  var sidebarToggle = document.getElementById('sidebar-toggle');
  var sidebar       = document.querySelector('.admin-sidebar');
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
    });
  }

  // ===== ADDRESS DEFAULT RADIO =====
  document.querySelectorAll('.address-card').forEach(function (card) {
    card.addEventListener('click', function () {
      document.querySelectorAll('.address-card').forEach(function (c) {
        c.classList.remove('selected');
        var radio = c.querySelector('input[type="radio"]');
        if (radio) radio.checked = false;
      });
      card.classList.add('selected');
      var radio = card.querySelector('input[type="radio"]');
      if (radio) radio.checked = true;
    });
  });

  // ===== PRODUCT SEARCH DEBOUNCE =====
  var searchInput = document.querySelector('.search-bar input');
  if (searchInput) {
    var debounceTimer;
    searchInput.addEventListener('input', function () {
      clearTimeout(debounceTimer);
      var val = this.value.trim();
      if (val.length === 0) return;
      debounceTimer = setTimeout(function () {
        // Auto-submit if user stopped typing for 600ms
        // searchInput.closest('form').submit();
      }, 600);
    });
  }

  // ===== CONFIRM DELETE =====
  document.querySelectorAll('[data-confirm]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      if (!confirm(this.dataset.confirm)) e.preventDefault();
    });
  });

  // ===== SMOOTH SCROLL =====
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });

  // ===== ADD TO CART ANIMATION =====
  document.querySelectorAll('.btn-add-cart').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var icon = this.querySelector('i');
      if (icon) {
        icon.className = 'fas fa-check';
        btn.style.background = 'var(--success)';
        setTimeout(function () {
          icon.className = 'fas fa-cart-plus';
          btn.style.background = '';
        }, 1200);
      }
    });
  });

  // ===== EXPIRY DATE HIGHLIGHT (Admin) =====
  document.querySelectorAll('[data-expiry]').forEach(function (el) {
    var days = parseInt(el.dataset.expiry);
    if (days < 0)  el.classList.add('expiry-danger');
    else if (days <= 30)  el.classList.add('expiry-danger');
    else if (days <= 90)  el.classList.add('expiry-near');
    else el.classList.add('expiry-ok');
  });

});
