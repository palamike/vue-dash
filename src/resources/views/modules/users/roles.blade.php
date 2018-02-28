@extends('vueDash::layouts.generic')

@section('content')
    <app-panel>
        <role-module></role-module>
    </app-panel>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/users/roles.js') }}"></script>
@endpush