@extends('layouts.front')

@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Checkout</strong>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">

    <div class="row">

      <div class="col-md-6 mb-5 mb-md-0">

        <div class="col-md-12">

          <h2 class="h3 mb-3 text-black">Your Order</h2>
          <div class="p-3 p-lg-5 border">
            <table class="table site-block-order-table mb-5">
              <thead>
                <th>Product</th>
                <th>Total</th>
              </thead>
              <tbody>
                <tr>
                  <td>Bioderma <strong class="mx-2">x</strong> 1</td>
                  <td>$55.00</td>
                </tr>
                <tr>
                  <td>Ibuprofeen <strong class="mx-2">x</strong> 1</td>
                  <td>$45.00</td>
                </tr>
                <tr>
                  <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                  <td class="text-black">$350.00</td>
                </tr>
                <tr>
                  <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                  <td class="text-black font-weight-bold"><strong>$350.00</strong></td>
                </tr>
              </tbody>
            </table>

            <div class="border mb-3">
              <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button"
                  aria-expanded="false" aria-controls="collapsebank">Direct Bank Transfer</a></h3>

              <div class="collapse" id="collapsebank">
                <div class="py-2 px-4">
                  <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the
                    payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                </div>
              </div>
            </div>

            <div class="border mb-3">
              <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsecheque" role="button"
                  aria-expanded="false" aria-controls="collapsecheque">Cheque Payment</a></h3>

              <div class="collapse" id="collapsecheque">
                <div class="py-2 px-4">
                  <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the
                    payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                </div>
              </div>
            </div>

            <div class="border mb-5">
              <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsepaypal" role="button"
                  aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3>

              <div class="collapse" id="collapsepaypal">
                <div class="py-2 px-4">
                  <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the
                    payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                </div>
              </div>
            </div>

            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block" onclick="window.location='thankyou.php'">Place
                Order</button>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="row mb-5">

          <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">Coupon Code</h2>
            <div class="p-3 p-lg-5 border">

              <label for="c_code" class="text-black mb-3">Enter your coupon code if you have one</label>
              <div class="input-group w-75">
                <input type="text" class="form-control" id="c_code" placeholder="Coupon Code" aria-label="Coupon Code"
                  aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary btn-sm px-4" type="button" id="button-addon2">Apply</button>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="row mb-5">
          
        </div>

      </div>
    </div>
    <!-- </form> -->
  </div>
</div>
@endsection