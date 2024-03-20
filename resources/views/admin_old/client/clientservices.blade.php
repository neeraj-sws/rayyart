<div class="mb-4 d-md-flex align-items-center justify-content-between">
 <div>
 <h4>Services</h4>
 </div>                                    
</div>
<div class="row">
<div class="col-md">
<div class="table-responsive">
   <table class="table table-responsive">
    <thead>
        <tr>
            <th>Name </th>
            <th>Description</th>
            <th>Image</th>
        </tr>
    </thead>
      <tbody>
 
        @foreach($services as $service)
         <tr>
         <td class="py-3">{{ ucfirst(@$service->servsId->title) }}</td>
         <td class="py-3">{{ ucfirst(@$service->servsId->description) }}</td>
         <td class="py-3"> <img src="  {{ ucfirst(@$service->servsId->image_url) }} " alt="image" width="100px"></td>
         </tr>
        @endforeach
      </tbody>
   </table>
</div>
</div>
</div>