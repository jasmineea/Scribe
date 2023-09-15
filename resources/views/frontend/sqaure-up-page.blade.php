{{-- <html>
    <head>
        <link rel="stylesheet" href="https://developer.squareup.com/reference/sdks/web/static/styles/code-preview.css" preload>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
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
      </head>
      <body>
      <div class="loading">Loading&#8230;</div>
        <form id="payment-form" action="{{route('frontend.cards.paymentResponse')}}" method="POST">
          <div id="card-container"></div>
          {{ csrf_field() }}
          <input id="token" name="token" type="hidden">
          <input id="user_id" name="user_id" value="{{$user_id}}" type="hidden">
          <button id="card-button" type="button">Pay USD{{format_money($amount)}}</button>
        </form>

        <script type="text/javascript">
          async function main() {
            const payments = Square.payments('{{setting("squareup_application_id")}}','{{setting("squareup_access_token")}}');
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
            cardButton.addEventListener('click', eventHandler);
          }

          main();
        </script>
      </body>

    </html> --}}


    <!DOCTYPE html>
<html>
  <head>
    <link href="/app.css" rel="stylesheet" />
    <script
      type="text/javascript"
      src="https://sandbox.web.squarecdn.com/v1/square.js"
    ></script>
    <script>
      const appId = '{{setting("squareup_application_id")}}';
      const locationId = '{{setting("squareup_location_id")}}';

      async function initializeCard(payments) {
        const card = await payments.card();
        await card.attach('#card-container');

        return card;
      }

      async function storeCard(token, customerId, verificationToken) {
        const bodyParameters = {
          locationId,
          sourceId: token,
          customerId,
          verificationToken,
          idempotencyKey: window.crypto.randomUUID(),
        };

        const body = JSON.stringify(bodyParameters);

        const paymentResponse = await fetch("{{route('frontend.cards.paymentResponse')}}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
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

      // status is either SUCCESS or FAILURE;
      function displayResults(status) {
        const statusContainer = document.getElementById(
          'payment-status-container'
        );
        if (status === 'SUCCESS') {
          statusContainer.classList.remove('is-failure');
          statusContainer.classList.add('is-success');
        } else {
          statusContainer.classList.remove('is-success');
          statusContainer.classList.add('is-failure');
        }

        statusContainer.style.visibility = 'visible';
      }

      // Required in SCA Mandated Regions: Learn more at https://developer.squareup.com/docs/sca-overview
      async function verifyBuyer(payments, token) {
        const verificationDetails = {
          billingContact: {
            addressLines: ['123 Main Street', 'Apartment 1'],
            familyName: 'Doe',
            givenName: 'John',
            email: 'jondoe@gmail.com',
            country: 'GB',
            phone: '3214563987',
            region: 'LND',
            city: 'London',
          },
          intent: 'STORE',
        };

        const verificationResults = await payments.verifyBuyer(
          token,
          verificationDetails
        );
        return verificationResults.token;
      }

      document.addEventListener('DOMContentLoaded', async function () {
        if (!window.Square) {
          throw new Error('Square.js failed to load properly');
        }

        let payments;
        try {
          payments = window.Square.payments(appId, locationId);
        } catch {
          const statusContainer = document.getElementById(
            'payment-status-container'
          );
          statusContainer.className = 'missing-credentials';
          statusContainer.style.visibility = 'visible';
          return;
        }

        let card;
        try {
          card = await initializeCard(payments);
        } catch (e) {
          console.error('Initializing Card failed', e);
          return;
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

            displayResults('SUCCESS');
            console.debug('Store Card Success', storeCardResults);
          } catch (e) {
            cardButton.disabled = false;
            displayResults('FAILURE');
            console.error('Store Card Failure', e);
          }
        }

        const cardButton = document.getElementById('card-button');
        cardButton.addEventListener('click', async function (event) {
          const textInput = document.getElementById('customer-input');
          if (!textInput.reportValidity()) {
            return;
          }

          const customerId = textInput.value;
          handleStoreCardSubmission(event, card, customerId);
        });
      });
    </script>
  </head>
  <body>
    <form id="payment-form">
      <input
        id="customer-input"
        type="text"
        aria-required="true"
        aria-label="Customer ID"
        required="required"
        placeholder="Customer ID"
        name="customerId"
      />
      <div id="card-container" style="margin-top: 0"></div>
      <button id="card-button" type="button">Store Card</button>
    </form>
    <div id="payment-status-container" class="store-card-message"></div>
  </body>
</html>