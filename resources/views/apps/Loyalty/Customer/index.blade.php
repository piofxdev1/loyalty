<x-dynamic-component :component="$app->componentName">
    <div class="container-fluid my-5">

        <!-- Actions -->
        <div class="d-flex justify-content-between align-ites-center bg-white px-3 rounded shadow-sm mb-3">
            <div>
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href=""  class="text-muted text-decoration-none">{{ ucfirst($app->app) }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href=""  class="text-muted text-decoration-none">{{ ucfirst($app->module) }}</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <form action="{{ route($app->module.'.create') }}" class="d-flex align-items-center">
                <button type="submit" class="btn btn-light-primary font-weight-bold ml-2 d-flex align-items-center"><i class="fas fa-plus fa-sm"></i> Add Record</button>
            </form>
        </div>
        <!-- End Actions -->

        <div class="bg-white p-3 rounded-lg shadow">
            <!-- Table -->
            <table class="table table-borderless bg-white">
                <tr class="border-bottom">
                    <th scope="col" class="p-3">#</th>
                    <th scope="col" class="p-3 text-decoration-none">Name</th>
                    <th scope="col" class="p-3">Phone</th>
                    <th scope="col" class="p-3">Email</th>
                    <th scope="col" class="p-3">Address</th>
                    <th scope="col" class="p-3">Info</th>
                    <th scope="col" class="p-3">Balance</th>
                    <th scope="col" class="p-3">Created</th>
                    <th scope="col" class="p-3 text-secondary font-weight-bolder text-center">Actions</th>
                </tr>
                @foreach($objs as $key=>$obj)
                    @php
                        $remaining_credits = 0;

                        foreach($obj->rewards as $reward){
                            $remaining_credits = $remaining_credits + ($reward->credits - $reward->redeem);
                        }
                    @endphp
                    <tr class="border-bottom">
                        <th scope="row" class="px-3 align-middle">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                        <td class="px-3 align-middle font-weight-bolder">{{ $obj->name }}</td>
                        <td class="px-3 align-middle">{{ $obj->phone }}</td>
                        <td class="px-3 align-middle">{{ $obj->email }}</td>
                        <td class="px-3 align-middle">{{ $obj->address }}</td>
                        <td class="px-3 align-middle">{{ $obj->info }}</td>
                        <td class="px-3 align-middle">{{ $remaining_credits }}</td>
                        <td class="px-3 align-middle text-primary font-weight-bolder">{{ $obj->created_at ? $obj->created_at->diffForHumans() : '' }}</td>
                        <td class="px-3 d-flex align-items-center justify-content-center align-middle">
                            <!-- View Button-->
                            <a href="{{ route($app->module.'.show', $obj->id) }}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2"><i class="fas fa-eye m-0"></i></a>
                            <!-- End View Button -->

                            <!-- Edit Button -->
                            <form action="{{ route($app->module.'.edit', $obj->id) }}">
                                <button class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" type="submit"><i class="fas fa-edit m-0"></i></button> 
                            </form>
                            <!-- End Edit Button -->

                            <!-- Confirm Delete Modal Trigger -->
                            <a href="#" data-toggle="modal" class="btn btn-sm btn-default btn-text-primary btn-hover-danger btn-icon mr-2" data-target="#staticBackdrop-{{$obj->id}}"><i class="fas fa-trash-alt m-0"></i></a>
                            <!-- End Confirm Delete Modal Trigger -->
                            
                            <!-- Confirm Delete Modal -->
                            <div class="modal fade" id="staticBackdrop-{{$obj->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Confirm Delete</h5>
                                        <button type="button" class="btn btn-xs btn-icon btn-soft-secondary" data-dismiss="modal" aria-label="Close">
                                        <svg aria-hidden="true" width="10" height="10" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                                        </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Do you want to delete this permanently?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                        <form action="{{ route($app->module.'.destroy', $obj->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger">Confirm Delete</button>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Confirm Delete Modal -->
                        </td>
                    </tr>
                @endforeach
            </table>
            <!-- End Table -->
            <!-- Pagination -->
            {{$objs->links()}}
            <!-- End Pagination -->
        </div>

    </div>
</x-dynamic-component>