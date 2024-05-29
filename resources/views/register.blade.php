@extends('layoutblank')

@section('content')
<section class="vh-100" style="background-color: #9A616D;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="{{url('img/sapi.jpeg')}}"
                  alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">
  
                    <form action="post-register" method="POST">
                        {{ csrf_field() }}
  
                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                      <span class="h1 fw-bold mb-0">SATO</span>
                    </div>
  
                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Register Your Account!</h5>
  
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input id="name" type="text" class="form-control form-control-lg" name="name" required autofocus>
                        <label class="form-label" for="name">Name</label>
                      </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                      <input id="email" type="email" class="form-control form-control-lg" name="email" required>
                      <label class="form-label" for="email">Email address</label>
                    </div>
  
                    <div data-mdb-input-init class="form-outline mb-4">
                      <input id="password" type="password" class="form-control form-control-lg" name="password" required>
                      <label class="form-label" for="password">Password</label>
                    </div>
  
                    <div class="pt-1 mb-4">
                      <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit">Sign In</button>
                    </div>
                  </form>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection