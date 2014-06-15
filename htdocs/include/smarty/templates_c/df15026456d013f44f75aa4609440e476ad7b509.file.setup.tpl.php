<?php /* Smarty version Smarty-3.1.12, created on 2014-06-15 00:21:18
         compiled from "include/smarty/templates/setup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:527577818539ce6fedb3e28-44907090%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df15026456d013f44f75aa4609440e476ad7b509' => 
    array (
      0 => 'include/smarty/templates/setup.tpl',
      1 => 1402790652,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '527577818539ce6fedb3e28-44907090',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baselink' => 0,
    'main_menu_items' => 0,
    'sub_menu_items' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_539ce6feddc310_60888709',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539ce6feddc310_60888709')) {function content_539ce6feddc310_60888709($_smarty_tpl) {?><!DOCTYPE html>
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