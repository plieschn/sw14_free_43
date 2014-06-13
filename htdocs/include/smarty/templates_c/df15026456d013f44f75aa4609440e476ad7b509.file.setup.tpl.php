<?php /* Smarty version Smarty-3.1.12, created on 2014-06-13 14:30:22
         compiled from "include/smarty/templates/setup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1930984916539b089bbe4be8-19637142%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df15026456d013f44f75aa4609440e476ad7b509' => 
    array (
      0 => 'include/smarty/templates/setup.tpl',
      1 => 1402669771,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1930984916539b089bbe4be8-19637142',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_539b089bbf2f03_77438894',
  'variables' => 
  array (
    'baselink' => 0,
    'main_menu_items' => 0,
    'sub_menu_items' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539b089bbf2f03_77438894')) {function content_539b089bbf2f03_77438894($_smarty_tpl) {?><!DOCTYPE html>
<html>
  <head>
    <style type="text/css" media="screen">
    </style>
    <?php echo $_smarty_tpl->getSubTemplate ("head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  </head>
  <body>
    <?php echo $_smarty_tpl->getSubTemplate ("heading.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php echo $_smarty_tpl->getSubTemplate ('main_menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value,'items'=>$_smarty_tpl->tpl_vars['main_menu_items']->value), 0);?>


    <div id="content">
      <h2>Setup</h2>
      <?php echo $_smarty_tpl->getSubTemplate ('sub_menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value,'main_item'=>'Setup','items'=>$_smarty_tpl->tpl_vars['sub_menu_items']->value,'selected'=>''), 0);?>


    </div>
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value), 0);?>

  </body>
</html>
<?php }} ?>