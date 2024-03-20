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
               <div class="col-md-3">
               <label for="status" class="form-label">Service</label>
                  <input type="text" class="form-control"  name="services" placeholder="services" value="{{$spriceid->services}}">
               </div>
               <div class="col-md-3">
               <label for="status" class="form-label">Category</label>
                  <select class="form-select" name="category_id">
                     <option value=""> Select Category ... </option>
                     @foreach($categories as $category)
                     <option value="{{ $category->id }}" @if($category->id == $spriceid->category_id) selected @endif> {{ $category->title }} </option>
                     @endforeach
                  </select>
               </div>
               <div class="col-md-6">
                  <div class="row">
               <div class="col-md-4">
               <label for="status" class="form-label">Sub Category</label>
                  <select class="form-select" name="Sub_category">
                     @foreach($subcat as $subcategory)
                     <option value="{{ $subcategory->id }}" @if($subcategory->id == $spriceid->sub_category_id) selected @endif> {{ $subcategory->title }} </option>
                     @endforeach
                  </select>
               </div>
               <div class="col-md-4">
               <label for="status" class="form-label">Price</label>
                  <input type="text" class="form-control" id="price" placeholder="add price" name ="price" value="{{$spriceid->price}}">
               </div>
                  <div class="col-md-4 mt-4" style="text-align: right;">
                     <button type="submit" class="btn btn-primary" id="add-row">Update</button>
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>