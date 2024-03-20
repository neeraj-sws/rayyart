<div class="card">
   <div class="card-body">
      <div class="modal-header">
         <h4 class="modal-title">Add {{ $single_heading }} Services</h4>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
         <form class="row g-3" action="{{$route->storeservices}}" onsubmit="event.preventDefault();storeservices(this);return false;" method="POST">
            @csrf
            <input type="hidden"  name ="client_id" value="{{ $cid->id }}">
            <div class="form-div">
               <div class="row">
               <div class="col-md-5">
                <select class="form-select" name="services_id">
                <option value=""> Select Services ... </option>
                @foreach($services as $service)
                <option value="{{ $service->id }}" > {{ $service->title }} </option>
                @endforeach
                </select>
               </div>
                  <div class="col-md-5">
                     <input type="text" class="form-control" id="price" placeholder="add price" name ="price">
                  </div>
                  <div class="col-md-2" style="text-align: right;">
                     <button type="submit" class="btn btn-primary" id="add-row">Add</button>
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
                     <th>Services</th>
                     <th>Price</th>
                    <th>Action</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
      
<script>
id = "{{ $cid->id }}";
  
   window.dataTable = $('#data-table6').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'ajax': {
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "{{ $route->clientServicesList}}",
        'data': function(data) {
            data.cid=id
        }
    },
    'lengthMenu': [10, 20, 50, 100, 200],
    'columns': [{ data: 'sno'},
        {data: 'services_id' },
        {data: 'price' },
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

