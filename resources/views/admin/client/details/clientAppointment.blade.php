<div class="mb-4 d-md-flex align-items-center justify-content-between">
 <div>
 <h4>Appointments</h4>
 </div>                                    
</div>

       <div class="row">
            <div class="col-md-4">
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
<div class="row">
<div class="col-md-12">
<div class="table-responsive">
<div class="card">
      <div class="card-body">
        <input type="hidden" id="client_id" name="client_id" value="{{$client_id}}">
         <div class="table-responsive">
            <table id="data-table2" class="table table-hover table-bordered ">
               <thead>
                  <tr>
                     <th> S.No.</th>
                     <th>User Name</th>
                     <th>User Mobile Number</th>
                     <th>Date</th>
                     <th>Time</th>
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
</div>
</div>
<script>
   var id = $('#client_id').val();
      window.dataTable = $('#data-table2').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'ajax': {
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "{{ $route->clientAppointmentList}}",
        'data': function(data) {
            data.cid=id,
            data.flterAppoit = $('#flterAppoitment').val();
        }
    },
    'lengthMenu': [10, 20, 50, 100, 200],
    'columns': [{ data: 'sno'},
        {data: 'username' },
        {data: 'usermobilenumber' },
        {data: 'date' },
        {data: 'time' },
        { data: 'action'},
    ],
    "order": [
        [1, 'DESC']
    ],
    "columnDefs": [{
        "targets": [0, 3],
        "orderable": false, 
    }]


});
$('#data-table').on('page.dt', function() {
    $('#checkAll').prop("checked", false);
    $('.filed_check').prop("checked", false);
});
function apply()
{
   dataTable.draw();
}

</script>