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
                <h4>You are not searching anything!</h4>
            </div>
        </div>
    </div>
@endsection