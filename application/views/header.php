<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo $title; ?></title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo ASSET_PATH; ?>css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?php echo ASSET_PATH; ?>css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link rel="icon" type="image/x-icon" href="<?php echo ASSET_PATH; ?>img/favicon.ico">
</head>
<body>
  <script>var jq_url = '<?php echo BASE_URL; ?>'</script>
  <header>
    <nav class="light-blue lighten-1" role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="<?php echo BASE_URL; ?>" class="brand-logo">Daily Tasks</a>
        <ul class="right hide-on-med-and-down">
          <li><a href="https://github.com/miwha1990">Me on GitHub</a></li>
          <li><a href="https://www.linkedin.com/in/michael-%E2%99%95-fisun-1252b699?trk=hp-identity-photo">Me on LinkedIn</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
          <li><a href="https://github.com/miwha1990">Me on GitHub</a></li>
          <li><a href="https://www.linkedin.com/in/michael-%E2%99%95-fisun-1252b699?trk=hp-identity-photo">Me on LinkedIn</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
      </div>
    </nav>
  </header>
  <main>