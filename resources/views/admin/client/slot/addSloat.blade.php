<div class="card">
   <div class="card-body">
   <div class="modal-header">
         <h4 class="modal-title">{{ $single_heading }} Slot</h4>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body py-3">
        <div class="row">
             <div class="col-md-12">
                 <label for="status" class="form-label">Date</label>
                <input type="text" class="form-control datepicker" name="date" data="{{ $client_id }}" onchange="slotwithdate('<?php  echo $route->slotWithDate; ?>',this)"  id="slotdate" value="{{ date('Y-m-d') }}">
            </div>
        </div>
        <div class="row p-5 datawithdate123">
        @foreach($slots as $slot)
        
        <div class="col-md-4 my-1 text-center" id="slotData{{$slot->id}}">
        @php $cls=""; @endphp 
        @if($slot->bookedSlot)
           
             @php $cls = "btn-light"; @endphp 
             @php $color = "text-light"; @endphp 
        @else
             @php $cls = "btn-success"; @endphp 
             @php $color = "text-dark"; @endphp 
        @endif

             @php
                $openTime = new DateTime($slot->start_time);
                $closeTime = new DateTime($slot->end_time);
                $startTime = $openTime->format("h:i A");
                $endTime = $closeTime->format("h:i A");
            @endphp

          
        <a href="javascript:void(0);" class="{{ $color }} {{ $slot->id }}" onclick="busySlot('<?php echo $route->availabilityslot; ?>','<?php echo $client_id;?>','<?php echo $slot->id; ?>')" >
            <div class="btn {{ $cls}}  {{ $slot->id }}" >
        
            @if($slot->bookedSlot) <del id="{{ $slot->id }}">  @endif   <?php  echo trim($startTime); ?>- <?php echo trim($endTime); ?>  @if($slot->bookedSlot) </del>  @endif
          
            </div>
            </a>
           
        </div>
        @endforeach
        </div>
    </div>
    </div>
</div>
<script>
    $( ".datepicker" ).datepicker({  
        format: "yyyy-mm-dd", 
        autoclose: true
       
    });
  function slotwithdate(url,e){
   var date = $(e).val();
   var client_id = $(e).attr('data');  
   $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: url,
    method: "POST",
    data: {
        client_id:client_id,
        date:date,
    },
    success: function (res) {
console.log(res.slotwithDate);

        $('.datawithdate123').html(res.slotwithDate)
   
    }
  });
  }
</script>
