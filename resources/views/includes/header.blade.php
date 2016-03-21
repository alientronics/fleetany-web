<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.js"></script>

 <style type="text/css">
    .mdl-layout__drawer-right {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-flex-wrap: nowrap;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
    width: 240px;
    height: 100%;
    max-height: 100%;
    position: absolute;
    top: 0;
    right: 0;
    box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
    box-sizing: border-box;
    border-right: 1px solid #e0e0e0;
    background: #fafafa;
    -webkit-transform: translateX(250px);
    -ms-transform: translateX(250px);
    transform: translateX(250px);
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
    will-change: transform;
    -webkit-transition-duration: .2s;
    transition-duration: .2s;
    -webkit-transition-timing-function: cubic-bezier(.4,0,.2,1);
    transition-timing-function: cubic-bezier(.4,0,.2,1);
    -webkit-transition-property: -webkit-transform;
    transition-property: transform;
    color: #424242;
    overflow: visible;
    overflow-y: auto;
    z-index: 5;
}

.active {
    -webkit-transform: translateX(0);
    -ms-transform: translateX(0);
    transform: translateX(0);  
}


.mdl-layout__obfuscator-right {
    background-color: transparent;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    z-index: 4;
    visibility: hidden;
    -webkit-transition-property: background-color;
    transition-property: background-color;
    -webkit-transition-duration: .2s;
    transition-duration: .2s;
    -webkit-transition-timing-function: cubic-bezier(.4,0,.2,1);
    transition-timing-function: cubic-bezier(.4,0,.2,1);
}

.ob-active {
    background-color: rgba(0,0,0,.5);
    visibility: visible;
}

.demo-drawer.mdl-layout__drawer-right>.mdl-layout-title {
    line-height: 56px;
    text-align: right;
    padding-right: 16px;
}
  </style>


<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(".mdl-button--notifications").click(function() {
  $(".mdl-layout__drawer-right").addClass("active");
  $(".mdl-layout__obfuscator-right").addClass("ob-active");
});

$(".mdl-layout__obfuscator-right").click(function() {
  $(".mdl-layout__drawer-right").removeClass("active");
  $(".mdl-layout__obfuscator-right").removeClass("ob-active");
});

}//]]> 

</script>

<header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
    <div class="mdl-layout__header-row">
      <span class="mdl-layout-title">Empresa</span>
      <div class="mdl-layout-spacer"></div>

      <div class="mdl-button mdl-js-button mdl-button--icon mdl-button--notifications" >
	    <i class="material-icons">search</i>
      </div>

      <div class="demo-drawer mdl-layout__drawer-right">
	    <span class="mdl-layout-title">Procurar</span>
	     <div class="mdl-textfield mdl-js-textfield mdl-cell--8-col">
    		<input class="mdl-textfield__input" type="text" name="name" value="{{$filters['name']}}">
    		<label class="mdl-textfield__label" for="name">{{Lang::get("general.name")}}</label>
	     </div>
	     <div class="mdl-textfield mdl-js-textfield mdl-cell--8-col">
    		<input class="mdl-textfield__input" type="text" name="city" value="{{$filters['city']}}">
    		<label class="mdl-textfield__label" for="city">{{Lang::get("general.city")}}</label>
	     </div>
	     <div class="mdl-textfield mdl-js-textfield mdl-cell--8-col">
    		<input class="mdl-textfield__input" type="text" name="country" value="{{$filters['country']}}">
    		<label class="mdl-textfield__label" for="country">{{Lang::get("general.country")}}</label>
	     </div><br>
	     <button type="submit" class="mdl-button mdl-color--amber mdl-color-text--white mdl-js-button mdl-button--raised mdl-button--colored">
    		Buscar
	     </button>
      </div>
      <div class="mdl-layout__obfuscator-right"></div>
    </div>
</header>

