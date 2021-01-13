<?php
  require_once("db.php");
  $name = $_GET["name"] ?? str_replace('/', '', $_SERVER['REQUEST_URI']);

  $data = [];

  $query = "SELECT id, name, type, image, platform, launcher, status FROM list WHERE user=\"" .  $name .  "\" order by case when status = \"active\" then 1 when status = \"backlog\" then 2 when status = \"done\" then 3 end";
  if ($result = $db->query($query)) {
    while ($obj = $result->fetch_object()) {
      $obj->subitems = [];
      $innerQuery = "SELECT name, image, status FROM subitems WHERE listid=" .  $obj->id ."  ORDER BY `order` ASC"; 
      if ($innerResult = $db->query($innerQuery)) {
        while ($subitem = $innerResult->fetch_object()) {
          array_push($obj->subitems, $subitem);
        }
        $innerResult->close();
      }
      array_push($data, $obj);
    }
    $result->close();
  }
  $db->close();

  
  function drawSubItems ($item) {
    $subitems = "";
    if(count($item->subitems) > 0) {
      $subitems .= "<ul class=\"list-group list-group-flush\">";
      foreach ($item->subitems as $subitem) {
        $status = "";
        switch ($subitem->status) {
          case "done":
            $status = "<span class=\"badge bg-success\">Done</span>";
            break;
          case "active":
            $status = "<span class=\"badge bg-warning\">Active</span>";
            break;
          default: break;
        }
        $subitems .= "<li class=\"list-group-item\">";
        if($subitem->image) {
          $subitems .= "<img class=\"icon\" src=\"$subitem->image\" alt=\"$item->name - $subitem->name\"/>";
        }
        $subitems .= $subitem->name;
        $subitems .= $status;
        $subitems .= "</li>";
      }
      $subitems .= "</ul>";
    }
    return $subitems;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $name;?>'s List</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/logo/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/logo/favicon-16x16.png">
    <link rel="manifest" href="/assets/logo/site.webmanifest">
    <link rel="mask-icon" href="/assets/logo/safari-pinned-tab.svg" color="#000000">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta charset='UTF-8'>
    <meta name="application-name" content="My List">
    <meta name='author' content='<?php echo $name;?>'>
    <meta name='publisher' content='Dominik Sigmund'>
    <meta name='copyright' content='Dominik Sigmund'>
    <meta name='page-topic' content='Forschung Technik'>
    <meta name='page-type' content='HTML-Formular'>
    <meta name='audience' content='All'>
    <meta name='description' content='My List - Show what you are Gaming, Streaming, Reading!'>
    <meta name='keywords' content='Gaming, Steam, Origin, Games, Platform, list, netflix, prime, series, books, kindle'>
    <meta http-equiv='content-language' content='en'>
    <meta name='robots' content='index, follow'>
    <meta name='DC.Creator' content='<?php echo $name;?>'>
    <meta name='DC.Publisher' content='Dominik Sigmund'>
    <meta name='DC.Rights',content='Dominik Sigmund'>
    <meta name='DC.Language' content='en'>
    <meta name='DC.Description' content='My List - Show what you are Gaming, Streaming, Reading!'>
    <meta property='og:type' content='website'>
    <meta property='og:title' content='My List'>
    <meta property='og:url' content='https://mylist.dominik-sigmund.de'>
    <meta property='og:image' content='https://mylist.dominik-sigmund.de/assets/logo/apple-touch-icon.png'>
    <meta property='og:description' content='My List - Show what you are Gaming, Streaming, Reading!'>
    <meta name='twitter:card' content='summary_large_image'>
    <meta name='twitter:site' content='https://mylist.dominik-sigmund.de'>
    <meta name='twitter:title' content='My List'>
    <meta name='twitter:image' content='https://mylist.dominik-sigmund.de/assets/logo/apple-touch-icon.png'>
    <meta name='twitter:description' content='My List - Show what you are Gaming, Streaming, Reading!'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.3/gh-fork-ribbon.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <a class="github-fork-ribbon" href="https://github.com/DSigmund/my-playlist/" data-ribbon="Fork me on GitHub" title="Fork me on GitHub">Fork me on GitHub</a>
  <div class="container">
      <h1><img class="icon" src="assets/logo/icon.png" alt="Logo"/> <?php echo $name;?>'s List</h1>
      <hr/>
      <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php foreach($data as $item): ?>
          <div class="col">
            <div class="card" style="width: 18rem;">
            <?php if($item->status == "active"):?>
              <div class="ribbon ribbon-top-right"><span><?php echo $item->status;?></span></div>
            <?php endif; ?>
            <?php if($item->status == "done"):?>
              <div class="ribbon ribbon-top-right ribbon-done"><span><?php echo $item->status;?></span></div>
            <?php endif; ?> 
              <div class="images">          
                <img src="<?php echo $item->image;?>" class="card-img-top" alt="<?php echo $item->name;?>">
                <img class="icon launcher" src="assets/launchers/<?php echo $item->launcher;?>.png" alt="<?php echo $item->launcher;?>"/>
                <img class="icon platform" src="assets/platforms/<?php echo $item->platform;?>.png" alt="<?php echo $item->platform;?>"/>
              </div>
              <?php echo drawSubItems($item);?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
  </div>
</body>
</html>