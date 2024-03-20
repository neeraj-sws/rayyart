<div class="mb-4 d-md-flex align-items-center justify-content-between">
 <div>
 <h4>Amenities</h4>
 </div>                                    
</div>
<div class="row">
<div class="col-md">
  <div class="responsive">
   <table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th>Nmae</th>
            <th>Desctiption</th>
            <th>Image</th>

        </tr>
    </thead>
      <tbody>
       
        @foreach($amenities as $amenity)
         <tr>
         <td class="py-3">{{ ucfirst($amenity->allAmentiy->title) }}</td>
         <td class="py-3">{{ ucfirst($amenity->allAmentiy->description) }}</td>
         <td class="py-3"> <img src="{{ ucfirst($amenity->allAmentiy->image_url) }}" alt="image" width="100px"></td>
         </tr>
        @endforeach
      </tbody>
   </table>
   </div>
</div>
</div>