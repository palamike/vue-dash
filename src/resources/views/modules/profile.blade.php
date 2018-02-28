@extends('vueDash::layouts.generic')

@section('content')
    <app-panel>
        <profile></profile>
    </app-panel>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/profile.js') }}"></script>
@endpush