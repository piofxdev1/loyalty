<x-dynamic-component :component="$app->componentName">

    <div class="bg-white p-5 shadow rounded-lg mt-5">
        <form action="{{ route($app->module.'.show') }}">
            <h2 class="text-center text-primary">Check Reward</h2>
            <h5 class="text-muted">Phone Number:</h5>
            <input type="text" name="phone" class="form-control mb-3">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

</x-dynamic-component>