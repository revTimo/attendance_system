<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>出席管理システム</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scala ble=no" name="viewport">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <?= $this->Html->css('style.css') ?>
  <?= $this->Html->css('../dist/css/AdminLTE.min.css') ?>
  <?= $this->Html->css('../dist/css/skins/skin-blue.min.css') ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <?= $this->Html->css ('../plugins/iCheck/square/blue.css') ?>
</head>
  <body class="login-page">
    <?php echo $this->fetch('content'); ?>
  </body>
</html>