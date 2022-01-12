@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header">Crud Operation
            <button class="btn btn-sm btn-danger" style="float: right;" data-bs-toggle="modal" data-bs-target="#addEmployee">+ Add Employee</button>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Status</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                  
                </tbody>
                <p class="pagiData"></p>
              </table>
        </div>
    </div>
</div>


  <!-- Create Modal -->
  <div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="addEmployeeForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <ul class="alert alert-danger d-none" id="saveError"></ul>
                <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name.....">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                </div>
                <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone no....">
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image" id="image">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="employeeSubmit" class="btn btn-info btn-sm">Add Employee</button>
            </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Edit Employee -->
  <div class="modal fade" id="editEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="updateEmployeeForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <ul class="alert alert-danger d-none" id="saveError"></ul>
                <input type="hidden" name="ed_id" id="edd_id">
                <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="ed_name" placeholder="Enter your name.....">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                </div>
                <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="ed_phone" name="phone" placeholder="Enter your phone no....">
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

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
                <button type="submit" id="employeeSubmit" class="btn btn-info btn-sm">Update Employee</button>
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
            
            fetchEmployee();

            function fetchEmployee(){
                // e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{route('employee.fetch')}}",
                    dataType: "json",
                    success: function (response) {
                        // console.log(response.employee);
                        $('tbody').html("");
                        $.each(response.employee, function (key, item) { 
                            
                            let status = "";
                            if(item.status == 1){ status = '<span class="badge" style="background: #6b8b69;">Active</span>' }
                            else{status = '<span class="badge" style="background: #000;">InActive</span>'}

                            $('tbody').append('<tr>\
                                <th scope="row">'+`${++key}`+'</th>\
                                <td>'+item.name+'</td>\
                                <td>'+item.phone+'</td>\
                                <td>'+status+'</td>\
                                <td>\
                                    <img src="uploads/employee/'+item.image+'" style="height: 65px; width: 60px" alt="">\
                                </td>\
                                <td>\
                                    <button value="'+item.id+'" type="submit" class="edit_btn btn btn-sm btn-success">Edit</button>\
                                    <button value="'+item.id+'" class="delete_btn btn btn-sm btn-success">Del</button>\
                                </td>\
                            </tr>');
                            
                            $('.pagiData').append(

                            );
                        });

                    }
                });
            }
            function getmark(type) {
                var mark = '';
                if (type == '1'){
                    mark = 'Active'
                } else if (type == '0'){
                    mark = 'InActive'
                }
                return mark;
            }

            $(document).on('click','.edit_btn', function (e) {
                e.preventDefault();
                
                var ed_id = $(this).val();
                // alert(ed_id);
                $('#editEmployee').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/edit-employee/"+ed_id,
                    success: function (response) {
                        console.log(response.employee.name);
                        $('#ed_name').val(response.employee.name);
                        $('#ed_phone').val(response.employee.phone);
                        $('#ed_image_show').attr('src','uploads/employee/'+response.employee.image);
                        $('#edd_id').val(ed_id);

                    },
                    error:function (error){
                          console.log(error); 
                          $('#editEmployee').modal('hide'); 
                          
                    }
                });

            });

            $(document).on('click','.delete_btn', function (e) {
                e.preventDefault();
                
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                var del_id = $(this).val();
                // alert(del_id);
                // $('#editEmployee').modal('show');

                $.ajax({
                    type: "Delete",
                    url: "/delete-employee/"+del_id,
                    dataType: "json",
                    success: function (response) {
                        toastr["success"](response.message);
                        fetchEmployee();
                    },
                    error:function (error){
                          console.log(error); 
                          
                    }
                });

            });

            $(document).on('submit','#updateEmployeeForm', function (e) {
                e.preventDefault();

                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                var id = $('#edd_id').val();
                console.log(id);
                
                let formData = new FormData();
                formData.append('name', $('#ed_name').val());
                formData.append('phone', $('#ed_phone').val());
                formData.append('image', $('#ed_image')[0].files[0]);
                
                $.ajax({
                    type: "POST",
                    url: "{{url('/update-employee/')}}/"+id,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {

                        toastr["success"](response.message);
                        fetchEmployee();
                        // $('#updateEmployeeForm').find('input').val("");
                        $('#editEmployee').modal('hide');

                        // fetchEmployee();
                        // alert(response.message);
                        // location.reload();
                        
                        
                    },
                    error:function (error){
                        toastr["success"](error);
                          console.log(error);  
                          
                    }
                    
                });
            });

           
            $('#employeeSubmit').click(function(e) {
                e.preventDefault();

                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                
                let formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('phone', $('#phone').val());
                formData.append('image', $('#image')[0].files[0]);
                
                $.ajax({
                    type: "POST",
                    url: "{{route('employee.store')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {

                        toastr["success"](response.message);
                        fetchEmployee();
                        $('#addEmployeeForm').find('input').val("");
                        $('#addEmployee').modal('hide');

                        // fetchEmployee();
                        // alert(response.message);
                       
                        // location.reload();
                        
                        
                    },
                    error:function (error){
                          console.log(error);  
                          
                    }
                    
                });
            });
        });
    </script>
@endsection