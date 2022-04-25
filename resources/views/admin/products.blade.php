<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')
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
                <div class="alert alert-warning">{{ session('success') }}</div>
                @endif
                <h1 class="text-white fw-bold my-3">All Products</h1>
                <table class="table table-light table-hover">
                    <thead>
                      <tr>
                        <th scope="col">id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Image</th>
                        <th colspan="2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $product)
                      <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->price }}</td>
                        <td><img src="/storage/{{ $product->image }}"></td>
                        <td>
                            <form class="mb-2" action="/products/{{ $product->id }}/update">
                                 @csrf
                                 <button class="btn btn-primary">Update</button>
                             </form>
                            <form action="/products/{{ $product->id }}/delete" method="POST">
                               @method('DELETE')
                                @csrf
                                <button onclick="return confirm('Are you sure??')" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
          <!-- partial -->
       @include('admin.script')
  </body>
</html>
