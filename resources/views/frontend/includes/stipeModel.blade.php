<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Recharge Now</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <input type="hidden" id="create_token_url" value="{{route('frontend.cards.createStripeToken')}}">
        <input type="hidden" id="pk_key" value="{{env('STRIPE_KEY')}}">
        <p><b class="actual_payment_amount">$100.00</b> will be deducted on wallet recharge of <b class="payment_amount">100.00</b></p>
        <hr>
        @if(count(auth()->user()->userPaymentMethods)>0)
        <div class="row">
          @foreach (auth()->user()->userPaymentMethods as $item)
            <div class="col-12">
              <div class="row">
                <div class="col-3">
                  {{$item->card_type}}
                </div>
                <div class="col-3">
                  End with {{$item->last_4_digits}}
                </div>
                <div class="col-3">
                  {{$item->expiry_date}}
                </div>
                <div class="col-3">
                  <form method="POST" name="form_{{$item->id}}" action="{{route('frontend.cards.deductPaymentFromSavedCard')}}">
                    @csrf
                  <input type="hidden" class="payment_amount" name="amount" value="">
                  <button type="submit" name="payment_id"  value="{{$item->id}}">Pay Now</button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
            </div>
            <hr>
        @endif


        <form id="payment-form">
          <div id="link-authentication-element">
              <!--Stripe.js injects the Link Authentication Element-->
          </div>
          <div id="payment-element">
              <!--Stripe.js injects the Payment Element-->
          </div>
          <button id="submit">
              <div class="spinner hidden" id="spinner"></div>
              <span id="button-text">Pay now</span>
          </button>
          <div id="payment-message" class="hidden"></div>
          </form>

      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
</div>
<style>
  #submit {
    background: #e58a40;
    font-family: Arial, sans-serif;
    color: #ffffff;
    border-radius: 4px;
    border: 0;
    padding: 12px 16px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: block;
    transition: all 0.2s ease;
    box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
    width: 100%;
    margin-top: 16px;
}
/* spinner/processing state, errors */
.spinner,
.spinner:before,
.spinner:after {
  border-radius: 50%;
}
.spinner {
  color: #ffffff;
  font-size: 22px;
  text-indent: -99999px;
  margin: 0px auto;
  position: relative;
  width: 20px;
  height: 20px;
  box-shadow: inset 0 0 0 2px;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.spinner:before,
.spinner:after {
  position: absolute;
  content: "";
}
.spinner:before {
  width: 10.4px;
  height: 20.4px;
  background: #5469d4;
  border-radius: 20.4px 0 0 20.4px;
  top: -0.2px;
  left: -0.2px;
  -webkit-transform-origin: 10.4px 10.2px;
  transform-origin: 10.4px 10.2px;
  -webkit-animation: loading 2s infinite ease 1.5s;
  animation: loading 2s infinite ease 1.5s;
}
.spinner:after {
  width: 10.4px;
  height: 10.2px;
  background: #5469d4;
  border-radius: 0 10.2px 10.2px 0;
  top: -0.1px;
  left: 10.2px;
  -webkit-transform-origin: 0px 10.2px;
  transform-origin: 0px 10.2px;
  -webkit-animation: loading 2s infinite ease;
  animation: loading 2s infinite ease;
}

@-webkit-keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

</style>