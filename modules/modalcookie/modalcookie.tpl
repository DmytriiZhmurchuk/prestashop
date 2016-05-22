<link rel="stylesheet" type="text/css" href="{$base_dir}modules/modalcookie/stylesmodal.css" />

<script src="{$base_dir}modules/modalcookie/jquery.cookie.js"></script>
<script src="{$base_dir}modules/modalcookie/scriptcookie.js"></script>
<div id="popupBlock" class="myup"> 
      <div class="mytext">
        <div id="timerOutput" class="mytimer"></div>
	{if $modalcookie->message}<div class="rte">{$modalcookie->message|stripslashes}</div>{/if}
	<a id="setCookie" class="myclose" onclick="document.getElementById('popupBlock').style.display='none';"></a>
</div>
  </div>
<script type="text/javascript">
	var delay_popup = 5000;
	
</script>
