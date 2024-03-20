
<div class="modal-content">
<div class="modal-header">
        <h5 class="modal-title">Appointment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>                                  
</div>
<div class="modal-body">
    <div class="row">
    <div class="col-md">
    <div class="table-responsive">
       <table class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th>S.No. </th>
                <th>Services </th>
                <th>Price</th>
            </tr>
        </thead>
          <tbody>
      <?php $no=1; ?>
          @foreach($appointmentdetailes as $appointmentdetaile)
             <tr>
             <td class="py-3"><?php echo $no; ?></td>
             <td class="py-3">{{$appointmentdetaile->clientServePriceData->services}}</td>
             <td class="py-3">{{$appointmentdetaile->clientServePriceData->price}}</td>
             </tr>
             <?php $no++; ?>
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
    </div>
</div>
<div class="modal-footer">
    
      </div>
</div>