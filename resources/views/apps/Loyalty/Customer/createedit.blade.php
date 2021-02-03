<x-dynamic-component :component="$app->componentName">

    @if($alert ?? "")
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ $alert }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="p-5 mt-5 bg-white rounded shadow">
        <h1 class="text-center"></h1>
        @if($stub == 'create')
            <form action="{{ route($app->module.'.store') }}" method="POST" enctype="multipart/form-data">
        @else
            <form action="{{ route($app->module.'.update', $obj->id) }}" method="POST" enctype="multipart/form-data">
        @endif
                <label >Name:</label>
                <input type="text" class="form-control mt-1" name="name" value="@if($stub == 'update'){{ $obj->name }}@endif">
                <label class="mt-3">Phone:</label>
                <input type="text" class="form-control mt-1" name="phone" value="@if($stub == 'update'){{ $obj->phone }}@endif">
                <label class="mt-3">Email:</label>
                <input type="email" class="form-control mt-1" name="email" value="@if($stub == 'update'){{ $obj->email }}@endif">
                <label class="mt-3">Address:</label>
                <textarea type="text" class="form-control mt-1" name="address">@if($stub == 'update'){{ $obj->address }}@endif</textarea>
                @if($stub == "create")
                    <label class="mt-3">Credits:</label>
                    <input type="text" class="form-control mt-1" name="credits">
                @endif
                @if($stub=='update')
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{ $obj->id }}">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-outline-dark mt-3" name="publish" value="now">Create</button>
            </form>
    </div>
</x-dynamic-component>