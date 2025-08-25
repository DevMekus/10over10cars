<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic Title -->
    <title><?php echo isset($metaTitle) ? $metaTitle : BRAND_NAME; ?></title>

    <!-- Dynamic Meta Description -->
    <meta name="description" content="<?php echo isset($metaDescription) ? $metaDescription : 'Default description'; ?>">

    <!-- Dynamic Meta Keywords -->
    <meta name="keywords" content="<?php echo isset($metaKeywords) ? $metaKeywords : 'default, keywords'; ?>">

    <!-- Dynamic Open Graph Meta Tags (Optional for Social Media Sharing) -->
    <meta property="og:title" content="<?php echo isset($metaTitle) ? $metaTitle : 'Default Title'; ?>" />
    <meta property="og:description" content="<?php echo isset($metaDescription) ? $metaDescription : 'Default description'; ?>" />
    <meta property="og:image" content="YOUR_DEFAULT_IMAGE_URL.jpg" />
    <meta property="og:url" content="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />

    <!-- Other meta tags you may need -->
    <meta name="robots" content="index, follow">

    <!-- Links to stylesheets and fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">




    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/styles/main.css" />

</head>