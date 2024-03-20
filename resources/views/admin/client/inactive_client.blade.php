@extends('admin.layouts.app')
@section('wrapper')

<div class="content">
<div class="main">
<div class="row d-flex mb-2">
   <div class="col-2">
      <h4 class="mt-2">{{ $single_heading }}</h4>
   </div>
   <div class="col-4 ms-auto text-end ">
               <div class="btn-group">
                  <a href="{{$route->add}}" class="btn btn-primary"><i class="bx bxs-plus-square"></i>New {{ $single_heading }}</a>
               </div>
            </div> 
</div>
   <div class="card">
      <div class="card-body">
         <div class="row d-flex align-items-center">

         <div class="col-sm-2 mb-2">
               <select class="form-select select2 " name="username" id="username" onchange="getSelectedValue()">
                  <option value="">Client Name...</option>
                  @foreach($usernames as $username)
                  <option value="{{$username->id}}">{{$username->name}}</option>
                  @endforeach
               </select>
               </div>

               <div class="col-sm-2 mb-2">
               <select class="form-select select2 " name="category" id="category">
                  <option value="">Category...</option>
                  @foreach($categories as $category)
                  <option value="{{$category->id}}">{{$category->title}}</option>
                  @endforeach
               </select>
               </div>
               
               

               <div class="col-sm-2 mb-2">
               <select class="form-select select2 " name="service" id="service">
                  <option value="">Services...</option>
                  @foreach($services as $service)
                  <option value="{{$service->services}}">{{$service->services}}</option>
                  @endforeach
               </select>
               </div>
               
                <div class="col-sm-2 mb-2">
               <select class="form-select select2 " name="city" id="city">
                  <option value="">Cities...</option>
                  @foreach($cities as $city)
                  <option value="{{$city->id}}">{{$city->name}}</option>
                  @endforeach
               </select>
               </div>
               <div class="col-sm-2 ms-auto text-md-end text-center sm-mt-2 mt-2 mt-md-0">
               <button type="button" onclick="apply();" class="me-2 btn btn-primary text-white rounded-2  px-4 py-2">Search</button>
               </div>
         </div>
      </div>
   </div>
   <div class="card">
      <div class="card-body">
         <div class="table-responsive">
            <table id="data-table" class="table table-hover">
               <thead>
                  <tr>
                     <th> S.No.</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Cities</th>
                     <th>Category</th>
                     <th>Services</th>
                     <th>Holidays</th>
                     <th>Slot</th>
                     <th>Outlet Name</th>
                     <th>Status</th>
                     <th>Details</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection
@section('page-js-script')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>



<script>
   
    window.dataTable = $('#data-table').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'ajax': {
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "{{ $route->inactive }}",
        'data': function(data)
        {
            data.category = $('#category').val();
            data.username =$('#username').val();
            data.service = $('#service').val();
            data.city = $('#city').val();
        }
    },
    'lengthMenu': [10, 20, 50, 100, 200],
    'columns': [
      { data: 'sno'},
        {data: 'name' },
        {data: 'email' },
        {data: 'cities' },
        {data: 'category' },
        {data: 'services' },
        {data: 'holidays' },
        {data: 'slot' },
        {data: 'outlet name'},
        {data: 'status' },
        {data: 'detail' },
        { data: 'action'},
    ],
    "order": [
        [1, 'DESC']
    ],
    "columnDefs": [{
        "targets": [0, 3,4,5,6,7],
        "orderable": false, 
    }]


});
$('#data-table').on('page.dt', function() {
    $('#checkAll').prop("checked", false);
    $('.filed_check').prop("checked", false);
});


    
     function getSelectedValue() {
   var selectedValue = document.getElementById("username").value;
   $.ajax({
    url: "{{ $route->getClientData }}",
    method: "GET",
    data: { id: selectedValue },
    success: function (response) { 
            $('#category').html(response.category);
            $('#service').html(response.services);
            $('#city').html(response.city);
            
    },
});
  }

function apply()
{
   dataTable.draw();
}
$('.select2').select2();
</script>
@endsection