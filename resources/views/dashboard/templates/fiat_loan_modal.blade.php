
 @if($user->id == $loan->user)
 <!-- Topup Fiat Loan Offer-->
 <div class="modal" id="payBackFiatLoan">
     <div class="modal-dialog modal-dialog-centered modal-md text-center " role="document">
         <div class="modal-content tx-size-sm">
             <div class="modal-header">
                 <h1 class="modal-title">Payback Loan</h1>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body text-left p-4" >
                 <form method="POST" id="create_offer_form" action="{{url('account/loans/repay_fiat_loan')}}">
                     @csrf
                     <p class="text-primary text-center">
                        You are about to repay this loan. By clicking the button below,you are authorizing
                        {{$siteName}} to debit your {{$loan->fiat}} account balance of the
                        sum {{$loan->fiat}}{{number_format($loan->fiatAmount+$loan->currentBill,2)}} to repay
                        the loan.<span class="text-info">Click the button below to proceed</span>
                     </p>
                     <div class="row">
                         <div class="form-group col-md-12" style="display: none;">
                             <label for="exampleInputEmail1" class="form-label">
                                Reference
                             </label>
                             <input type="text" class="form-control form-control-lg"
                             name="id" value="{{$loan->reference}}">
                         </div>
                         <div class="form-group col-md-12 mx-auto">
                             <label for="exampleInputEmail1" class="form-label">
                                Account Pin
                             </label>
                             <input type="password" class="form-control form-control-lg"
                             name="pin" maxlength="6" minlength="6">
                         </div>
                     </div>
                     <div class="text-center">
                         @if ($user->setPin == 1)
                             <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="submit_create_crypto_offer">
                             <i class="fa fa-check-circle"></i> Pay</button>
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

@endif
