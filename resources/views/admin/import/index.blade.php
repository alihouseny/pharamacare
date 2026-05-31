@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'استيراد منتجات':'Bulk Import')
@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar">
      <button class="sidebar-toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-file-upload" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'استيراد منتجات بالجملة':'Bulk Product Import' }}</h1>
    </div>
    <div class="admin-content">

      @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:20px"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
      @endif
      @if(session('import_errors') && count(session('import_errors')))
        <div style="background:#FFF3E0;border:1.5px solid var(--warning);border-radius:10px;padding:16px;margin-bottom:20px">
          <strong><i class="fas fa-exclamation-triangle" style="color:var(--warning)"></i> {{ app()->getLocale()==='ar'?'بعض الصفوف فيها أخطاء:':'Some rows had errors:' }}</strong>
          <ul style="margin-top:8px;font-size:13px;padding-right:20px">
            @foreach(array_slice(session('import_errors'),0,10) as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">

        {{-- UPLOAD --}}
        <div class="card">
          <div class="card-header"><i class="fas fa-upload" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'رفع ملف CSV':'Upload CSV File' }}</div>
          <form action="{{ route('admin.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="border:2px dashed var(--border);border-radius:12px;padding:32px;text-align:center;margin-bottom:16px;cursor:pointer;transition:border-color .2s" onclick="document.getElementById('csv-file').click()" id="drop-zone">
              <i class="fas fa-file-csv" style="font-size:48px;color:var(--success);margin-bottom:12px"></i>
              <div style="font-weight:700;font-size:16px;margin-bottom:4px">{{ app()->getLocale()==='ar'?'اسحب الملف هنا أو اضغط للاختيار':'Drag CSV here or click to select' }}</div>
              <div style="font-size:13px;color:var(--text-muted)">{{ app()->getLocale()==='ar'?'CSV فقط — حتى 5MB':'CSV only — Max 5MB' }}</div>
              <input type="file" id="csv-file" name="file" accept=".csv,.txt" style="display:none" onchange="showFileName(this)">
            </div>
            <div id="file-name" style="font-size:13px;color:var(--primary);margin-bottom:16px;display:none;text-align:center;font-weight:700"></div>
            <button type="submit" class="btn btn-primary btn-block btn-lg">
              <i class="fas fa-upload"></i> {{ app()->getLocale()==='ar'?'بدء الاستيراد':'Start Import' }}
            </button>
          </form>
          <script>
          function showFileName(input) {
            if (input.files[0]) {
              document.getElementById('file-name').style.display='block';
              document.getElementById('file-name').textContent = '📄 ' + input.files[0].name;
              document.getElementById('drop-zone').style.borderColor = 'var(--primary)';
            }
          }
          </script>
        </div>

        {{-- INSTRUCTIONS --}}
        <div>
          <div class="card" style="margin-bottom:16px">
            <div class="card-header"><i class="fas fa-info-circle" style="color:var(--info)"></i> {{ app()->getLocale()==='ar'?'تعليمات الاستيراد':'Import Instructions' }}</div>
            <ol style="padding-right:20px;font-size:14px;line-height:2;color:var(--text-muted)">
              <li>{{ app()->getLocale()==='ar'?'حمّل القالب أولاً':'Download the template first' }}</li>
              <li>{{ app()->getLocale()==='ar'?'افتحه في Excel أو Google Sheets':'Open in Excel or Google Sheets' }}</li>
              <li>{{ app()->getLocale()==='ar'?'أضف المنتجات صف بصف':'Add products row by row' }}</li>
              <li>{{ app()->getLocale()==='ar'?'احفظه كـ CSV واستورده هنا':'Save as CSV and import here' }}</li>
            </ol>
            <a href="{{ route('admin.import.template') }}" class="btn btn-outline btn-block">
              <i class="fas fa-download" style="color:var(--success)"></i> {{ app()->getLocale()==='ar'?'تحميل القالب (CSV)':'Download Template (CSV)' }}
            </a>
          </div>

          <div class="card">
            <div class="card-header"><i class="fas fa-columns" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'الأعمدة المطلوبة':'Required Columns' }}</div>
            <table class="table" style="font-size:13px">
              <thead><tr><th>{{ app()->getLocale()==='ar'?'العمود':'Column' }}</th><th>{{ app()->getLocale()==='ar'?'مطلوب':'Required' }}</th><th>{{ app()->getLocale()==='ar'?'مثال':'Example' }}</th></tr></thead>
              <tbody>
                @foreach([
                  ['name_ar','✅','بنادول اكسترا'],
                  ['name_en','✅','Panadol Extra'],
                  ['category_id','✅','1'],
                  ['price','✅','15.50'],
                  ['stock','✅','100'],
                  ['active_ingredient','—','باراسيتامول'],
                  ['manufacturer','—','GSK'],
                  ['requires_prescription','—','0 أو 1'],
                  ['barcode','—','6001060001'],
                ] as $col)
                <tr>
                  <td style="font-family:monospace;color:var(--info)">{{ $col[0] }}</td>
                  <td>{{ $col[1] }}</td>
                  <td style="color:var(--text-muted)">{{ $col[2] }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection
