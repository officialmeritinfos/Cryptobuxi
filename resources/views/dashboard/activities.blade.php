@include('dashboard.templates.header')
<!-- Row -->
                <div class="row">
                    <div class="col-12">
                        <!--div-->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">{{$pageName}}</div>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <div class="table-responsive">
                                        @isset($logins)
                                            <div class="text-center">
                                                <a href="{{url('account/activities')}}" class="btn btn-outline-primary text-center" style="margin-bottom: 5px;">
                                                    View Account Activities</a>
                                            </div>
                                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Location</th>
                                                    <th class="border-bottom-0">Device</th>
                                                    <th class="border-bottom-0">Ip</th>
                                                    <th class="border-bottom-0">ISP</th>
                                                    <th class="border-bottom-0">Time Accessed</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($logins as $login)
                                                    <tr>
                                                        <td>{{$login->location}}</td>
                                                        <td>{{$login->agent}}</td>
                                                        <td>{{$login->loginIp}}</td>
                                                        <td>{{$login->isp}}</td>
                                                        <td>{{$login->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="text-center">
                                                <a href="{{url('account/logins')}}" class="btn btn-outline-secondary text-center" style="margin-bottom: 5px;">
                                                    View Account Logins</a>
                                            </div>
                                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Activity</th>
                                                    <th class="border-bottom-0">Details</th>
                                                    <th class="border-bottom-0">Ip</th>
                                                    <th class="border-bottom-0">Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($activities as $activity)
                                                        <tr>
                                                            <td>{{$activity->activity}}</td>
                                                            <td>{!! $activity->details  !!}</td>
                                                            <td>{{$activity->agent_ip}}</td>
                                                            <td>{{$activity->created_at}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/div-->

                    </div>
                </div>
                <!-- /Row -->
            </div>
        </div><!-- end app-content-->
    </div>

@include('dashboard.templates.footer')
