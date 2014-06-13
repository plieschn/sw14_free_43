<?php /* Smarty version Smarty-3.1.12, created on 2014-06-13 14:28:30
         compiled from "include/smarty/templates/setup_test.tpl" */ ?>
<?php /*%%SmartyHeaderCode:766092713539b0a8ec4ef24-84514635%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0ee3408c5e65ab5358672baf890acfc67011fad' => 
    array (
      0 => 'include/smarty/templates/setup_test.tpl',
      1 => 1402669692,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '766092713539b0a8ec4ef24-84514635',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baselink' => 0,
    'main_menu_items' => 0,
    'sub_menu_items' => 0,
    'sub_selected' => 0,
    'version' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_539b0a8ec5d588_31513738',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539b0a8ec5d588_31513738')) {function content_539b0a8ec5d588_31513738($_smarty_tpl) {?><!DOCTYPE html>
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
      <h2>Setup (Test)</h2>
      <?php echo $_smarty_tpl->getSubTemplate ('sub_menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value,'main_item'=>'Setup','items'=>$_smarty_tpl->tpl_vars['sub_menu_items']->value,'selected'=>$_smarty_tpl->tpl_vars['sub_selected']->value), 0);?>

      <div id="main_area">
        <p>The current database version according to this test is: <strong><?php echo $_smarty_tpl->tpl_vars['version']->value;?>
</strong>.</p>
        <p>If you can see a reasonable database version then the configuration seems to be valid.</p>
        <p>Otherwise please check your configuration again.</p>
      </div>
    </div>
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value), 0);?>

  </body>
</html>
<?php }} ?>