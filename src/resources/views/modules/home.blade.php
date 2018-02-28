@extends('vueDash::layouts.generic')

@section('content')
    <app-panel>
        <dashboard></dashboard>
    </app-panel>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/home.js') }}"></script>
@endpush