<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>Piofx Media</title>
		<meta name="description" content="Page with empty content" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		@include('components.themes.metronic7.blocks.styles')
		<link rel="shortcut icon" href="{{ asset('favicon_piofx.ico') }}" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading bg-light">
		<!--begin::Main-->
		
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					

					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
                                @if($alert ?? "")
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    {{ $alert }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="card p-5 card-custom rounded-lg mt-5">
                                    <form action="{{ route($app->module.'.public') }}">
                                        <h2 class="text-center">Check Reward</h2>
                                        <h5 class="text-muted">Phone Number:</h5>
                                        <input type="text" name="phone" class="form-control mb-3" value="{{ $phone ?? "" }}">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </form>
                                </div>

                                @if($objs ?? "")
                                    @if($remaining_credits ?? '')
                                        <div class="card card-custom gutter-b mt-5">
                                            <div class="card-header">
                                                <h3 class="d-flex align-items-center">
                                                    <span class="mr-2">
                                                        <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    Balance
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <h1>$ {{ $remaining_credits }}</h1>
                                            </div>
                                        </div>

                                        @auth
                                            <form action="{{ route($app->module.'.store') }}" class="mt-5" method="POST">
                                                @csrf
                            
                                                <div class="d-flex align-items-center">
                                                    <!-- <label>Credit:</label> -->
                                                    <input type="text" class="form-control" name="credit" placeholder="Credit">

                                                    <!-- <label>Redeem:</label> -->
                                                    <input type="text" class="form-control ml-3" name="redeem" placeholder="Redeem">
                                                </div>

                                                <input type="text" hidden name="phone" value="{{ $phone }}">
                                                <button type="submit" class="btn btn-dark mt-3">Add</button>

                                            </form>
                                        @endauth
                                    @else
                                        @auth
                                            <div class="p-5 mt-5 bg-white rounded shadow">
                                                <h1 class="text-center">Create Customer</h1>
                                                <form action="{{ route('Customer.store') }}" method="POST">
                                                    @csrf
                                                    <label >Name:</label>
                                                    <input type="text" class="form-control mt-1" name="name">
                                                    <label class="mt-3">Phone:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">+91</span>
                                                        <input type="text" class="form-control" name="phone">
                                                    </div>
                                                    <label class="mt-3">Email:</label>
                                                    <input type="email" class="form-control mt-1" name="email">
                                                    <label class="mt-3">Address:</label>
                                                    <textarea type="text" class="form-control mt-1" name="address"></textarea>
                                                    <label class="mt-3">Credits:</label>
                                                    <input type="text" class="form-control mt-1" name="credits">
                                                    <button type="submit" class="btn btn-dark mt-3">Create</button>
                                                </form>
                                            </div>
                                        @endauth
                                    @endif
                                @endif
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
					
					@include('components.themes.metronic7.blocks.footer')
					
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
		
		@include('components.themes.metronic7.blocks.scrolltop')
		@include('components.themes.metronic7.blocks.scripts')
	</body>
	<!--end::Body-->
</html>

    


