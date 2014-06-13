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
      <h2>Setup (Test)</h2>
      {include file='sub_menu.tpl' baselink=$baselink main_item='Setup' items=$sub_menu_items selected=$sub_selected}
      <div id="main_area">
        <p>The current database version according to this test is: <strong>{$version}</strong>.</p>
        <p>If you can see a reasonable database version then the configuration seems to be valid.</p>
        <p>Otherwise please check your configuration again.</p>
      </div>
    </div>
    {include file='footer.tpl' baselink=$baselink}
  </body>
</html>
