@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'تفاعلات الأدوية':'Drug Interactions')
@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar">
      <button class="sidebar-toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-exclamation-triangle" style="color:var(--danger)"></i> {{ app()->getLocale()==='ar'?'تفاعلات الأدوية':'Drug Interactions' }}</h1>
    </div>
    <div class="admin-content">

      @if(session('success'))<div class="alert alert-success" style="margin-bottom:16px"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif

      <div style="display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start">

        {{-- TABLE --}}
        <div class="card" style="padding:0;overflow:hidden">
          <div style="padding:16px 20px;font-weight:800;border-bottom:1px solid var(--border)">{{ $interactions->total() }} {{ app()->getLocale()==='ar'?'تفاعل مسجّل':'interactions registered' }}</div>
          <table class="table">
            <thead><tr>
              <th>{{ app()->getLocale()==='ar'?'المادة الأولى':'Ingredient A' }}</th>
              <th>{{ app()->getLocale()==='ar'?'المادة الثانية':'Ingredient B' }}</th>
              <th>{{ app()->getLocale()==='ar'?'الخطورة':'Severity' }}</th>
              <th>{{ app()->getLocale()==='ar'?'التأثير':'Effect' }}</th>
              <th></th>
            </tr></thead>
            <tbody>
              @forelse($interactions as $i)
              <tr>
                <td style="font-weight:700;color:var(--info)">{{ $i->ingredient_a }}</td>
                <td style="font-weight:700;color:var(--info)">{{ $i->ingredient_b }}</td>
                <td>
                  @php $sev=['severe'=>'badge-red','moderate'=>'badge-orange','mild'=>'badge-green']; @endphp
                  <span class="badge {{ $sev[$i->severity]??'badge-gray' }}">
                    {{ ['severe'=>'خطير','moderate'=>'متوسط','mild'=>'خفيف'][$i->severity] ?? $i->severity }}
                  </span>
                </td>
                <td style="font-size:13px;max-width:200px">{{ Str::limit($i->description_ar, 60) }}</td>
                <td>
                  <form action="{{ route('admin.interactions.destroy',$i) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline btn-sm" style="color:var(--danger)" onclick="return confirm('حذف؟')"><i class="fas fa-trash"></i></button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:32px">{{ app()->getLocale()==='ar'?'لا توجد تفاعلات مسجلة':'No interactions registered' }}</td></tr>
              @endforelse
            </tbody>
          </table>
          <div style="padding:12px 16px">{{ $interactions->links() }}</div>
        </div>

        {{-- ADD FORM --}}
        <div class="card">
          <div class="card-header"><i class="fas fa-plus" style="color:var(--primary)"></i> {{ app()->getLocale()==='ar'?'إضافة تفاعل جديد':'Add New Interaction' }}</div>
          <form action="{{ route('admin.interactions.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label class="form-label">{{ app()->getLocale()==='ar'?'المادة الفعالة الأولى':'Ingredient A' }} *</label>
              <input type="text" name="ingredient_a" class="form-control" placeholder="e.g. warfarin" required>
              <div class="form-text">{{ app()->getLocale()==='ar'?'بالإنجليزية (lowercase)':'In English (lowercase)' }}</div>
            </div>
            <div class="form-group">
              <label class="form-label">{{ app()->getLocale()==='ar'?'المادة الفعالة الثانية':'Ingredient B' }} *</label>
              <input type="text" name="ingredient_b" class="form-control" placeholder="e.g. aspirin" required>
            </div>
            <div class="form-group">
              <label class="form-label">{{ app()->getLocale()==='ar'?'مستوى الخطورة':'Severity' }} *</label>
              <select name="severity" class="form-select" required>
                <option value="mild">{{ app()->getLocale()==='ar'?'خفيف — قد يسبب آثاراً بسيطة':'Mild' }}</option>
                <option value="moderate" selected>{{ app()->getLocale()==='ar'?'متوسط — يستوجب المراقبة':'Moderate' }}</option>
                <option value="severe">{{ app()->getLocale()==='ar'?'خطير — تجنّب الجمع':'Severe' }}</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">{{ app()->getLocale()==='ar'?'وصف التفاعل بالعربية':'Arabic Description' }} *</label>
              <textarea name="description_ar" class="form-control" rows="3" required placeholder="قد يؤدي الجمع بين..."></textarea>
            </div>
            <div class="form-group">
              <label class="form-label">{{ app()->getLocale()==='ar'?'وصف التفاعل بالإنجليزية':'English Description' }} *</label>
              <textarea name="description_en" class="form-control" rows="3" required placeholder="Combining these may..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> {{ __('main.save') }}</button>
          </form>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection
