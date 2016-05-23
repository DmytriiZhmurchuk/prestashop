<?php /* Smarty version Smarty-3.1.19, created on 2016-05-23 22:06:00
         compiled from "Z:\home\wp-odyssey\www\prestashop\modules\modalcookie\modalcookie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:731957435498de1915-88038417%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27ca1875f146c2222052df760956e50ece295c4a' => 
    array (
      0 => 'Z:\\home\\wp-odyssey\\www\\prestashop\\modules\\modalcookie\\modalcookie.tpl',
      1 => 1463329213,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '731957435498de1915-88038417',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir' => 0,
    'modalcookie' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_57435499274730_87124506',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57435499274730_87124506')) {function content_57435499274730_87124506($_smarty_tpl) {?><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
modules/modalcookie/stylesmodal.css" />

<script src="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
modules/modalcookie/jquery.cookie.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
modules/modalcookie/scriptcookie.js"></script>
<div id="popupBlock" class="myup"> 
      <div class="mytext">
        <div id="timerOutput" class="mytimer"></div>
	<?php if ($_smarty_tpl->tpl_vars['modalcookie']->value->message) {?><div class="rte"><?php echo stripslashes($_smarty_tpl->tpl_vars['modalcookie']->value->message);?>
</div><?php }?>
	<a id="setCookie" class="myclose" onclick="document.getElementById('popupBlock').style.display='none';"></a>
</div>
  </div>
<script type="text/javascript">
	var delay_popup = 5000;
	
</script>
<?php }} ?>
