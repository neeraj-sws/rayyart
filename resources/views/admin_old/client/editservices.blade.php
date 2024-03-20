<div class="card">
<div class="card-body">
   <div class="modal-header">
      <h4 class="modal-title">Edit {{ $single_heading }} Services</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
   <div class="modal-body py-3">
      <form class="row g-3" action="{{$route->clientServicesUpdate}}" onsubmit="event.preventDefault();editservices(this);return false;" method="POST">
         @csrf
         <input type="hidden"  name ="id" value="{{ $spriceid->id }}">
         <div class="form-div">
            <div class="row">
               <div class="col-md-5">
                  <select class="form-select" name="services_id">
                     <option value=""> Select Services ... </option>
                     @foreach($services as $service)
                     <option value="{{ $service->id }}" @if($service->id == $spriceid->services_id) selected @endif> {{ $service->title }} </option>
                     @endforeach
                  </select>
               </div>
               <div class="col-md-5">
                  <input type="text" class="form-control" id="price" placeholder="add price" name ="price" value="{{$spriceid->price}}">
               </div>
               <div class="col-md-2" style="text-align: right;">
                  <button type="submit" class="btn btn-primary" id="add-row">Update</button>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>