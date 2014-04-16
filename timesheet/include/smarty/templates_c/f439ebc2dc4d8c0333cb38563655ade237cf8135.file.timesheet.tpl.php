<?php /* Smarty version Smarty-3.1.12, created on 2014-04-16 14:57:23
         compiled from "include/smarty/templates/timesheet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23385528534e90e1c1df45-19763399%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f439ebc2dc4d8c0333cb38563655ade237cf8135' => 
    array (
      0 => 'include/smarty/templates/timesheet.tpl',
      1 => 1397660242,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23385528534e90e1c1df45-19763399',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_534e90e1c26c41_80227353',
  'variables' => 
  array (
    'timing_rows' => 0,
    'timing_row' => 0,
    'timing_column' => 0,
    'task_rows' => 0,
    'task_row' => 0,
    'task_column' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_534e90e1c26c41_80227353')) {function content_534e90e1c26c41_80227353($_smarty_tpl) {?><!DOCTYPE html>
<html>
  <head>
    <title>Timesheet</title>
    <link rel="stylesheet" type="text/css" href="css/timesheet.css" />
  </head>
  <body>
    <h1>Timesheet</h1>
    <div id="timing_information">
      <table>
	<?php  $_smarty_tpl->tpl_vars['timing_row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['timing_row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['timing_rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['timing_row']->key => $_smarty_tpl->tpl_vars['timing_row']->value){
$_smarty_tpl->tpl_vars['timing_row']->_loop = true;
?>
	<tr>
	  <?php  $_smarty_tpl->tpl_vars['timing_column'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['timing_column']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['timing_row']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['timing_column']->key => $_smarty_tpl->tpl_vars['timing_column']->value){
$_smarty_tpl->tpl_vars['timing_column']->_loop = true;
?>
	  <td><?php echo $_smarty_tpl->tpl_vars['timing_column']->value;?>
</td>
	  <?php } ?>
	</tr>
	<?php } ?>
      </table>
    </div>

    <div id="task_information">
      <table>
	<?php  $_smarty_tpl->tpl_vars['task_row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['task_row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['task_rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['task_row']->key => $_smarty_tpl->tpl_vars['task_row']->value){
$_smarty_tpl->tpl_vars['task_row']->_loop = true;
?>
	<tr>
	  <?php  $_smarty_tpl->tpl_vars['task_column'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['task_column']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['task_row']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['task_column']->key => $_smarty_tpl->tpl_vars['task_column']->value){
$_smarty_tpl->tpl_vars['task_column']->_loop = true;
?>
	  <td><?php echo $_smarty_tpl->tpl_vars['task_column']->value;?>
</td>
	  <?php } ?>
	</tr>
	<?php } ?>
      </table>
    </div>
  </body>
</html>
<?php }} ?>