function deleteAction(id, name, pathDelete) {
  $("#dialogDelete").modal("show");
  $("div.modal-header h4").attr('class', 'modal-title text-danger');
  $("#valueInfo").html(name);
  $("#valueTitle").html(name);
  $("#deleteAction").attr('data-pathdelete', pathDelete);
  $("#deleteAction").attr('data-id', id);
}

function addActionShow() {
  $("#dialogAdd").modal("show");
  $("div.modal-header h4").attr('class', 'modal-title text-primary');
  $('.loaderBody').fadeIn(0);
  $('#editcontent').fadeOut(0);

}

// Dialogue Prepartion
function dialogPreparation(dailogType, colorStyle, data){
  $('#' + dailogType).html(data);
  $("#" + dailogType).modal("show");
  $("div.modal-header h4").attr('class', 'modal-title text-' + colorStyle);
  $('.loaderBody').fadeIn(0);
  $('#editcontent').fadeOut(0);
};


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


// checkErrors
function checkErrors(data) {
  var objResult = jQuery.parseJSON(data);
  if(objResult.result == 'error') {
    $('#alertDialog').css({'display' : 'block'});
    $('#alertDialog').html(objResult.message);
console.log("Tap");
  } else {
     location.reload();
  };

};


// Delete Entity
$('#deleteAction').click(function (e) {

  var datas = {'id' : $('#deleteAction').data('id')};
  var pathdelete = $("#deleteAction").data("pathdelete");

  $.ajax({
             type: "GET",
             url: pathdelete ,
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
