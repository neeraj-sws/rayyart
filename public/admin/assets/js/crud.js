$(".allowno").keypress(function (e) {
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      e.preventDefault(); 
  }
});


function addForm(url, modal = 'modal-lg') {
    $('#modal-default .modal-content').html('');
    $.ajax({
  
      url: url,
      method: "GET",
      data: {},
      success: function (res) {
  
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
  
      }
    });
  }

  function clientform_submit(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
  
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
          window.location.href = base_url+'/admin/client';
          dataTable.draw(false);

        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }


  function form_submit(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
  
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
          $(e).find('.st_loader').hide();
          $(e)[0].reset();
          $('#modal-lg').modal('hide');
          $('#modal-lg .modal-content').html('');
  
          if (data.tableView) {
  
            $('.expenses-Table').show();
            $('#expenses-Table tbody').append(data.tableView);
  
          }
          dataTable.draw(false);
  
  
  
        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }
  
  function clientprofile_submit(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
  
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
        // location.reload();
        $(".clientName").removeClass("d-none"); 
        $(".clientEmail").removeClass("d-none"); 
        $(".clientUsername").removeClass("d-none"); 

        $(".clientName").html(data.name); 
        $(".clientEmail").html(data.email); 
        $(".clientUsername").html(data.username); 
   
        $(".client_name").addClass("d-none");
        $(".client_email").addClass("d-none");
        $(".client_username").addClass("d-none");
        $("#update").addClass("d-none");


        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function adminProfile_submit(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
  
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
        location.reload();

        } else if (data.status == 0) {
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
        else if (data.status == 3){
          toastr.error(data.message, 'Error');
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function edit_row(url, id, modal = 'modal-lg') {

    $('#modal-default .modal-content').html('');
    url = url.replace(':id', id);
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: url,
      method: "GET",
      data: {},
      success: function (res) {
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
      }
    });
  }

  function showAppointments(url, id, modal = 'modal-lg') {

    $('#modal-default .modal-content').html('');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: url,
      method: "POST",
      data: {
        id:id
      },
      success: function (res) {
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
      }
    });
  }

  function delete_row(url, id) {
    url = url.replace(':id', id);
    if (confirm('Are you sure you want to delete this?')) {
      $.ajax({
        url: url,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "GET",
        data: {},
        dataType: "JSON",
        success: function (data) {
          toastr.success(data.message, 'Success');
          dataTable.draw(false);
        },
  
      });
    } else {
      return false;
    }
  }

  function addservices(url, id, modal = 'modal-lg') {
    $('#modal-default .modal-content').html('');
    url = url.replace(':id', id);
    $.ajax({

      url: url,
      method: "GET",
      data: {},
      success: function (res) {
  
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
  
      }
    });
  }


  function addholidays(url, id, modal = 'modal-lg') {
    $('#modal-default .modal-content').html('');
    url = url.replace(':id', id);
    $.ajax({

      url: url,
      method: "GET",
      data: {},
      success: function (res) {
  
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
  
      }
    });
  }


  function addslot(url, id, modal = 'modal-lg') {
    $('#modal-default .modal-content').html('');
    url = url.replace(':id', id);
    $.ajax({

      url: url,
      method: "GET",
      data: {},
      success: function (res) {
  
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
  
      }
    });
  }


  function storeservices(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
          // $(e).find('.st_loader').hide();
          // $(e)[0].reset();
          // $('#modal-lg').modal('hide');
          // $('#modal-lg .modal-content').html('');
        
          dataTable.draw(false);
        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function storeholiday(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
         
          dataTable.draw(false);
        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function editservices(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
          var id = data.id;
          var url =  base_url+"/admin/client/add-services/"+id;
          addservices(url,id)
          
          dataTable.draw(false);
        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function editholiday(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
          var id = data.id;
          var url =  base_url+"/admin/client/add-holidays/"+id;
          addservices(url,id)
          
          dataTable.draw(false);
        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }



 function clientServiceList(){
  $.ajax({
    'headers': {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: base_url+"/admin/client/services-list",
    method: "POST",
    dataType: "JSON",
    data: {},
    success: function (res) {
        
    }
});
 }

  function status_change(url,newStatus, id) {
    $('#st_loader_' + id).show();
    
    var statusText = newStatus === 1 ? 'Active' : 'Inactive'

    if (confirm("Are you sure you want to set the status to " + statusText + "?")) {
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: "POST",
            dataType: "JSON",
            data: { id: id, status: newStatus },
            success: function (res) {
                $('#st_loader_' + id).hide();

                toastr.success('Status changed successfully', 'Success');
                dataTable.draw(false);
            }
        });
    } else {
        // Optionally handle the case when the user cancels the confirmation
    }
}
 

function upload_image(form, url, id, input) 
{
  $(form).find('.' + id + '_loader').show();
  $.ajax({
    type: "POST",
    url: url + '?type=' + id,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    contentType: false,
    cache: false,
    processData: false,
    dataType: "json",
    data: new FormData(form[0]),
    success: function (res) {
      if (res.status == 0) {
        $(form).find('.' + id + '_loader').hide();
        toastr.error(res.msg, 'Error');
      } else {
        $(form).find('.' + id + '_loader').hide();
        $('#' + id + '_prev').attr('src', res.file_path);
        $('#' + id + '_prev').addClass('form-image');
        $('#' + id + '_prev').show();
        $('#' + input).val(res.file_id);
      }

    }
  });
}

function upload_multipleimage(form, url, id, input) 
{
  $(form).find('.' + id + '_loader').show();
  $.ajax({
    type: "POST",
    url: url + '?type=' + id,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    contentType: false,
    cache: false,
    processData: false,
    dataType: "json",
    data: new FormData(form[0]),
    success: function (res) {
      if (res.status == 0) {
        $(form).find('.' + id + '_loader').hide();
        toastr.error(res.msg, 'Error');
      } else {
        $(form).find('.' + id + '_loader').hide();
        // $('#' + id + '_prev').attr('src', res.file_path);
        $('#outlet_images_prev').html(res.file_path);
        $('#' + id + '_prev').addClass('form-image');
        $('#' + id + '_prev').show();
        $('#' + input).val(res.file_id);
      }

    }
  });
}

function delete_multiple_image(url,e){  
  var id = $(e).attr('data-id');
  var ids = $('#outlet_images_id').val();
  
   if(confirm('Are you sure you want to delete this?')){
      $.ajax({     
              url :url, 
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },  
       method:"POST",  
       data:{id:id,ids:ids},
       success: function(data){ 
            $(e).parent().remove();
            $('#outlet_images_id').val(data);
       },
       
     }); 
   }else{ 
     return false; 
   }
}

function clientdetails(url ,id,e)
{
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: url,
    method: "POST",
    data: {
      cId:id,
      dataId:e,

    },
    success: function (res) {
      $('#clientalldetails').html('');
      $('#clientalldetails').html(res);
    }
  });
}


function adminProfile(url ,id,e)
{
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: url,
    method: "POST",
    data: {
      adminId:id,
      dataId:e,

    },
    success: function (res) {
      $('#editprofile').html('');
      $('#editprofile').html(res);
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

function pagesform_submit(e) {
  toastr.clear();
  $(e).find('.st_loader').show();
  $.ajax({
    url: $(e).attr('action'),
    method: "POST",
    dataType: "json",
    data: $(e).serialize(),
    success: function (data) {

      if (data.status == 1) {
        toastr.success(data.message, 'Success');
        window.location.href = base_url+'/admin/pages';
        dataTable.draw(false);

      } else if (data.status == 0) {

        var $err = '';
        $.each(data.errors, function (key, value) {
          $err = $err + value + "<br>";
        });
        toastr.error($err, 'Error');
      }
      else if (data.status == 2) {
        toastr.success(data.message, 'Success');
        window.setTimeout(function () {
          window.location.href = data.surl;
        }, 1000);
      }
    },
    error: function (data) {
      if (typeof data.responseJSON.status !== 'undefined') {
        toastr.error(data.responseJSON.error, 'Error');
      } else {
        var $err = '';
        $.each(data.responseJSON.errors, function (key, value) {
          $err = $err + value + "<br>";
        });
        toastr.error($err, 'Error');
      }
      $(e).find('.st_loader').hide();
    }
  });
}

function delete_rows(url, id) {
  url = url.replace(':id', id);
  if (confirm('Are you sure you want to delete this?')) {
    $.ajax({
      url: url,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: "GET",
      data: {},
      dataType: "JSON",
      success: function (data) {
        toastr.success(data.message, 'Success');
        window.location.href = base_url+'/admin/subscription';
        dataTable.draw(false);
      },

    });
  } else {
    return false;
  }
}
  
  function subscription_submit(e) {
  toastr.clear();
  $(e).find('.st_loader').show();
  $.ajax({
    url: $(e).attr('action'),
    method: "POST",
    dataType: "json",
    data: $(e).serialize(),
    success: function (data) {

      if (data.status == 1) {
        toastr.success(data.message, 'Success');
        window.location.href = base_url+'/admin/subscription';
        dataTable.draw(false);

      } else if (data.status == 0) {

        var $err = '';
        $.each(data.errors, function (key, value) {
          $err = $err + value + "<br>";
        });
        toastr.error($err, 'Error');
      }
      
    },
    error: function (data) {
      if (typeof data.responseJSON.status !== 'undefined') {
        toastr.error(data.responseJSON.error, 'Error');
      } else {
        var $err = '';
        $.each(data.responseJSON.errors, function (key, value) {
          $err = $err + value + "<br>";
        });
        toastr.error($err, 'Error');
      }
      $(e).find('.st_loader').hide();
    }
  });
}

