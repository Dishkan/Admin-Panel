@extends('layouts.app', [
    'namePage' => 'Search',
    'class' => 'sidebar-mini',
    'activePage' => 'search',
    'activeNav' => '',
])

@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="card-header"><b>{{ $searchResults->count() }} results found for "{{ request('query') }}"</b>
                </div>

                <div class="card-body">
                    @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                        <h3>{{ ucfirst($type) }}</h3>

                        @foreach($modelSearchResults as $searchResult)
                            <ul>
                                <li style="font-weight:bold;"><a href="{{ $searchResult->url }}">{{ $searchResult->title }}</a></li>
                            </ul>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection