<!-- Topup Fiat Loan Offer-->
 <div class="modal" id="create_support">
     <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
         <div class="modal-content tx-size-sm">
             <div class="modal-header">
                 <h1 class="modal-title">New Support</h1>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body text-left p-4" >
                 <form method="POST" id="create_offer_form" action="{{url('account/support/create')}}">
                     @csrf
                     <p class="text-primary text-center">

                     </p>
                     <div class="row">
                         <div class="form-group col-md-12">
                             <label for="exampleInputEmail1" class="form-label">
                                Title
                             </label>
                             <input type="text" class="form-control form-control-lg"
                             name="title">
                         </div>
                         <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">
                               Details
                            </label>
                            <textarea type="text" class="form-control form-control-lg"
                            name="detail" cols="5"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">
                               Department
                            </label>
                            <select class="form-control form-control-lg select2-show-search"
                            name="department">
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                     </div>
                     <div class="text-center">
                         @if ($user->setPin == 1)
                             <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="submit_create_crypto_offer">
                             <i class="fa fa-check-circle"></i> Create</button>
                         @else
                             <br>
                             <p class="text-danger">
                                 You need to set your account pin first before you can initiate this
                                 transaction.
                             </p>
                         @endif
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
