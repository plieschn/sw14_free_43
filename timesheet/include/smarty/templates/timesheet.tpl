<!DOCTYPE html>
<html>
  <head>
    <title>Timesheet</title>
    <link rel="stylesheet" type="text/css" href="css/timesheet.css" />
  </head>
  <body>
    <h1>Timesheet</h1>
    <div id="timing_information">
      <table>
	{foreach from=$timing_rows item=timing_row}
	<tr>
	  {foreach from=$timing_row item=timing_column}
	  <td>{$timing_column}</td>
	  {/foreach}
	</tr>
	{/foreach}
      </table>
    </div>

    <div id="task_information">
      <table>
	{foreach from=$task_rows item=task_row}
	<tr>
	  {foreach from=$task_row item=task_column}
	  <td>{$task_column}</td>
	  {/foreach}
	</tr>
	{/foreach}
      </table>
    </div>
  </body>
</html>
