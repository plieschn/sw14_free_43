<?php /* Smarty version Smarty-3.1.12, created on 2014-06-16 17:48:12
         compiled from "include/smarty/templates/projects_view_specific.tpl" */ ?>
<?php /*%%SmartyHeaderCode:133433245539de441a60db9-82140881%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6333027275eee7f86bc7712207bbbf1003e21296' => 
    array (
      0 => 'include/smarty/templates/projects_view_specific.tpl',
      1 => 1402940864,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '133433245539de441a60db9-82140881',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_539de441a6f145_54098275',
  'variables' => 
  array (
    'baselink' => 0,
    'main_menu_items' => 0,
    'kml_name' => 0,
    'timestamp' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539de441a6f145_54098275')) {function content_539de441a6f145_54098275($_smarty_tpl) {?><!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCTWCwQPj0GSYvw0ujlBJnXcLrS6zPX7zs&amp;sensor=true"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['baselink']->value;?>
js/content/Projects/location.js"></script>
    <style type="text/css" media="screen">
      div #map {
      height:600px;
      width:800px;
      }
    </style>
    <?php echo $_smarty_tpl->getSubTemplate ("head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  </head>
  <body>
    <?php echo $_smarty_tpl->getSubTemplate ("heading.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php echo $_smarty_tpl->getSubTemplate ('main_menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value,'items'=>$_smarty_tpl->tpl_vars['main_menu_items']->value), 0);?>


    <div id="content">
      <h2>Projects</h2>
      <div id="map"></div>
      <script type="text/javascript">initialize(15.14753759242735, 47.04351470905308, 17, '<?php echo $_smarty_tpl->tpl_vars['baselink']->value;?>
Projects/KML/<?php echo $_smarty_tpl->tpl_vars['kml_name']->value;?>
/?timestamp=<?php echo $_smarty_tpl->tpl_vars['timestamp']->value;?>
');</script>
    </div>
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('baselink'=>$_smarty_tpl->tpl_vars['baselink']->value), 0);?>

  </body>
</html>
<?php }} ?>