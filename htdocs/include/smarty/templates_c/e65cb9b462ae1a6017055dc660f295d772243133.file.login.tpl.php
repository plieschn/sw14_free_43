<?php /* Smarty version Smarty-3.1.12, created on 2014-06-15 00:21:21
         compiled from "include/smarty/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1937817955539ce7015d75f2-36191710%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e65cb9b462ae1a6017055dc660f295d772243133' => 
    array (
      0 => 'include/smarty/templates/login.tpl',
      1 => 1402790652,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1937817955539ce7015d75f2-36191710',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baselink' => 0,
    'main_menu_items' => 0,
    'failed' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_539ce701601296_25968274',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539ce701601296_25968274')) {function content_539ce701601296_25968274($_smarty_tpl) {?><!DOCTYPE html>
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
      <h2>Login</h2>
      <?php if ($_smarty_tpl->tpl_vars['failed']->value){?>
      <p>Login failed. Please check your login information again.</p>
      <?php }?>
      <form action="<?php echo $_smarty_tpl->tpl_vars['baselink']->value;?>
Login/?action=submit" method="POST">
        <table>
          <tr><td><label for="username">Username</label></td><td><input id="username" name="username" value="" /></td></tr>
          <tr><td><label for="password">Password</label></td><td><input id="password" name="password" type="password" /></td></tr>
        </table>
        <input type="submit" value="OK">
      </form>
    </div>
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value), 0);?>

  </body>
</html>
<?php }} ?>