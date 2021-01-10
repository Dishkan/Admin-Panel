@extends('layouts.app', [
    'namePage' => 'Roles',
    'class' => 'sidebar-mini',
    'activePage' => 'roles',
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
                        <a class="btn btn-primary btn-round text-white pull-right" href="{{ route('role.create') }}" >{{ __('Add role')}}</a>
                        <h4 class="card-title">{{ __('Roles') }}</h4>
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
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Creation date') }}</th>
                                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Creation date') }}</th>
                                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{$role->name}}</td>
                                        <td>{{$role->description}}</td>
                                        <td>{{ $role->created_at->format('d/m/Y H:i') }}</td>
                                        @can('manage-users', App\User::class)
                                            <td class="text-right">
                                                @if (auth()->user()->can('update', $role) || auth()->user()->can('delete', $role))
                                                    @can('update', $role)
                                                        <a type="button" href="{{route("role.edit",$role)}}" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                                                            <i class="now-ui-icons ui-2_settings-90"></i>
                                                        </a>
                                                        <form action="{{ route('role.destroy', $role) }}" method="post"
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
                                                    @endcan
                                                @endif
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($roles->lastPage() > 1)
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    @if ($roles->currentPage() !== 1)
                                        <li class="page-item ">
                                            <a class="page-link" href="{{ $roles->url(($roles->currentPage()-1)) }}">Previous</a>
                                        </li>
                                    @endif
                                    @for ($i = 1; $i <= $roles->lastPage(); $i++)
                                        <li class="page-item {{$roles->currentPage() == $i ? 'active' : ''}}">
                                            @if ($roles->currentPage() == $i)
                                                <a class="page-link">{{ $i }}</a>
                                            @else
                                                <a class="page-link " href="{{ $roles->url($i) }}">{{ $i }}</a>
                                            @endif
                                        </li>
                                    @endfor
                                    @if ($roles->currentPage() !== $roles->lastPage())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $roles->url($roles->currentPage()+1) }}">Next</a>
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
    $(document).ready(function() {
      $(".delete-button").click(function(){ 
        var clickedButton = $( this );
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Yes, delete it!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          clickedButton.parents(".delete-form").submit();
        }
      })

      })
        $('#datatable').DataTable({
            info: false,
            paging : false,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });

      var table = $('#datatable').DataTable();

      // Edit record
      table.on('click', '.edit', function() {
        $tr = $(this).closest('tr');
        if ($($tr).hasClass('child')) {
          $tr = $tr.prev('.parent');
        }

        var data = table.row($tr).data();
        alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
      });

      // Delete a record
      table.on('click', '.remove', function(e) {
        $tr = $(this).closest('tr');
        if ($($tr).hasClass('child')) {
          $tr = $tr.prev('.parent');
        }
        table.row($tr).remove().draw();
        e.preventDefault();
      });

      //Like record
      table.on('click', '.like', function() {
        alert('You clicked on Like button');
      });
    });
  </script>
@endpush