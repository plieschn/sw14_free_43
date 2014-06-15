<?php /* Smarty version Smarty-3.1.12, created on 2014-06-15 00:10:54
         compiled from "include/smarty/templates/error_404.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1468332525539ce48eceb9c9-46005820%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a4d2e1324e251292a7ce543c442c1ce5d8b02c0' => 
    array (
      0 => 'include/smarty/templates/error_404.tpl',
      1 => 1402790652,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1468332525539ce48eceb9c9-46005820',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baselink' => 0,
    'main_menu_items' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_539ce48ed142a9_57425742',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539ce48ed142a9_57425742')) {function content_539ce48ed142a9_57425742($_smarty_tpl) {?><!DOCTYPE html>
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
      <p>Error!</p>
      <p>Page not found (404)!</p>
    </div>
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value), 0);?>

  </body>
</html>
<?php }} ?>