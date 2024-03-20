<div class="card">
   <div class="card-body">
      <div class="modal-header">
         <h4 class="modal-title">Add Holidays</h4>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
         <form class="row g-3" action="{{$route->storeholiday}}" onsubmit="event.preventDefault();storeholiday(this);return false;" method="POST">
            @csrf
            <input type="hidden"  name ="client_id" value="{{ $cid->id }}">
            <div class="form-div">
               <div class="row">
                     <div class="row">
                        <div class="col-md-4">
                        <label for="status" class="form-label">Date</label>
                            <input type="text" class="form-control datepicker" name="date" value="{{ date('d/m/Y') }}">
                       </div>
                        <div class="col-md-4">
                        <label for="status" class="form-label">Title</label>
                           <input type="text" class="form-control" id="price" placeholder="title" name ="title">
                        </div>
                        <div class="col-md-4 mt-4" style="text-align: right;">
                           <button type="submit" class="btn btn-primary" id="add-row">Add</button>
                        </div>
                     </div>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="card-body">
         <div class="table-responsive">
            <table id="data-table6" class="table table-hover">
               <thead>
               <tr>
                     <th> S.No.</th>
                     <th>Date</th>
                     <th>Title</th>
                    <th>Action</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>


      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$( ".datepicker" ).datepicker({
});
  
id = "{{ $cid->id }}";
$('.select2').select2();
   window.dataTable = $('#data-table6').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'ajax': {
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "{{ $route->holidaylist}}",
        'data': function(data) {
            data.cid=id
        }
    },
    'lengthMenu': [10, 20, 50, 100, 200],
    'columns': [{ data: 'sno'},
        {data: 'date' },
        {data: 'title' },
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

</script>

