<?php /* Smarty version Smarty-3.1.12, created on 2014-06-06 13:15:07
         compiled from "include/smarty/templates/timesheet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10132320475391bedb2914a3-79716700%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f439ebc2dc4d8c0333cb38563655ade237cf8135' => 
    array (
      0 => 'include/smarty/templates/timesheet.tpl',
      1 => 1402060284,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10132320475391bedb2914a3-79716700',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user_filter' => 0,
    'users' => 0,
    'user' => 0,
    'project_filter' => 0,
    'projects' => 0,
    'project' => 0,
    'date_begin' => 0,
    'date_end' => 0,
    'timing_rows' => 0,
    'timing_row' => 0,
    'timing_column' => 0,
    'task_rows' => 0,
    'task_row' => 0,
    'task_column' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5391bedb2c3c93_57666168',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5391bedb2c3c93_57666168')) {function content_5391bedb2c3c93_57666168($_smarty_tpl) {?><?php echo '<?xml';?> version="1.0" encoding="UTF-8"<?php echo '?>';?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8"/>
    <title>Timesheet</title>
    <link rel="stylesheet" type="text/css" href="css/timesheet.css" />
  </head>
  <body>
    <div id="content_area">
      <h1>Timesheet</h1>
      <div id="control">
	<form action="index.php?action=filter" method="post">
	  <table id="filters">
	    <tr>
	      <td>
		<label for="user">Select user:</label>
	      </td>
	      <td>
		<select id="user" name="user" size="1">
		  <option value="0" <?php if ($_smarty_tpl->tpl_vars['user_filter']->value[0]==0){?>selected="selected"<?php }?>>All users</option>
		  <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['users']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
		  <option value="<?php echo $_smarty_tpl->tpl_vars['user']->value[0];?>
" <?php if ($_smarty_tpl->tpl_vars['user_filter']->value[0]==$_smarty_tpl->tpl_vars['user']->value[0]){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['user']->value[1];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value[2];?>
</option>
		  <?php } ?>
		</select>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="project">Select project:</label>
	      </td>
	      <td>
		<select id="project" name="project" size="1">
		  <option value="0" <?php if ($_smarty_tpl->tpl_vars['project_filter']->value[0]==0){?>selected="selected"<?php }?>>All projects</option>
		  <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['projects']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
		  <option value="<?php echo $_smarty_tpl->tpl_vars['project']->value[0];?>
" <?php if ($_smarty_tpl->tpl_vars['project_filter']->value[0]==$_smarty_tpl->tpl_vars['project']->value[0]){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['project']->value[1];?>
</option>
		  <?php } ?>
		</select>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="date_begin">Date begin:</label>
	      </td>
	      <td>
		<input id="date_begin" name="date_begin" type="date" value="<?php echo $_smarty_tpl->tpl_vars['date_begin']->value;?>
" />
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="date_end">Date end:</label>
	      </td>
	      <td>
		<input id="date_end" name="date_end" type="date" value="<?php echo $_smarty_tpl->tpl_vars['date_end']->value;?>
" />
	      </td>
	    </tr>
	    <tr>
	      <td colspan="2"><input type="submit" /></td>
	    </tr>
	  </table>
	</form>
      </div>
      
      <div id="information">
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
      </div>
    </div>
  </body>
</html>
<?php }} ?>