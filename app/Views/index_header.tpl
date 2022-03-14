<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{$nowparam.actionyear}}{{$nowparam.sitetitle}}|{{$pagetitle}}</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{{base_url()}}/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="{{base_url()}}/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="{{base_url()}}/favicon-16x16.png">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">

  <!-- Icons -->
  <link href="{{base_url('assets')}}/css/nucleo-icons.css" rel="stylesheet">
  <!--<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">

  <!-- Argon CSS -->
  <link type="text/css" href="{{base_url('assets')}}/css/argon-design-system.css" rel="stylesheet">
  <link type="text/css" href="{{base_url('assets')}}/css/style.css" rel="stylesheet">
</head>
</head>
<body>
{{include file='index_nav.tpl'}}
{{if !empty($msg)}}
  {{include file='msg.tpl'}}
{{/if}}
<div class="wrapper">