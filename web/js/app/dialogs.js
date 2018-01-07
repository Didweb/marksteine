function deleteAction(id, name, domain) {

      $("#dialog" + domain).modal("show");
      $("div.modal-header h4").attr('class', 'modal-title text-danger');
      $("#value" + domain).html(name);
      $("#value" + domain + "Title").html(name);
      $("#deleteAction").attr('data-id', id);
}
