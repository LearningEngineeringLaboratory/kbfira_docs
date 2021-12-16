<div class="app-navbar d-flex p-2 border-bottom">
  <div class="btn-group btn-group-sm">
    <button class="bt-new btn btn-primary"><i class="bi bi-asterisk"></i> New</button>
    <button class="bt-open btn btn-sm btn-primary"><i class="bi bi-folder2-open"></i> Open</button>
  </div>
  <div class="btn-group btn-group-sm ms-2">
    <button class="bt-save btn btn-primary"><i class="bi bi-save"></i> Save</button>
    <button class="bt-save-as btn btn-primary"><i class="bi bi-front"></i> Save As...</button>
    <button class="bt-export btn btn-primary"><i class="bi bi-send"></i> Export</button>
  </div>
  <!-- <div class="btn-group btn-group-sm ms-2">
    <button class="bt-copy btn btn-primary"><i class="bi bi-files"></i> Copy</button>
    <button class="bt-paste btn btn-primary"><i class="bi bi-clipboard"></i> Paste</button>
  </div> -->
</div>
<div class="d-flex flex-fill align-items-stretch">
  <?php $this->pluginView('kitbuild-ui', ["id" => "goalmap-canvas"], 0); ?>
</div>





<form id="concept-map-save-as-dialog" class="card d-none">
  <h6 class="card-header"><i class="bi bi-file-earmark-plus dialog-icon"></i> <span class="dialog-title">Save Concept Map As...</span></h6>
  <div class="card-body">
      <div class="row mb-1 align-items-center">
        <label for="input-title" class="col-sm-3 col-form-label">Title</label>
        <div class="col-sm-9">
          <input type="text" name="title" class="form-control input-title" id="input-title">
        </div>
      </div>
      <div class="row mb-1 align-items-center">
        <label for="input-fid" class="col-sm-3 col-form-label">Custom ID (Optional)</label>
        <div class="col-sm-9">
          <div class="input-group">
            <input type="text" class="form-control input-fid form-control-sm" name="fid" id="input-fid" style="text-transform: uppercase;">
            <button class="bt-generate-fid btn btn-warning btn-sm"><i class="bi bi-magic"></i></button>
          </div>
        </div>
      </div>
      <div class="row my-2"><small class="col-sm-12 text-center text-secondary fst-italic"><strong class="fs-bold text-primary">optionally</strong> associate with a topic:</small></div>
      <div class="row mb-1 align-items-center">
        <!-- <label for="select-topic" class="col-sm-3 col-form-label">Topic (Optional)</label> -->
        <div class="col-sm-12">
          <div class="input-group input-group-sm">
            <select class="form-select form-control-sm" id="select-topic" name="topic" aria-label="Default select example">
              <option value="" selected>No topic associated</option>
              <!-- <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option> -->
            </select>
            <button class="btn btn-secondary bt-new-topic-form bt-sm"><i class="bi bi-plus-lg"></i></button>
          </div>
        </div>
      </div>
      <div class="row my-2"><small class="col-sm-12 text-center text-secondary fst-italic"><strong class="fs-bold text-primary">optionally</strong> associate with existing text:</small></div>
      <div class="row mb-1 align-items-center">
        <div class="col-sm-12">
          <select class="form-select form-select-sm" id="select-text" name="text" aria-label="Default select example">
            <option value="" selected>No text associated</option>
            <!-- <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option> -->
          </select>
        </div>
      </div>
      
      <!-- <div class="row mb-1 align-items-center form-new-topic" style="display: none;">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <input type="text" class="form-control mb-1" placeholder="New Topic Name" aria-label="New Topic Name" aria-describedby="button-create-new-topic">
              <select class="form-select mb-1" id="select-grup" aria-label="Default select example">
                  <option selected>No group assigned</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
              </select>
              <button class="bt-quick-create-topic btn btn-secondary" type="button" id="button-create-new-topic"><i class="bi bi-plus-lg"></i> Create Topic</button>
            </div>
          </div>
        </div>
      </div> -->
  </div>
  <div class="card-footer">
    <div class="row">
      <div class="col text-end">
        <button class="bt-cancel btn btn-sm btn-secondary" style="min-width: 6rem;">Cancel</button>
        <button class="bt-save btn btn-sm btn-primary ms-1" style="min-width: 6rem;">Save</button>
      </div>
    </div>
  </div>
</form>



<form id="concept-map-open-dialog" class="card d-none">
  <h6 class="card-header"><i class="bi bi-folder2-open"></i> Open Concept Map</h6>
  <div class="card-body">
    <ul class="nav nav-pills" id="open-concept-map-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link px-2 py-1 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#database" type="button" role="tab" aria-controls="home" aria-selected="true"><small>Database</small></button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link px-2 py-1" id="profile-tab" data-bs-toggle="tab" data-bs-target="#decode" type="button" role="tab" aria-controls="profile" aria-selected="false"><small>Decode</small></button>
      </li>
    </ul>
    <hr class="my-2">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="database" role="tabpanel" aria-labelledby="database-tab">
        <div class="row gx-2 mb-1">
          <div class="col d-flex">
            <span class="border-bottom px-2 py-1 flex-fill position-relative">Topic</span></div>
          <div class="col d-flex">
            <span class="border-bottom px-2 py-1 flex-fill position-relative">Concept Map</span></div>
        </div>
        <div class="row gx-2 mb-3">
          <div class="col list list-topic">
            <span class="topic list-item default" data-tid="">
              <em>Unassigned</em><bi class="bi bi-check-lg text-primary"></bi>
            </span>
          </div>
          <div class="col list list-concept-map"></div>
        </div>
        <div class="badge rounded-pill bg-secondary bt-refresh-topic-list" role="button">Refresh Topic List</div>
      </div>
      <div class="tab-pane fade" id="decode" role="tabpanel" aria-labelledby="decode-tab">
        <div class="mb-3">
          <label for="decode-textarea" class="form-label">Concept Map Data</label>
          <textarea class="form-control" id="decode-textarea" rows="4"></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="row">
      <div class="col text-end">
        <button class="bt-cancel btn btn-sm btn-secondary" style="min-width: 6rem;">Cancel</button>
        <button class="bt-open btn btn-sm btn-primary ms-1" style="min-width: 6rem;">Open</button>
      </div>
    </div>
  </div>
</form>

<div id="concept-map-export-dialog" class="card d-none">
  <h6 class="card-header"><i class="bi bi-send"></i> Export</h6>
  <div class="card-body">
    <textarea class="form-control encoded-data" rows="5"></textarea>
  </div>
  <div class="card-footer text-end">
    <button class="btn btn-sm btn-secondary bt-cancel px-3">Cancel</button>
    <button class="btn btn-sm btn-primary ms-1 bt-clipboard px-3"><i class="bi bi-clipboard"></i> Copy to Clipboard</button>
  </div>
</div>

<!-- <div id="concept-map-copy-paste-dialog" class="card d-none">
  <h6 class="card-header"><i class="dialog-icon bi"></i> <span class="dialog-title">Copy</span></h6>
  <div class="card-body">
    <textarea class="form-control encoded-data" rows="5"></textarea>
  </div>
  <div class="card-footer text-end">
    <button class="btn btn-sm btn-secondary bt-cancel px-3">Cancel</button>
    <button class="btn btn-sm btn-secondary bt-paste px-3 ms-1"><i class="bi bi-clipboard"></i> Paste Clipboard</button>
    <button class="btn btn-sm btn-primary ms-1 bt-copy-paste px-3"><i class="dialog-icon bi"></i> <span class="dialog-action">Copy</span></button>
  </div>
</div> -->