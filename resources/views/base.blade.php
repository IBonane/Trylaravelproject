<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<body style="padding: 0; margin: 0; box-sizing: border-box;">
    <nav style=" background-color: darkblue; color: white; width: 100%; height: 50px; display:flex; justify-content:right;  align-items: center;">
        
        <ul style="list-style-type: none; margin-right: 20px; font-weight: bold; display:flex;">
            @yield('list')
        </ul>
    </nav>
    @yield('content')

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" 
    src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-620d51228f769764">
    </script>
    @yield('script')
</body>
</html>