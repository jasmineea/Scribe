
<?php if(setting('squareup_environment')=='live'){?>
        <script src="https://web.squarecdn.com/v1/square.js"></script>
    <?php }else{?>
        <script src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<?php }?>
<style>
  /* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.9), rgba(0, 0, 0, .9));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.9), rgba(0, 0, 0,.9));
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="loading">Loading&#8230;</div>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Recharge Now</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="payment_line"><b class="actual_payment_amount">$100.00</b> will be deducted on wallet recharge of <b class="payment_amount">100.00</b><br></p>
        <hr>

        @if(count(auth()->user()->userPaymentMethods)>0)
        <div class="saved_card">
        <center style="margin-bottom: 1rem;"><b>Pay with saved card(s)</b></center>
        <div class="row">
          @foreach (auth()->user()->userPaymentMethods as $item)
            <div class="col-12">
              <div class="row" style="padding: 5px 0px;">
                <div class="col-3">
                  {{$item->card_type}}
                </div>
                <div class="col-3">
                  End with {{$item->last_4_digits}}
                </div>
                <div class="col-2">
                  {{$item->expiry_date}}
                </div>
                <div class="col-4">
                  <ul style="list-style: none;"><li style="float: left; margin-right: 10px;">
                  <form method="POST" name="form_{{$item->id}}" action="{{route('frontend.cards.deductPaymentFromSavedCard')}}">
                    @csrf
                  <input type="hidden" class="payment_amount" name="amount" value="">
                  <input type="hidden" class="order_id" name="order_id" value="">
                  <button type="submit" name="payment_id"  value="{{$item->id}}" class="theme-btn pay_submit_button" style="height: 25px;padding: 0px 9px;">Pay Now</button>
                  </form>
                </li>
                <li>
                  <i class="fa fa-trash delete_card" data-id="{{$item->id}}" style="color: #972323;"></i>
                </li>
              </ul>
                </div>
              </div>
            </div>
          @endforeach
            </div>
            <h2 class="h2_class"><span>OR</span></h2>
        </div>
        @endif
        <center style="margin-bottom: 1rem;"><b>Add New Card</b></center>
        <form id="payment-form" action="{{route('frontend.cards.paymentResponse')}}" method="POST">
          <input
            id="customer-input"
            type="hidden"
            aria-required="true"
            aria-label="Customer ID"
            required="required"
            placeholder="Customer ID"
            name="customerId"
            value="{{auth()->user()->name}}"
          />
          <div id="card-container"></div>
          {{ csrf_field() }}
          <input id="token" name="token" type="hidden">
          <input id="order_id" name="order_id" class="order_id" type="hidden">
          <input id="user_id" name="user_id" value="{{auth()->user()->id}}" type="hidden">
          <p><input id="future_payment" name="future_payment" value="1" checked type="checkbox" style="
            margin-right: 10px;">save your card for future payments.</p>
          <button id="card-button" type="button" class="pay_button">Pay <b class="actual_payment_amount"></b>
            <div class="spinner hidden" id="spinner"></div></button>
        </form>


        <div id="payment-status-container" class="store-card-message"></div>
        <script type="text/javascript">

          const locationId = '{{setting("squareup_location_id")}}';
          async function main() {
            const payments = Square.payments('{{setting("squareup_application_id")}}','{{setting("squareup_location_id")}}');
            const card = await payments.card();
            await card.attach('#card-container');
            $('.loading').hide();
            async function eventHandler(event) {
              $('.loading').show();
              event.preventDefault();
              try {
                const result = await card.tokenize();
                if (result.status === 'OK') {
                  $("#token").val(`${result.token}`);
                  $("#payment-form").submit();
                } else {
                  $('.loading').hide();
                }
              } catch (e) {
                $('.loading').hide();
                console.error(e);
                window.location.href = "{{route('frontend.cards.paymentResponse')}}";
              }
            };

            const cardButton = document.getElementById('card-button');
            cardButton.addEventListener('click', async function (event) {
              $("#spinner").addClass('inline_class');
              $(".loading").show();
              const textInput = document.getElementById('customer-input');
              if (!textInput.reportValidity()) {
                return;
              }

              const customerId = textInput.value;
              // Add the `handleStoreCardMethodSubmission` method.
              handleStoreCardSubmission(event, card, customerId);
            })



            async function verifyBuyer(payments, token) {
              const verificationDetails = {
                billingContact: {
                  familyName: '{{auth()->user()->first_name}}',
                  givenName: '{{auth()->user()->last_name}}',
                  email: '{{auth()->user()->email}}'
                },
                intent: 'STORE',
              };

              const verificationResults = await payments.verifyBuyer(
                token,
                verificationDetails
              );
              return verificationResults.token;
            }


            async function storeCard(token, customerId, verificationToken) {
              const bodyParameters = {
                locationId,
                sourceId: token,
                customerId,
                verificationToken,
                idempotencyKey: window.crypto.randomUUID(),
                amount:$(".payment_amount").val(),
                order_id:$(".order_id").val(),
                future_payment:$("#future_payment").is(':checked')?1:0
              };

              const body = JSON.stringify(bodyParameters);

              const paymentResponse = await fetch("{{route("frontend.cards.storeCard")}}", {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body,
              });

              if (paymentResponse.ok) {
                return paymentResponse.json();
              }

              const errorBody = await paymentResponse.text();
              throw new Error(errorBody);
            }

        async function tokenize(paymentMethod) {
        const tokenResult = await paymentMethod.tokenize();
        if (tokenResult.status === 'OK') {
          return tokenResult.token;
        } else {
          throw new Error(
            `Tokenization errors: ${JSON.stringify(tokenResult.errors)}`
          );
        }
      }
      async function handleStoreCardSubmission(event, card, customerId) {
          event.preventDefault();

          try {
            // disable the submit button as we await tokenization and make a payment request.
            cardButton.disabled = true;
            const token = await tokenize(card);

            let verificationToken = await verifyBuyer(payments, token);
            const storeCardResults = await storeCard(
              token,
              customerId,
              verificationToken
            );
            location.reload();
          } catch (e) {
            cardButton.disabled = false;
            console.error('Store Card Failure', e);
            Alert.error('Payment Failed','Error',{displayDuration: 3000, pos: 'top'})
            $("#spinner").removeClass('inline_class');
            $(".loading").hide();
          }
        }
          }

          $(".delete_card").click(async function(){
              const body = JSON.stringify({'id':$(this).data('id')});
              const result = await fetch("{{route('frontend.cards.deleteCard')}}", {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body,
              });
              $(this).closest('.col-12').remove();
          })



          main();
          $(".pay_submit_button").click(function(){
            $(".loading").show();
          })
        </script>

      </div>
    </div>
  </div>
</div>
<style>.pay_button {
  color: #ffffff;
  background-color: #E58A40;
  border-radius: 5px;
  cursor: pointer;
  border-style: none;
  user-select: none;
  outline: none;
  font-size: 16px;
  font-weight: 500;
  line-height: 24px;
  padding: 12px;
  width: 100%;
  box-shadow: 1px;
}
.inline_class{
  display: inline;
}
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
  margin-left: 10px;
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
.h2_class {
   width: 100%;
   text-align: center;
   border-bottom: 1px solid #000;
   line-height: 0.1em;
   margin: 10px 0 20px;
}

.h2_class span {
    background:#fff;
    padding:0 10px;
}
</style>