<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Joomla! Downloader</title>
    <meta name="description" content="">
    <meta name="author" content="Joomla!LABS">
    <link href="https://www.joomla.org/templates/joomla/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css" integrity="sha512-yDUXOUWwbHH4ggxueDnC5vJv4tmfySpVdIcN1LksGZi8W8EVZv4uKGrQc0pVf66zS7LDhFJM7Zdeow1sw1/8Jw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.min.css" integrity="sha512-9YHSK59/rjvhtDcY/b+4rdnl0V4LPDWdkKceBl8ZLF5TB6745ml1AfluEU6dFWqwDw9lPvnauxFgpKvJqp7jiQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css" integrity="sha512-SgaqKKxJDQ/tAUAAXzvxZz33rmn7leYDYfBP+YoMRSENhf3zJyx3SBASt/OfeQwBHA1nxMis7mM3EV/oYT6Fdw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/svg-with-js.min.css" integrity="sha512-FTnGkh+EGoZdexd/sIZYeqkXFlcV3VSscCTBwzwXv1IEN5W7/zRLf6aUBVf2Ahdgx3h/h22HNzaoeBnYT6vDlA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
      <img src="https://lh3.googleusercontent.com/u/0/drive-viewer/AAOQEORWPE5gYxWd9USVNfyMZpj4wa8f1EjM9CF8fMtRBeot5qxsU8u8-tHjzRPjPEEalpyM_nUnw5ELfboSuE8sHPuBxWZGfsaw7-7VuH3MVjkLtoUShcgf8fkqcB4K=w1920-h969" alt="Joomla! Logo" aria-hidden="true">
      <h1 class="display-1"><span class="visually-hidden">Joomla! </span>Downloader</h1>
    </div>
<?php
if( !isset($_GET['pkg']) && !isset($_GET['clear']) ) {
?>
    <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
<?php
  //Joomla! Core update servers
  $updateUrls = array(
    'stable'        => 'https://update.joomla.org/core/sts/extension_sts.xml',
    'test'          => 'https://update.joomla.org/core/test/extension_test.xml',
    'nightly-major' => 'https://update.joomla.org/core/nightlies/next_major_extension.xml',
    'nightly-minor' => 'https://update.joomla.org/core/nightlies/next_minor_extension.xml',
    'nightly-patch' => 'https://update.joomla.org/core/nightlies/next_patch_extension.xml'
  );
  $pkgs = array();
  foreach ($updateUrls as $server => $url) {
    // Retrieve the package url of the latest joomla version
    $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
    $xml = file_get_contents($url, false, $context);
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
    $pkgs[$server] = $pkgsUpd;
  }
  foreach($pkgs as $server => $update) {
    foreach($update as $pkg) {
      $color;
      $icon;
      switch ($pkg['server']) {
        case 'stable':
          $color = 'text-success';
          $icon = '<i class="fa-solid fa-box-archive fa-4x position-relative top-50 start-50 translate-middle py-4"></i>';
          break;
        case 'test':
          $color = 'text-info';
          $icon = '<i class="fa-solid fa-vial fa-4x position-relative top-50 start-50 translate-middle py-4"></i>';
          break;
        case 'nightly-major':
          $color = 'text-warning';
          $icon = '<span class="fa-layers fa-fw fa-4x position-relative top-50 start-50 translate-middle py-4"><i class="fa-solid fa-moon"></i><span class="bg-danger fa-layers-counter fa-layers-bottom-right" style="--fa-bottom: -2rem;">major</span></span>';
          break;
        case 'nightly-minor':
          $color = 'text-warning';
          $icon = '<span class="fa-layers fa-fw fa-4x position-relative top-50 start-50 translate-middle py-4"><i class="fa-solid fa-moon"></i><span class="bg-danger fa-layers-counter fa-layers-bottom-right" style="--fa-bottom: -2rem;">minor</span></span>';
          break;
        case 'nightly-patch':
          $color = 'text-warning';
          $icon = '<span class="fa-layers fa-fw fa-4x position-relative top-50 start-50 translate-middle py-4"><i class="fa-solid fa-moon"></i><span class="bg-danger fa-layers-counter fa-layers-bottom-right" style="--fa-bottom: -2rem;">patch</span></span>';
          break;
        default:
          $color = 'text-secondary';
          $icon = '<i class="fa-solid fa-question fa-4x position-relative top-50 start-50 translate-middle py-4"></i>';
          break;
      }
?>
        <div class="col">
          <div id="<?php echo $pkg['server']; ?>_<?php echo $pkg['version']; ?>" class="card mb-4 h-100">
            <div class="row g-0">
              <div class="col-md-3 <?php echo $color; ?>">
                <?php echo $icon; ?>
              </div>
              <div class="col-md-9">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $pkg['name']; ?></h5>
                  <p class="card-text"><?php echo $pkg['description']; ?></p>
                  <p class="card-text"><small class="text-muted">
                    <i class="fa-brands fa-joomla"></i> <?php echo $pkg['version']; ?>
                    <i class="fa-brands fa-php"></i> <?php echo $pkg['php']; ?>
                    <i class="fa-solid fa-code-branch"></i> <?php echo $pkg['server']; ?>
                  </small></p>
                  <p class="card-text"><small class="text-muted"><i class="fa-solid fa-link"></i> <a href="joomla_downloader.php?pkg=<?php echo $pkg['url'] ?>" class="stretched-link"><?php echo $pkg['url'] ?></a></small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php
    }
  }
?>
      </div>
    </div>
<?php
} elseif ( isset($_GET['pkg']) && !isset($_GET['clear']) ) {
  $pkgUrl = $_GET['pkg'];
?>
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
  unlink($pkg); // delete zip file
?>
      <div class="alert alert-success" role="alert">
        All done!
      </div>
      <div class="d-grid gap-2 col-6 mx-auto pt-5">
        <a class="btn btn-primary btn-lg" href="joomla_downloader.php?clear" role="button">Delete this script</a>
      </div>
    </div>
<?php
} elseif ( !isset($_GET['pkg']) && isset($_GET['clear']) ) {
?>
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
<?php
}
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>