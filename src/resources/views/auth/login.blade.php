@extends('vueDash::layouts.generic')

@section('content')
    <login-panel company="{{ env('APP_NAME') }}"></login-panel>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth/login.js') }}"></script>
@endpush