<?php /* Smarty version Smarty-3.1.12, created on 2014-06-15 00:07:13
         compiled from "include/smarty/templates/main_menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:513816820539ce3b1590f12-96375681%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbbb931f9c1316ea57c5869c4e0a59fbdb619d25' => 
    array (
      0 => 'include/smarty/templates/main_menu.tpl',
      1 => 1402790652,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '513816820539ce3b1590f12-96375681',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'selected' => 0,
    'value' => 0,
    'baselink' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_539ce3b15aa481_53055023',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539ce3b15aa481_53055023')) {function content_539ce3b15aa481_53055023($_smarty_tpl) {?><div id="main_menu">
  <ul>
    <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
    <?php if (isset($_smarty_tpl->tpl_vars['selected']->value)&&$_smarty_tpl->tpl_vars['selected']->value==$_smarty_tpl->tpl_vars['value']->value){?>
    <li id="selected"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</li>
    <?php }else{ ?>
    <li><a href="<?php echo $_smarty_tpl->tpl_vars['baselink']->value;?>
<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a></li>
    <?php }?>
    <?php } ?>
  </ul>
  <br>
</div>
<?php }} ?>