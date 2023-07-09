<!doctype html>
<?php
  $thisRelease = 'v1.0.2';
?>
<html lang="en" class="h-100" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Joomla! Downloader</title>
    <meta name="description" content="">
    <meta name="author" content="Joomla!LABS">
    <link  rel="shortcut icon" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAAAACMuAAAjLgAAAAAAAAAAAADNkFBLzZFR5c2QUPLNkVGWAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA0QO+CNUDv8TVA7+s1QPBfzZFR+s2QUP/MkFD/zZFR/8yQUJnNkFGB0pQxRwAAAAAAAAAALDXuUTVA8IQ1QO+KND/v/zVA7/81QO//NUDv/82RUf/NkVH/zZFR/82RUf/NkFD/zZFR/9CTO//HkU96Nz/tdCMb7f83Q+//NEDv/zVA7/80QO//NEDv/zRA7//NkFBgzZFR982RUf/OklH/y45R1MaHTrLJilH/1JYc/6aHf9gqLu7GJBvtvDE77+M3Q/D/NUDv/zVA7/41QPB2AAAAAM2QUXnNkVH/y45Q4AAAAAAAAAAAqp9ftMWFUf/XmQD/sYx2qAAAAAAAAAAAMDvv8DRA7/81QO9sAAAAAAAAAADNkFBlzZFR/8KCT9UAAAAAP8SHrELDf+irnF/Tx4lV/9SWCv/jogCBAAAAACQc7e41QO//NEDvRAAAAAAAAAAAyYpRJ8SET//GjVHZWrl5wELCfP9Ev3L/Tb1nT9GTK2zXmAD/vY5h10NO2skqLO7/NTDu/zUt7hUAAAAAAAAAAAAAAACxl1tEY7h24UHCfv9GvGT/P8GMWgAAAAAAAAAAq4V4XzxF5+AlG+3/ODLu9jNN8DAAAAAAAAAAAAAAAAAAAAAAQcJ9hELDf/9Gulz/Nrmv0xuh73oAAAAAAAAAAC8n7qQpLO7/OSPt/y1w8dEYqfdjAAAAAAAAAAAAAAAAQsF7P0LCfP9Gu175N7ipjxyO8+0anPT/G5z1kiw27ogyGu7/NyPu/y9m8IUTs/fyFqn3/xik9igAAAAAAAAAAEPCe2VDwnv/R7pbywAAAAAdjfNeG5Pz/Baq9/8hlvXeNTDuxTcZ7kEAAAAAE6/28Rqe9f8Zn/VEAAAAAAAAAABCwXp+QsF6/0LBee5Ev3InAAAAACms0LAcjvL8Fa74/yGT9a8AAAAAGKX2Oxmf9fcZn/X/GaD1dQAAAABCwXpzQsF7/0LBev9Cwn3/Q8F6/0e5Vv1HulrzK63LzhuV9P8Xqvf/Fa749xmf9f8Zn/X/GZ/1/xmg9f8Zn/WIQsF6/0LBe/9Dwnv/QsF6/0LBe/9Bwn3/Rrtf90LCfEIbnvNRGpr09hmf9f8aoPb/GqD2/xmf9f8ZoPb/GZ/1/0LBeudCwXv/QsF7/0LBe/9CwXpoQsF6QkS9axAAAAAAAAAAABqb9RcZn/VEGZ/1Vhqg9v8Zn/X/GaD2/xmf9fdCwXszQsF61kLBeuxCwXp+AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAZn/VsGaD16hmg9d8Zn/VEj/EAAAPAAAABgAAAgAEAAMwzAADIEwAAwYMAAOPHAADDhwAAwAMAAMwzAADMMwAAgAAAAAGAAAAP8AAAn/kAAA==" type="image/vnd.microsoft.icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css" integrity="sha512-yDUXOUWwbHH4ggxueDnC5vJv4tmfySpVdIcN1LksGZi8W8EVZv4uKGrQc0pVf66zS7LDhFJM7Zdeow1sw1/8Jw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.min.css" integrity="sha512-9YHSK59/rjvhtDcY/b+4rdnl0V4LPDWdkKceBl8ZLF5TB6745ml1AfluEU6dFWqwDw9lPvnauxFgpKvJqp7jiQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css" integrity="sha512-SgaqKKxJDQ/tAUAAXzvxZz33rmn7leYDYfBP+YoMRSENhf3zJyx3SBASt/OfeQwBHA1nxMis7mM3EV/oYT6Fdw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/svg-with-js.min.css" integrity="sha512-FTnGkh+EGoZdexd/sIZYeqkXFlcV3VSscCTBwzwXv1IEN5W7/zRLf6aUBVf2Ahdgx3h/h22HNzaoeBnYT6vDlA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  </head>
  <body class="d-flex flex-column h-100">
    <header class="py-5">
      <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center">
        <img alt="Joomla! Logo" aria-hidden="true" src="data:image/png;base64,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" />
        <h1 class="display-1"><span class="visually-hidden">Joomla! </span>Downloader</h1>
      </div>
    </header>
<?php
if( !isset($_GET['pkg']) && !isset($_GET['clear']) ) {
?>
    <main class="flex-shrink-0">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 py-4 m-0">
<?php
  //Joomla! Core update servers types
  $updateServers = array('stable', 'maintenance', 'test', 'nightly-major', 'nightly-minor', 'nightly-patch');
  $pkgs = array();
  foreach ($updateServers as $server) {
    $pkg = lastPkg($server);
    $color;
    $icon;
    switch ($pkg['server']) {
      case 'stable':
        $color = 'text-success';
        $icon = '<i class="fa-solid fa-box fa-fw fa-4x"></i>';
        break;
      case 'maintenance':
        $color = 'text-success';
        $icon = '<i class="fa-solid fa-box-archive fa-fw fa-4x"></i>';
        break;
      case 'test':
        $color = 'text-info';
        $icon = '<i class="fa-solid fa-vial fa-fw fa-4x"></i>';
        break;
      case 'nightly-major':
        $color = 'text-warning';
        $icon = '<span class="fa-layers fa-fw"><i class="fa-solid fa-moon fa-4x"></i><span class="bg-danger fa-4x fa-layers-counter fa-layers-bottom-left" style="--fa-bottom: -4rem;">major</span></span>';
        break;
      case 'nightly-minor':
        $color = 'text-warning';
        $icon = '<span class="fa-layers fa-fw"><i class="fa-solid fa-moon fa-4x"></i><span class="bg-danger fa-4x fa-layers-counter fa-layers-bottom-left" style="--fa-bottom: -4rem;">minor</span></span>';
        break;
      case 'nightly-patch':
        $color = 'text-warning';
        $icon = '<span class="fa-layers fa-fw"><i class="fa-solid fa-moon fa-4x"></i><span class="bg-danger fa-4x fa-layers-counter fa-layers-bottom-left" style="--fa-bottom: -4rem;">patch</span></span>';
        break;
      default:
        $color = 'text-secondary';
        $icon = '<i class="fa-solid fa-question fa-4x"></i>';
        break;
    }
?>
        <div class="col">
          <div id="<?php echo $pkg['server']; ?>_<?php echo $pkg['version']; ?>" class="card mb-4 h-100">
            <div class="row g-0">
              <div class="col-md-3 <?php echo $color; ?> text-center align-self-center py-4">
                <?php echo $icon."\n"; ?>
              </div>
              <div class="col-md-9">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $pkg['name']; ?></h5>
                  <p class="card-text"><?php echo $pkg['description']; ?></p>
                  <ul class="card-text list-inline text-muted">
                    <li class="list-inline-item"><i class="fa-brands fa-joomla"></i> <?php echo $pkg['version']; ?></li>
                    <li class="list-inline-item"><i class="fa-brands fa-php"></i> <?php echo $pkg['php']; ?></li>
                    <li class="list-inline-item"><i class="fa-solid fa-code-branch"></i> <?php echo $pkg['server']; ?></li>
                  </ul>
                  <p class="card-text"><small class="text-muted"><i class="fa-solid fa-download"></i> <?php echo $pkg['url'] ?></small></p>
                  <a href="joomla_downloader.php?pkg=<?php echo $server; ?>" class="btn btn-primary stretched-link"><i class="fa-solid fa-caret-right"></i> Install</a>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php
  }
?>
      </div>
    </main>
<?php
} elseif ( isset($_GET['pkg']) && !isset($_GET['clear']) ) {
  $pkg = $_GET['pkg'];

  $pkgUrl = lastPkg($pkg)['url'];
?>
    <main class="flex-shrink-0">
      <div class="container">
        <p class="lead">
          <?php echo "Downloading <code>$pkgUrl</code> . . ."; ?>
        </p>
<?php
  $pkg = getcwd().DIRECTORY_SEPARATOR.basename($pkgUrl);
  file_put_contents($pkg, file_get_contents($pkgUrl));
?>
        <p class="lead">
          <?php echo "Unzipping <code>$pkg</code> . . ."; ?>
        </p>
<?php
  $zip = new ZipArchive;
  $res = $zip->open($pkg);
  if ($res === TRUE) {
    $zip->extractTo(getcwd().DIRECTORY_SEPARATOR); // extract the zip file
    $zip->close();
  }
?>
        <p class="lead">
          <?php echo "Deleting <code>$pkg</code> . . ."; ?>
        </p>
<?php
  unlink($pkg); // delete zip file
?>
        <div class="alert alert-success" role="alert">
          All done!
        </div>
        <div class="d-grid gap-2 col-6 mx-auto pt-5">
          <a class="btn btn-primary btn-lg" href="joomla_downloader.php?clear" role="button">Delete this script</a>
        </div>
      </div>
    </main>
<?php
} elseif ( !isset($_GET['pkg']) && isset($_GET['clear']) ) {
?>
    <main class="flex-shrink-0">
      <div class="container">
        <p class="lead">
          Script removing ...
        </p>
<?php
  unlink($_SERVER["SCRIPT_FILENAME"]); // delete script file
?>
        <div class="alert alert-success" role="alert">
          All done!
        </div>
        <div class="d-grid gap-2 col-6 mx-auto pt-5">
          <a class="btn btn-success btn-lg" href="<?php echo str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_URI"]) ?>" role="button">Install Joomla!</a>
        </div>
      </div>
    </main>
<?php
}
?>
    <footer class="footer mt-auto py-3 bg-body-tertiary">
      <div class="container-fluid">
        <div class="row">
          <div class='col col-12 col-md-2 text-center align-self-center py-2'>
<?php
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/JoomlaLABS/Joomla_Downloader/releases/latest');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Joomla!LABS User Agent');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_FAILONERROR, true);
  $lastRelease = curl_exec($ch);
  if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
  }
  curl_close($ch);
  if ($lastRelease == false) {
?>
            <p class="text-muted mb-0"><?php echo $thisRelease; ?></p>
            <p><?php echo $error_msg; ?></p>
            
<?php
  } else {
    $lastRelease = json_decode($lastRelease)->tag_name;

    switch (version_compare ($thisRelease , $lastRelease)) {
      case 0:
?>
            <p class="text-muted mb-0"><?php echo $thisRelease; ?></p>
            <p class="text-muted mb-0">the latest</p>
<?php
        break;

      case -1:
?>
            <p class="text-muted mb-0"><?php echo $thisRelease; ?></p>
            <p><a class="text-danger mb-0" href="https://github.com/JoomlaLABS/Joomla_Downloader/releases/latest" target="_blank"><?php echo $lastRelease; ?> aviable</a></p>
<?php
        break;

      case 1:
?>
            <p class="text-warning mb-0"><?php echo $thisRelease; ?></p>
            <p class="text-muted mb-0"><?php echo $lastRelease; ?> is the latest</p>
<?php
        break;

      default:
        // code...
        break;
    }
  }
?>
          </div>
          <div class='col col-12 col-md-10 align-self-center'>
            <p class="text-muted mb-0">Joomla!LABS and this file is not affiliated with or endorsed by The Joomla! Project™. Any products and services provided through this file are not supported or warrantied by The Joomla! Project or Open Source Matters, Inc. Use of the Joomla!® name, symbol, logo and related trademarks is permitted under a limited license granted by Open Source Matters, Inc.</p>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </body>
</html>
<?php
  function lastPkg(string $server) : array {
    //Joomla! Core update servers
    $updateUrls = array(
      'stable'        => 'https://update.joomla.org/core/sts/extension_sts.xml',
      'maintenance'   => 'https://update.joomla.org/core/extension.xml',
      'test'          => 'https://update.joomla.org/core/test/extension_test.xml',
      'nightly-major' => 'https://update.joomla.org/core/nightlies/next_major_extension.xml',
      'nightly-minor' => 'https://update.joomla.org/core/nightlies/next_minor_extension.xml',
      'nightly-patch' => 'https://update.joomla.org/core/nightlies/next_patch_extension.xml'
    );
    $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
    $xml = file_get_contents($updateUrls[$server], false, $context);
    $xml = simplexml_load_string($xml);
    $pkgsUpd = array();
    foreach($xml->update as $update) {
      $pkgsUpd[(string)$update->version]['name'] = $update->name;
      $pkgsUpd[(string)$update->version]['version'] = $update->version;
      $pkgsUpd[(string)$update->version]['server'] = $server;
      $pkgsUpd[(string)$update->version]['description'] = $update->description;
      $pkgsUpd[(string)$update->version]['php'] = $update->php_minimum;
      $pkgsUpd[(string)$update->version]['url'] = str_replace('Update_Package.zip', 'Full_Package.zip', $update->downloads->downloadurl);
    }
    usort($pkgsUpd, function($a,$b) {
      return -1 * version_compare ( $a['version'] , $b['version'] );
    });
    return $pkgsUpd[0];
  }
