<?php /* Smarty version Smarty-3.1.12, created on 2014-04-16 18:33:23
         compiled from "include/smarty/templates/timesheet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1806062530534ec75fd9f2d8-81652712%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f439ebc2dc4d8c0333cb38563655ade237cf8135' => 
    array (
      0 => 'include/smarty/templates/timesheet.tpl',
      1 => 1397673199,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1806062530534ec75fd9f2d8-81652712',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_534ec75fdb3549_75691505',
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
<?php if ($_valid && !is_callable('content_534ec75fdb3549_75691505')) {function content_534ec75fdb3549_75691505($_smarty_tpl) {?><?php echo '<?xml';?> version="1.0" encoding="UTF-8"<?php echo '?>';?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8"/>
<title>Timesheet</title>
<link rel="stylesheet" type="text/css" href="css/timesheet.css" />
</head>
<body>
<h1>Timesheet</h1>
<div id="timing_information">
<?php if (count($_smarty_tpl->tpl_vars['timing_rows']->value)>0){?>
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
<?php }?>
</div>

<div id="task_information">
<?php if (count($_smarty_tpl->tpl_vars['task_rows']->value)>0){?>
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
<?php }?>
</div>
</body>
</html>
<?php }} ?>