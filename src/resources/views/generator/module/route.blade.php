Route::get('/{{$parentPluralKebab}}/{{$modulePluralKebab}}', '{{$parentPlural}}\{{$moduleSingular}}Controller@index')->name('{{$modulePluralLower}}')->middleware('permission:{{$moduleSingularSnake}}_view');
    Route::post('/{{$parentPluralKebab}}/{{$modulePluralKebab}}/grid', '{{$parentPlural}}\{{$moduleSingular}}Controller@grid')->name('{{$modulePluralLower}}Grid')->middleware('permission:{{$moduleSingularSnake}}_view');
    Route::post('/{{$parentPluralKebab}}/{{$modulePluralKebab}}/view', '{{$parentPlural}}\{{$moduleSingular}}Controller@view')->name('{{$modulePluralLower}}View')->middleware('permission:{{$moduleSingularSnake}}_view');
    Route::post('/{{$parentPluralKebab}}/{{$modulePluralKebab}}/create', '{{$parentPlural}}\{{$moduleSingular}}Controller@create')->name('{{$modulePluralLower}}Create')->middleware('permission:{{$moduleSingularSnake}}_add');
    Route::post('/{{$parentPluralKebab}}/{{$modulePluralKebab}}/update', '{{$parentPlural}}\{{$moduleSingular}}Controller@update')->name('{{$modulePluralLower}}Update')->middleware('permission:{{$moduleSingularSnake}}_edit');
    Route::post('/{{$parentPluralKebab}}/{{$modulePluralKebab}}/delete', '{{$parentPlural}}\{{$moduleSingular}}Controller@delete')->name('{{$modulePluralLower}}Delete')->middleware('permission:{{$moduleSingularSnake}}_delete');
    Route::post('/{{$parentPluralKebab}}/{{$modulePluralKebab}}/delete-selected', '{{$parentPlural}}\{{$moduleSingular}}Controller@deleteSelected')->name('{{$modulePluralLower}}DeleteSelected')->middleware('permission:{{$moduleSingularSnake}}_delete');

    /**ROUTE_REPLACER**/