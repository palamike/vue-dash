@extends('vueDash::layouts.generic')

@section('content')
    <app-panel>
        <user-module></user-module>
    </app-panel>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/users/users.js') }}"></script>
@endpush