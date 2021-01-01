@extends('layouts.app', [
    'namePage' => 'Users',
    'class' => 'sidebar-mini',
    'activePage' => 'users',
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
              <a class="btn btn-primary btn-round text-white pull-right" href="{{ route('user.create') }}">{{ __('Add user') }}</a>
            <h4 class="card-title">{{ __('Users') }}</h4>
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
                  <th>{{ __('Profile') }}</th>
                  <th>{{ __('Name') }}</th>
                  <th>{{ __('Email') }}</th>
                  <th>{{ __('Role') }}</th>
                  <th>{{ __('Creation date') }}</th>
                  <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>{{ __('Profile') }}</th>
                  <th>{{ __('Name') }}</th>
                  <th>{{ __('Email') }}</th>
                  <th>{{ __('Role') }}</th>
                  <th>{{ __('Creation date') }}</th>
                  <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($users as $user)
                  <tr>
                    <td>
                      <span class="avatar avatar-sm rounded-circle">
                        <img src="{{ $user->profilePicture() }}" alt="" style="max-width: 80px; border-radiu: 100px">
                      </span>
                    </td>
                    <td>{{$user->firstname}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role->name}}</td>
                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    @can('manage-users', App\User::class)
                      <td class="text-right">
                      @if($user->id!=auth()->user()->id)
                        @can('update', $user)
                          <a type="button" href="{{route("user.edit",$user)}}" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                            <i class="now-ui-icons ui-2_settings-90"></i>
                          </a>
                        @endcan
                        <form action="{{ route('user.destroy', $user) }}" method="post" style="display:inline-block;" class ="delete-form">
                          @csrf
                          @method('delete')
                          <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm delete-button" data-original-title="" title="" onclick="dt.showSwal('warning-message-and-confirmation')">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                          </button>
                        </form>
                      @else
                        <a type="button" href="{{ route('profile.edit') }}" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                          <i class="now-ui-icons ui-2_settings-90"></i>
                        </a>
                      @endif
                      </td>
                    @endcan
                  </tr>
                @endforeach
              </tbody>
            </table>
              @if ($users->lastPage() > 1)
                  <nav aria-label="Page navigation example">
                      <ul class="pagination justify-content-end">
                          @if ($users->currentPage() !== 1)
                              <li class="page-item ">
                                  <a class="page-link" href="{{ $users->url(($users->currentPage()-1)) }}">Previous</a>
                              </li>
                          @endif
                          @for ($i = 1; $i <= $users->lastPage(); $i++)
                              <li class="page-item {{$users->currentPage() == $i ? 'active' : ''}}">
                                  @if ($users->currentPage() == $i)
                                      <a class="page-link">{{ $i }}</a>
                                  @else
                                      <a class="page-link " href="{{ $users->url($i) }}">{{ $i }}</a>
                                  @endif
                              </li>
                          @endfor
                          @if ($users->currentPage() !== $users->lastPage())
                              <li class="page-item">
                                  <a class="page-link" href="{{ $users->url($users->currentPage()+1) }}">Next</a>
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