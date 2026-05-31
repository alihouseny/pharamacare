@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'ماسح الباركود':'Barcode Scanner')

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar">
      <button class="sidebar-toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800">
        <i class="fas fa-barcode" style="color:var(--primary)"></i>
        {{ app()->getLocale()==='ar'?'ماسح الباركود':'Barcode Scanner' }}
      </h1>
    </div>
    <div class="admin-content">
      <div style="display:grid;grid-template-columns:1fr 400px;gap:24px;align-items:start">

        {{-- CAMERA --}}
        <div class="card">
          <div class="card-header"><i class="fas fa-camera"></i> {{ app()->getLocale()==='ar'?'كاميرا المسح':'Scanner Camera' }}</div>
          
          {{-- Manual entry --}}
          <div style="display:flex;gap:10px;margin-bottom:20px">
            <input type="text" id="manual-barcode" class="form-control" placeholder="{{ app()->getLocale()==='ar'?'أدخل الباركود يدوياً...':'Enter barcode manually...' }}" onkeydown="if(event.key==='Enter')lookupBarcode(this.value)">
            <button onclick="lookupBarcode(document.getElementById('manual-barcode').value)" class="btn btn-primary" style="flex-shrink:0">
              <i class="fas fa-search"></i> {{ app()->getLocale()==='ar'?'بحث':'Search' }}
            </button>
          </div>

          {{-- Camera scanner --}}
          <div style="position:relative;background:#000;border-radius:12px;overflow:hidden;aspect-ratio:4/3">
            <video id="scanner-video" style="width:100%;height:100%;object-fit:cover" playsinline></video>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none">
              <div style="width:70%;height:40%;border:3px solid #00FF7F;border-radius:8px;box-shadow:0 0 0 9999px rgba(0,0,0,.4)">
                <div style="position:absolute;top:-2px;right:-2px;width:20px;height:20px;border-top:3px solid #00FF7F;border-right:3px solid #00FF7F"></div>
                <div style="position:absolute;top:-2px;left:-2px;width:20px;height:20px;border-top:3px solid #00FF7F;border-left:3px solid #00FF7F"></div>
                <div style="position:absolute;bottom:-2px;right:-2px;width:20px;height:20px;border-bottom:3px solid #00FF7F;border-right:3px solid #00FF7F"></div>
                <div style="position:absolute;bottom:-2px;left:-2px;width:20px;height:20px;border-bottom:3px solid #00FF7F;border-left:3px solid #00FF7F"></div>
              </div>
            </div>
            <div id="scanner-line" style="position:absolute;top:30%;left:15%;right:15%;height:2px;background:rgba(0,255,127,.8);animation:scan 2s linear infinite"></div>
          </div>
          <style>@keyframes scan { 0%{top:30%} 50%{top:65%} 100%{top:30%} }</style>

          <div style="display:flex;gap:10px;margin-top:16px">
            <button onclick="startScanner()" class="btn btn-primary" id="start-btn">
              <i class="fas fa-play"></i> {{ app()->getLocale()==='ar'?'تشغيل الكاميرا':'Start Camera' }}
            </button>
            <button onclick="stopScanner()" class="btn btn-outline" id="stop-btn" style="display:none">
              <i class="fas fa-stop"></i> {{ app()->getLocale()==='ar'?'إيقاف':'Stop' }}
            </button>
          </div>
          <div id="scan-status" style="margin-top:12px;font-size:13px;color:var(--text-muted);text-align:center"></div>
        </div>

        {{-- RESULT --}}
        <div>
          <div class="card" id="scan-result" style="display:none">
            <div class="card-header"><i class="fas fa-box" style="color:var(--success)"></i> {{ app()->getLocale()==='ar'?'نتيجة المسح':'Scan Result' }}</div>
            <div id="result-content"></div>
          </div>
          <div class="card" id="not-found-card" style="display:none;text-align:center;padding:32px">
            <i class="fas fa-times-circle" style="font-size:48px;color:var(--danger)"></i>
            <h3 style="margin-top:12px">{{ app()->getLocale()==='ar'?'المنتج غير موجود':'Product Not Found' }}</h3>
            <p id="not-found-barcode" style="color:var(--text-muted);margin-top:8px;font-size:14px"></p>
            <a id="add-product-link" href="{{ route('admin.products.create') }}" class="btn btn-primary" style="margin-top:16px">
              <i class="fas fa-plus"></i> {{ app()->getLocale()==='ar'?'إضافة منتج جديد':'Add New Product' }}
            </a>
          </div>
          <div class="card" style="margin-top:16px">
            <div class="card-header"><i class="fas fa-history" style="color:var(--text-muted)"></i> {{ app()->getLocale()==='ar'?'آخر المسحات':'Recent Scans' }}</div>
            <div id="scan-history" style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'لا توجد مسحات بعد':'No scans yet' }}</div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

@push('scripts')
<script>
let stream = null;
let scanHistory = [];

async function startScanner() {
  try {
    stream = await navigator.mediaDevices.getUserMedia({video:{facingMode:'environment'}});
    document.getElementById('scanner-video').srcObject = stream;
    document.getElementById('scanner-video').play();
    document.getElementById('start-btn').style.display = 'none';
    document.getElementById('stop-btn').style.display = 'flex';
    document.getElementById('scan-status').textContent = '{{ app()->getLocale()==="ar"?"الكاميرا تعمل — وجّه نحو الباركود":"Camera active — point at barcode" }}';
    
    // Use BarcodeDetector if available
    if ('BarcodeDetector' in window) {
      const detector = new BarcodeDetector({formats: ['ean_13','ean_8','code_128','code_39','qr_code']});
      const video = document.getElementById('scanner-video');
      const scanLoop = setInterval(async () => {
        try {
          const barcodes = await detector.detect(video);
          if (barcodes.length > 0) {
            const code = barcodes[0].rawValue;
            document.getElementById('scan-status').textContent = `✅ Detected: ${code}`;
            await lookupBarcode(code);
          }
        } catch(e) {}
      }, 500);
      video._scanLoop = scanLoop;
    } else {
      document.getElementById('scan-status').textContent = '{{ app()->getLocale()==="ar"?"استخدم الإدخال اليدوي في هذا المتصفح":"Use manual entry in this browser" }}';
    }
  } catch(e) {
    document.getElementById('scan-status').textContent = '❌ {{ app()->getLocale()==="ar"?"لا يمكن الوصول للكاميرا":"Cannot access camera" }}';
  }
}

function stopScanner() {
  if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
  const video = document.getElementById('scanner-video');
  if (video._scanLoop) clearInterval(video._scanLoop);
  video.srcObject = null;
  document.getElementById('start-btn').style.display = 'flex';
  document.getElementById('stop-btn').style.display = 'none';
  document.getElementById('scan-status').textContent = '';
}

async function lookupBarcode(barcode) {
  if (!barcode || barcode.trim().length < 3) return;
  barcode = barcode.trim();
  document.getElementById('scan-result').style.display = 'none';
  document.getElementById('not-found-card').style.display = 'none';

  try {
    const res  = await fetch('/admin/products/barcode-lookup?barcode=' + encodeURIComponent(barcode), {
      headers: {'Accept':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}
    });
    const data = await res.json();
    
    addToHistory(barcode, data.found);
    
    if (data.found) {
      const p = data.product;
      document.getElementById('result-content').innerHTML = `
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px">
          ${p.image ? `<img src="${p.image}" style="width:70px;height:70px;object-fit:cover;border-radius:10px">` : `<div style="width:70px;height:70px;background:var(--primary-light);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:28px"><i class="fas fa-pills"></i></div>`}
          <div>
            <div style="font-weight:800;font-size:18px">${p.name}</div>
            <div style="font-size:13px;color:var(--info)">${p.ingredient || ''}</div>
            <div style="font-size:12px;color:var(--text-muted);font-family:monospace">${barcode}</div>
          </div>
        </div>
        <div style="display:grid;gap:8px;font-size:14px">
          <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border)">
            <span style="color:var(--text-muted)">{{ app()->getLocale()==="ar"?"السعر":"Price" }}</span>
            <strong style="color:var(--primary)">${p.price} {{ __("main.sar") }}</strong>
          </div>
          <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border)">
            <span style="color:var(--text-muted)">{{ app()->getLocale()==="ar"?"المخزون":"Stock" }}</span>
            <strong style="color:${p.stock <= p.min_stock ? 'var(--danger)' : 'var(--success)'}">${p.stock}</strong>
          </div>
          <div style="display:flex;justify-content:space-between;padding:8px 0">
            <span style="color:var(--text-muted)">{{ app()->getLocale()==="ar"?"الفئة":"Category" }}</span>
            <span>${p.category}</span>
          </div>
        </div>
        <div style="display:flex;gap:8px;margin-top:16px">
          <a href="/admin/products/${p.id}/edit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> {{ app()->getLocale()==="ar"?"تعديل":"Edit" }}</a>
          <a href="/admin/products/${p.id}/analytics" class="btn btn-outline btn-sm"><i class="fas fa-chart-bar"></i> {{ app()->getLocale()==="ar"?"تحليل":"Analytics" }}</a>
          <a href="/admin/products/${p.id}/expiry" class="btn btn-outline btn-sm"><i class="fas fa-calendar-times"></i> {{ app()->getLocale()==="ar"?"الصلاحية":"Expiry" }}</a>
        </div>
      `;
      document.getElementById('scan-result').style.display = 'block';
    } else {
      document.getElementById('not-found-barcode').textContent = '{{ app()->getLocale()==="ar"?"باركود":"Barcode" }}: ' + barcode;
      document.getElementById('not-found-card').style.display = 'block';
    }
  } catch(e) {
    document.getElementById('scan-status').textContent = '❌ Error: ' + e.message;
  }
}

function addToHistory(barcode, found) {
  scanHistory.unshift({barcode, found, time: new Date().toLocaleTimeString()});
  if (scanHistory.length > 5) scanHistory.pop();
  document.getElementById('scan-history').innerHTML = scanHistory.map(s =>
    `<div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid var(--border);cursor:pointer" onclick="lookupBarcode('${s.barcode}')">
      <span style="font-family:monospace">${s.barcode}</span>
      <span style="color:${s.found?'var(--success)':'var(--danger)'}">${s.found?'✅':'❌'} ${s.time}</span>
    </div>`
  ).join('');
}
</script>
@endpush
@endsection
