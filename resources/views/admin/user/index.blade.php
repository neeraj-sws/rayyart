@extends('admin.layouts.app')
@section('wrapper')
<div class="content">
<div class="main">
   <div class="card">
      <div class="card-body">
         <div class="d-flex ">
            <h4>{{ $single_heading }}</h4>
            <div class="ms-auto">
               <div class="btn-group">
                  <a href="javascript:void(0);" class="btn btn-primary" onclick="addForm('{{ $route->add }}');return false;"><i class="bx bxs-plus-square"></i>New {{ $single_heading }}</a>
               </div>
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
                     <th>City</th>
                     <th>Mobile Number</th>
                     <th>Favorite</th>
                     <th>appointments</th>
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
<script>

window.dataTable = $('#data-table').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'ajax': {
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "{{ $route->list }}",
        'data': function(data) {
            
        }
    },
    'lengthMenu': [10, 20, 50, 100, 200],
    'columns': [{ data: 'id'},
        {data: 'name' },
        {data: 'email' },
        {data: 'city' },
        {data: 'mobilenumber' },
        {data: 'favorite' },
        {data: 'appointment' },
        { data: 'action'},
    ],
    "order": [
        [0, 'DESC']
    ],
    "columnDefs": [{
        "targets": [0,3,4,5],
        "orderable": false, 
    }]


});
$('#data-table').on('page.dt', function() {
    $('#checkAll').prop("checked", false);
    $('.filed_check').prop("checked", false);
});



function showfav(url, id, modal = 'modal-lg') {

$('#modal-default .modal-content').html('');
url = url.replace(':id', id);
$.ajax({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  url: url,
  method: "GET",
  data: {},
  success: function (res) {
    $('#' + modal + ' .modal-content').html(res);
    $('#' + modal).modal('show');
  }
});
}


</script>
@endsection

