<!DOCTYPE html>
<html lang="en">
  <head>
      <base href="/">
    @include('admin.css')
    <style>
        label{
            width: 130px
        }
    </style>
  </head>
  <body>
      @include('admin.sidebar')
      <!-- partial -->
        <!-- partial:partials/_navbar.html -->
        @include('admin.navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="container p-4" align="center">
                @if (session('success'))
                <div class="alert alert-primary">{{ session('success') }}</div>
                @endif
               <h1 class="text-white fw-bold">Edit Product</h1>

               <div class="row">
                   <div class="col-md-5 mx-auto">
                    <form action="/products/{{ $data->id }}/updated" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4">
                            <label class="form-label me-3" for="title">Title</label>
                            <input value="{{ $data->title }}" class="form-control-sm text-dark rounded-3" name="title" type="text" id="title" placeholder="Product Title">
                        </div>
                        <div class="mt-3">
                           <label class="form-label me-3" for="price">Price</label>
                           <input value="{{ $data->price }}" class="form-control-sm text-dark rounded-3" name="price" type="number" id="price" placeholder="Product Price">
                       </div>
                       <div class="mt-3">
                           <label class="form-label me-3" for="description">Description</label>
                           <input value="{{ $data->description }}" class="form-control-sm text-dark rounded-3" name="des" type="text" id="description" placeholder="Product Description">
                       </div>
                       <div class="mt-3 ms-5 d-flex  align-items-center">
                           <label class="form-label me-3" for="image">Recent Image</label>
                           <img class="ms-4" src="/storage/{{ $data->image }}" width="120px" height="60px">
                       </div>
                       <div class="mt-3">
                           <label class="form-label me-3" for="quantity">Quantity</label>
                           <input value="{{ $data->quantity }}" class="form-control-sm text-dark rounded-3" name="quantity" type="number" id="quantity" placeholder="Product quantity">
                       </div>
                       <div class="mt-3">
                           <input class="form-control-sm text-white p-2 rounded-3" name="image" type="file" id="image" placeholder="Product image">
                       </div>
                           <button class="btn btn-primary" type="submit">Add</button>
                      </form>
                   </div>
               </div>
            </div>
        </div>
          <!-- partial -->
       @include('admin.script')
  </body>
</html>

