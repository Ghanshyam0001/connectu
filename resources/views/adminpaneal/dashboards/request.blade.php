@extends('adminpaneal.dashboards.admin_master_layout')
@section('title')
  Author Request
@endsection

@section('link')
  /author-active
@endsection

@section('linkname')
  Active Author
@endsection


@section('contant')
  <div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">Author Request</h3>
              <div class="text-success bg-white px-2 py-1  fw-bold" style="display:none; border-radius: 4px;"
                id="success-message"></div>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="request-author">

            </div>
            <!-- /.card-body -->

          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  

<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

<script>
  function loaddata(page = 1) {
    fetch(`/api/approveorreject?page=${page}`)
      .then(response => response.json())
      .then(data => {

        const allrequest = data.data;
        const paginationData = data.pagination;
        const authorcontainer = document.querySelector("#request-author");

        let tabledata = `
             <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th>Approve</th>
                        <th>Reject</th>
                      </tr>
                    </thead>
                    <tbody>
            `;

        allrequest.forEach(request => {
          tabledata += `
                <tr>
                  <td>${request.id}</td>
                  <td>${request.name}</td>
                  <td>${request.email}</td>
                  <td><img src="/uploads/${request.image}" width="60" height="60" style="object-fit: cover;"></td>
                  <td><button onclick="approveauthor(${request.id})" class="btn btn-success btn-sm">Approve</button></td>
                  <td><button onclick="Rejectauthor(${request.id})" class="btn btn-danger btn-sm">Reject</button></td>
                </tr>
              `;
        });

        tabledata += `</tbody></table>`;


        let pagination = `<div class="mt-3">`;
        for (let i = 1; i <= paginationData.last_page; i++) {
          pagination += `<button 
                                   class="btn btn-sm ${i === paginationData.current_page ? 'btn-primary' : 'btn-light'}"
                                   onclick="loaddata(${i})">
                                   ${i}
                               </button>`;
        }
        pagination += `</div>`;

        authorcontainer.innerHTML = tabledata + pagination;
      })
  }

  loaddata();

  async function Rejectauthor(authorid) {
    try {
      let response = await fetch(`/api/requestreject/${authorid}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      });


      let data = await response.json();
      console.log(data);

      // Show success message
      let successmessage = document.getElementById('success-message');
      successmessage.innerHTML = data.message;
      successmessage.style.display = 'block'; // make sure it's visible

      // Optionally hide message after 3 seconds
      setTimeout(() => {
        successmessage.style.display = 'none';
      }, 3000);



      loaddata();
    } catch (error) {
      console.error('Error rejecting author:', error);
    }
  }

  // Approve author
  async function approveauthor(authorid) {
    try {
      let response = await fetch(`/api/requestapproved/${authorid}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      });

      let data = await response.json();
      console.log(data);


      let successmessage = document.getElementById('success-message');
      successmessage.innerHTML = data.message;
      successmessage.style.display = 'block';


      setTimeout(() => {
        successmessage.style.display = 'none';
      }, 3000);


      loaddata();
    } catch (error) {
      console.error('Error approving author:', error);
    }
  }

 document.addEventListener("DOMContentLoaded", loaddata);

</script>
@endsection