@include('dashboard.templates.header')

<!-- Row -->
<div class="row">
    @inject('options','App\Custom\Regular')
    <div class="col-xl-6 col-lg-6 col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Sales Details</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Asset </span>
                            </td>
                            <td class="py-2 px-0">
                                <img src="{{asset('cryptocoins/'.strtolower($options->getWalletCoinIcon($trade->asset)).'.svg')}}"
                                     class="w-5 h-5 mr-2" style="width:100px;" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Amount Sold </span>
                            </td>
                            <td class="py-2 px-0">{{number_format($trade->amount,5)}}{{$trade->asset}}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Fiat </span>
                            </td>
                            <td class="py-2 px-0">{{$trade->currency}}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Rate </span>
                            </td>
                            <td class="py-2 px-0">
                                <b class="text-success">
                                    {{$trade->currency}} {{number_format($options->getTradeOfferrate($trade->id),2)}}/$
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Amount Paid </span>
                            </td>
                            <td class="py-2 px-0">{{$currency->signs}}{{number_format($trade->fiatAmount,2)}}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Amount Credited </span>
                            </td>
                            <td class="py-2 px-0">{{$currency->signs}}{{number_format($trade->amountCredited,2)}}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Charge </span>
                            </td>
                            <td class="py-2 px-0">{{$currency->signs}}{{number_format($trade->charge,2)}}</td>
                        </tr>
                        @if($trade->hasLoan ==1)
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Amount Paid To Lender </span>
                                </td>
                                <td class="py-2 px-0">{{$currency->signs}}{{number_format($trade->loanSettled,2)}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Reference </span>
                            </td>
                            <td class="py-2 px-0"><span class="text-info">{{$trade->reference}}</span></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Payment Reference </span>
                            </td>
                            <td class="py-2 px-0"><span class="text-primary">{{$trade->paymentReference}}</span></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Status </span>
                            </td>
                            <td class="py-2 px-0">
                                @switch($trade->status)
                                    @case(1)
                                    <span class="fa fa-check-circle text-success" data-toggle="tooltip" title="completed"></span>
                                    @break
                                    @default
                                    <span class="fa fa-times-circle text-danger" data-toggle="tooltip" title="failed/cancelled"></span>
                                @endswitch
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">More Details</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                        <tr>
                            <td class="py-2 px-0">
                                <span class="font-weight-semibold w-50">Wallet </span>
                            </td>
                            <td class="py-2 px-0"><span class="text-info">{{$withdrawal->addressTo}}</span></td>
                        </tr>
                        @if($withdrawal->status ==1)
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Transaction Id </span>
                                </td>
                                <td class="py-2 px-0">
                                    <a href="{{$coin->transactionExplorer.$withdrawal->transHash}}"
                                       class="text-primary" target="_blank">
                                        {{$withdrawal->transHash}}
                                    </a>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.templates.footer')
