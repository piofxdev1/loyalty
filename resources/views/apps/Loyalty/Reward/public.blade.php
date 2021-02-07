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
					<div class="content d-flex flex-column flex-column-fluid pt-0 pt-lg-5" id="kt_content">
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
                                @if($alert ?? "")
                                    @guest
                                        <div class="container-lg mt-3">
                                            <!--begin::Engage Widget 7-->
                                            <div class="card card-custom card-stretch gutter-b">
                                                <div class="card-body d-flex p-0">
                                                    <div class="flex-grow-1 p-12 card-rounded bgi-no-repeat d-flex flex-column justify-content-center align-items-start shadow" style="background-color: #FFF4DE; background-position: right bottom; background-size: auto 100%; background-image: url({{ asset('themes/metronic/media/svg/humans/custom-8.svg') }})">
                                                        <h3 class="text-danger font-weight-bolder m-0">No records found</h3>
                                                        <h5 class="text-dark-50 font-size-xl font-weight-bold">Please contact the Sales Executive</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Engage Widget 7-->
                                        </div>
                                    @endguest
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
                                        <h2 class="text-center text-dark font-weight-bolder">Check Reward</h2>
                                        <h5 class="text-muted">Phone Number:</h5>
                                        <input type="text" name="phone" class="form-control mb-3" value="{{ $phone ?? "" }}" required>
                                        <button type="submit" class="btn btn-light-primary">Search</button>
                                    </form>
                                </div>

                                <div id="user_balance_data" data-value="{{ $rewards ?? ''}}"></div>

                                @if($objs ?? "")
                                    @if($remaining_credits ?? '')
                                        <!--begin::Mixed Widget 20-->
                                        <div class="card card-custom bgi-no-repeat gutter-b mt-5" style="background-color: #4AB58E; background-position: 100% bottom; background-size: auto auto; background-image: url({{ asset('themes/metronic/media/svg/humans/custom-1.svg') }})">
                                            <div class="d-flex align-items-center pl-9 pt-3">
                                                <i class="flaticon-piggy-bank icon-2x text-dark mr-2 font-weight-bolder"></i>
                                                <h3 class="m-0">Balance</h3>
                                            </div>
                                            <!--begin::Body-->
                                            <div class="card-body d-flex align-items-center">
                                                <div class="">
                                                    <div class="d-flex align-items-center">
                                                        <h1 class="text-white font-weight-bolder mr-3 d-flex align-items-center">{{ $remaining_credits }} Points</h1>
                                                        @auth
                                                            <a href="{{ route('Customer.show', $objs[0]->id) }}" class="btn btn-icon btn-light-success pulse pulse-success">
                                                                <i class="fas fa-stream ml-3"></i>
                                                                <span class="pulse-ring"></span>
                                                            </a>
                                                        @endauth
                                                    </div>
                                                   
                                                    <h3 class="text-success font-weight-bolder">Remaining Balance</h3>
                                                </div>
                                            </div>
                                            <!--end::Body-->



                                        </div>
                                        <!--end::Mixed Widget 20-->

                                        @auth
                                            <!--begin::Tiles Widget 25-->
                                            <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b bg-dark" style="height: 250px; background-image: url({{ asset('themes/metronic/media/svg/patterns/taieri.svg') }}">
                                                <div class="card-body d-flex">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <form action="{{ route($app->module.'.store') }}" class="" method="POST">
                                                                @csrf
                                            
                                                                <div class="d-block d-lg-flex align-items-center">
                                                                    <!-- <label>Credit:</label> -->
                                                                    <input type="text" class="form-control form-control-lg" name="credit" placeholder="Credit">

                                                                    <!-- <label>Redeem:</label> -->
                                                                    <input type="text" class="form-control form-control-lg mt-3 mt-lg-0 ml-lg-3" name="redeem" placeholder="Redeem">
                                                                </div>

                                                                <input type="text" hidden name="phone" value="{{ $phone }}">
                                                                <button type="submit" class="btn btn-lg btn-light-danger btn-shadow font-weight-bold mt-3 px-4">Add</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Tiles Widget 25-->
                                        @endauth
                                    @else
                                        @auth
                                            <div class="p-5 mt-5 bg-dark text-white rounded shadow">
                                                <h1 class="text-center">Create Customer</h1>
                                                <form action="{{ route('Customer.store') }}" method="POST">
                                                    @csrf
                                                    <div class="row g-3 mt-4">
                                                        <div class="col-12 col-lg-6">
                                                            <label >Name:</label>
                                                            <input type="text" class="form-control" name="name" required>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <label>Phone:</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">+91</span>
                                                                <input type="text" class="form-control" name="phone" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="mt-3">Email:</label>
                                                    <input type="email" class="form-control" name="email" required>
                                                    <label class="mt-3">Address:</label>
                                                    <textarea type="text" class="form-control" name="address" required></textarea>
                                                    <label class="mt-3">Credits:</label>
                                                    <input type="text" class="form-control" name="credits" required>
                                                    <button type="submit" class="btn btn-light-danger px-4 mt-4">Create</button>
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

                console.log(Object.keys(user_balance_data));

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

    


