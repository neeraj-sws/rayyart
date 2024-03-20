
      <div class="modal-header">
        <h5 class="modal-title">{{ $single_heading }} Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
      </div>
      <div class="modal-body">
       <form action="">
            <h4>Customer</h4>
            <div class="row mb-2">
                <div class="col-md-4">
                    <label for="title" class="form-label"> Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $appointment->userData->name }}" >
                </div>
                <div class="col-md-4">
                    <label for="title" class="form-label"> Email</label>
                    <input type="text" class="form-control" name="name" value="{{ $appointment->userData->email }}" >
                </div>
                <div class="col-md-4">
                    <label for="title" class="form-label"> Mobile</label>
                    <input type="text" class="form-control" name="name" value="{{ $appointment->userData->mobile_number }}" >
                </div>
                </div>
                <hr>
                <h4>Client</h4>
                <div class="row">
                    <div class="col-md-12">
                        <label for="title" class="form-label"> Outlet Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $appointment->clientData->outlet_name }}" >
                    </div>
                    <div class="col-md-12">
                        <label for="title" class="form-label"> Outlet Address</label>
                        <textarea class="form-control" aria-label="With textarea" id="address" name="outletAddress"  > {{$appointment->clientData->outlet_address}}</textarea>
                    </div>
                </div>
                <hr>
       </form>
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
          @foreach($appointmentDetails as $appointmentDetail)
       <tr>
             <td class="py-3"><?php echo $no; ?></td>
             <td class="py-3">{{$appointmentDetail->clientServePriceData->services}}</td>
             <td class="py-3">{{$appointmentDetail->clientServePriceData->price}}</td>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>


