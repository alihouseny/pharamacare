@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'إدارة المستخدمين':'Users Management')

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:900"><i class="fas fa-users"></i> {{ app()->getLocale()==='ar'?'إدارة المستخدمين':'Users Management' }}</h1>
    </div>
    <div class="admin-content">

      @if(session('success'))
        <div style="background:#E8F5E9;border:1.5px solid var(--success);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--success)">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div style="background:#FFEBEE;border:1.5px solid var(--danger);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:var(--danger)">
          <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
      @endif

      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th>{{ app()->getLocale()==='ar'?'المستخدم':'User' }}</th>
            <th>{{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email' }}</th>
            <th>{{ app()->getLocale()==='ar'?'الهاتف':'Phone' }}</th>
            <th>{{ app()->getLocale()==='ar'?'الطلبات':'Orders' }}</th>
            <th>{{ app()->getLocale()==='ar'?'الدور الحالي':'Current Role' }}</th>
            <th>{{ app()->getLocale()==='ar'?'تغيير الدور':'Change Role' }}</th>
            <th>{{ app()->getLocale()==='ar'?'تاريخ التسجيل':'Joined' }}</th>
          </tr></thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>
                <div style="font-weight:700">{{ $user->name }}</div>
                @if($user->id === auth()->id())
                  <span style="font-size:11px;color:var(--text-muted)">({{ app()->getLocale()==='ar'?'أنت':'You' }})</span>
                @endif
              </td>
              <td style="font-size:13px">{{ $user->email }}</td>
              <td style="font-size:13px">{{ $user->phone ?? '—' }}</td>
              <td style="font-weight:700;text-align:center">{{ $user->orders_count }}</td>
              <td>
                @php $roleColors = ['admin'=>'badge-red','pharmacist'=>'badge-blue','customer'=>'badge-green']; @endphp
                <span class="badge {{ $roleColors[$user->role]??'badge-gray' }}">
                  {{ ['admin'=>'أدمن','pharmacist'=>'صيدلاني','customer'=>'عميل'][$user->role] ?? $user->role }}
                </span>
              </td>
              <td>
                @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.role',$user) }}" method="POST" style="display:flex;gap:6px;align-items:center">
                  @csrf @method('PATCH')
                  <select name="role" class="form-select" style="font-size:13px;padding:5px 10px;min-width:120px">
                    <option value="customer" {{ $user->role==='customer'?'selected':'' }}>{{ app()->getLocale()==='ar'?'عميل':'Customer' }}</option>
                    <option value="pharmacist" {{ $user->role==='pharmacist'?'selected':'' }}>{{ app()->getLocale()==='ar'?'صيدلاني':'Pharmacist' }}</option>
                    <option value="admin" {{ $user->role==='admin'?'selected':'' }}>{{ app()->getLocale()==='ar'?'أدمن':'Admin' }}</option>
                  </select>
                  <button type="submit" class="btn btn-primary btn-sm">{{ __('main.save') }}</button>
                </form>
                @else
                  <span style="font-size:12px;color:var(--text-muted)">—</span>
                @endif
              </td>
              <td style="font-size:13px;color:var(--text-muted)">{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div style="padding:16px">{{ $users->links() }}</div>
      </div>

    </div>
  </main>
</div>
@endsection
