
            @if($user->setPin!=1)
            <!-- Show pin setting form-->
            <div class="modal" id="set_pin">
                <div class="modal-dialog modal-dialog-centered text-center " role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header">
                            <h1 class="modal-title">Protect Account from Intruders</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-left p-4" >
                            <form method="POST" id="set_trans_pin" action="{{url('account/dashboard/set_pin')}}">
                                @csrf
                                <div >
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="form-label">New Pin</label>
                                        <input type="password" class="form-control " id="pins" name="pin" maxlength="6" minlength="6">
                                        <small class="text-info">This cannot be recovered if lost; therefore, ensure to keep it in a secured place.</small>
                                    </div>
                                    <div class="form-group" >
                                        <label for="exampleInputEmail1" class="form-label">Confirm Pin</label>
                                        <input type="password" class="form-control " id="pin1s" name="confirm_pin" maxlength="6" minlength="6">
                                    </div>
                                    <div class="form-group" >
                                        <label for="exampleInputEmail1" class="form-label">Password</label>
                                        <input type="password" class="form-control form-control-lg" id="exampleInputEmail1" name="password">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="submit_pin">
                                        <i class="fa fa-check-circle"></i> Protect</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!--Footer-->
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
                        <small>Copyright © {{date('Y')}} <a href="#">{{$web->siteName}}</a>.
                            {{config('app.name')}} is a product of <a href="https://meritinfos.co" target="_blank">Meritinfos LLC</a>.
                            All rights reserved.</small>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer-->
    </div>

    <!-- Back to top -->
    <a href="#top" id="back-to-top">
        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"/></svg>
    </a>

    <!-- Jquery js-->
    <script src="{{ asset('dashboard/assets/js/vendors/jquery-3.5.1.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <!-- Bootstrap4 js-->
    <script src="{{ asset('dashboard/assets/plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!--Othercharts js-->
    <script src="{{ asset('dashboard/assets/plugins/othercharts/jquery.sparkline.min.js') }}"></script>

    <!-- Circle-progress js-->
    <script src="{{ asset('dashboard/assets/js/vendors/circle-progress.min.js') }}"></script>

    <!-- Jquery-rating js-->
    <script src="{{ asset('dashboard/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

    <!--Sidemenu js-->
    <!--<script src="{{ asset('dashboard/assets/plugins/sidemenu/sidemenu.js') }}"></script>-->
        <script src="{{ asset('dashboard/assets/plugins/sidemenu/sidemenu1.js') }}"></script>

    <!-- P-scroll js-->
    <script src="{{ asset('dashboard/assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/p-scrollbar/p-scroll1.js') }}"></script>

    <!-- Custom js-->
    <script src="{{ asset('dashboard/assets/js/custom.js') }}"></script>

    <!-- Switcher js -->
    <script src="{{ asset('dashboard/assets/switcher/js/switcher.js') }}"></script>


    <!-- INTERNAL JS INDEX2 START -->
    <!--Moment js-->
    <script src="{{ asset('dashboard/assets/plugins/moment/moment.js') }}"></script>

    <!-- Daterangepicker js-->
    <script src="{{ asset('dashboard/assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/daterange.js') }}"></script>

    <!--Chart js -->
    <script src="{{ asset('dashboard/assets/plugins/chart/chart.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/chart/chart.extension.js') }}"></script>

    <!-- ECharts js-->
    <script src="{{ asset('dashboard/assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/index2.js') }}"></script>
    <!-- popover js -->
    <script src="{{ asset('dashboard/assets/js/popover.js')}}"></script>
        <!-- Clipboard js -->
        <script src="{{ asset('dashboard/assets/plugins/clipboard/clipboard.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/clipboard/clipboard.js')}}"></script>
        @include('templates.noti_js')
    <!-- INTERNAL JS INDEX2 END -->
        <script src="{{ asset('dashboard/user/dashboard.js')}}"></script>
        <script src="{{ asset('dashboard/user/payments.js')}}"></script>
        <script src="{{ asset('dashboard/user/profile.js')}}"></script>
        <script src="{{ asset('dashboard/user/verification.js')}}"></script>
        <script src="{{ asset('dashboard/user/transfer.js')}}"></script>
        <script src="{{ asset('dashboard/user/escrow.js')}}"></script>
        <script src="{{ asset('dashboard/user/business.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/jszip.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/buttons.html5.min.j')}}s"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/js/datatables.js')}}"></script>
        <!--Select2 js -->
        <script src="{{ asset('dashboard/assets/plugins/select2/select2.full.min.js')}}"></script>
        <script src="{{ asset('dashboard/assets/js/select2.js')}}"></script>
        <script src="{{ asset('dashboard/bootstrap-pincode-input.js')}}"></script>

        <!-- File uploads js -->
        <script src="{{ asset('dashboard/assets/plugins/fileupload/js/dropify.js')}}"></script>
        <script src="{{ asset('dashboard/assets/js/filupload.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
        <script src="https://checkout.flutterwave.com/v3.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.5.3/dist/cleave.min.js"></script>
        <!--<script>
            $(document).ready(() => {
                $(document.body).on('click', '.card[data-clickable=true]', (e) => {
                    window.location = $(e.currentTarget).data('href');
                    $.LoadingOverlay("show", {
                        text        : "please wait ..",
                        textAnimation:"pulse",
                        size    : "10"
                    });
                });
            });
        </script>

        <script>
            $(function(){
                $("a").on("click",function(){
                    $.LoadingOverlay("show", {
                        text        : "please wait ..",
                        textAnimation:"pulse",
                        size    : "10"
                    });
                    setTimeout(function(){
                        $.LoadingOverlay("hide", true);
                    }, 2000);
                });
            });
        </script>-->
</body>
</html>
