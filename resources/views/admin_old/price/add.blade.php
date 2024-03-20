
<div class="card">
   <div class="card-body">
      <div class="modal-header">
         <h4 class="modal-title">Add {{ $single_heading }}</h4>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
         <form class="row g-3" action="{{$route->store}}" onsubmit="event.preventDefault();form_submit(this);return false;" method="POST">
            @csrf
            <div class="col-md-12">
               <label for="name" class="form-label">Price</label>
               <input type="number" class="form-control allowno"  name="price">
            </div>
            <div class="col-md-12">
                <label for="status" class="form-label">Category</label>
                <select class="form-select" name="category_id">
                <option value=""> Select Category ... </option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}"> {{ $category->title }} </option>
                @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label for="status" class="form-label">Services</label>
                <select class="form-select" name="services_id">
                <option value=""> Select Services ... </option>
                @foreach($services as $service)
                <option value="{{ $service->id }}" > {{ $service->title }} </option>
                @endforeach
                </select>
            </div>
    
            <div class="col-12">
                <hr>
               <button type="submit" class="btn btn-primary float-end">Save <i class="st_loader spinner-border spinner-border-sm"
                  style="display:none;"></i></button>
            </div>
         </form>
      </div>
   </div>
</div>