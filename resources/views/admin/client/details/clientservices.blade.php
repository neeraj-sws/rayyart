<div class="mb-4 d-md-flex align-items-center justify-content-between">
 <div>
 <h4>Services</h4>
 </div>                                    
</div>
<div class="row">
<div class="col-md">
<div class="table-responsive">
   <table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th>S.No. </th>
            <th>Services </th>
            <th>Price</th>
            <th>Category</th>
            <th>Sub Category</th>
        </tr>
    </thead>
      <tbody>
  <?php $no=1; ?>
        @foreach($services as $service)
         <tr>
         <td class="py-3"><?php echo $no; ?></td>
         <td class="py-3">{{ ucfirst(@$service->services) }}</td>
         <td class="py-3">{{ ucfirst(@$service->price) }}</td>
         <td class="py-3">{{ ucfirst(@$service->CatId->title) }}</td>
         <td class="py-3">{{ ucfirst(@$service->subCate->title) }}</td>
         </tr>
         <?php $no++; ?>
        @endforeach
      </tbody>
   </table>
</div>
</div>
</div>