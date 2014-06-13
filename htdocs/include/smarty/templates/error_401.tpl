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
      <p>Error!</p>
      <p>Unauthorized (401)!</p>
    </div>
    {include file='footer.tpl' baselink=$baselink}
  </body>
</html>
