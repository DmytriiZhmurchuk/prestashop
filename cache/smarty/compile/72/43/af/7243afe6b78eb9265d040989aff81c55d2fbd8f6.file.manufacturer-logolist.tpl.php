<?php /* Smarty version Smarty-3.1.19, created on 2016-05-22 22:28:46
         compiled from "Z:\home\wp-odyssey\www\prestashop\themes\default-bootstrap\manufacturer-logolist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:298585742086e30cc66-43129698%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7243afe6b78eb9265d040989aff81c55d2fbd8f6' => 
    array (
      0 => 'Z:\\home\\wp-odyssey\\www\\prestashop\\themes\\default-bootstrap\\manufacturer-logolist.tpl',
      1 => 1463425910,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '298585742086e30cc66-43129698',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manufacturers' => 0,
    'manufacturer' => 0,
    'link' => 0,
    'img_manu_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5742086e361584_33289329',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5742086e361584_33289329')) {function content_5742086e361584_33289329($_smarty_tpl) {?>	<div class="manufacturers_frontlist row">
		<?php  $_smarty_tpl->tpl_vars['manufacturer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['manufacturer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['manufacturers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['manufacturer']->key => $_smarty_tpl->tpl_vars['manufacturer']->value) {
$_smarty_tpl->tpl_vars['manufacturer']->_loop = true;
?>
			<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
				<div class="manufacturer-front-logo">
					<?php if (isset($_smarty_tpl->tpl_vars['manufacturer']->value['nb_products'])&&$_smarty_tpl->tpl_vars['manufacturer']->value['nb_products']>0) {?>
						<a
						class="lnk_img"
						href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'],$_smarty_tpl->tpl_vars['manufacturer']->value['link_rewrite']), ENT_QUOTES, 'UTF-8', true);?>
"
						title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" >
					<?php }?>
						<img src="<?php echo $_smarty_tpl->tpl_vars['img_manu_dir']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value['image'], ENT_QUOTES, 'UTF-8', true);?>
-medium_default.jpg" alt="" />
					<?php if (isset($_smarty_tpl->tpl_vars['manufacturer']->value['nb_products'])&&$_smarty_tpl->tpl_vars['manufacturer']->value['nb_products']>0) {?>
						</a>
					<?php }?>
				</div>
			</div>
		<?php } ?>
	</div>	
<?php }} ?>
