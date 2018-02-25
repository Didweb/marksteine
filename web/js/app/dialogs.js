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

// Dialogue Prepartion Collaborator
function dialogPreparationCollabortaor(data, currentRole, user_id){
  $("#dialogEdit").modal("show");
  $("#titleDialog").html("Select Manager...");
  $("div.modal-header h4").attr('class', 'modal-title text-success');

  var listManagers = '';
  var datas = JSON.parse(data);
  for (var i=0; i < datas.length; i++) {
    if (datas[i].idUser != user_id) {
      var imgPath = '/images/defaultAvatar.png';
      if(datas[i].avatar != null) {
        imgPath = '/avatars/' + datas[i].avatar;
      }
      img = '<img src="' + imgPath + '" style="border:5px solid ' + datas[i].colorRole+ '" class="avatar-user-list" />'
      listManagers = listManagers + '<div class="row" onClick="changeRole(1, ' + currentRole +  ',' + user_id + ',' + datas[i].idUser + ')" > ' + img + ' ' + datas[i].name + '</div>'
    }

  }
  $("div.modal-body div.row").html('<div class="row"> <input type="button" onClick="" class="btn btn-success" value="Myself" /> </div>' +  listManagers);
  $('.loaderBody').fadeIn(0);
  $('#editcontent').fadeOut(0);
};


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
