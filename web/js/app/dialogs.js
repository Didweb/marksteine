function deleteAction(id, name, domain) {

      $("#dialog" + domain).modal("show");
      $("div.modal-header h4").attr('class', 'modal-title text-danger');
      $("#value" + domain).html(name);
      $("#value" + domain + "Title").html(name);
      $("#deleteAction").attr('data-id', id);
}

// Hidden Dialog Alert
$('input').focus(function () {
  if($('#alertDialog').css('display') == 'block') {
    $('#alertDialog').css({'display' : 'none'});
  }
});

// Hidden Dialog Alert
$('select').focus(function () {
  if($('#alertDialog').css('display') == 'block') {
    $('#alertDialog').css({'display' : 'none'});
  }
});


// Delete Entity
$('#deleteAction').click(function (e) {

  var datas = {'id' : $('#deleteAction').data('id')};
  var routenamedelete = $("#deleteAction").data("routenamedelete");

  $.ajax({
             type: "GET",
             url: routenamedelete ,
             dataType: 'json',
             data: datas,
             encode: true,
             success: function (json) {
               var objResult = jQuery.parseJSON(json);
               if(objResult.result == 'error') {
                 $('#alertDialog').css({'display' : 'block'});
                 $('#alertDialog').html(objResult.message);
               } else {
                  location.reload();
               }
             }
         })

});
