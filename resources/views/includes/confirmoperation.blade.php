<dialog class="mdl-dialog">
    <div class="mdl-dialog__content">
      <p>
        {{$confirm}}
      </p>
    </div>
    <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
      <input type="hidden" id="url-confirm" />
      <button type="button" class="mdl-button confirm-operation">{{Lang::get("general.Yes")}}</button>
      <button type="button" class="mdl-button close">{{Lang::get("general.No")}}</button>
    </div>
</dialog>