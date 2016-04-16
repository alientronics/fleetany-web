<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="fleetany - open source fleet management system">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>fleetany - open source fleet management system</title>

<!-- first, parallel css -->
{!! HTML::style('css/style-edit.css') !!}
{!! HTML::style('css/md-date-time-picker.min.css') !!}
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.amber-indigo.min.css">
{!! HTML::style('css/styles.css') !!}

<!-- second, javascript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.3/material.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{!! HTML::script('js/md-date-time-picker.min.js') !!}
{!! HTML::script('js/fleetany.js') !!}

<script>
	@if (!is_null(env('GOOGLE_ANALYTICS')))
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', '{{ env('GOOGLE_ANALYTICS') }}', 'auto');
		ga('send', 'pageview');
	@else
		window.ga = function() { console.log("Sending to GA", arguments) };
	@endif
</script>