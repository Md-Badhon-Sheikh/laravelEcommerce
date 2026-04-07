@extends('layouts.admin')
@section('content')
  <div class="main-content-inner">
      <div class="main-content-wrap">
          <div class="flex items-center flex-wrap justify-between gap20 mb-27">
              <h3>Brands</h3>
              <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                  <li>
                      <a href="{{route('index')}}">
                          <div class="text-tiny">Dashboard</div>
                      </a>
                  </li>
                  <li>
                      <i class="icon-chevron-right"></i>
                  </li>
                  <li>
                      <div class="text-tiny">Brands</div>
                  </li>
              </ul>
          </div>

          <div class="wg-box">
              <div class="flex items-center justify-between gap10 flex-wrap">
                  <div class="wg-filter flex-grow">
                      <form class="form-search">
                          <fieldset class="name">
                              <input type="text" placeholder="Search here..." class="" name="name"
                                  tabindex="2" value="" aria-required="true" required="">
                          </fieldset>
                          <div class="button-submit">
                              <button class="" type="submit"><i class="icon-search"></i></button>
                          </div>
                      </form>
                  </div>
                  <a class="tf-button style-1 w208" href="{{ route('add.brand') }}"><i
                          class="icon-plus"></i>Add new</a>
              </div>
              <div class="wg-table table-all-user">
                  <div class="table-responsive">
                     
                      <table class="table table-striped table-bordered">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Name</th>
                                  <th>Image</th>
                                  <th>Slug</th>
                                  <th>Products</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($brands as $brand)
                              <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  <td>{{ $brand->name }}</td>
                                  <td class="pname">
                                      <div class="image">
                                          <img src="{{ asset('uploads/brands') }}/{{$brand->image}}" alt="{{$brand->name}}" class="image">
                                      </div>
                                      
                                  </td>

                                  <td>{{ $brand->slug }}</td>
                                  <td><a href="#" target="_blank">0</a></td>
                                  <td>
                                      <div class="list-icon-function">
                                          <a href="{{ route('edit.brand',['id' => $brand->id]) }}">
                                              <div class="item edit">
                                                  <i class="icon-edit-3"></i>
                                              </div>
                                          </a>
                                          <form>
                                            <div class="item text-danger delete" data-id="{{ $brand->id }}">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </form>
                                      </div>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
                  <div class="divider"></div>
                  <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{$brands->links('pagination::bootstrap-5')}}
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    #toast-container * {
        font-size: 12px;
    }
</style>
<script>
    
    $(function() {
        $('.delete').on('click', function(e) {
            e.preventDefault();
            var brandId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/brands/delete/' + brandId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                // Remove row from table without page reload
                                $('[data-id="' + brandId + '"]').closest('tr').fadeOut(500, function() {
                                    $(this).remove();
                                });
                                toastr.success(response.message);
                            }
                        },
                        error: function() {
                            toastr.error('Something went wrong!');
                        }
                    });
                }
            });
        });
});

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "4000",
    }

    @if(Session::has('status'))
        toastr.success("{{ Session::get('status') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif
</script>
@endpush