<x-dynamic-component :component="$app->componentName">

    @if($alert ?? "")
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ $alert }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="bg-white p-5 shadow rounded-lg mt-5">
        <form action="{{ route($app->module.'.public') }}">
            <h2 class="text-center">Check Reward</h2>
            <h5 class="text-muted">Phone Number:</h5>
            <input type="text" name="phone" class="form-control mb-3" value="{{ $phone ?? "" }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    @if($objs ?? "")
        @if($remaining_credits ?? '')
            <div class="bg-white mt-5 text-center p-5 shadow"> 
                <h1>Balance</h1>
                <h5>Number of remaining credits: <span class="font-weight-bolder">{{ $remaining_credits }}</span></h5>
            </div>

        @else

            @auth
                <div class="p-5 mt-5 bg-white rounded shadow">
                    <h1 class="text-center">Create Customer</h1>
                    <form action="{{ route('Customer.store') }}" method="POST">
                        @csrf
                        <label >Name:</label>
                        <input type="text" class="form-control mt-1" name="name">
                        <label class="mt-3">Phone:</label>
                        <input type="text" class="form-control mt-1" name="phone">
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


</x-dynamic-component>