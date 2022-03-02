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
                                        @isset($beneficiaries)
                                            <div class="text-center">
                                                <a href="{{url('account/activities')}}" class="btn btn-outline-primary text-center" style="margin-bottom: 5px;">
                                                    View Account Activities</a>
                                            </div>
                                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Account Name</th>
                                                    <th class="border-bottom-0">Account Number</th>
                                                    <th class="border-bottom-0">Bank</th>
                                                    <th class="border-bottom-0">Date added</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($beneficiaries as $bene)
                                                    <tr>
                                                        <td>{{$bene->accountName}}</td>
                                                        <td>{{$bene->accountNumber}}</td>
                                                        <td>{{$bene->bank}}</td>
                                                        <td>{{$bene->created_at}}</td>
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
