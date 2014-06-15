<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCTWCwQPj0GSYvw0ujlBJnXcLrS6zPX7zs&amp;sensor=true"></script>
    <script type="text/javascript" src="{$baselink}js/content/Projects/location.js"></script>
    <style type="text/css" media="screen">
      div #map {
      height:600px;
      width:800px;
      }
    </style>
    {include file="head.tpl"}
  </head>
  <body>
    {include file="heading.tpl"}
    {include file='main_menu.tpl' baselink=$baselink items=$main_menu_items}

    <div id="content">
      <h2>Projects</h2>
      <div id="map"></div>
      <script type="text/javascript">initialize(15.14753759242735, 47.04351470905308, 17, '{$baselink}Projects/KML/{$project_name}/?timestamp={$timestamp}');</script>
    </div>
    {include file='footer.tpl' baselink=$baselink}
  </body>
</html>
