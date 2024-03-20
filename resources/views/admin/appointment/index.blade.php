@extends('admin.layouts.app')
@section('wrapper')
<div class="content">
<div class="main">
<h4>{{ $single_heading }}</h4>
   <div class="card">
      <div class="card-body">
         <div class="d-flex ">
           
            <div class="ms-auto">
               <div class="btn-group">

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
                     <th>S.No.</th>
                     <th>Customer</th>
                     <th>Client</th>
                     <th>Date</th>
                     <th>Time</th>
                     <th>Total Price</th>
                     <th>Invoice</th>
                     <th>Details</th>
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
        {data: 'customer' },
        {data: 'client' },
        { data: 'date'},
        { data: 'time'},
        { data: 'price'},
        { data: 'invoice'},
        { data: 'details'},
    ],
    "order": [
        [1, 'DESC']
    ],
    "columnDefs": [{
        "targets": [0,1,2,3,4,5,6,7],
        "orderable": false, 
    }]


});
$('#data-table').on('page.dt', function() {
    $('#checkAll').prop("checked", false);
    $('.filed_check').prop("checked", false);
});


function details(url, id, modal = 'modal-lg') {
    url = url.replace(':id', id);
$('#modal-default .modal-content').html('');
$.ajax({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  url: url,
  method: "GET",
  data: {
    id:id
  },
  success: function (res) {
    $('#' + modal + ' .modal-content').html(res);
    $('#' + modal).modal('show');
  }
});
}

</script>
@endsection

