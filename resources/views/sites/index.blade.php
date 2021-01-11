@extends('layouts.app', [
    'namePage' => 'Sites',
    'class' => 'sidebar-mini',
    'activePage' => 'sites',
    'activeNav' => '',
])

@section('content')
    <div class="panel-header">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary btn-round text-white pull-right"
                           href="{{ route('sites.create') }}">{{ __('Add site') }}</a>
                        <h4 class="card-title">{{ __('Site list') }}</h4>
                        <div class="col-12 mt-2">
                            @include('alerts.success')
                            @include('alerts.errors')
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr style="font-size: 97%;">
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Website url') }}</th>
                                <th>{{ __('Dealer name') }}</th>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('City') }}</th>
                                <th>{{ __('Dealer number') }}</th>
                                <th>{{ __('Address') }}</th>
                                <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                @if( auth()->user()->isAdmin() )
                                    <th>{{ __('Website url') }}</th>
                                    <th>{{ __('Dealer name') }}</th>
                                    <th>{{ __('Document Root') }}</th>
                                    <th>{{ __('Server ip') }}</th>
                                    <th>{{ __('Db name') }}</th>
                                    <th>{{ __('Db user') }}</th>
                                    <th>{{ __('Db pass') }}</th>
                                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                                @endif
                            </tr>
                            @foreach($sites as $site)
                                @if( auth()->user()->isAdmin() )
                                <tr>
                                    <td>{{$site->old_website_url}}</td>
                                    <td>{{$site->dealer_name}}</td>
                                    <td>{{$site->document_root ? $site->document_root : 'Empty'}}</td>
                                    <td>{{$site->server_ip ? $site->server_ip : 'Empty'}}</td>
                                    <td>{{$site->db_name ? $site->db_name : 'Empty'}}</td>
                                    <td>{{$site->db_user ? $site->db_user : 'Empty'}}</td>
                                    <td>{{$site->db_pass ? $site->db_pass : 'Empty'}}</td>
                                    <td class="text-right">
                                        <a type="button" href="{{route("sites.edit",$site->id)}}" rel="tooltip"
                                           class="btn btn-success btn-icon btn-sm " data-original-title="" title="">

                                            <i class="now-ui-icons ui-2_settings-90"></i>

                                        </a>
                                        <form action="{{ route('sites.destroy', $site) }}" method="post"
                                              style="display:inline-block;" class="delete-form">
                                            @csrf
                                            @method('delete')
                                            <button type="button" rel="tooltip"
                                                    class="btn btn-danger btn-icon btn-sm delete-button"
                                                    data-original-title="" title=""
                                                    onclick="dt.showSwal('warning-message-and-confirmation')">
                                                <i class="now-ui-icons ui-1_simple-remove"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tfoot>
                            <tbody>
                            @foreach($sites as $site)
                                @if($site->to_remove == 0)
                                <tr>
                                    <td>{{$site->type}}</td>
                                    <td>{{$site->old_website_url}}</td>
                                    <td>{{$site->dealer_name}}</td>
                                    <td>{{$site->country}}</td>
                                    <td>{{$site->city}}</td>
                                    <td>{{$site->dealer_number}}</td>
                                    <td>{{$site->address}}</td>
                                    <td class="text-right">
                                        <a type="button" href="{{route("sites.edit",$site->id)}}" rel="tooltip"
                                           class="btn btn-success btn-icon btn-sm " data-original-title="" title="">

                                            <i class="now-ui-icons ui-2_settings-90"></i>

                                        </a>
                                        <form action="{{ route('sites.destroy', $site) }}" method="post"
                                              style="display:inline-block;" class="delete-form">
                                            @csrf
                                            @method('delete')
                                            <button type="button" rel="tooltip"
                                                    class="btn btn-danger btn-icon btn-sm delete-button"
                                                    data-original-title="" title=""
                                                    onclick="dt.showSwal('warning-message-and-confirmation')">
                                                <i class="now-ui-icons ui-1_simple-remove"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        @if ($sites->lastPage() > 1)
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    @if ($sites->currentPage() !== 1)
                                        <li class="page-item ">
                                            <a class="page-link" href="{{ $sites->url(($sites->currentPage()-1)) }}">Previous</a>
                                        </li>
                                    @endif
                                    @for ($i = 1; $i <= $sites->lastPage(); $i++)
                                        <li class="page-item {{$sites->currentPage() == $i ? 'active' : ''}}">
                                            @if ($sites->currentPage() == $i)
                                                <a class="page-link">{{ $i }}</a>
                                            @else
                                                <a class="page-link " href="{{ $sites->url($i) }}">{{ $i }}</a>
                                            @endif
                                        </li>
                                    @endfor
                                    @if ($sites->currentPage() !== $sites->lastPage())
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="{{ $sites->url($sites->currentPage()+1) }}">Next</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
@endsection

@push('js')
    <script>
        $( document ).ready( function(){
            $( ".delete-button" ).click( function(){
                var clickedButton = $( this );
                Swal.fire( {
                    title             : 'Are you sure?',
                    text              : "You won't be able to revert this!",
                    type              : 'warning',
                    showCancelButton  : true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass : 'btn btn-danger',
                    confirmButtonText : 'Yes, delete it!',
                    buttonsStyling    : false
                } ).then( ( result ) => {
                    if( result.value ){
                        clickedButton.parents( ".delete-form" ).submit();
                    }
                } )

            } )
            $( '#datatable' ).DataTable( {
                info      : false,
                paging    : false,
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ 10, 25, 50, "All" ]
                ],
                responsive: true,
                language  : {
                    search           : "_INPUT_",
                    searchPlaceholder: "Search records",
                }

            } );

            var table = $( '#datatable' ).DataTable();

            // Edit record
            table.on( 'click', '.edit', function(){
                $tr = $( this ).closest( 'tr' );
                if( $( $tr ).hasClass( 'child' ) ){
                    $tr = $tr.prev( '.parent' );
                }

                var data = table.row( $tr ).data();
                alert( 'You press on Row: ' + data[ 0 ] + ' ' + data[ 1 ] + ' ' + data[ 2 ] + '\'s row.' );
            } );

            // Delete a record
            table.on( 'click', '.remove', function( e ){
                $tr = $( this ).closest( 'tr' );
                if( $( $tr ).hasClass( 'child' ) ){
                    $tr = $tr.prev( '.parent' );
                }
                table.row( $tr ).remove().draw();
                e.preventDefault();
            } );

            //Like record
            table.on( 'click', '.like', function(){
                alert( 'You clicked on Like button' );
            } );
        } );
    </script>
@endpush
