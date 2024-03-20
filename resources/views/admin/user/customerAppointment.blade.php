@extends('admin.layouts.app')
@section('wrapper')
<div class="content">
<div class="main">
<h4>{{ $single_heading }} Appointments</h4>
<div class="card">
      <div class="card-body">
       <div class="row">
            <div class="col-md-3">
            <select class="form-select select2 " name="flterAppoitment" id="flterAppoitment">
                  <option value=""> Appointment...</option>
                  <option value="0"> Todays Appointment </option>
                  <option value="1"> Previous Appointment </option>
                  <option value="2"> Upcoming Appointment </option>
               
               </select>
            </div>
            <div class="col-md-2 ms-auto text-end"> 
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
                     <th>Outlet Name</th>
                     <th>Mobile Number</th>
                     <th>Date</th>
                     <th>Start Time</th>
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
        'url': "{{ $route->customerAppointmentList }}",
        'data': function(data) {
            data.id = "{{$id}}",
            data.flterAppoitment = $('#flterAppoitment').val();
        }
    },
    'lengthMenu': [10, 20, 50, 100, 200],
    'columns': [{ data: 'id'},
        {data: 'clientname' },
        {data: 'email' },
        {data: 'outlet_name' },
        {data: 'mobilenumber' },
        {data: 'date' },
        {data: 'starttime' },
        {data: 'action' },
    ],
    "order": [
        [0, 'DESC']
    ],
    "columnDefs": [{
        "targets": [0,1,2,3,4,5],
        "orderable": false, 
    }]


});
$('#data-table').on('page.dt', function() {
    $('#checkAll').prop("checked", false);
    $('.filed_check').prop("checked", false);
});

function showappointment(url, id, modal = 'modal-lg')
{
   $('#modal-default .modal-content').html('');
$.ajax({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  url: url,
  method: "GET",
  data: {'id':id},
  success: function (res) {
    $('#' + modal + ' .modal-content').html(res);
    $('#' + modal).modal('show');
  }
});
}

function apply()
{
   dataTable.draw();
}

</script>
@endsection