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

                                <div id="user_balance_data" data-value="{{ $rewards ?? ''}}"></div>

                                @if($objs ?? "")
                                    @if($remaining_credits ?? '')
                                        <div class="card card-custom gutter-b mt-5">
                                            <div class="d-flex justify-content-between align-items-user p-3 border-bottom">
                                                <h3 class="d-flex align-items-center">
                                                    <span class="mr-2">
                                                        <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                                                    </span>
                                                    Balance
                                                </h3>
                                                @auth
                                                    <a href="{{ route('Customer.show', $objs[0]->customer_id ) }}" class="btn btn-outline-dark">
                                                        <i class="fas fa-user-circle"></i> User
                                                    </a>
                                                @endauth
                                            </div>
                                            <div class="card-body">
                                                <h1 class="d-flex align-items-center"><i class="fas fa-wallet text-muted mr-2" style="font-size: 2rem;"></i> {{ $remaining_credits }}</h1>
                                            </div>
                                        </div>

                                         <!--begin::Tiles Widget 17-->
												<div class="card card-custom gutter-b" style="height: 300px;">
													<!--begin::Body-->
													<div class="card-body d-flex flex-column p-0">
														<!--begin::Stats-->
														<div class="flex-grow-1 text-right card-spacer pb-0">
															<div class="font-weight-bolder font-size-h2">{{ $remaining_credits }}</div>
															<div class="text-muted font-weight-bold">Remaining Credits</div>
														</div>
														<!--end::Stats-->
														<!--begin::Chart-->
														<div id="user_balance_chart" class="card-rounded-bottom" style="height: 150px"></div>
														<!--end::Chart-->
													</div>
													<!--end::Body-->
												</div>
												<!--end::Tiles Widget 17-->

                                        @auth
                                            <div class="card card-custom p-3">
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
                                            </div>
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

        <script>
            $(document).ready(function () {
                let user_balance_data = document
                        .getElementById("user_balance_data")
                        .getAttribute("data-value");

                user_balance_data = JSON.parse(user_balance_data);

                var element = document.getElementById("user_balance_chart");
                var height = parseInt(KTUtil.css(element, 'height'));
                var color = KTUtil.hasAttr(element, 'data-color') ? KTUtil.attr(element, 'data-color') : 'info';

                if (!element) {
                    return;
                }

                console.log(user_balance_data);

                var options = {
                    series: [{
                        name: 'Net Profit',
                        data: Object.values(user_balance_data)
                    }],
                    chart: {
                        type: 'area',
                        height: height,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [KTApp.getSettings()['colors']['theme']['base'][color]]
                    },
                    xaxis: {
                        categories: Object.keys(user_balance_data),
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        },
                        crosshairs: {
                            show: false,
                            position: 'front',
                            stroke: {
                                color: KTApp.getSettings()['colors']['gray']['gray-300'],
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 32,
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                                return "$" + val + " thousands"
                            }
                        }
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['light'][color]],
                    markers: {
                        colors: [KTApp.getSettings()['colors']['theme']['light'][color]],
                        strokeColor: [KTApp.getSettings()['colors']['theme']['base'][color]],
                        strokeWidth: 3
                    }
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            });
        </script>
	</body>
	<!--end::Body-->
</html>

    


