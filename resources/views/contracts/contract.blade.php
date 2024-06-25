<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="contractPageAsPDF.css" rel="stylesheet">
	<link href="Css/app.css" rel="stylesheet">
	 <!-- Font Awesome -->
	 <link rel="stylesheet" href="fontawesome-free-6.3.0-web/css/all.min.css" />
	 <!-- Google font -->
	 <style>
		@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Poppins:wght@300;700&display=swap');
		</style>
	 <title>Event Mangment System</title>
</head>
<body>
	<!-- ====================THIS PAGE FOR AHMED DEEEEEEEEB================================== -->
		<div class="container">
			<div class="invitetion">
				<div class="main">
					<div class="first-section">
						<!-- /---------------1----------------- -->
						<div class="logo-holder">
							<img src="images/Logo.png" alt="">
						</div>
						<!-- /---------------2----------------- -->
						<h1>Eventopia</h1>
						<!-- /---------------3----------------- -->
						<h2>Zakaria Al-nabulsi</h2>
				</div>
				<!-- /---------------4----------------- -->
				<div class="second-section">
					<div class="client-info">
						<h6>Client Information</h6>
						<p class="name">
							<span>Client Name: </span>
							<span>
								{{ $contract->user->first_name . ' ' . $contract->user->last_name }}
							</span>
							<span></span>
						</p>
						<p class="role">
							<span>Role: </span>
							<span>
								{{ $contract->user->getRoleNames()[0] }}
							</span>
							<span></span>
						</p>
                        @if ($contract->user->getRoleNames()[0] == 'HallOwner')
                        <p class="lounge">
							<span>Lounge Name: </span>
							<span>
								Al-Bahia Lounge
							</span>
							<span></span>
						</p>
                        @endif
						<p class="phone">
							<span>phone Number: </span>
							<span>
								{{ $contract->user->phone_number }}
							</span>
							<span></span>
						</p>
						<p class="addres">
							<span>Lounge Addres: </span>
							<span>
								{{ $contract->user->address }}
							</span>
							<span></span>
						</p>
					</div>
					<!-- /---------------5----------------- -->
					<div class="contract-info">
						<h6>Contract Information</h6>
						<div class="date">
							<div class="start-date">
								<p>Start Date:</p>
								<span>{{ $contract->start_date }}</span>
							</div>
							<div class="end-date">
								<p>End Date:</p>
								<span>{{ $contract->end_date }}</span>
							</div>
						</div>
						<p class="aggred-value">
							<span>Aggred-value: </span>
							<span>
								{{ $contract->price }}
							</span>
						</p>
						<p class="aggred-value">
							<span>Client Signature: </span>
							<span>
								
							</span>
						</p>
					</div>
				</div>
				</div>
				<footer>
					<p class="admin-email">zakariana2003@gmail.com</p>
					<p class="admin-phone">phone number: +963969830277</p>
					<p class="admin-account">www.LinkedIn.com</p>
				</footer>
			</div>
		</div>

	<script>
		// Fetch and insert the header dynamically
		fetch('header.html')
			.then(response => response.text())
			.then(html => {
				document.getElementById('header-placeholder').innerHTML = html;
			})
			.catch(error => console.error('Error fetching header:', error));
		</script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>