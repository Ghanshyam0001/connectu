@extends('adminpaneal.dashboards.admin_master_layout')
@section('title')
  Author Profile
@endsection


@section('contant')

  <div class="container py-4">
    <div class="card profile-card shadow-sm">
      <div class="card-body">

        <!-- Profile header -->
        <div class="text-center mb-3">
          <img src="/uploads/{{ $data->image }}" alt="Avatar" class="profile-avatar mb-2">

        </div>

        <!-- Info table (two-column) -->
        <div class="table-responsive">
          <table class="table profile-table mb-3">
            <tbody>
              <tr>
                <th class="w-50">ID</th>
                <td class="text-muted">{{ $data->id }}</td>
              </tr>
              <tr>
                <th>Name</th>
                <td>{{ $data->name }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $data->email }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Action area: two buttons side-by-side -->
        <div class="d-flex gap-2 justify-content-between">
          <button class="btn btn-primary btn-sm" data-bs-postid="{{$data->id }}" data-bs-toggle="modal"
            data-bs-target="#changepassword">Change Password</button>
          <button class="btn btn-primary btn-sm" data-bs-postid="{{ $data->id }}" data-bs-toggle="modal"
            data-bs-target="#changeimage">
            Change Image
          </button>
        </div>

      </div><!-- card-body -->
    </div><!-- card -->
  </div><!-- container -->




  <div class="modal fade" id="changepassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="changepasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="changepasswordLabel">Change Password</h5> <!-- ✅ fixed ID -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateform">
          <div class="modal-body">
            <b>New Password</b>
            <input type="password" id="newpassword" name="password" class="form-control" placeholder="Enter Password">

            <b>Confirm Password</b>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
              placeholder="Confirm Password">
          </div>

          <div class="error-message text-danger px-2 py-1" id="error-message" style="display:none;"></div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" value="Save changes" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>


  {{-- update image --}}

  <div class="modal fade" id="changeimage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="imageLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageLabel">Change Profile Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="updateimage">

          <div class="modal-body">
            <img id="showimage" width="150px" class="img-fluid mb-3">

            <p>Upload image</p>
            <div class="error-message text-danger px-2 py-1" id="error-message" style="display:none;"></div>

            <input type="file" name="image" class="form-control">
          </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" value="Save changes" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection


@section('script')


  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const form = document.getElementById("updateform");
      const errorBox = document.getElementById("error-message");
      let selectedId = null;

      const updatemodel = document.getElementById("changepassword");
      if (updatemodel) {
        updatemodel.addEventListener("show.bs.modal", event => {
          const button = event.relatedTarget;
          selectedId = button.getAttribute("data-bs-postid");
        });
      }

      form.addEventListener("submit", async (e) => {
        e.preventDefault();
        errorBox.style.display = "none";
        successBox.style.display = "none";


        if (!selectedId) {
          errorBox.innerHTML = "No author selected!";
          errorBox.style.display = "block";
          return;
        }

        let formdata = new FormData();
        formdata.append("password", document.getElementById("newpassword").value);
        formdata.append("password_confirmation", document.getElementById("password_confirmation").value);

        try {
          let response = await fetch(`/api/changePassword/${selectedId}`, {
            method: "POST",
            body: formdata,
            headers: {
              "X-HTTP-Method-Override": "PUT",
              "Accept": "application/json"
            },
            credentials: "include"
          });

          let data = await response.json();

          if (response.ok && data.status) {
            successBox.innerHTML = data.message || "Password changed successfully.";
            successBox.style.display = "block";

            // Use a more modern and reliable way to close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('changepassword'));
            modal.hide();

            setTimeout(() => {
              window.location.href = "/author-profile";
            }, 2000);
          } else {
            if (data.errors) {
              errorBox.innerHTML = Object.values(data.errors).flat().join("<br>"); // ✅ Fixed for better error handling
            } else {
              errorBox.innerHTML = data.message || "Validation failed.";
            }
            errorBox.style.display = "block";
          }
        } catch (err) {
          console.error(err);
          errorBox.innerHTML = "Server error! Please try again later.";
          errorBox.style.display = "block";
        }
      });
    });


    // show Author image

    $(document).ready(function () {
      const updateimagemodel = document.querySelector("#changeimage");
      const updateForm = document.querySelector("#updateimage");
      if (updateimagemodel) {
        updateimagemodel.addEventListener('show.bs.modal', event => {
          const button = event.relatedTarget;
          const id = button.getAttribute('data-bs-postid');

          $.ajax({
            url: `/api/changeautherimage/${id}`,
            type: "GET",
            dataType: "json",
            headers: {
              "Accept": "application/json",
            },
            xhrFields: {
              withCredentials: true
            },
            success: function (data) {
              const imageUrl = (data.data && data.data.image)
                ? `/uploads/${data.data.image}`
                : "";
              $("#showimage").attr("src", imageUrl);
            },
            error: function (xhr, status, error) {
              console.error("AJAX failed:", error);
            }
          });
        });
      }




      // Update Image
      if ($("#updateimage").length) {
        $("#updateimage").on("submit", function (e) {
          e.preventDefault();


          $("#error-message").html("").hide();


          const id = $("[data-bs-postid]").attr("data-bs-postid");
          const formData = new FormData(this);

          $.ajax({
            url: `/api/updateauthorimage/${id}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
              "X-HTTP-Method-Override": "PUT",
              "Accept": "application/json",
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            xhrFields: {
              withCredentials: true
            },
            success: function (data) {
              if (data.data && data.data.image) {

                $("#showimage").attr("src", `/uploads/${data.data.image}`);
              }

              window.location.href = "/author-profile";
            },
            error: function (xhr) {
              let errorHtml = "";

              if (xhr.responseJSON) {
                if (xhr.responseJSON.errors) {

                  errorHtml = "<ul>";
                  xhr.responseJSON.errors.forEach(function (error) {
                    errorHtml += `<li>${error}</li>`;
                  });
                  errorHtml += "</ul>";
                } else if (xhr.responseJSON.message) {
                  errorHtml = `<p>${xhr.responseJSON.message}</p>`;
                } else {
                  errorHtml = "Something went wrong. Please try again.";
                }
              } else {
                errorHtml = "Server error. Please try again.";
              }

              $("#error-message").html(errorHtml).slideDown();
            }

          });
        });
      }

    });

  </script>
@endsection