@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header">Crud Operation
            <button class="btn btn-sm btn-danger" style="float: right;" data-bs-toggle="modal" data-bs-target="#addProduct">+ Add Product</button>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Items</th>
                    <th scope="col">Status</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $item)
                        <tr>
                            <td scope="col">{{ ++$key }}</td>
                            <td scope="col">{{ $item->name }}</td>
                            <td scope="col">{{ $item->items }}</td>
                            <td scope="col">
                                @if($item->status)
                                    <span class="badge badge-info" style="background: #3e7c68;width: 75px;">Active</span>
                                @else
                                    <span class="badge" style="background: #000;width: 75px;">InActive</span>
                                
                                @endif
                            </td>
                            <td scope="col">
                                <img src="{{ 'uploads/product/'.$item->image }}" style="height: 50px; width: 55px;" alt="">
                            </td>
                            <td scope="col">
                                @if($item->status == 0)
                                <button value="{{ $item->id }}" type="submit" class="active_btn btn btn-sm btn-primary"><i class="fa fa-arrow-up" title="Active Now"></i></button>
                                @else
                                <button value="{{ $item->id }}" type="submit" class="inactive_btn btn btn-sm btn-dark"><i class="fa fa-arrow-down" title="InActive Now"></i></button>
                                @endif
                                <button value="{{ $item->id }}" type="submit" class="edit_btn btn btn-sm btn-success"><i class="fa fa-edit"></i></button>
                                <button value="{{ $item->id }}" class="delProduct btn btn-sm btn-success"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                  
                </tbody>
                
              </table>
              
              <div>
                {{ $products->render("pagination::semantic-ui") }}

                {{-- {!! $products->render() !!} --}}
                {{-- {{ $products->render("pagination::bootstrap-4") }} --}}
                {{ $products->render("pagination::simple-bootstrap-4") }}
                @if ($products->lastPage() > 1)
                    <ul class="pagination">
                        <li class="{{ ($products->currentPage() == 1) ? ' disabled' : '' }}" style="padding: 5px 8px; border: 1px solid #bdbdbd;">
                            <a href="{{ $products->url(1) }}" style="text-decoration: none;"><<</a>
                        </li>
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <li class="{{ ($products->currentPage() == $i) ? ' active' : '' }}" style="padding: 5px 12px; border: 1px solid #bdbdbd;">
                                <a href="{{ $products->url($i) }}" style="text-decoration: none;">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="{{ ($products->currentPage() == $products->lastPage()) ? ' disabled' : '' }}" style="padding: 5px 8px; border: 1px solid #bdbdbd;">
                            <a href="{{ $products->url($products->currentPage()+1) }}" style="text-decoration: none;" > >> </a>
                        </li>
                    </ul>
                @endif
                <?php
                // config
                $link_limit = 9; // maximum number of links (a little bit inaccurate, but will be ok for now)
                ?>
                
                @if ($products->lastPage() > 1)
                
                    <ul class="pagination">
                        <li class="{{ ($products->currentPage() == 1) ? ' disabled' : '' }}" style="padding: 5px 8px; border: 1px solid #bdbdbd;">
                            <a href="{{ $products->url(1) }}" style="text-decoration: none;"> << </a>
                        </li>
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <?php
                            $half_total_links = floor($link_limit / 2);
                            $from = $products->currentPage() - $half_total_links;
                            $to = $products->currentPage() + $half_total_links;
                            if ($products->currentPage() < $half_total_links) {
                            $to += $half_total_links - $products->currentPage();
                            }
                            if ($products->lastPage() - $products->currentPage() < $half_total_links) {
                                $from -= $half_total_links - ($products->lastPage() - $products->currentPage()) - 1;
                            }
                            ?>
                            @if ($from < $i && $i < $to)
                                <li class="{{ ($products->currentPage() == $i) ? ' active' : '' }}" style="padding: 5px 12px; border: 1px solid #bdbdbd;">
                                    <a href="{{ $products->url($i) }}" style="text-decoration: none;">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        <li class="{{ ($products->currentPage() == $products->lastPage()) ? ' disabled' : '' }}" style="padding: 5px 8px; border: 1px solid #bdbdbd;">
                            <a href="{{ $products->url($products->lastPage()) }}" style="text-decoration: none;"> >> </a>
                        </li>
                    </ul>
                @endif

 
              
        </div>
    </div>
</div>


  <!-- Create Modal -->
  <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="addProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <ul class="alert alert-danger d-none" id="saveError"></ul>
                <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="ad_name" placeholder="Enter your name.....">
                {{-- @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror --}}

                </div>
                <div class="mb-3">
                <label for="items" class="form-label">Items</label>
                <input type="number" class="form-control" id="ad_item" name="items" placeholder="Enter your items no....">
                {{-- @error('items')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror --}}

                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image" id="ad_image">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="productAdded" class="btn btn-info btn-sm">Add Product</button>
            </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Edit Product -->
  <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="updateProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <ul class="alert alert-danger d-none" id="saveError"></ul>
                <input type="hidden" name="ed_id" id="edd_id">
                <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="ed_name" placeholder="Enter your name.....">
                {{-- @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror --}}

                </div>
                <div class="mb-3">
                <label for="items" class="form-label">items</label>
                <input type="text" class="form-control" id="ed_items" name="items" placeholder="Enter your items no....">
                {{-- @error('items')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror --}}

                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image" id="ed_image">
                    <br>
                    <img src="" height="150" width="270" alt=""  id="ed_image_show">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="productUpdate" class="btn btn-info btn-sm">Update Product</button>
            </div>
        </form>

      </div>
    </div>
  </div>

  
@endsection

@section('scripts')
    <script>
                                 
        $(document).ready(function () {
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            // Product Added
           $('#productAdded').click(function(e) {
                e.preventDefault();

                
                let formData = new FormData();
                formData.append('name', $('#ad_name').val());
                formData.append('items', $('#ad_item').val());
                formData.append('image', $('#ad_image')[0].files[0]);

                console.log(formData);
                
                $.ajax({
                    type: "POST",
                    url: "{{route('product.store')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // alert('Ok');
                        console.log(response.message);
                        // fetchEmployee();
                        $('#addProductForm').find('input').val("");
                        $('#addProduct').modal('hide');
                        window.location.reload();
                        
                    },
                    error:function (error){
                          console.log(error);  
                          
                    }
                    
                });
            });
            
            // Product Edit
            $(document).on('click','.edit_btn', function (e) {
                e.preventDefault();
                
                var ed_id = $(this).val();
                // alert(ed_id);
                $('#editProduct').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/edit-product/"+ed_id,
                    success: function (response) {
                        console.log(response.product.name);
                        $('#ed_name').val(response.product.name);
                        $('#ed_items').val(response.product.items);
                        $('#ed_image_show').attr('src','uploads/product/'+response.product.image);
                        $('#edd_id').val(ed_id);

                    },
                    error:function (error){
                          console.log(error); 
                          $('#editProduct').modal('hide'); 
                          
                    }
                });

            });

            // Product Active now
            $(document).on('click','.active_btn', function (e) {
                e.preventDefault();
                
                var ed_id = $(this).val();
                // alert(ed_id);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/active-product/"+ed_id,
                    success: function (response) {
                        window.location.reload();
                        console.log(response.status);

                    },
                    error:function (error){
                          console.log(error); 
                          
                    }
                });

            });

            // Product Inactive now
            $(document).on('click','.inactive_btn', function (e) {
                e.preventDefault();
                
                var ed_id = $(this).val();
                // alert(ed_id);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/inactive-product/"+ed_id,
                    success: function (response) {
                        window.location.reload();
                        console.log(response.status);

                    },
                    error:function (error){
                          console.log(error); 
                          
                    }
                });

            });

            // Product deleted now
            $(document).on('click','.delProduct', function (e) {
                e.preventDefault();

                var del_id = $(this).val();
                // alert(del_id);

                $.ajax({
                    type: "Delete",
                    url: "/delete-product/"+del_id,
                    dataType: "json",
                    success: function (response) {
                        window.location.reload();
                        console.log(response.message);
                        
                    },
                    error:function (error){
                          console.log(error); 
                          
                    }
                });

            });

            // Product Updated now
            $(document).on('submit','#updateProductForm', function (e) {
                e.preventDefault();

                var id = $('#edd_id').val();
                // alert(id);
                
                let formData = new FormData();
                formData.append('name', $('#ed_name').val());
                formData.append('items', $('#ed_items').val());
                formData.append('image', $('#ed_image')[0].files[0]);
                
                $.ajax({
                    type: "POST",
                    url: "{{url('/update-product/')}}/"+id,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {

                        $('#editProduct').modal('hide');
                        window.location.reload();
                        
                    },
                    error:function (error){
                          console.log(error);  
                          
                    }
                    
                });
            });

        });
    </script>
@endsection