@extends('adminpaneal.authauthor.layout')



@section('content')


  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <a href="../index2.html" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
          <h1 class="mb-0"><b>connect</b>U</h1>
        </a>
      </div>
      <div class="card-body login-card-body">


        <div class="input-group mb-1">
          <div class="form-floating">
            <input id="email" type="email" class="form-control" />
            <label for="">Email</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>
        <div class="input-group mb-1">
          <div class="form-floating">
            <input type="password" name="password" id="password" class="form-control">
            <label for="">Password</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>
        <div id="error-message" class="text-danger"></div>

        <!--begin::Row-->
        <div class="row">

          <!-- /.col -->
          <div class="col-12">
            <div class="d-grid gap-2">
              <button id="loginbtn" type="button" class="btn btn-primary w-100">Sign in</button>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!--end::Row-->


        <!-- /.social-auth-links -->
        <p class="mb-1 mt-3"><a href="{{route('author-forgotpassword')}}">forgot password</a></p>
        <p class="mb-0">
          <a href="{{route('author-register')}}" class="text-center"> Register a author </a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

<script>
  $(document).ready(function () {
    $('#loginbtn').on('click', function (e) {
      e.preventDefault();
      const csrfToken = $('meta[name="csrf-token"]').attr('content');
      const email = $("#email").val();
      const password = $("#password").val();

      $.ajax({
        url: 'api/login',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        contentType: 'application/json',
        data: JSON.stringify({
          email: email,
          password: password,
        }),
        success: function (response) {
          console.log(response);



          window.location.href = "/dashboard"
        },
        error: function (xhr) {
          let errorHtml = '';

          if (xhr.responseJSON) {
            if (xhr.responseJSON.errors) {
              // Handle validation errors (object of arrays)
              let errors = xhr.responseJSON.errors;
              errorHtml = '<ul>';
              Object.keys(errors).forEach(function (key) {
                errors[key].forEach(function (error) {
                  errorHtml += `<li>${error}</li>`;
                });
              });
              errorHtml += '</ul>';
            } else if (xhr.responseJSON.message) {
              // Handle simple message (e.g., invalid credentials)
              errorHtml = `<p>${xhr.responseJSON.message}</p>`;
            } else {
              errorHtml = 'Something went wrong. Please try again.';
            }
          } else {
            errorHtml = 'Server error. Please try again.';
          }

          $('#error-message').html(errorHtml).slideDown();
        }

      })
    })


  })

</script>