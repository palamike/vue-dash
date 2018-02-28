@extends('vueDash::layouts.generic')

@section('content')
    <app-panel>
        <general-setting-module></general-setting-module>
    </app-panel>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/settings/general_settings.js') }}"></script>
@endpush