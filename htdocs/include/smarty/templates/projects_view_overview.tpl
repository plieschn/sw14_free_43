<!DOCTYPE html>
<html>
  <head>
    <style type="text/css" media="screen">
    </style>
    {include file="head.tpl"}
  </head>
  <body>
    {include file="heading.tpl"}
    {include file='main_menu.tpl' baselink=$baselink items=$main_menu_items}

    <div id="content">
      <h2>Projects</h2>
      <table id="projects">
	<thead>
	  <tr>
	    <th>Project name</th>
	  </tr>
	</thead>
	<tbody>
	{foreach from=$projects item=project}
	<tr>
	  <td><a href="{$baselink}Projects/View/{$project->getName()}/">{$project->getName()}</a></td>
	</tr>
	{/foreach}
	</tbody>
      </table>
    </div>
    {include file='footer.tpl' baselink=$baselink}
  </body>
</html>
