@extends('layouts.login')

@section('content')
<style>
	.mdl-layout__container {
		position: relative;
	}
</style>

<div class="mdl-layout mdl-layout--fixed-header mdl-js-layout mdl-color--grey-100">
      <div class="page-ribbon mdl-color--primary"></div>
      <main class="page-main mdl-layout__content">
        <div class="mdl-grid">
          <div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
          <div class="page-content mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--8-col">
			<h2>Privacy Policy</h2>

			<h4>Information gathering</h4>
			<p>When you register for Alientronics we collect information such as your name and email address. Alientronics uses this information to be able to provide our service, for identification and authorization of users, and to be able to contact you.</p>
			<p>The information we collect is not shared with other organisations except as detailed below for the provisioning and improvement of our service. The data we collect will never be sold to third parties for commercial purposes.</p>

			<h4>Cookies</h4>
			<p>Alientronics uses a cookie, which is a small amount of data stored by your web browser on your computer. The cookie stores your current session and allows you to stay logged in. Cookies are required to use the Alientronics service.</p>

			<h4>Data storage</h4>
			<p>Alientronics uses third parties to host our services and store your data. You retain all rights to the data you upload to Alientronics.</p>

			<h4>Third party tracking</h4>
			<p>We use Google Analytics to track users' interactions with Alientronics. This data is used for the improvement of our service.</p>
		  </div>
        </div>
      </main>
    </div>
@endsection