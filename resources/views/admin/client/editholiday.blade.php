<div class="card">
<div class="card-body">
   <div class="modal-header">
      <h4 class="modal-title">Edit {{ $single_heading }} Services</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
   <div class="modal-body py-3">
      <form class="row g-3" action="{{$route->updateholiday}}" onsubmit="event.preventDefault();editholiday(this);return false;" method="POST">
         @csrf
         <input type="hidden"  name ="id" value="{{ $holiday->id }}">
         <div class="form-div">
            <div class="row">
               <div class="col-md-4">
               <label for="status" class="form-label">Date</label>
                  <input type="text" class="form-control datepicker" id="price" name ="date" value="{{$holiday->date}}">
               </div>
               <div class="col-md-4">
               <label for="status" class="form-label">Title</label>
                  <input type="text" class="form-control" id="price"  name ="title" value="{{$holiday->title}}">
               </div>
                  <div class="col-md-4 mt-4" style="text-align: right;">
                     <button type="submit" class="btn btn-primary" id="add-row">Update</button>
                  </div>
            </div>
         </div>
      </form>
   </div>
</div>
<script>
    $( ".datepicker" ).datepicker({
       
    });
</script>