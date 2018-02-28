#extends('vueDash::layouts.generic')

#section('content')
    <app-panel>
        <{{$moduleSingularKebab}}-module></{{$moduleSingularKebab}}-module>
    </app-panel>
#endsection

#push('scripts')
    <script src="[[ asset('js/modules/{{$parentPluralSnake}}/{{$modulePluralSnake}}.js') ]]"></script>
#endpush