@include('dashboard.templates.header')
@isset($tickets)
<div class="row">
    <div class="col-md-8 col-lg-8 mx-auto text-center">
        <p class="text-primary text-center">
            <button class="btn btn-primary btn-sm" data-toggle="modal"
            data-target="#create_support" style="margin-bottom:5px;">
                New Support
            </button>
            <a class="btn btn-info btn-sm" href="{{url('account/support/all')}}" style="margin-bottom:5px;">
                View All Support Ticket
            </a>
        </p>
    </div>
    @if ($tickets->count()<1)
        <div class="col-md-8 col-lg-8 mx-auto text-center">
            <div class="card ">
                <div class="card-body">
                    <h4 class="font-weight-bolder text-primary font-40">
                        Welcome to {{config('app.name')}} {{$pageName}}
                    </h4>
                    <p class="text-orange">
                        Alas! There are no support tickets created by you here. Click the button below
                        to create a support ticket and our always active team will respond to it as fast
                        as possible. Our average response time to all tickets is 10 minutes. If you need
                        a faster response, please contact your account manager or use the livechat option.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 col-lg-12">
            <div class="row">
                @foreach ($tickets as $ticket)
                    <!-- col -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="chat-widget-header d-flex p-5">
                                    <div class="font-weight-bold d-flex">
                                        <img class="avatat avatar-md brround mr-2" src="https://ui-avatars.com/api/?name={{$ticket->topic}}&rounded=true&background=random" alt="img">
                                        <div class="mt-1  d-sm-block">
                                            <h6 class="mb-0 font-weight-bold">{{$ticket->topic}}</h6>
                                            <p class=" mb-1 text-muted fs-12">Ref: <b>{{$ticket->reference}}</b></p><br><br>
                                            <p>
                                                @switch($ticket->status)
                                                    @case(2)
                                                        <span class="badge badge-primary">Awaiting Support Reply</span>
                                                        @break
                                                    @case(3)
                                                        <span class="badge badge-success">Closed</span>
                                                        @break
                                                    @case(4)
                                                        <span class="badge badge-warning">Awaiting Customer Reply</span>
                                                    @break
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="d-flex">
                                            <a class="btn btn-primary" href="{{url('account/support/'.$ticket->reference.'/details')}}"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /col -->
                @endforeach
            </div><br>
            <div class="pull-left">
                {{$tickets->links()}}
            </div>
        </div>
    @endif
</div>
@endisset
@isset($tickets_all)
<div class="row">
    <div class="col-md-8 col-lg-8 mx-auto text-center">
        <p class="text-primary text-center">
            <button class="btn btn-primary btn-sm" data-toggle="modal"
            data-target="#create_support" style="margin-bottom:5px;">
                New Support
            </button>
            <a class="btn btn-info btn-sm" href="{{url('account/support')}}" style="margin-bottom:5px;">
                View Active Support Ticket
            </a>
        </p>
    </div>
    @if ($tickets_all->count()<1)
        <div class="col-md-8 col-lg-8 mx-auto text-center">
            <div class="card ">
                <div class="card-body">
                    <h4 class="font-weight-bolder text-primary font-40">
                        Welcome to {{config('app.name')}} {{$pageName}}
                    </h4>
                    <p class="text-orange">
                        Alas! There are no support tickets created by you here. Click the button below
                        to create a support ticket and our always active team will respond to it as fast
                        as possible. Our average response time to all tickets is 10 minutes. If you need
                        a faster response, please contact your account manager or use the livechat option.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 col-lg-12">
            <div class="row">
                @foreach ($tickets_all as $ticket)
                    <!-- col -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="chat-widget-header d-flex p-5">
                                    <div class="font-weight-bold d-flex">
                                        <img class="avatat avatar-md brround mr-2" src="https://ui-avatars.com/api/?name={{$ticket->topic}}&rounded=true&background=random" alt="img">
                                        <div class="mt-1  d-sm-block">
                                            <h6 class="mb-0 font-weight-bold">{{$ticket->topic}}</h6>
                                            <p class=" mb-1 text-muted fs-12">Ref: <b>{{$ticket->reference}}</b></p><br><br>
                                            <p>
                                                @switch($ticket->status)
                                                    @case(2)
                                                        <span class="badge badge-primary">Awaiting Support Reply</span>
                                                        @break
                                                    @case(3)
                                                        <span class="badge badge-success">Closed</span>
                                                        @break
                                                    @case(4)
                                                        <span class="badge badge-warning">Awaiting Customer Reply</span>
                                                    @break
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="d-flex">
                                            <a class="btn btn-primary" href="{{url('account/support/'.$ticket->reference.'/details')}}"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /col -->
                @endforeach
            </div><br>
            <div class="pull-left">
                {{$tickets_all->links()}}
            </div>
        </div>
    @endif
</div>
@endisset
</div>
</div><!-- end app-content-->
</div>
@include('dashboard.templates.support_modal')
@include('dashboard.templates.footer')
