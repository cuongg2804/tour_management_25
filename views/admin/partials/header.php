<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle?></title>
    <base href="/tour_management/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/file-upload-with-preview/dist/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="public/admin/css/style.css">
  </head>
<body>
<header class="header">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-3">
        <div class="inner-logo">
          <a href="admin/dashboard">ADMIN</a>
        </div>
      </div>
      <div class="col-9">
        <div class="text-right">
          <a href="/<%= prefixAdmin %>/my-account" class="btn btn-primary btn-sm mr-2">Le Van A</a>
          <a href="/<%= prefixAdmin %>/auth/logout" class="btn btn-danger btn-sm">Đăng xuất</a>
        </div>
      </div>
    </div>
  </div>
</header>
