<dialog class="mdl-dialog">
    <div class="mdl-dialog__content">
      <p>
        {{$confirm}}
      </p>
    </div>
    <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
      <button type="button" class="mdl-button" onclick="location.href='{{$url}}';">{{Lang::get("general.Yes")}}</button>
      <button type="button" class="mdl-button close">{{Lang::get("general.No")}}</button>
    </div>
</dialog>
<script>
    var dialog = $('dialog')[0];
    if (! $('dialog')[0].showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    $('.show-confirm-operation').click(function() {
      dialog.showModal();
    });
    $('.close').click(function() {
      dialog.close();
    });
</script>