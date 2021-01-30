<x-dynamic-component :component="$app->componentName">

    <div class="bg-white p-5 shadow rounded-lg mt-5">
        <form action="{{ route($app->module.'.show') }}">
            <h2 class="text-center">Check Reward</h2>
            <h5 class="text-muted">Phone Number:</h5>
            <input type="text" name="phone" class="form-control mb-3" value="{{ $obj->phone }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <div class="bg-white mt-5 text-center p-5 shadow"> 
        <h5>{{ $remaining_credits }}</h5>
    </div>

</x-dynamic-component>