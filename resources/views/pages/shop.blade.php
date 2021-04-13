@extends('layouts.front')

@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0"><a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Store</strong></div>
    </div>
  </div>
</div>

<div class="site-section">
    {{-- SEARCH --}}
    <div class="container" width="30%">
        <div class="input-group mb-3">
            <input id="search" name="search" type="text" class="form-control" placeholder="Search product...">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button"><span class="icon-search"></span></button>
            </div>
        </div>
        {{-- RESULT --}}
        <ul id="result" class="list-group">
        </ul>
    </div>
  <div class="container">

    <div class="row">
      <div class="col-lg-6">
        <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Reference</h3>
        <button type="button" class="btn btn-secondary btn-md dropdown-toggle px-4" id="dropdownMenuReference"
          data-toggle="dropdown">Reference</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
          <a class="dropdown-item" href="{{ route('pages.shop') }}">Relevance</a>
          <a class="dropdown-item" href="{{ route('pages.shop', ['filter' => 'name_asc']) }}">Name, A to Z</a>
          <a class="dropdown-item" href="{{ route('pages.shop', ['filter' => 'name_desc']) }}">Name, Z to A</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('pages.shop', ['filter' => 'price_asc']) }}">Price, low to high</a>
          <a class="dropdown-item" href="{{ route('pages.shop', ['filter' => 'price_desc']) }}">Price, high to low</a>
        </div>
      </div>

    </div>

    {{-- Products --}}
    <div class="row">

      @foreach ($products as $product)
      {{-- Container --}}
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <a href="{{ route('pages.show', ['product' => $product->id]) }}">
          {{-- Image --}}
          <img
            width="300"
            height="300"
            src="{{ asset('images/' . $product->image) }}"
            alt="Image">
          {{-- Name --}}
          <h3 class="text-dark">
            {{ $product->name }}
          </h3>
          {{-- Generic Name --}}
          <span class="price">{{ $product->generic_name }}</span>
          {{-- Price --}}
          <p class="price">&#8369;{{ $product->price }}</p>
        </a>
      </div>
      {{-- Container End --}}
      @endforeach

    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
      {{ $products->links() }}
    </div>



  </div>
</div>
@endsection

@section('script')
{{-- AJAX SEARCH SCRIPT --}}
<script>

    document.getElementById('search').addEventListener('keyup', searchProducts);

    function searchProducts() {
        // GET TEXT IN SEARCH
        var filter =  document.getElementById('search').value;

        // CREATE XHR
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "{{ route('pages.search') }}" + '?filter=' + filter, true);

        // CLEAR ITEMS IF SEARCH IT EMPTY
        if (filter == '') {
            document.getElementById('result').innerHTML = '';
        }

        xhr.onload = function() {
            if (this.status == 200) {
                var res = this.responseText;
                var output = '';

                if(res){
                    var products = JSON.parse(this.responseText);

                    if (products.length !== 0) {
                        for(var i in products){
                        output += `
                        <a href="/pages/show/${products[i].id}">
                            <li class="list-group-item">
                                <img src="/images/${products[i].image}" alt="image" height="40" width="40">
                                <span>Name: ${products[i].name}</span> &nbsp;&nbsp;&nbsp;
                                <span>Generic Name: ${products[i].generic_name}</span> &nbsp;&nbsp;&nbsp;
                                <span>Drug Class: ${products[i].drug_class}</span> &nbsp;&nbsp;&nbsp;
                                <span>Price: ${products[i].price}</span>
                            </li>
                        </a>`;
                        }
                    }else{
                        console.log('array is empty')
                        output = '<h2 class="text-center">Nothing Found</h2>';
                    }
                }

                document.getElementById('result').innerHTML = output;

            }
        }

        xhr.send();
    }
</script>

@endsection
