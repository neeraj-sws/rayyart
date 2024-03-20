<style>
   .select2-container {
    width: 100% !important;
}
</style>
<div class="card">
   <div class="card-body">
      <div class="modal-header">
         <h4 class="modal-title">Add {{ $single_heading }}</h4>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
         <form class="row g-3" action="{{ $route->store }}" onsubmit="event.preventDefault();form_submit(this);return false;" method="POST">
            @csrf
            <div class="col-md-6">
               <label for="name" class="form-label">Customer Name</label>
               <input type="text" class="form-control"  name="name">
            </div>
            <div class="col-md-6">
               <label for="Email" class="form-label">Email</label>
               <input type="email" class="form-control" name="email">
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">Latitude</label>
                <input type="text" class="form-control"  name="latitude">
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">Longitude </label>
                <input type="text" class="form-control"  name="longitude">
            </div>
            <div class="col-md-6">
               <label for="name" class="form-label">Mobile Number</label>
               <input type="number" class="form-control"  name="number">
            </div>
            <div class="col-md-6">
               <label for="Password" class="form-label">Password</label>
               <input type="password" class="form-control" name="password">
            </div>

            <div class="col-md-12">
            <label for="Outletname" class="form-label">Outlet address</label>
               <textarea class="form-control" aria-label="With textarea" id="address" name="address"></textarea>
            </div>
            <div class="col-12">
               <button type="submit" class="btn btn-primary float-end">Save <i class="st_loader spinner-border spinner-border-sm"
                  style="display:none;"></i></button>
            </div>
         </form>
      </div>
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
   $(document).ready(function(){
      $('.select2').select2();
});
     
      
function selectSate()
        {
         // alert('work');
         var selectedValue = document.getElementById("state").value;
         $.ajax({
                  headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                  url: "{{ $route->userStateData }}",
                  method: "POST",
                  data: { id: selectedValue },
                  success: function (response)
                 { 
                  $('#cities').html(response.cities);
                },
               });
        }

</script>