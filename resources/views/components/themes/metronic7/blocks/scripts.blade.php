<!--begin::Global Config(lobal config for global J scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff" "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('themes/metronic/plugins/global/plugins.bundle.js?v=7.0.5')}}"></script>
<script src="{{ asset('themes/metronic/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.5')}}"></script>
<script src="{{ asset('themes/metronic/js/scripts.bundle.js?v=7.0.5')}}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!--end::Global Theme Bundle-->

<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('themes/metronic/js/pages/crud/datatables/basic/basic.js?v=7.0.5') }}"></script>
<script src="{{ asset('themes/metronic/plugins/custom/datatables/datatables.bundle.js?v=7.0.5') }}"></script>
<script src="{{ asset('themes/metronic/js/pages/features/charts/apexcharts.js?v=7.0.5') }}"></script>
<!--end::Page Scripts-->

<!-- Charting library -->
<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

{{-- ChartScript --}}

@if($CustomerChart)

{!! $CustomerChart->script() !!}

@endif

