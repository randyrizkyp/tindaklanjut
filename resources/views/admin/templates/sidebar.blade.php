<!--APP-SIDEBAR-->
<div class="sticky">
	<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
	<div class="app-sidebar">
		<div class="side-header">
			<a class="header-brand1 text-dark" style="font-weight: bold;" href="/user"><img src="/storage/image/lampura.png" style="width: 30px;" class="header-brand-img all-logo" alt="logo"> E-Cuti</a>
		</div>		

		<div class="main-sidemenu">			
			<ul class="side-menu">
				<li class="nav-link leading-none d-flex">
					<span class="avatar avatar-lg brround cover-image" data-bs-image-src="../assets/images/users/17.jpg"></span>
					<span class="side-menu__label" style="padding-left: 5px; font-weight: bold;">{{ Str::upper(Session::get('nama')) }}<br><a style="font-size: 10px;">Admin</a></span>
				</li>	
				<li class="slide  {{ request()->is('bpk*') ? 'is-expanded' : '' }}">
					<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
							class="side-menu__icon fa fa-bank"></i><span
							class="side-menu__label">BPK-RI</span><i
							class="angle fe fe-chevron-right"></i>
					</a>
					<ul class="slide-menu">
						<li class="panel sidetab-menu">
							<div class="panel-body tabs-menu-body p-0 border-0">
								<div class="tab-content">
									<div class="tab-pane fade show" id="side1">
										<ul class="sidemenu-list">
											<li class="side-menu-label1"><a href="javascript:void(0)">BPK-RI</a></li>
											<li><a href="/bpkmatix" class="slide-item {{ request()->is('bpkmatix') || request()->is('bpkdetail*') || request()->is('bpkrekomendasi*') ? 'active' : '' }}">Matrix</a></li>
											<li><a href="/bpkpengaturan" class="slide-item {{ request()->is('bpkpengaturan') ? 'active' : '' }}">Pengaturan Temuan & Rekom</a></li>
											<li><a href="calendar.html" class="slide-item"> Default calendar</a></li>											
										</ul>
									</div>																								
								</div>
							</div>
						</li>
					</ul>
				</li>
				<li class="slide  {{ request()->is('user*') ? 'is-expanded' : '' }}">
					<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
							class="side-menu__icon fe fe-users"></i><span
							class="side-menu__label">User</span><i
							class="angle fe fe-chevron-right"></i>
					</a>
					<ul class="slide-menu">
						<li class="panel sidetab-menu">
							<div class="panel-body tabs-menu-body p-0 border-0">
								<div class="tab-content">
									<div class="tab-pane fade show" id="side1">
										<ul class="sidemenu-list">
											<li><a href="/userconfig" class="slide-item {{ request()->is('user*') ? 'active' : '' }}">Pengaturan</a></li>										
										</ul>
									</div>																								
								</div>
							</div>
						</li>
					</ul>
				</li>
									
			</ul>
			<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
					width="24" height="24" viewBox="0 0 24 24">
					<path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
				</svg></div>
		</div>
	</div>
</div>
<!--/APP-SIDEBAR-->
