@extends('dashboard.layouts.index')

@section('container-fluid')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="f2">
                            <tr>
                                <th class="text-center">
                                    {{ _d('original') }}
                                </th>
                                <th class="text-center">
                                    {{ _d('reference') }}
                                </th>
                                @foreach (config('larator.langs', $larators->langs) as $lang)
                                    <th class="text-center">
                                        {{ _d("lang.$lang") }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="f1">
                            @foreach ($larators->translates as $original => $translate)
                            <tr>
                                <td class="text-center">{{ $original }}</td>
                                <td class="text-center">
                                    <input type="text" name="reference" data-lijax="change 300" data-method="put" data-action="{{route('dashboard.larators.update', $original)}}" value="{{ isset($translate->reference) ? $translate->reference : '' }}">
                                </td>
                                @foreach (config('larator.langs', $larators->langs) as $lang)
                                    <th class="text-center">
                                    <input type="text" name="{{$lang}}" data-lijax="change 300" data-method="put" data-action="{{route('dashboard.larators.update', $original)}}" value="{{ isset($translate->{$lang}) ? $translate->{$lang} : '' }}">

                                    </th>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection