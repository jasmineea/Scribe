<div class="text-end">
    <a href="#" class="btn btn-warning btn-sm mt-1 recharge_wallet" data-id="{{$data->id}}"  data-wallet="{{$data->wallet_balance}}" data-toggle="tooltip" title="wallet recharge"><i class="fas fa-wallet"></i></a>
    <a href="{{route('backend.orders.index',['id'=>$data])}}" class="btn btn-success btn-sm mt-1" data-toggle="tooltip" title="view campaigns"><i class="fas fa-shopping-cart"></i></a>
    <!-- <a href="{{route('backend.transactions.index',['id'=>$data])}}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip" title="view transactions"><i class="fas fa-exchange"></i></a>
    <a href="{{route('backend.listings.index',['id'=>$data])}}" class="btn btn-info btn-sm mt-1" data-toggle="tooltip" title="view campaign lists"><i class="fas fa-list"></i></a> -->
    <a href="{{route('backend.customers.details',['id'=>$data])}}" class="btn btn-danger btn-sm mt-1" data-toggle="tooltip" title="view customer detail"><i class="fas fa-desktop"></i></a>
</div>