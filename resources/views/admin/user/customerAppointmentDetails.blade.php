<div class="modal-header">
    <h5 class="modal-title">Appointment Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
         <div class="table-responsive">
           <table class="table table-bordered" id= "orderitem">
               <thead>
                  <tr>
                     <th scope="col">S.no.</th>
                     <th scope="col">Services</th>
                     <th scope="col">Price</th> 
                  </tr>
               </thead>
               <tbody>
                  <?php $n=1;  ?>
                  @foreach($appointmentDetails as $appointmentDetail)
                     <tr>
                        <td> <?php echo $n; ?> </td>
                        <td> {{@$appointmentDetail->clientServePriceData->services}} </td>
                        <td> {{@$appointmentDetail->clientServePriceData->price}} </td>
                     </tr>
                           <?php $n++; ?>
                  @endforeach
               </tbody>
               <tfoot>
             <tr>
                <td class="text-end" colspan="2">Sub Total</td>
                <td>{{ $appointment->sub_total }}</td>
                </tr>
                <tr>
                <td class="text-end" colspan="2">Tax</td>
                <td>{{ $appointment->tax }}</td>
                </tr>
                <tr>
                <td class="text-end" colspan="2">Total</td>
                <td>{{ $appointment->price }}</td>
                </tr>
         </tfoot>
           </table>
 
         </div>
</div>
