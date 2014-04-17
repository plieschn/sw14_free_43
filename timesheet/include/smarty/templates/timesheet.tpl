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
