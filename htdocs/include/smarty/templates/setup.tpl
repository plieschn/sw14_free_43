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
      <h2>Setup</h2>
      {include file='sub_menu.tpl' baselink=$baselink main_item='Setup' items=$sub_menu_items selected=''}

    </div>
    {include file='footer.tpl' baselink=$baselink}
  </body>
</html>
