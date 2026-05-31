@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'مناطق التوصيل':'Delivery Zones')
@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar">
      <button class="sidebar-toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-map-marked-alt" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'مناطق التوصيل وأسعاره':'Delivery Zones & Fees' }}</h1>
    </div>
    <div class="admin-content">
      @if(session('success'))<div class="alert alert-success" style="margin-bottom:20px"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif

      <div style="display:grid;gap:20px">
        @foreach($zones as $zone)
        <div class="card">
          <form action="{{ route('admin.delivery.update', $zone) }}" method="POST">
            @csrf @method('PATCH')
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;align-items:end">
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'الاسم بالعربية':'Name (AR)' }}</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $zone->name_ar }}">
              </div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'الاسم بالإنجليزية':'Name (EN)' }}</label>
                <input type="text" name="name_en" class="form-control" value="{{ $zone->name_en }}">
              </div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'رسوم التوصيل (ج.م)':'Delivery Fee (EGP)' }}</label>
                <input type="number" step="0.5" name="delivery_fee" class="form-control" value="{{ $zone->delivery_fee }}">
              </div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'توصيل مجاني من (ج.م)':'Free delivery from (EGP)' }}</label>
                <input type="number" step="10" name="free_delivery_threshold" class="form-control" value="{{ $zone->free_delivery_threshold }}">
              </div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'أيام التوصيل':'Delivery Days' }}</label>
                <input type="number" name="estimated_days" class="form-control" value="{{ $zone->estimated_days }}" min="1">
              </div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'نشط':'Active' }}</label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:8px">
                  <input type="checkbox" name="is_active" value="1" {{ $zone->is_active?'checked':'' }}>
                  <span>{{ app()->getLocale()==='ar'?'نعم':'Yes' }}</span>
                </label>
              </div>
              <div class="form-group" style="grid-column:1/-1">
                <label class="form-label">{{ app()->getLocale()==='ar'?'المدن (مفصولة بفاصلة)':'Cities (comma separated)' }}</label>
                <input type="text" name="cities" class="form-control" value="{{ is_array($zone->cities) ? implode(', ', $zone->cities) : '' }}" placeholder="{{ app()->getLocale()==='ar'?'القاهرة، الجيزة، ...':'Cairo, Giza, ...' }}">
              </div>
              <div style="grid-column:1/-1;display:flex;justify-content:space-between;align-items:center">
                <div style="font-size:13px;color:var(--text-muted)">
                  @if(is_array($zone->cities) && count($zone->cities))
                    <i class="fas fa-city"></i> {{ count($zone->cities) }} {{ app()->getLocale()==='ar'?'مدينة':'cities' }}
                  @else
                    <span style="color:var(--info)">{{ app()->getLocale()==='ar'?'منطقة افتراضية (تشمل باقي المدن)':'Default zone (covers remaining cities)' }}</span>
                  @endif
                </div>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> {{ __('main.save') }}</button>
              </div>
            </div>
          </form>
        </div>
        @endforeach

        {{-- ADD NEW ZONE --}}
        <div class="card">
          <div class="card-header"><i class="fas fa-plus" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'إضافة منطقة جديدة':'Add New Zone' }}</div>
          <form action="{{ route('admin.delivery.store') }}" method="POST">
            @csrf
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;align-items:end">
              <div class="form-group"><label class="form-label">{{ app()->getLocale()==='ar'?'الاسم عربي':'Name AR' }} *</label><input type="text" name="name_ar" class="form-control" required></div>
              <div class="form-group"><label class="form-label">{{ app()->getLocale()==='ar'?'الاسم إنجليزي':'Name EN' }} *</label><input type="text" name="name_en" class="form-control" required></div>
              <div class="form-group"><label class="form-label">{{ app()->getLocale()==='ar'?'رسوم التوصيل':'Fee (EGP)' }} *</label><input type="number" step="0.5" name="delivery_fee" class="form-control" value="25" required></div>
              <div class="form-group"><label class="form-label">{{ app()->getLocale()==='ar'?'مجاني من':'Free from' }}</label><input type="number" name="free_delivery_threshold" class="form-control" value="200"></div>
              <div class="form-group"><label class="form-label">{{ app()->getLocale()==='ar'?'أيام التوصيل':'Days' }}</label><input type="number" name="estimated_days" class="form-control" value="2" min="1"></div>
              <div class="form-group" style="grid-column:1/-1"><label class="form-label">{{ app()->getLocale()==='ar'?'المدن':'Cities' }}</label><input type="text" name="cities" class="form-control" placeholder="{{ app()->getLocale()==='ar'?'اسم المدينة، ...':'City name, ...' }}"></div>
              <div><button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> {{ app()->getLocale()==='ar'?'إضافة':'Add' }}</button></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection
