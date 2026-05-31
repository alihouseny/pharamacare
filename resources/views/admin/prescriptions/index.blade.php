@extends('layouts.app')
@section('title', app()->getLocale()==='ar'?'الروشيتات':'Prescriptions')

@section('content')
<div class="admin-layout">
  @include('admin._sidebar')
  <main class="admin-main">
    <div class="admin-topbar"><button class="sidebar-toggle-btn" onclick="toggleSidebar()" style="margin-inline-end:8px"><i class="fas fa-bars"></i></button>
      <h1 style="font-size:20px;font-weight:800"><i class="fas fa-file-prescription"></i> {{ app()->getLocale()==='ar'?'الروشيتات':'Prescriptions' }}</h1>
    </div>
    <div class="admin-content">
      <div class="card" style="padding:0;overflow:hidden">
        <table class="table">
          <thead><tr>
            <th>#</th>
            <th>{{ app()->getLocale()==='ar'?'العميل':'Customer' }}</th>
            <th>{{ app()->getLocale()==='ar'?'الصورة':'Image' }}</th>
            <th>{{ app()->getLocale()==='ar'?'التاريخ':'Date' }}</th>
            <th>{{ app()->getLocale()==='ar'?'الحالة':'Status' }}</th>
            <th>{{ app()->getLocale()==='ar'?'إجراء':'Action' }}</th>
          </tr></thead>
          <tbody>
            @foreach($prescriptions as $rx)
            <tr>
              <td style="font-family:monospace">#{{ $rx->id }}</td>
              <td>
                <div style="font-weight:700">{{ $rx->user->name }}</div>
                <div style="font-size:12px;color:var(--text-muted)">{{ $rx->user->phone }}</div>
              </td>
              <td>
                <a href="{{ asset('storage/'.$rx->image) }}" target="_blank">
                  <img src="{{ asset('storage/'.$rx->image) }}" style="width:48px;height:48px;object-fit:cover;border-radius:6px">
                </a>
              </td>
              <td style="font-size:13px">{{ $rx->created_at->format('d/m/Y H:i') }}</td>
              <td>
                @php $cls=['pending'=>'badge-orange','approved'=>'badge-green','rejected'=>'badge-red','used'=>'badge-gray']; @endphp
                <span class="badge {{ $cls[$rx->status]??'badge-gray' }}">{{ $rx->status }}</span>
              </td>
              <td>
                @if($rx->status === 'pending')
                <div style="display:flex;gap:6px">
                  <form action="{{ route('admin.prescriptions.review',$rx) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    <button class="btn btn-primary btn-sm"><i class="fas fa-check"></i></button>
                  </form>
                  <form action="{{ route('admin.prescriptions.review',$rx) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                  </form>
                </div>
                @else
                  <span style="font-size:13px;color:var(--text-muted)">{{ $rx->pharmacist_notes ?: '—' }}</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div style="padding:16px">{{ $prescriptions->links() }}</div>
      </div>
    </div>
  </main>
</div>
@endsection
