@extends('adminpaneal.dashboards.admin_master_layout')

@section('title')
  Content Types
@endsection

@section('link')
  /dashboard
@endsection

@section('linkname')
  Dashboard
@endsection

@section('contant')



  <div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Content</h3>
                <a href="{{ route('addcontent') }}" class="btn btn-success btn-sm">Add New Content</a>
              </div>

              <div id="success-message" class="text-success bg-white px-2 py-1 fw-bold mt-2 d-none"
                style="border-radius: 4px;">
              </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body" id="active-content">

            </div>
            <!-- /.card-body -->

          </div>

        </div>
      </div>
    </div>
  </div>




  <div class="modal fade" id="viewdetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="viewdetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <!-- Header -->
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="viewdetailLabel">View Content Detail</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form id="updateform">
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped align-middle">
                <tbody>
                  <tr>
                    <th style="width: 30%;">ID</th>
                    <td id="view_id"></td>
                  </tr>
                  <tr>
                    <th>Title</th>
                    <td id="view_title"></td>
                  </tr>
                  <tr>
                    <th>Description</th>
                    <td id="view_description"></td>
                  </tr>
                  <tr>
                    <th>Slug</th>
                    <td id="view_slug"></td>
                  </tr>
                  <tr>
                    <th>Image</th>
                    <td>
                      <img id="view_image" src="" alt="Content Image" class="img-fluid rounded border"
                        style="max-height:200px;object-fit:cover; display:none;">
                      <video id="view_video" class="img-fluid rounded border" style="max-height:200px; display:none;"
                        controls>
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                      </video>
                    </td>

                  </tr>
                  <tr>
                    <th>Author ID</th>
                    <td id="view_author"></td>
                  </tr>
                  <tr>
                    <th>Category ID</th>
                    <td id="view_category"></td>
                  </tr>
                  <tr>
                    <th>Type</th>
                    <td id="view_type"></td>
                  </tr>
                  <tr>
                    <th>Created At</th>
                    <td id="view_created"></td>
                  </tr>
                  <tr>
                    <th>Updated At</th>
                    <td id="view_updated"></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Error Message -->
            <div class="error-message text-danger px-2 py-1" id="error-message" style="display:none;"></div>
          </div>

          <!-- Footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

          </div>
        </form>

      </div>
    </div>
  </div>


  {{-- show singal data for update --}}
  <div class="modal fade" id="updatecontent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="updatecontentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title fs-5" id="updatecontentLabel">Update Content</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="updateContentForm" enctype="multipart/form-data">

          <input type="hidden" name="id">

          <div class="modal-body">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
              </div>

              <div class="col-12">
                <label for="summernote1" class="form-label">Description</label>
                <textarea id="summernote1" name="description" required></textarea>
              </div>

              <div class="col-md-6 col-12">
                <label class="form-label">Author</label>
                <input type="hidden" name="author_id" value="{{ Auth::guard('author')->user()->id }}">
                <input type="text" class="form-control" value="{{ Auth::guard('author')->user()->name }}" readonly>
              </div>

              <div class="col-md-6 col-12">
                <label class="form-label">Category</label>
                <select name="category_id" id="categorySelect" class="form-control" required>
                  <option value="">-- Select Category --</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Content Type</label>
                <select name="type_id" id="typeSelect" class="form-control" required>
                  <option value="">-- Select Type --</option>
                </select>
              </div>

              <div class="col-12" id="imageField" style="display:none;">
                <label class="form-label">Upload Image</label>
                <input type="file" name="image" class="form-control">
                <div class="mt-2 text-center">
                  <img id="oldImagePreview" src="" alt="Old Image" class="img-fluid rounded d-none"
                    style="max-height: 200px;">
                </div>
              </div>

              <div class="col-12" id="videoField" style="display:none;">
                <label class="form-label">Upload Video</label>
                <input type="file" name="video" class="form-control">
                <div class="mt-2 text-center">
                  <video id="oldVideoPreview" controls class="d-none" style="max-height: 250px; width:100%;">
                    <source src="" type="video/mp4">
                    Your browser does not support video.
                  </video>
                </div>
              </div>
            </div>

            <div class="mt-2">
              <div id="error-message" class="alert alert-danger d-none"></div>
              <div id="success-message" class="alert alert-success d-none"></div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update Content</button>
          </div>
        </form>
      </div>
    </div>
  </div>








@endsection

@section('script')
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

  <!-- Bootstrap 5 (if not already in your layout) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Summernote (Bootstrap 5 version) -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">


  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
  <script>

    $(document).ready(function () {
      $('#summernote1').summernote({
        placeholder: 'Write your content here...',
        tabsize: 2,
        height: 250,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    });

    // Load paginated data
    function loaddata(page = 1) {
      fetch(`/api/showcontents?page=${page}`)
        .then(response => response.json())
        .then(data => {
          const contents = data.data; // rows
          const paginationData = data.pagination; // pagination meta
          const contentContainer = document.querySelector("#active-content");

          let tabledata = `<table class="table table-bordered">
                                                                        <thead>
                                                                          <tr>
                                                                            <th>Id</th>
                                                                            <th>Title</th>
                                                                            <th>Description</th>
                                                                            <th>File</th>
                                                                            <th>Edit</th>
                                                                            <th>View</th>
                                                                            <th>Delete</th>
                                                                          </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                    `;

          if (contents.length === 0) {
            tabledata += `
                                                                        <tr>
                                                                          <td colspan="7" class="text-center text-muted">No contents found.</td>
                                                                        </tr>
                                                                      `;
          } else {
            contents.forEach(content => {
              let filePreview = `<span class="text-muted">No Media</span>`;

              if (content.image) {
                filePreview = `<img src="/${content.image}"width="80" height="60" style="object-fit:cover;">`;
              } else if (content.video) {
                filePreview = `
                                                                            <video width="80" height="60" controls>
                                                                              <source src="/${content.video}" type="video/mp4">
                                                                              Your browser does not support the video tag.
                                                                            </video>`;
              }

              tabledata += `
                                                                          <tr>
                                                                            <td>${content.id}</td>
                                                                            <td>${content.title}</td>
                                                                            <td>${content.description}</td>
                                                                            <td>${filePreview}</td>
                                                                              <td> <button class="btn btn-warning btn-sm update-btn" data-bs-postid="${content.id}" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#updatecontent">
                                                          Update
                                                        </button>
                                                      </td>
                                                                           <td> <button class="btn btn-primary btn-sm view-btn" data-bs-postid="${content.id}" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#viewdetail">
                                                          View
                                                        </button>
                                                      </td>


                                                                            <td>
                                                                              <button class="btn btn-danger btn-sm" onclick="deletecontent(${content.id})">Delete</button>
                                                                            </td>
                                                                          </tr>
                                                                        `;
            });
          }

          tabledata += `</tbody></table>`;

          // Pagination buttons
          let pagination = `<div class="mt-3">`;
          for (let i = 1; i <= paginationData.last_page; i++) {
            pagination += `
                                                                        <button 
                                                                          class="btn btn-sm ${i === paginationData.current_page ? 'btn-primary' : 'btn-light'} me-1"
                                                                          onclick="loaddata(${i})">
                                                                          ${i}
                                                                        </button>
                                                                      `;
          }
          pagination += `</div>`;

          contentContainer.innerHTML = tabledata + pagination;
        })
        .catch(err => {
          console.error("Error loading data:", err);
          document.querySelector("#active-content").innerHTML =
            `<p class="text-danger text-center">Failed to load contents.</p>`;
        });
    }
    loaddata();

    // Delete Content
    function deletecontent(contentId) {
      if (!confirm("Are you sure you want to delete this content?")) return;

      $.ajax({
        url: `/api/deletecontent/${contentId}`,
        type: "DELETE",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function (data) {
          $("#success-message").text(data.message).fadeIn().delay(2000).fadeOut();
          loaddata(); // reload table
        },
        error: function () {
          alert("Error deleting content");
        }
      });
    }

    // view  singal content
    $(document).ready(function () {
      const showmodel = document.querySelector("#viewdetail");
      if (showmodel) {
        showmodel.addEventListener('show.bs.modal', event => {
          const button = event.relatedTarget;
          const id = button.getAttribute('data-bs-postid');

          $.ajax({
            url: `/api/viewsingalcontent/${id}`,
            type: "GET",
            dataType: "json",
            headers: {
              "Accept": "application/json",
            },
            xhrFields: {
              withCredentials: true
            },
            success: function (data) {
              console.log(data);
              const contant = data.data;
              $("#view_id").text(contant.id || 'N/A');
              $("#view_title").text(contant.title || 'N/A');
              $("#view_description").text(contant.description || 'N/A');
              $("#view_slug").text(contant.slug || 'N/A');

              $("#view_author").text(contant.author && contant.author.name ? contant.author.name : 'N/A');
              $("#view_category").text(contant.category && contant.category.name ? contant.category.name : 'N/A');
              $("#view_type").text(contant.type && contant.type.name ? contant.type.name : 'N/A');

              $("#view_created").text(contant.created_at ? new Date(contant.created_at).toLocaleString() : 'N/A');
              $("#view_updated").text(contant.updated_at ? new Date(contant.updated_at).toLocaleString() : 'N/A');

              if (contant.image) {
                $("#view_image").attr("src", `/${contant.image}`).show();
                $("#view_video").hide();
              } else if (contant.video) {
                $("#view_video source").attr("src", `/${contant.video}`);
                $("#view_video")[0].load(); // reload video source
                $("#view_video").show();
                $("#view_image").hide();
              } else {
                $("#view_image, #view_video").hide();
              }
            },
            error: function (xhr, status, error) {
              console.error("Error Fetching Content", error);
            }
          });
        });
      }

      // show content in model for update

      const updateModal = document.querySelector("#updatecontent");

      if (updateModal) {
        updateModal.addEventListener("show.bs.modal", event => {
          const button = event.relatedTarget;
          const id = button.getAttribute("data-bs-postid");

          $.ajax({
            url: `/api/singalupdatecontent/${id}`,
            type: "GET",
            dataType: "json",
            success: function (res) {
              const content = res.data;
              const categories = res.categories;
              const contentTypes = res.contentTypes;




              if (content.image) {
                $("#oldImagePreview").attr("src", "/" + content.image).show();
              } else {
                $("#oldImagePreview").hide();
              }


              if (content.video) {
                $("#oldVideoPreview source").attr("src", "/" + content.video);
                $("#oldVideoPreview")[0].load();
                $("#oldVideoPreview").show();
              } else {
                $("#oldVideoPreview").hide();
              }


              $("#updateContentForm [name='id']").val(content.id);


              $("#updateContentForm [name='title']").val(content.title || "");
              $("#summernote1").summernote("code", content.description || "");


              const categorySelect = $("#categorySelect");
              categorySelect.empty().append('<option value="">-- Select Category --</option>');
              categories.forEach(cat => {
                categorySelect.append(
                  `<option value="${cat.id}" ${cat.id === content.category_id ? "selected" : ""}>${cat.name}</option>`
                );
              });

              const typeSelect = $("#typeSelect");
              typeSelect.empty().append('<option value="">-- Select Type --</option>');
              contentTypes.forEach(ct => {
                typeSelect.append(
                  `<option value="${ct.id}" ${ct.id === content.type_id ? "selected" : ""}>${ct.name}</option>`
                );
              });

              if (content.type && content.type.name?.toLowerCase() === "post") {
                $("#imageField").show();
                $("#videoField").hide();
              } else if (content.type && content.type.name?.toLowerCase() === "video") {
                $("#videoField").show();
                $("#imageField").hide();
              } else {
                $("#imageField, #videoField").hide();
              }


            },
            error: function (xhr, status, error) {
              console.error("Error fetching content:", error);
            }
          });
        });
      }

      $(document).on("submit", "#updateContentForm", function (e) {
        e.preventDefault();

        let id = $("input[name='id']").val();
        let formData = new FormData(this);

        // 1. Clear previous messages before sending new request
        $('#error-message').html('').hide();
        $('#success-message').text('');



        $.ajax({
          url: `/api/updatecontent/${id}`,
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          headers: {
            "Accept": "application/json",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          xhrFields: { withCredentials: true },
          success: function (data) {

            $('#success-message').text(data.message);


            setTimeout(() => {
              window.location.href = "/allcontent";
            }, 1500);
          },
          error: function (xhr) {

            let response;
            try {

              response = xhr.responseJSON || JSON.parse(xhr.responseText);
            } catch (e) {

              $('#error-message').html('A server error occurred, and the response could not be parsed.').slideDown();
              return;
            }

            let errorHtml = '';

            if (response && response.errors) {

              let errors = response.errors;
              errorHtml = '<ul>';
              Object.values(errors).forEach(errorArray => {
                errorArray.forEach(err => {
                  errorHtml += `<li>${err}</li>`;
                });
              });
              errorHtml += '</ul>';
            } else if (response && response.message) {

              errorHtml = response.message;
            } else {

              errorHtml = 'Something went wrong. Please check your form data.';
            }


            $('#error-message').html(errorHtml).slideDown();
            $('#success-message').text('');
          }
        });
      });


    });

















  </script>

@endsection