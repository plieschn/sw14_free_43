<?php /* Smarty version Smarty-3.1.12, created on 2014-06-15 00:21:22
         compiled from "include/smarty/templates/register.tpl" */ ?>
<?php /*%%SmartyHeaderCode:883142290539ce7029b4300-11680272%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96d00bef40acac688126972c1529e49fba1d5f92' => 
    array (
      0 => 'include/smarty/templates/register.tpl',
      1 => 1402790652,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '883142290539ce7029b4300-11680272',
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
  'unifunc' => 'content_539ce7029d9b19_60790130',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539ce7029d9b19_60790130')) {function content_539ce7029d9b19_60790130($_smarty_tpl) {?><!DOCTYPE html>
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
      <h2>Register</h2>
      <form action="<?php echo $_smarty_tpl->tpl_vars['baselink']->value;?>
Register/?action=submit" method="POST">
        <table>
          <tr><td><label for="username">Username</label></td><td><input id="username" name="username" /></td></tr>
          <tr><td><label for="password">Password</label></td><td><input id="password" name="password" type="password" /></td></tr>
          <tr><td><label for="title">Title</label></td><td><input id="title" name="title" /></td></tr>
          <tr><td><label for="first_name">First name</label></td><td><input id="first_name" name="first_name" /></td></tr>
          <tr><td><label for="last_name">Last name</label></td><td><input id="last_name" name="last_name" /></td></tr>
        </table>
        <input type="submit" value="OK">
      </form>
    </div>
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value), 0);?>

  </body>
</html>
<?php }} ?>