<?php
  session_start();
  $thisRelease = 'v2.5.0';
  
  // Configuration: packages to display on main page
  $packagesConfig = array(
    // Stable releases
    array('server' => 'targets'),                      // Latest Joomla! stable
    array('server' => 'targets', 'channel' => '5.x'),  // Joomla! 5.x LTS
    # array('server' => 'j5'),                         // Joomla! 5.4
    # array('server' => 'j4'),                         // Joomla! 4.4
    # array('server' => 'stable'),                     // Joomla! 4.4
    # array('server' => 'maintenance'),                // Joomla! 3.10
    
    // Release Candidates
    array('server' => 'targets', 'stability' => 'RC'),                     // Latest Release Candidate
    array('server' => 'targets', 'channel' => '5.x', 'stability' => 'RC'), // Joomla! 5.x Release Candidate
    # array('server' => 'test'),                                           // Joomla! 5.1 RC
    
    // Nightly builds
    array('server' => 'nightly-major'),
    array('server' => 'nightly-minor'),
    array('server' => 'nightly-patch'),
  );
  
  // AJAX endpoint for progress tracking
  if (isset($_GET['action']) && $_GET['action'] === 'progress') {
    header('Content-Type: application/json');
    echo json_encode(isset($_SESSION['install_progress']) ? $_SESSION['install_progress'] : array('step' => 0, 'message' => 'Waiting...', 'percent' => 0));
    exit;
  }
  
  // AJAX endpoint for installation execution
  if (isset($_GET['action']) && $_GET['action'] === 'install') {
    $server = isset($_GET['server']) ? trim($_GET['server']) : null;
    $channel = isset($_GET['channel']) ? trim($_GET['channel']) : null;
    $stability = isset($_GET['stability']) ? trim($_GET['stability']) : null;
    
    // Validation
    $allowedServers = array('targets', 'stable', 'maintenance', 'j4', 'j5', 'test', 'nightly-major', 'nightly-minor', 'nightly-patch');
    if (!$server || !in_array($server, $allowedServers)) {
      header('Content-Type: application/json');
      echo json_encode(array('success' => false, 'error' => 'Invalid server parameter'));
      exit;
    }
    
    // Execute installation
    executeInstallation($server, $channel, $stability);
    exit;
  }
  
  // AJAX endpoint for loading packages
  if (isset($_GET['action']) && $_GET['action'] === 'get_packages') {
    header('Content-Type: application/json');
    
    // Get packages based on configuration
    $pkgs = array();
    foreach ($packagesConfig as $config) {
      $server = $config['server'];
      $channel = isset($config['channel']) ? $config['channel'] : null;
      $stability = isset($config['stability']) ? $config['stability'] : null;
      
      $pkg = lastPkg($server, $channel, $stability);
      if (!empty($pkg)) {
        $pkgs[] = $pkg;
      }
    }
    
    // Save reference to last targets call for icon comparison
    $lastTargetsPkg = lastPkg('targets');
    
    // Prepare response array
    $response = array();
    
    foreach ($pkgs as $pkg) {
      // Skip if completely empty or missing essential data
      if (empty($pkg) || !isset($pkg['name']) || !isset($pkg['version']) || empty($pkg['url'])) {
        continue;
      }
      
      // Determine icon and color based on server, stability, and branch
      $server = isset($pkg['server']) ? $pkg['server'] : '';
      $stability = isset($pkg['stability']) ? $pkg['stability'] : '';
      $branch = isset($pkg['branch']) ? $pkg['branch'] : '';
      
      // Assign icon type and color
      $iconType = 'default';
      $color = 'text-secondary';
      
      if (in_array($server, ['nightly-major', 'nightly-minor', 'nightly-patch'])) {
        $color = 'text-warning';
        $iconType = $server; // nightly-major, nightly-minor, nightly-patch
      } elseif ($server === 'test' || strtolower($stability) === 'rc' || strtolower($branch) === 'test') {
        $color = 'text-info';
        $iconType = 'test';
      } elseif (in_array($server, ['stable', 'maintenance', 'j4', 'j5'])) {
        $color = 'text-success';
        $iconType = 'archive';
      } elseif ($server === 'targets') {
        $color = 'text-success';
        $iconType = ($pkg === $lastTargetsPkg) ? 'box' : 'archive';
      }
      
      // Build URL parameters
      $urlParams = 'server=' . urlencode($pkg['server']);
      if (!empty($pkg['channel'])) {
        $urlParams .= '&channel=' . urlencode($pkg['channel']);
      }
      if (!empty($pkg['stability'])) {
        $urlParams .= '&stability=' . urlencode($pkg['stability']);
      }
      
      // Add to response
      $response[] = array(
        'id' => $pkg['server'] . '_' . $pkg['version'],
        'name' => $pkg['name'],
        'description' => $pkg['description'],
        'version' => $pkg['version'],
        'branch' => $pkg['branch'],
        'stability' => isset($pkg['stability']) ? $pkg['stability'] : '',
        'php' => $pkg['php'],
        'supported_databases' => isset($pkg['supported_databases']) ? $pkg['supported_databases'] : array(),
        'url' => $pkg['url'],
        'infourl' => isset($pkg['infourl']) ? $pkg['infourl'] : null,
        'color' => $color,
        'iconType' => $iconType,
        'linkUrl' => 'joomla_downloader.php?' . $urlParams
      );
    }
    
    echo json_encode($response);
    exit;
  }
?>
<!doctype html>
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
// Validation and sanitization of GET parameters
$allowedServers = array('targets', 'stable', 'maintenance', 'j4', 'j5', 'test', 'nightly-major', 'nightly-minor', 'nightly-patch');
$server = isset($_GET['server']) ? trim($_GET['server']) : null;
$channel = isset($_GET['channel']) ? trim($_GET['channel']) : null;
$stability = isset($_GET['stability']) ? trim($_GET['stability']) : null;
$clear = isset($_GET['clear']);

// Validation of server parameter
if ($server !== null && !in_array($server, $allowedServers)) {
    $server = null; // Reset if invalid
}

if( !$server && !$clear ) {
?>
    <main class="flex-shrink-0">
      <!-- Loading Spinner -->
      <div id="loadingSpinner" class="text-center py-5">
        <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
          <span class="visually-hidden">Loading packages...</span>
        </div>
        <p class="mt-3 text-muted">Loading available Joomla! packages...</p>
      </div>
      
      <!-- Packages Container (initially hidden) -->
      <div id="packagesContainer" class="container-fluid py-4" style="display: none;">
        <!-- Stable Releases Section -->
        <div id="stableSection" class="mb-5" style="display: none;">
          <h2 class="mb-4 text-success text-center"><i class="fa-solid fa-box"></i> Stable Releases</h2>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center" id="stableCards">
            <!-- Stable release cards will be inserted here -->
          </div>
        </div>
        
        <!-- Pre-releases / Release Candidates Section -->
        <div id="rcSection" class="mb-5" style="display: none;">
          <h2 class="mb-4 text-info text-center"><i class="fa-solid fa-vial"></i> Release Candidates</h2>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center" id="rcCards">
            <!-- RC cards will be inserted here -->
          </div>
        </div>
        
        <!-- Nightly Builds Section -->
        <div id="nightlySection" class="mb-5" style="display: none;">
          <h2 class="mb-4 text-warning text-center"><i class="fa-solid fa-moon"></i> Nightly Builds</h2>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center" id="nightlyCards">
            <!-- Nightly build cards will be inserted here -->
          </div>
        </div>
      </div>
    </main>
    
    <script>
    // Load packages via AJAX
    document.addEventListener('DOMContentLoaded', function() {
      fetch('joomla_downloader.php?action=get_packages')
        .then(response => response.json())
        .then(packages => {
          const container = document.getElementById('packagesContainer');
          const spinner = document.getElementById('loadingSpinner');
          
          // Separate packages by category
          const stablePackages = [];
          const rcPackages = [];
          const nightlyPackages = [];
          
          packages.forEach(pkg => {
            // Categorize based on iconType
            if (pkg.iconType.startsWith('nightly-')) {
              nightlyPackages.push(pkg);
            } else if (pkg.iconType === 'test' || pkg.stability.toLowerCase() === 'rc') {
              rcPackages.push(pkg);
            } else {
              stablePackages.push(pkg);
            }
          });
          
          // Function to generate card HTML
          function generateCardHTML(pkg) {
            // Generate icon HTML based on iconType
            let iconHTML = '';
            switch(pkg.iconType) {
              case 'nightly-major':
                iconHTML = '<span class="fa-layers fa-fw"><i class="fa-solid fa-moon fa-4x"></i><span class="bg-danger fa-4x fa-layers-counter fa-layers-bottom-left" style="--fa-bottom: -4rem;">major</span></span>';
                break;
              case 'nightly-minor':
                iconHTML = '<span class="fa-layers fa-fw"><i class="fa-solid fa-moon fa-4x"></i><span class="bg-danger fa-4x fa-layers-counter fa-layers-bottom-left" style="--fa-bottom: -4rem;">minor</span></span>';
                break;
              case 'nightly-patch':
                iconHTML = '<span class="fa-layers fa-fw"><i class="fa-solid fa-moon fa-4x"></i><span class="bg-danger fa-4x fa-layers-counter fa-layers-bottom-left" style="--fa-bottom: -4rem;">patch</span></span>';
                break;
              case 'test':
                iconHTML = '<i class="fa-solid fa-vial fa-fw fa-4x"></i>';
                break;
              case 'archive':
                iconHTML = '<i class="fa-solid fa-box-archive fa-fw fa-4x"></i>';
                break;
              case 'box':
                iconHTML = '<i class="fa-solid fa-box fa-fw fa-4x"></i>';
                break;
              default:
                iconHTML = '<i class="fa-solid fa-question fa-4x"></i>';
            }
            
            // Format supported databases
            let dbText = '';
            if (pkg.supported_databases) {
              const dbParts = [];
              if (pkg.supported_databases.mariadb) dbParts.push('mariadb: ' + pkg.supported_databases.mariadb);
              if (pkg.supported_databases.mysql) dbParts.push('mysql: ' + pkg.supported_databases.mysql);
              if (pkg.supported_databases.postgresql) dbParts.push('postgresql: ' + pkg.supported_databases.postgresql);
              dbText = dbParts.join(' | ');
            }
            
            // Build stability list item
            const stabilityHTML = pkg.stability ? `<li class="list-inline-item"><i class="fa-solid fa-layer-group"></i> ${pkg.stability}</li>` : '';
            
            // Build database list item
            const dbHTML = dbText ? `<li class="list-inline-item"><i class="fa-solid fa-database"></i> ${dbText}</li>` : '';
            
            // Build info button
            const infoButtonHTML = pkg.infourl ? 
              `<a href="${pkg.infourl.url}" target="_blank" class="btn btn-outline-info" style="z-index: 10;"><i class="fa-solid fa-circle-info"></i> ${pkg.infourl.title}</a>` : '';
            
            // Return card HTML
            return `
              <div class="col">
                <div id="${pkg.id}" class="card mb-4 h-100">
                  <div class="row g-0">
                    <div class="col-md-3 ${pkg.color} text-center align-self-center py-4">
                      ${iconHTML}
                    </div>
                    <div class="col-md-9">
                      <div class="card-body">
                        <h5 class="card-title">${pkg.name}</h5>
                        <p class="card-text">${pkg.description}</p>
                        <ul class="card-text list-inline text-muted small">
                          <li class="list-inline-item"><i class="fa-brands fa-joomla"></i> ${pkg.version}</li>
                          <li class="list-inline-item"><i class="fa-solid fa-code-branch"></i> ${pkg.branch}</li>
                          ${stabilityHTML}
                        </ul>
                        <ul class="card-text list-inline text-muted small">
                          <li class="list-inline-item"><i class="fa-brands fa-php"></i> ${pkg.php}</li>
                          ${dbHTML}
                        </ul>
                        <p class="card-text"><small class="text-muted"><i class="fa-solid fa-download"></i> ${pkg.url}</small></p>
                        <div class="d-flex gap-2">
                          <a href="${pkg.linkUrl}" class="btn btn-primary flex-grow-1 stretched-link"><i class="fa-solid fa-caret-right"></i> Install</a>
                          ${infoButtonHTML}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
          }
          
          // Render stable packages
          if (stablePackages.length > 0) {
            const stableSection = document.getElementById('stableSection');
            const stableCardsContainer = document.getElementById('stableCards');
            stablePackages.forEach(pkg => {
              stableCardsContainer.insertAdjacentHTML('beforeend', generateCardHTML(pkg));
            });
            stableSection.style.display = 'block';
          }
          
          // Render RC packages
          if (rcPackages.length > 0) {
            const rcSection = document.getElementById('rcSection');
            const rcCardsContainer = document.getElementById('rcCards');
            rcPackages.forEach(pkg => {
              rcCardsContainer.insertAdjacentHTML('beforeend', generateCardHTML(pkg));
            });
            rcSection.style.display = 'block';
          }
          
          // Render nightly packages
          if (nightlyPackages.length > 0) {
            const nightlySection = document.getElementById('nightlySection');
            const nightlyCardsContainer = document.getElementById('nightlyCards');
            nightlyPackages.forEach(pkg => {
              nightlyCardsContainer.insertAdjacentHTML('beforeend', generateCardHTML(pkg));
            });
            nightlySection.style.display = 'block';
          }
          
          // Hide spinner and show packages container
          spinner.style.display = 'none';
          container.style.display = 'block';
        })
        .catch(error => {
          console.error('Error loading packages:', error);
          const spinner = document.getElementById('loadingSpinner');
          spinner.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-triangle-exclamation"></i> Error loading packages. Please refresh the page.</div>';
        });
    });
    </script>
<?php
} elseif ( $server && !$clear ) {
  // Call lastPkg with the provided server, channel, and stability parameters
  $pkgData = lastPkg($server, $channel, $stability);
  
  // Additional URL validation
  if (!$pkgData || !isset($pkgData['url']) || !filter_var($pkgData['url'], FILTER_VALIDATE_URL)) {
    die('Error: Invalid package URL.');
  }
  
  $pkgUrl = $pkgData['url'];
  
  // Verify that the URL is from authorized domains
  $authorizedDomains = ['update.joomla.org', 'downloads.joomla.org', 'developer.joomla.org', 'github.com'];
  $urlParts = parse_url($pkgUrl);
  if (!in_array($urlParts['host'], $authorizedDomains)) {
    die('Error: Unauthorized domain.');
  }
  
  // Store installation parameters in session for AJAX call
  $_SESSION['install_params'] = array(
    'server' => $server,
    'channel' => $channel,
    'stability' => $stability,
    'url' => $pkgUrl
  );
?>
    <main class="flex-shrink-0">
      <div class="container">
        <!-- Progress Bar UI -->
        <div id="progressContainer" class="mb-4">
          <h5 id="progressMessage">Initializing...</h5>
          <div class="progress" style="height: 30px;">
            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
          </div>
          <div class="mt-2">
            <small class="text-muted">
              <span id="stepInfo">Step 1 of 5: Preparing...</span>
            </small>
          </div>
        </div>
        
        <div id="statusMessages">
          <p class="lead">Preparing to download <code><?php echo htmlspecialchars($pkgUrl, ENT_QUOTES, 'UTF-8'); ?></code></p>
        </div>
        
        <!-- Installation Steps Log -->
        <div id="stepsLog" class="card mb-4">
          <div class="card-header">
            <h6 class="mb-0">Installation Steps</h6>
          </div>
          <div class="card-body">
            <ul id="stepsList" class="list-unstyled mb-0">
              <!-- Steps will be added here dynamically -->
            </ul>
          </div>
        </div>
        
        <div id="completionMessage" class="d-none">
          <div class="alert alert-success" role="alert">
            All done!
          </div>
          <div class="d-grid gap-2 col-6 mx-auto pt-5">
            <a class="btn btn-primary btn-lg" href="joomla_downloader.php?clear" role="button">Delete this script</a>
          </div>
        </div>
      </div>
    </main>
<?php
} elseif ( $clear ) {
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
          <a class="btn btn-success btn-lg" href="<?php echo rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/' ?>" role="button">Install Joomla!</a>
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
  // Function to get release info with improved error handling
  function getLatestReleaseInfo($currentVersion) {
    $ch = curl_init();
    curl_setopt_array($ch, [
      CURLOPT_URL => 'https://api.github.com/repos/JoomlaLABS/Joomla_Downloader/releases/latest',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_USERAGENT => 'Joomla! Downloader',
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_FAILONERROR => true,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_CONNECTTIMEOUT => 5,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    // Handle cURL errors
    if ($response === false || !empty($error)) {
      return [
        'success' => false, 
        'error' => $error ?: 'Network error',
        'current' => $currentVersion
      ];
    }
    
    // Handle HTTP errors
    if ($httpCode !== 200) {
      return [
        'success' => false, 
        'error' => "HTTP $httpCode error",
        'current' => $currentVersion
      ];
    }
    
    // Parse JSON response
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE || !isset($data['tag_name'])) {
      return [
        'success' => false, 
        'error' => 'Invalid JSON response',
        'current' => $currentVersion
      ];
    }
    
    $latestVersion = $data['tag_name'];
    $comparison = version_compare($currentVersion, $latestVersion);
    
    return [
      'success' => true,
      'current' => $currentVersion,
      'latest' => $latestVersion,
      'comparison' => $comparison,
      'url' => 'https://github.com/JoomlaLABS/Joomla_Downloader/releases/latest'
    ];
  }
  
  // Function to render version status
  function renderVersionStatus($releaseInfo) {
    $repoUrl = 'https://github.com/JoomlaLABS/Joomla_Downloader';
    $current = htmlspecialchars($releaseInfo['current'], ENT_QUOTES, 'UTF-8');
    $downloadUrl = $repoUrl . '/releases/tag/' . urlencode($releaseInfo['current']);
    
    if (!$releaseInfo['success']) {
      return sprintf(
        '<p class="text-muted mb-0"><a href="%s" target="_blank" class="text-muted text-decoration-none">%s <i class="fa-solid fa-download"></i></a></p><p class="text-warning mb-0">%s</p>',
        $downloadUrl,
        $current,
        htmlspecialchars($releaseInfo['error'], ENT_QUOTES, 'UTF-8')
      );
    }
    
    $latest = htmlspecialchars($releaseInfo['latest'], ENT_QUOTES, 'UTF-8');
    $latestUrl = htmlspecialchars($releaseInfo['url'], ENT_QUOTES, 'UTF-8');
    
    switch ($releaseInfo['comparison']) {
      case 0: // Same version
        return sprintf(
          '<p class="text-muted mb-0"><a href="%s" target="_blank" class="text-muted text-decoration-none">%s <i class="fa-solid fa-download"></i></a></p><p class="text-muted mb-0"><a href="%s" target="_blank" class="text-muted text-decoration-none">the latest <i class="fa-solid fa-download"></i></a></p>',
          $downloadUrl, $current, $latestUrl
        );
        
      case -1: // Current is older
        return sprintf(
          '<p class="text-muted mb-0"><a href="%s" target="_blank" class="text-muted text-decoration-none">%s <i class="fa-solid fa-download"></i></a></p><p><a class="text-danger mb-0" href="%s" target="_blank">%s available <i class="fa-solid fa-download"></i></a></p>',
          $downloadUrl, $current, $latestUrl, $latest
        );
        
      case 1: // Current is newer (development) - no download link for unreleased version
        return sprintf(
          '<p class="text-warning mb-0">%s</p><p class="text-muted mb-0"><a href="%s" target="_blank" class="text-muted text-decoration-none">%s is the latest <i class="fa-solid fa-download"></i></a></p>',
          $current, $latestUrl, $latest
        );
        
      default:
        return sprintf(
          '<p class="text-muted mb-0"><a href="%s" target="_blank" class="text-muted text-decoration-none">%s <i class="fa-solid fa-download"></i></a></p><p class="text-muted mb-0">Version check failed</p>',
          $downloadUrl, $current
        );
    }
  }
  
  // Get and display release information
  $releaseInfo = getLatestReleaseInfo($thisRelease);
  echo renderVersionStatus($releaseInfo);
?>
          </div>
          <div class='col col-12 col-md-10 align-self-center'>
            <p class="mb-2"><strong><a href="https://github.com/JoomlaLABS/Joomla_Downloader" target="_blank" class="text-decoration-none">Joomla! Downloader</a></strong> is a smart, single-file PHP script that revolutionizes the Joomla! installation process.</p>
            <p class="text-muted mb-0">Joomla!LABS and this file is not affiliated with or endorsed by The Joomla! Project™. Any products and services provided through this file are not supported or warrantied by The Joomla! Project or Open Source Matters, Inc. Use of the Joomla!® name, symbol, logo and related trademarks is permitted under a limited license granted by Open Source Matters, Inc.</p>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script>
      // Progress tracking with AJAX polling
      (function() {
        const progressBar = document.getElementById('progressBar');
        const progressMessage = document.getElementById('progressMessage');
        const stepInfo = document.getElementById('stepInfo');
        const progressContainer = document.getElementById('progressContainer');
        const completionMessage = document.getElementById('completionMessage');
        const statusMessages = document.getElementById('statusMessages');
        const stepsList = document.getElementById('stepsList');
        
        if (!progressContainer) return; // Only run on installation page
        
        const stepNames = [
          'Preparing download...',
          'Downloading package...',
          'Validating archive...',
          'Extracting files...',
          'Cleaning up...'
        ];
        
        let lastCompletedStep = -1;
        let hasError = false;
        
        // Function to add a step to the log
        function addStepToLog(stepName, success) {
          const li = document.createElement('li');
          li.className = 'mb-2';
          
          const icon = document.createElement('i');
          if (success) {
            icon.className = 'fas fa-check-circle text-success me-2';
          } else {
            icon.className = 'fas fa-times-circle text-danger me-2';
          }
          
          const text = document.createTextNode(stepName);
          
          li.appendChild(icon);
          li.appendChild(text);
          stepsList.appendChild(li);
        }
        
        // Start installation via AJAX
        function startInstallation() {
          const urlParams = new URLSearchParams(window.location.search);
          const server = urlParams.get('server');
          const channel = urlParams.get('channel');
          const stability = urlParams.get('stability');
          
          let installUrl = '?action=install&server=' + encodeURIComponent(server);
          if (channel) installUrl += '&channel=' + encodeURIComponent(channel);
          if (stability) installUrl += '&stability=' + encodeURIComponent(stability);
          
          // Fire and forget - we rely on polling for status
          fetch(installUrl, {
            method: 'GET',
            cache: 'no-cache'
          }).catch(error => {
            // Ignore fetch errors - polling will handle status
            console.log('Installation fetch completed/timed out:', error.message);
          });
        }
        
        function updateProgress() {
          fetch('?action=progress', {
            method: 'GET',
            cache: 'no-cache'
          })
          .then(response => response.json())
          .then(data => {
            const step = data.step || 0;
            const percent = data.percent || 0;
            const message = data.message || 'Processing...';
            
            // Update progress bar
            progressBar.style.width = percent + '%';
            progressBar.setAttribute('aria-valuenow', percent);
            progressBar.textContent = percent + '%';
            
            // Update message
            progressMessage.textContent = message;
            
            // Update step info
            if (step >= 0 && step < stepNames.length) {
              stepInfo.textContent = 'Step ' + (step + 1) + ' of 5: ' + stepNames[step];
            }
            
            // Add completed steps to log
            if (!hasError && step > lastCompletedStep) {
              for (let i = lastCompletedStep + 1; i <= step; i++) {
                if (i >= 0 && i < stepNames.length) {
                  addStepToLog(stepNames[i], true);
                }
              }
              lastCompletedStep = step;
            }
            
            // Store current step for error handling
            progressBar.setAttribute('data-current-step', step);
            
            // Change color based on completion
            if (percent === 100 && step === 4) {
              progressBar.classList.remove('progress-bar-animated');
              progressBar.classList.remove('bg-danger');
              progressBar.classList.add('bg-success');
              
              // Show completion message
              if (completionMessage) {
                completionMessage.classList.remove('d-none');
              }
              if (statusMessages) {
                statusMessages.classList.add('d-none');
              }
            }
            
            // Continue polling if not complete
            if (!(percent === 100 && step === 4)) {
              setTimeout(updateProgress, 500);
            }
          })
          .catch(error => {
            console.error('Progress update failed:', error);
            setTimeout(updateProgress, 1000); // Retry on error
          });
        }
        
        // Start installation and polling
        startInstallation();
        updateProgress();
      })();
    </script>
  </body>
</html>
<?php
  /**
   * Execute the installation process
   */
  function executeInstallation(string $server, ?string $channel, ?string $stability) {
    // Installation progress distribution (5 steps total, 20% each):
    // Step 0 (0-20%):   Preparing download
    // Step 1 (20-40%):  Downloading package with real-time progress
    // Step 2 (40-60%):  Validating archive integrity
    // Step 3 (60-80%):  Extracting files to destination
    // Step 4 (80-100%): Cleaning up temporary files
    
    // Set unlimited execution time for installation
    set_time_limit(0);
    ini_set('max_execution_time', '0');
    
    // Get package data
    $pkgData = lastPkg($server, $channel, $stability);
    
    if (!$pkgData || !isset($pkgData['url']) || !filter_var($pkgData['url'], FILTER_VALIDATE_URL)) {
      header('Content-Type: application/json');
      echo json_encode(array('success' => false, 'error' => 'Invalid package URL'));
      exit;
    }
    
    $pkgUrl = $pkgData['url'];
    
    // Verify authorized domain
    $authorizedDomains = ['update.joomla.org', 'downloads.joomla.org', 'developer.joomla.org', 'github.com'];
    $urlParts = parse_url($pkgUrl);
    if (!in_array($urlParts['host'], $authorizedDomains)) {
      header('Content-Type: application/json');
      echo json_encode(array('success' => false, 'error' => 'Unauthorized domain'));
      exit;
    }
    
    $pkgFileName = basename($pkgUrl);
    
    // File name validation
    if (!preg_match('/^[a-zA-Z0-9._-]+\\.zip$/', $pkgFileName)) {
      header('Content-Type: application/json');
      echo json_encode(array('success' => false, 'error' => 'Invalid file name'));
      exit;
    }
    
    $pkgPath = getcwd() . DIRECTORY_SEPARATOR . $pkgFileName;
    
    // Initialize progress tracking
    $_SESSION['install_progress'] = array(
      'step' => 0,
      'message' => 'Preparing download...',
      'percent' => 20
    );
    session_write_close();
    
    // Download with cURL and progress tracking
    $fp = fopen($pkgPath, 'w+');
    if ($fp === false) {
      header('Content-Type: application/json');
      echo json_encode(array('success' => false, 'error' => 'Unable to create file'));
      exit;
    }
    
    $ch = curl_init($pkgUrl);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Joomla! Downloader');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_NOPROGRESS, false);
    curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, function($resource, $download_size, $downloaded, $upload_size, $uploaded) {
      if ($download_size > 0) {
        $downloadPercent = ($downloaded / $download_size);
        // Map download progress from 20% to 40% (step 1 occupies 20% of total)
        $totalPercent = 20 + round($downloadPercent * 20);
        // Ensure it doesn't exceed 40%
        $totalPercent = min($totalPercent, 40);
        
        session_start();
        $_SESSION['install_progress'] = array(
          'step' => 1,
          'message' => 'Downloading package...',
          'percent' => $totalPercent
        );
        session_write_close();
      }
    });
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);
    
    if ($result === false || $httpCode !== 200) {
      @unlink($pkgPath);
      header('Content-Type: application/json');
      echo json_encode(array('success' => false, 'error' => 'Unable to download file'));
      exit;
    }
    
    session_start();
    $_SESSION['install_progress'] = array(
      'step' => 1,
      'message' => 'Download completed',
      'percent' => 40
    );
    session_write_close();
    
    // Validate and extract
    session_start();
    $_SESSION['install_progress'] = array(
      'step' => 2,
      'message' => 'Validating archive...',
      'percent' => 60
    );
    session_write_close();
    
    $zip = new ZipArchive;
    $res = $zip->open($pkgPath);
    if ($res === TRUE) {
      $extractPath = getcwd() . DIRECTORY_SEPARATOR;
      
      for ($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);
        
        if (strpos($filename, '..') !== false || strpos($filename, '/') === 0) {
          $zip->close();
          unlink($pkgPath);
          header('Content-Type: application/json');
          echo json_encode(array('success' => false, 'error' => 'Archive contains unsafe paths'));
          exit;
        }
      }
      
      $totalFiles = $zip->numFiles;
      
      // Extract files with progress tracking
      for ($i = 0; $i < $totalFiles; $i++) {
        $filename = $zip->getNameIndex($i);
        
        // Extract single file
        $zip->extractTo($extractPath, $filename);
        
        // Update progress every 50 files or on last file to avoid too many session writes
        if ($i % 50 === 0 || $i === $totalFiles - 1) {
          $extractPercent = ($i / $totalFiles);
          // Map extraction progress from 60% to 80% (step 3 occupies 20% of total)
          $totalPercent = 60 + round($extractPercent * 20);
          
          session_start();
          $_SESSION['install_progress'] = array(
            'step' => 3,
            'message' => 'Extracting files... (' . ($i + 1) . '/' . $totalFiles . ')',
            'percent' => $totalPercent
          );
          session_write_close();
        }
      }
      
      $zip->close();
    } else {
      unlink($pkgPath);
      header('Content-Type: application/json');
      echo json_encode(array('success' => false, 'error' => 'Unable to open ZIP archive'));
      exit;
    }
    
    // Cleanup
    session_start();
    $_SESSION['install_progress'] = array(
      'step' => 4,
      'message' => 'Cleaning up...',
      'percent' => 80
    );
    session_write_close();
    
    // Give polling time to capture step 4
    usleep(500000); // 0.5 seconds
    
    if (file_exists($pkgPath)) {
      @unlink($pkgPath);
    }
    
    session_start();
    $_SESSION['install_progress'] = array(
      'step' => 4,
      'message' => 'Installation completed!',
      'percent' => 100
    );
    session_write_close();
    
    header('Content-Type: application/json');
    echo json_encode(array('success' => true, 'message' => 'Installation completed successfully'));
  }

  function lastPkg(string $server, ?string $channel = null, ?string $stability = null) : array {
    //Joomla! Core update servers
    $updateUrls = array(
      'stable'        => 'https://update.joomla.org/core/sts/extension_sts.xml',
      'maintenance'   => 'https://update.joomla.org/core/extension.xml',
      'j4'            => 'https://update.joomla.org/core/j4/default.xml',
      'j5'            => 'https://update.joomla.org/core/j5/default.xml',
      'test'          => 'https://update.joomla.org/core/test/extension_test.xml',
      'nightly-major' => 'https://update.joomla.org/core/nightlies/next_major_extension.xml',
      'nightly-minor' => 'https://update.joomla.org/core/nightlies/next_minor_extension.xml',
      'nightly-patch' => 'https://update.joomla.org/core/nightlies/next_patch_extension.xml',
      'targets'       => 'https://update.joomla.org/cms/targets.json'
    );
    
    // Server validation
    if (!array_key_exists($server, $updateUrls)) {
      return array();
    }
    
    // Determine server type
    $isNightly = in_array($server, ['nightly-major', 'nightly-minor', 'nightly-patch']);
    $isTargets = ($server === 'targets');
    
    // Handle JSON targets endpoint
    if ($isTargets) {
      return parseTargetsJson($updateUrls[$server], $server, $channel, $stability);
    }
    
    // Handle XML endpoints (stable, maintenance, j4, j5, test, nightlies)
    return parseXmlEndpoint($updateUrls[$server], $server, $isNightly);
  }
  
  /**
   * Parse JSON targets endpoint with TUF format
   */
  function parseTargetsJson(string $url, string $server, ?string $channel, ?string $stability) : array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Joomla! Downloader');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    
    $jsonContent = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($jsonContent === false || $httpCode !== 200) {
      return array();
    }
    
    $data = json_decode($jsonContent, true);
    if (json_last_error() !== JSON_ERROR_NONE || !isset($data['signed']['targets'])) {
      return array();
    }
    
    $targets = $data['signed']['targets'];
    $pkgsUpd = array();
    
    // Normalize filters (case-insensitive)
    $filterChannel = $channel ? strtolower($channel) : null;
    $filterStability = $stability ? strtolower($stability) : null;
    
    foreach ($targets as $filename => $target) {
      if (!isset($target['custom'])) {
        continue;
      }
      
      $custom = $target['custom'];
      
      // Extract metadata
      $targetChannel = isset($custom['channel']) ? strtolower($custom['channel']) : '';
      $targetStability = isset($custom['stability']) ? strtolower($custom['stability']) : '';
      $version = isset($custom['version']) ? $custom['version'] : '';
      
      // Apply filters
      if ($filterChannel && $targetChannel !== $filterChannel) {
        continue;
      }
      
      if ($filterStability && $targetStability !== $filterStability) {
        continue;
      }
      
      // Get download URLs
      $downloads = isset($custom['downloads']) ? $custom['downloads'] : array();
      if (empty($downloads)) {
        continue;
      }
      
      // Find valid download URL with optimized pattern matching
      $validUrl = null;
      foreach ($downloads as $download) {
        if (!isset($download['url'])) {
          continue;
        }
        
        $url = $download['url'];
        
        // URL validation
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
          continue;
        }
        
        // Convert Update_Package to Full_Package (simple replacement)
        $fullPackageUrl = str_replace('-Update_Package.zip', '-Full_Package.zip', $url);
        
        // Prefer update.joomla.org mirror for stable releases (most reliable)
        if ($targetStability === 'stable' && strpos($url, 'downloads.joomla.org') !== false) {
          // Extract version from URL pattern /6-0-1/ or /5-4-1/
          if (preg_match('/\/(\d+-\d+-\d+)\//', $url, $matches)) {
            $version = str_replace('-', '.', $matches[1]);
            $fullPackageUrl = "https://update.joomla.org/releases/$version/Joomla_$version-Stable-Full_Package.zip";
          }
        }
        
        // Validate URL availability via HTTP HEAD request
        $headers = @get_headers($fullPackageUrl, 1);
        $urlExists = $headers && (strpos($headers[0], '200') !== false || strpos($headers[0], '302') !== false);
        
        if ($urlExists) {
          $validUrl = $fullPackageUrl;
          break; // Use first download URL
        }
      }
      
      if ($validUrl) {
        // Stability priority for sorting: Stable=3, RC=2, Alpha=1, other=0
        $stabilityPriority = 0;
        switch ($targetStability) {
          case 'stable':
            $stabilityPriority = 3;
            break;
          case 'rc':
          case 'release candidate':
            $stabilityPriority = 2;
            break;
          case 'alpha':
            $stabilityPriority = 1;
            break;
        }
        
        $pkgsUpd[] = array(
          'name' => isset($custom['name']) ? $custom['name'] : $filename,
          'version' => $version,
          'server' => $server,
          'branch' => ($targetStability === 'rc') ? 'test' : $targetChannel,
          'description' => isset($custom['description']) ? $custom['description'] : '',
          'php' => isset($custom['php_minimum']) ? $custom['php_minimum'] : '',
          'url' => $validUrl,
          'infourl' => isset($custom['infourl']) ? $custom['infourl'] : '',
          'supported_databases' => isset($custom['supported_databases']) ? $custom['supported_databases'] : '',
          'channel' => $targetChannel,
          'stability' => $targetStability,
          'stability_priority' => $stabilityPriority
        );
      }
    }
    
    if (empty($pkgsUpd)) {
      return array();
    }
    
    // Sort by channel (higher first), then stability priority (higher first), then version (higher first)
    usort($pkgsUpd, function($a, $b) {
      // Compare channel (6.x > 5.x)
      $channelCompare = version_compare($b['channel'], $a['channel']);
      if ($channelCompare !== 0) {
        return $channelCompare;
      }
      
      // Compare stability priority (Stable > RC > Alpha)
      $stabilityCompare = $b['stability_priority'] - $a['stability_priority'];
      if ($stabilityCompare !== 0) {
        return $stabilityCompare;
      }
      
      // Compare version
      return -1 * version_compare($a['version'], $b['version']);
    });
    
    // Remove internal sorting fields
    unset($pkgsUpd[0]['stability_priority']);
    
    return $pkgsUpd[0];
  }
  
  /**
   * Parse XML endpoint (stable, maintenance, j4, j5, test, nightlies)
   */
  function parseXmlEndpoint(string $url, string $server, bool $isNightly) : array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Joomla! Downloader');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/xml'));
    
    $xmlContent = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($xmlContent === false || $httpCode !== 200) {
      return array();
    }
    
    // Prevent XXE attacks using secure XML loading with modern approach
    $prevUseInternalErrors = libxml_use_internal_errors(true);
    
    // Load XML with security flags to prevent XXE
    $xml = simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NONET);
    
    // Restore previous settings
    libxml_use_internal_errors($prevUseInternalErrors);
    
    if ($xml === false || !isset($xml->update)) {
      return array();
    }
    
    $pkgsUpd = array();
    foreach($xml->update as $update) {
      // Validation and sanitization of XML data
      $version = (string)$update->version;
      
      // Check if downloadurl exists in the XML structure
      $url = '';
      if (isset($update->downloads->downloadurl)) {
        $url = (string)$update->downloads->downloadurl;
      } elseif (isset($update->downloadurl)) {
        $url = (string)$update->downloadurl;
      } else {
        continue; // Skip if no download URL found
      }
      
      // URL validation
      if (!filter_var($url, FILTER_VALIDATE_URL)) {
        continue;
      }
      
      // Domain authorization based on server type
      $urlParts = parse_url($url);
      if (!isset($urlParts['host'])) {
        continue;
      }
      
      if ($isNightly) {
        // Nightly repositories: only developer.joomla.org
        $authorizedDomains = ['developer.joomla.org'];
      } else {
        // Standard repositories: multiple authorized domains
        $authorizedDomains = [
          'update.joomla.org', 
          'downloads.joomla.org', 
          'developer.joomla.org',
          'github.com'
        ];
      }
      
      if (!in_array($urlParts['host'], $authorizedDomains)) {
        continue;
      }
      
      // Convert Update_Package to Full_Package (simple replacement)
      $validUrl = str_replace('-Update_Package.zip', '-Full_Package.zip', $url);
      
      // For downloads.joomla.org URLs, prefer update.joomla.org mirror (more reliable)
      if (!$isNightly && strpos($url, 'downloads.joomla.org') !== false) {
        // Extract version from URL pattern /6-0-1/ or /5-4-1/
        if (preg_match('/\/(\d+-\d+-\d+)\//', $url, $matches)) {
          $versionNum = str_replace('-', '.', $matches[1]);
          $validUrl = "https://update.joomla.org/releases/$versionNum/Joomla_$versionNum-Stable-Full_Package.zip";
        }
      }
      
      // Validate URL availability via HTTP HEAD request
      $headers = @get_headers($validUrl, 1);
      $urlExists = $headers && (strpos($headers[0], '200') !== false || strpos($headers[0], '302') !== false);
      
      if ($urlExists) {
        // Extract infourl with title attribute
        $infourl = '';
        if (isset($update->infourl)) {
          $infourlElement = $update->infourl;
          $infourlUrl = (string)$infourlElement;
          $infourlTitle = isset($infourlElement['title']) ? (string)$infourlElement['title'] : '';
          
          if (!empty($infourlUrl)) {
            $infourl = array(
              'url' => $infourlUrl,
              'title' => $infourlTitle
            );
          }
        }
        
        // Create package entry with standardized structure
        $pkgsUpd[$version] = array(
          'name' => (string)$update->name,
          'version' => $version,
          'server' => $server,
          'branch' => $server,
          'description' => (string)$update->description,
          'php' => (string)$update->php_minimum,
          'url' => $validUrl,
          'infourl' => $infourl,
          'supported_databases' => ''
        );
      }
    }
    
    if (empty($pkgsUpd)) {
      return array();
    }
    
    usort($pkgsUpd, function($a,$b) {
      return -1 * version_compare($a['version'], $b['version']);
    });
    return $pkgsUpd[0];
  }
