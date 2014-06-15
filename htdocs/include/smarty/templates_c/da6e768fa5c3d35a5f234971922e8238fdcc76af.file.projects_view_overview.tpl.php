<?php /* Smarty version Smarty-3.1.12, created on 2014-06-15 15:30:35
         compiled from "include/smarty/templates/projects_view_overview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:136754438539dae10729cd1-79823817%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da6e768fa5c3d35a5f234971922e8238fdcc76af' => 
    array (
      0 => 'include/smarty/templates/projects_view_overview.tpl',
      1 => 1402846228,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '136754438539dae10729cd1-79823817',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_539dae10737b40_37366958',
  'variables' => 
  array (
    'baselink' => 0,
    'main_menu_items' => 0,
    'projects' => 0,
    'project' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539dae10737b40_37366958')) {function content_539dae10737b40_37366958($_smarty_tpl) {?><!DOCTYPE html>
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
      <h2>Projects</h2>
      <table id="projects">
	<thead>
	  <tr>
	    <th>Project name</th>
	  </tr>
	</thead>
	<tbody>
	<?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['projects']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
	<tr>
	  <td><a href="<?php echo $_smarty_tpl->tpl_vars['baselink']->value;?>
Projects/View/<?php echo $_smarty_tpl->tpl_vars['project']->value->getName();?>
/"><?php echo $_smarty_tpl->tpl_vars['project']->value->getName();?>
</a></td>
	</tr>
	<?php } ?>
	</tbody>
      </table>
    </div>
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value), 0);?>

  </body>
</html>
<?php }} ?>