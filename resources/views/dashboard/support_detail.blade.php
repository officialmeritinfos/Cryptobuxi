@include('dashboard.templates.header')
@if ($ticket->status != 3)
    <p class="text-primary text-center">
        <a class="btn btn-success btn-lg btn-pill btn-block" href="{{url('account/support/close/'.$ticket->reference)}}">
            Close Ticket
        </a>
    </p>
@else

@endif
<div class="row row-sm">
    <div class="col-lg-9 mx-auto">
        <div class="card overflow-hidden">
            <div class="card-body pb-0">
                <div class="d-flex">
                    <div class="media mt-0">
                        <div class="media-user mr-2">
                            <div class="">
                                @if($user->isUploaded==1)
                                    <img alt="User Avatar" class="rounded-circle avatar avatar-md"
                                    src="{{asset('user/photos/'.$user->photo)}}"
                                    style="width:40px;height:40px;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=random"
                                     alt="img"
                                    class="rounded-circle avatar avatar-md">
                                @endif
                            </div>
                        </div>
                        <div class="media-body">
                            <h6 class="mb-0 mt-1 font-weight-bold">{{$user->name}}</h6>
                            <small class="text-primary">
                                {{\Carbon\Carbon::createFromTimeStamp(strtotime($ticket->created_at))->diffForHumans()}}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="mb-0">
                        {{$ticket->intro}}
                    </p>
                </div>
                <div class="media mg-t-15 profile-footer">

                </div>
            </div>
            @foreach ($responses as $response)
                @if ($response->responseType ==1)
                    <div class="card-body pb-0 bg-primary text-white">
                        <div class="d-flex">
                            <div class="media mt-0">
                                <div class="media-user mr-2">
                                    <div class="">
                                         <img src="https://ui-avatars.com/api/?name={{$response->agent}}&rounded=true&background=random"
                                        alt="img" class="rounded-circle avatar avatar-md">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h6 class="mb-0 mt-1 font-weight-bold">{{$response->agent}}</h6>
                                    <small class="text-primary">
                                        {{\Carbon\Carbon::createFromTimeStamp(strtotime($response->created_at))->diffForHumans()}}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="mb-0">
                                {{$response->message}}
                            </p>
                        </div>
                        <div class="media mg-t-15 profile-footer">

                        </div>
                    </div>
                @else
                    <div class="card-body pb-0">
                        <div class="d-flex">
                            <div class="media mt-0">
                                <div class="media-user mr-2">
                                    <div class="">
                                        @if($user->isUploaded==1)
                                            <img alt="User Avatar" class="rounded-circle avatar avatar-md"
                                            src="{{asset('user/photos/'.$user->photo)}}"
                                            style="width:40px;height:40px;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=random"
                                            alt="img"
                                            class="rounded-circle avatar avatar-md">
                                        @endif
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h6 class="mb-0 mt-1 font-weight-bold">{{$user->name}}</h6>
                                    <small class="text-primary">
                                        {{\Carbon\Carbon::createFromTimeStamp(strtotime($response->created_at))->diffForHumans()}}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="mb-0">
                                {{$response->message}}
                            </p>
                        </div>
                        <div class="media mg-t-15 profile-footer">

                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="card">
            <div class="card-body d-flex border-top">
                <div class="mr-4">
                    @if($user->isUploaded==1)
                        <img alt="User Avatar" class="rounded-circle avatar avatar-md" src="{{asset('user/photos/'.$user->photo)}}" style="width:40px;height:40px;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=random" alt="img"
                        class="rounded-circle avatar avatar-md">
                    @endif
                </div>
                <form class="profile-edit w-100" id="create_offer_form" action="{{url('account/support/reply')}}" method="POST">
                    @csrf
                    <input class="form-control" name="id" value="{{$ticket->reference}}" style="display: none;"/>
                    <textarea class="form-control"placeholder="What do you have to say?" rows="7" name="message"></textarea>
                    <div class="profile-share border border-light2 border-top-0 text-center">
                        <button type="submit" class="btn btn-sm btn-primary" id="submit_create_crypto_offer">
                            <i class="fa fa-send ml-1"></i> Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
</div>
</div><!-- end app-content-->
</div>
@include('dashboard.templates.footer')
