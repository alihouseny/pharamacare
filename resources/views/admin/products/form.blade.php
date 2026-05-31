@extends('layouts.app')
@section('title', isset($product) ? (app()->getLocale()==='ar'?'تعديل منتج':'Edit Product') : (app()->getLocale()==='ar'?'منتج جديد':'New Product'))

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <div style="display:flex;align-items:center;gap:12px;">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        <h1 style="font-size:20px;font-weight:800">
          {{ isset($product) ? (app()->getLocale()==='ar'?'تعديل: ':'Edit: ').$product->name_ar : (app()->getLocale()==='ar'?'منتج جديد':'New Product') }}
        </h1>
      </div>
    </div>
    <div class="admin-content">

      @if(session('success'))
        <div class="alert" style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--success)">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif

      <form action="{{ isset($product) ? route('admin.products.update',$product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product)) @method('PATCH') @endif

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start;">

          {{-- LEFT COLUMN --}}
          <div>
            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-language"></i> {{ app()->getLocale()==='ar'?'الأسماء':'Names' }}</div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'الاسم بالعربية':'Name (Arabic)' }} *</label>
                <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                  value="{{ old('name_ar', $product->name_ar ?? '') }}">
                @error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'الاسم بالإنجليزية':'Name (English)' }} *</label>
                <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                  value="{{ old('name_en', $product->name_en ?? '') }}">
                @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'القسم':'Category' }} *</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                  <option value="">{{ app()->getLocale()==='ar'?'اختر قسماً...':'Select category...' }}</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                      {{ $cat->name_ar }}
                    </option>
                  @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group">
                <label class="form-label">{{ __('main.active_ingredient') }}</label>
                <input type="text" name="active_ingredient" class="form-control"
                  value="{{ old('active_ingredient', $product->active_ingredient ?? '') }}">
              </div>
              <div class="form-group">
                <label class="form-label">{{ __('main.manufacturer') }}</label>
                <input type="text" name="manufacturer" class="form-control"
                  value="{{ old('manufacturer', $product->manufacturer ?? '') }}">
              </div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'الباركود':'Barcode' }}</label>
                <input type="text" name="barcode" class="form-control"
                  value="{{ old('barcode', $product->barcode ?? '') }}">
              </div>
            </div>

            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-align-right"></i> {{ app()->getLocale()==='ar'?'الوصف':'Description' }}</div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'وصف عربي':'Description (Arabic)' }}</label>
                <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar', $product->description_ar ?? '') }}</textarea>
              </div>
              <div class="form-group">
                <label class="form-label">{{ app()->getLocale()==='ar'?'وصف إنجليزي':'Description (English)' }}</label>
                <textarea name="description_en" class="form-control" rows="3">{{ old('description_en', $product->description_en ?? '') }}</textarea>
              </div>
            </div>
          </div>

          {{-- RIGHT COLUMN --}}
          <div>
            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-pound-sign"></i> {{ app()->getLocale()==='ar'?'التسعير والمخزون':'Pricing & Stock' }}</div>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div class="form-group">
                  <label class="form-label">{{ app()->getLocale()==='ar'?'السعر':'Price' }} *</label>
                  <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
                    value="{{ old('price', $product->price ?? '') }}">
                  @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                  <label class="form-label">{{ app()->getLocale()==='ar'?'سعر الخصم':'Sale Price' }}</label>
                  <input type="number" step="0.01" name="sale_price" class="form-control"
                    value="{{ old('sale_price', $product->sale_price ?? '') }}">
                </div>
                <div class="form-group">
                  <label class="form-label">{{ app()->getLocale()==='ar'?'المخزون':'Stock' }} *</label>
                  <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                    value="{{ old('stock', $product->stock ?? '0') }}">
                  @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                  <label class="form-label">{{ app()->getLocale()==='ar'?'حد التنبيه':'Alert At' }}</label>
                  <input type="number" name="min_stock_alert" class="form-control"
                    value="{{ old('min_stock_alert', $product->min_stock_alert ?? '10') }}">
                </div>
              </div>
            </div>

            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-capsules"></i> {{ app()->getLocale()==='ar'?'التفاصيل الصيدلانية':'Pharmaceutical Details' }}</div>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div class="form-group">
                  <label class="form-label">{{ __('main.dosage_form') }}</label>
                  <select name="dosage_form" class="form-select">
                    <option value="">{{ app()->getLocale()==='ar'?'اختر...':'Select...' }}</option>
                    @foreach(['Tablet','Capsule','Syrup','Injection','Cream','Drops','Spray','Suppository'] as $form)
                      <option value="{{ $form }}" {{ old('dosage_form', $product->dosage_form ?? '') == $form ? 'selected' : '' }}>{{ $form }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">{{ __('main.strength') }}</label>
                  <input type="text" name="strength" class="form-control" placeholder="500mg"
                    value="{{ old('strength', $product->strength ?? '') }}">
                </div>
                <div class="form-group">
                  <label class="form-label">{{ __('main.package_size') }}</label>
                  <input type="text" name="package_size" class="form-control" placeholder="20 tablets"
                    value="{{ old('package_size', $product->package_size ?? '') }}">
                </div>
              </div>
            </div>

            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-cog"></i> {{ app()->getLocale()==='ar'?'الإعدادات':'Settings' }}</div>
              <div style="display:grid;gap:12px">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                  <input type="hidden" name="requires_prescription" value="0">
                  <input type="checkbox" name="requires_prescription" value="1" {{ old('requires_prescription', $product->requires_prescription ?? false) ? 'checked' : '' }}>
                  <span>{{ app()->getLocale()==='ar'?'يستلزم روشيتة طبية':'Requires Prescription' }}</span>
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                  <input type="hidden" name="is_featured" value="0">
                  <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                  <span>{{ app()->getLocale()==='ar'?'منتج مميز':'Featured Product' }}</span>
                </label>
                @if(isset($product))
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                  <input type="hidden" name="is_active" value="0">
                  <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                  <span>{{ app()->getLocale()==='ar'?'منتج نشط':'Active Product' }}</span>
                </label>
                @endif
              </div>
            </div>

            <div class="card" style="margin-bottom:20px">
              <div class="card-header"><i class="fas fa-image"></i> {{ app()->getLocale()==='ar'?'صورة المنتج':'Product Image' }}</div>
              @if(isset($product) && $product->image)
                <img src="{{ asset('storage/'.$product->image) }}" style="max-width:120px;border-radius:8px;margin-bottom:12px">
              @endif
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
              <div class="form-text">JPG, PNG — Max 2MB</div>
              @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">
              <i class="fas fa-save"></i>
              {{ isset($product) ? __('main.save') : (app()->getLocale()==='ar'?'إنشاء المنتج':'Create Product') }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </main>
</div>
@endsection
