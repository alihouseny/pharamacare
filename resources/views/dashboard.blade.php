@extends('layouts.app')
@section('content')
<div class="container" style="padding:40px 20px;text-align:center">
  <p>{{ app()->getLocale()==='ar'?'جاري التحويل...':'Redirecting...' }}</p>
  <script>window.location = "{{ route('account.dashboard') }}";</script>
</div>
@endsection
