<?php /* Smarty version Smarty-3.1.19, created on 2016-05-22 20:17:49
         compiled from "Z:\home\wp-odyssey\www\prestashop\admin9007aokte\themes\default\template\helpers\list\list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:95245741e9bd43e0c8-85996990%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '125682f61c8ffde87592fcda3ce7a160e47a4ec7' => 
    array (
      0 => 'Z:\\home\\wp-odyssey\\www\\prestashop\\admin9007aokte\\themes\\default\\template\\helpers\\list\\list_action_edit.tpl',
      1 => 1452088228,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '95245741e9bd43e0c8-85996990',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5741e9bd459fd6_66682952',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5741e9bd459fd6_66682952')) {function content_5741e9bd459fd6_66682952($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
