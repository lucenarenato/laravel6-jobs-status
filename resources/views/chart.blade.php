<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temper Assessment</title>
    <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}"/>
</head>
<body>

<div id="app">
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                Temper Assessment: Weekly Retention
            </div>
            <div class="card-body">
                <chart-component :series='@json($chartData)'></chart-component>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
