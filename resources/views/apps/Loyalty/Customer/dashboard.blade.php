<x-dynamic-component :component="$app->componentName">

<div style="width: 50%">

    {!! $CustomerChart->container() !!}

</div>


	<div class="container-mt-20">
		<div class="row">
		<!--begin::Card-->
			<div class="col-lg-3">
				<div class="card card-custom gutter-b">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">New Customers</h3>
						</div>
					</div>
						<div class="card-body">
						<h3 class="card-label">23</h3>
						</div>

						<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">Total Customers</h3>
						</div>
					</div>
						<div class="card-body">
						<h3 class="card-label">103</h3>
						</div>
				</div>
			</div>
																					
				<!--begin::Card-->
			<div class="col-lg-9">
				<div class="card card-custom gutter-b">
					
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">Area Chart</h3>
						</div>
					</div>
					<div class="card-body">
						<!--begin::Chart-->
						<div id="chart_2"></div>
						<!--end::Chart-->
					</div>
				</div>
				<!--end::Card-->
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<!--begin::Card-->
				<div class="card card-custom gutter-b">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">Column Chart</h3>
						</div>
					</div>
					<div class="card-body">
						<!--begin::Chart-->
						<div id="chart_3"></div>
						<!--end::Chart-->
					</div>
				</div>
				<!--end::Card-->
			</div>
			<div class="col-lg-6">
				<!--begin::Card-->
				<div class="card card-custom gutter-b">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">Mixed Chart</h3>
						</div>
					</div>
					<div class="card-body">
						<!--begin::Chart-->
						<div id="chart_5"></div>
						<!--end::Chart-->
					</div>
				</div>
				<!--end::Card-->
			</div>
		
		</div>
	</div>
	<!--end::Container-->
		
</x-dynamic-component>