<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>hobbys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <v-header></v-header>
    <main>
        <div class="container">
            <router-view></router-view>
        </div>
    </main>
</div>
<script src="./js/app.js"></script>
</body>
</html>
