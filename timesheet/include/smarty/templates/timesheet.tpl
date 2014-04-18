<?xml version="1.0" encoding="UTF-8"?>
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
		  <option value="0" {if $user_filter[0] == 0}selected="selected"{/if}>All users</option>
		  {foreach from=$users item=user}
		  <option value="{$user[0]}" {if $user_filter[0] == $user[0]}selected="selected"{/if}>{$user[1]} {$user[2]}</option>
		  {/foreach}
		</select>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="project">Select project:</label>
	      </td>
	      <td>
		<select id="project" name="project" size="1">
		  <option value="0" {if $project_filter[0] == 0}selected="selected"{/if}>All projects</option>
		  {foreach from=$projects item=project}
		  <option value="{$project[0]}" {if $project_filter[0] == $project[0]}selected="selected"{/if}>{$project[1]}</option>
		  {/foreach}
		</select>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="date_begin">Date begin:</label>
	      </td>
	      <td>
		<input id="date_begin" name="date_begin" type="date" value="{$date_begin}" />
	      </td>
	    </tr>
	    <tr>
	      <td>
		<label for="date_to">Date end:</label>
	      </td>
	      <td>
		<input id="date_end" name="date_end" type="date" value="{$date_end}" />
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
	  {if $timing_rows|@count gt 0}
	  <table>
	    {foreach from=$timing_rows item=timing_row}
	    <tr>
	      {foreach from=$timing_row item=timing_column}
	      <td>{$timing_column}</td>
	      {/foreach}
	    </tr>
	    {/foreach}
	  </table>
	  {/if}
	</div>
	
	<div id="task_information">
	  {if $task_rows|@count gt 0}
	  <table>
	    {foreach from=$task_rows item=task_row}
	    <tr>
	      {foreach from=$task_row item=task_column}
	      <td>{$task_column}</td>
	      {/foreach}
	    </tr>
	    {/foreach}
	  </table>
	  {/if}
	</div>
      </div>
    </div>
  </body>
</html>
