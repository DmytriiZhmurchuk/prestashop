<?php /* Smarty version Smarty-3.1.19, created on 2016-05-22 22:28:45
         compiled from "Z:\home\wp-odyssey\www\prestashop\modules\blockfacebook\blockfacebook.tpl" */ ?>
<?php /*%%SmartyHeaderCode:273785742086d115595-02283786%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39aad97a94e9da0025151ef635d104e0d9d3ef92' => 
    array (
      0 => 'Z:\\home\\wp-odyssey\\www\\prestashop\\modules\\blockfacebook\\blockfacebook.tpl',
      1 => 1452088228,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '273785742086d115595-02283786',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'facebookurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5742086d12b810_09818917',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5742086d12b810_09818917')) {function content_5742086d12b810_09818917($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['facebookurl']->value!='') {?>
<div id="fb-root"></div>
<div id="facebook_block" class="col-xs-4">
	<h4 ><?php echo smartyTranslate(array('s'=>'Follow us on Facebook','mod'=>'blockfacebook'),$_smarty_tpl);?>
</h4>
	<div class="facebook-fanbox">
		<div class="fb-like-box" data-href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['facebookurl']->value, ENT_QUOTES, 'UTF-8', true);?>
" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false">
		</div>
	</div>
</div>
<?php }?>
<?php }} ?>
