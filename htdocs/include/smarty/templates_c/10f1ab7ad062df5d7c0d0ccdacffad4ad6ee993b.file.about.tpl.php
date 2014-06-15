<?php /* Smarty version Smarty-3.1.12, created on 2014-06-15 14:20:53
         compiled from "include/smarty/templates/about.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1863362950539ce3b1566a14-37135766%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10f1ab7ad062df5d7c0d0ccdacffad4ad6ee993b' => 
    array (
      0 => 'include/smarty/templates/about.tpl',
      1 => 1402842050,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1863362950539ce3b1566a14-37135766',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_539ce3b158bd92_45007901',
  'variables' => 
  array (
    'baselink' => 0,
    'main_menu_items' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539ce3b158bd92_45007901')) {function content_539ce3b158bd92_45007901($_smarty_tpl) {?><!DOCTYPE html>
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
      <h2>About TSIS</h2>
    </div>
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value), 0);?>

  </body>
</html>
<?php }} ?>