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
    @if (session()->has('message'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
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
      <div class="col-lg-2">
        <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by</h3>
        <button type="button" class="btn btn-secondary btn-md dropdown-toggle px-4" id="dropdownMenuReference"
          data-toggle="dropdown">Reference</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
          <a class="dropdown-item" href="{{ route('pages.shop') }}">Show All</a>
          <a class="dropdown-item" href="{{ route('pages.shop', ['filter' => 'name_asc']) }}">Name, A to Z</a>
          <a class="dropdown-item" href="{{ route('pages.shop', ['filter' => 'name_desc']) }}">Name, Z to A</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('pages.shop', ['filter' => 'price_asc']) }}">Price, low to high</a>
          <a class="dropdown-item" href="{{ route('pages.shop', ['filter' => 'price_desc']) }}">Price, high to low</a>
        </div>
      </div>
      <div class="col-lg-2">
        <h3 class="mb-3 h6 text-uppercase text-black d-block">Select category</h3>
        <button type="button" class="btn btn-secondary btn-md dropdown-toggle px-4" id="dropdownMenuReference"
          data-toggle="dropdown">Category</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
            @forelse ($categories as $category)
                <a class="dropdown-item" href="{{ route('pages.shop', ['category' => $category->name]) }}">{{ $category->name }}</a>
            @empty
                <a class="dropdown-item">No Categories Found</a>
            @endforelse
        </div>
      </div>


    </div>

    @if (isset($filterName))
        <h2>Filtering By: {{ $filterName }}</h2>
    @endif

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
          @if ($product->sale()->exists())
            <p class="price text-dark">
            {{-- Old Price --}}
            <del class="text-danger">
                &#8369;{{ $product->price }}
            </del>
            {{-- New Price --}}
                <strong class="text-dark h4">
                    &#8369;
                    @if ($product->sale->is_percent)
                    {{ round(($product->price - ($product->price * ($product->sale->rate / 100))),2 )  }}
                    @else
                        {{ $product->price - $product->sale->rate }}
                    @endif
                </strong>

            @else
            <br>
                <span class="text-dark">&#8369;{{ $product->price }}</span>
            @endif
            </p>
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
                    var name = products.name;
                    var generic = products.generic;
                    var drug_class = products.class;

                    // NAME LOOP
                    output += '<h6 class="text-left text-info">Product Name</h6>';
                    for(var i in name){
                    output += `
                    <a href="/pages/show/${name[i].id}" class="text-dark">
                        <li class="list-group-item">
                            <img src="/images/${name[i].image}" alt="image" height="40" width="40">
                            <span>Name: ${name[i].name}</span> &nbsp;&nbsp;&nbsp;
                            <span>Generic Name: ${name[i].generic_name}</span> &nbsp;&nbsp;&nbsp;
                            <span>Drug Class: ${name[i].drug_class}</span> &nbsp;&nbsp;&nbsp;
                            <span>Price: ${name[i].price}</span>
                        </li>
                    </a>`;
                    }

                    // GENERIC LOOP
                    output += '<br><br><h6 class="text-left text-success">Generic Name</h6>';
                    for(var i in generic){
                    output += `
                    <a href="/pages/show/${generic[i].id}" class="text-dark>
                        <li class="list-group-item">
                            <img src="/images/${generic[i].image}" alt="image" height="40" width="40">
                            <span>Name: ${generic[i].name}</span> &nbsp;&nbsp;&nbsp;
                            <span>Generic Name: ${generic[i].generic_name}</span> &nbsp;&nbsp;&nbsp;
                            <span>Drug Class: ${generic[i].drug_class}</span> &nbsp;&nbsp;&nbsp;
                            <span>Price: ${generic[i].price}</span>
                        </li>
                    </a>`;
                    }

                    // CLASS LOOP
                    output += '<br><br><h6 class="text-left text-warning">Drug Class</h6>';
                    for(var i in drug_class){
                    output += `
                    <a href="/pages/show/${drug_class[i].id}" class="text-dark>
                        <li class="list-group-item">
                            <img src="/images/${drug_class[i].image}" alt="image" height="40" width="40">
                            <span>Name: ${drug_class[i].name}</span> &nbsp;&nbsp;&nbsp;
                            <span>Generic Name: ${drug_class[i].generic_name}</span> &nbsp;&nbsp;&nbsp;
                            <span>Drug Class: ${drug_class[i].drug_class}</span> &nbsp;&nbsp;&nbsp;
                            <span>Price: ${drug_class[i].price}</span>
                        </li>
                    </a>`;
                    }
                }
                else{
                        output = '<h2 class="text-center">Nothing Found</h2>';
                    }

                document.getElementById('result').innerHTML = output;

            }
        }

        xhr.send();
    }
</script>

@endsection
