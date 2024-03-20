 <a href="javascript:void(0);" class="btn-light {{$slot_id}}"  onclick="busySlot('<?php echo $route->availabilityslot; ?>','<?php echo $client_id;?>','<?php echo $slot_id; ?>')" >
 <div class="btn btn-light {{$slot_id}}">
    <del id="{{$slot_id}}">{{$startTime}}-{{$endTime}}</del>
</div>
</a>
 <script>
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