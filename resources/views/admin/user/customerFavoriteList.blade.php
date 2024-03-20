 <div class="modal-header">
        <h5 class="modal-title">Customer Favorite</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="table-responsive">
           <table class="table table-bordered" id= "orderitem">
               <thead>
                  <tr>
                     <th scope="col">S.no.</th>
                     <th scope="col">Client Name</th>
                     <th scope="col">Client Email</th> 
                     <th scope="col">Client Outlet</th>
                     <th scope="col">Client Mobile Number</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $n=1;  ?>
                  @foreach($results as $result)
                     <tr>
                        <td> <?php echo $n; ?> </td>
                        <td> {{@$result->clientFav->name}} </td>
                        <td> {{@$result->clientFav->email}} </td>
                        <td> {{@$result->clientFav->outlet_name}} </td>
                        <td> {{@$result->clientFav->owner_phonenumber}} </td>
                     </tr>
                           <?php $n++; ?>
                  @endforeach
               </tbody>
           </table>
 
         </div>
      </div>

