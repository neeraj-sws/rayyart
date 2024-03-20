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

<script>
  

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

  function busySlot(url ,clntId,id)
{
  var date = $('#slotdate').val()

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: url,
    method: "POST",
    data: {
      cId:clntId,
      slot:id,
      date:date,

    },
    success: function (res) {
      if(res.status == 0){
        toastr.success(res.message, 'Success');
        $('.'+res.slot_id).removeClass('btn-light');
        $('.'+res.slot_id).addClass("btn-success");
        var a = $('#'+res.slot_id).html();
        $('#'+res.slot_id).remove();
        $('.'+res.slot_id).find('div').html(a);
      }
      if(res.status == 1){
        toastr.success(res.message, 'Success');
        var a = $('.'+res.slot_id).html();
        $('#slotData'+id).html(res.pageslot)
        $('.'+res.slot_id).removeClass('btn-success');
        $('.'+res.slot_id).addClass("btn-light");
      }
    }
  });
}

        </script>