<header class="p-2 border-bottom">
  <button class="btn btn-success ms-1 bt-new">
    <i class="bi bi-plus-lg"></i> New Text
  </button>
</header>
<div class="row gx-0">
  <div class="col-6">
    <div class="border rounded bg-white m-2">
      <form class="m-2" id="form-search-text">
        <div class="input-group mb-3">
          <input type="text" name="keyword" class="form-control w-50 input-keyword" placeholder="Search keyword" aria-label="Keyword">
          <select name="perpage" class="form-select flex-shrink-1 input-perpage">
            <option value="1">1</option>
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
          <button class="btn btn-secondary bt-search"><i class="bi bi-search"></i></button>
        </div>
      </form>
      <div class="px-2">
        <div class="m-2">
          <div class="border-bottom py-2">
            <span class="ms-2 text-primary">Text Title</span>
            <span>&nbsp;</span>
          </div>
          <div id="list-text"></div>
        </div>
      </div>
      <ul aria-label="" class="mt-3" id="pagination-text"></ul>
    </div>    
  </div>
  <div class="col-6">
    <div class="m-2">
      <div id="detail-text" class="border rounded bg-white p-3"><em>Please select a text from the list to show its detail information.</em></div>
    </div>
  </div>
</div>
<footer></footer>


<div id="text-dialog" class="card d-none">
  <h6 class="card-header d-flex">
    <span class="drag-handle flex-fill"><i class="dialog-icon bi bi-eye-fill me-2"></i> <span class="dialog-title">New Text</span></span>
    <i class="bi bi-x-lg bt-close bt-x" role="button"></i>
  </h6>
  <div class="card-body d-flex flex-column">
    <form class="row form-text g-3 needs-validation flex-fill" novalidate>
      <div class="col mt-0 d-flex flex-column">
        <input type="text" class="form-control mb-2" id="input-title" placeholder="Text Title" required>
        <div class="invalid-feedback mb-2">
          Please provide a title for the text.
        </div>
        <textarea id="stacks-editor" class="flex-fill">

GitHub Flavored Markdown
========================

Everything from markdown plus GFM features:

## URL autolinking

Underscores_are_allowed_between_words.

## Strikethrough text

GFM adds syntax to strikethrough text, which is missing from standard Markdown.

~~Mistaken text.~~
~~**works with other formatting**~~

~~spans across
lines~~

## Fenced code blocks (and syntax highlighting)

```javascript
for (var i = 0; i < items.length; i++) {
    console.log(items[i], i); // log them
}
```

## Task Lists

- [ ] Incomplete task list item
- [x] **Completed** task list item

## A bit of GitHub spice

See http://github.github.com/github-flavored-markdown/.

(Set `gitHubSpice: false` in mode options to disable):

* SHA: be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2
* User@SHA ref: mojombo@be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2
* User/Project@SHA: mojombo/god@be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2
* \#Num: #1
* User/#Num: mojombo#1
* User/Project#Num: mojombo/god#1

(Set `emoji: false` in mode options to disable):

* emoji: :smile:

````javascript
class Hello {
	constructor() {
	  int x = 0;
		Makan.dame();
	}
}
````


        </textarea>
      </div>
    </form>
  </div>
  <div class="card-footer text-end">
    <button class="btn btn-sm btn-secondary bt-close px-4"><?php echo Lang::l('cancel'); ?></button>
    <button class="btn btn-sm btn-primary bt-ok px-4 ms-1"><?php echo Lang::l('ok'); ?></button>
    <button class="btn btn-sm resize-handle"><i class="bi bi-arrows-angle-expand"></i></button>
  </div>
</div>


<div id="nlp-dialog" class="card d-none">
  <h6 class="card-header d-flex">
    <span class="drag-handle flex-fill"><i class="dialog-icon bi bi-eye-fill me-2"></i> <span class="dialog-title">NLP Data</span></span>
    <i class="bi bi-x-lg bt-close bt-x" role="button"></i>
  </h6>
  <div class="card-body d-flex flex-column">
    <form class="row form-nlp g-3 needs-validation flex-fill" novalidate>
      <textarea id="input-nlp" class="flex-fill border rounded mx-1 font-monospace"></textarea>
    </form>
  </div>
  <div class="card-footer text-end">
    <button class="btn btn-sm btn-secondary bt-close px-4"><?php echo Lang::l('cancel'); ?></button>
    <button class="btn btn-sm btn-primary bt-ok px-4 ms-1"><?php echo Lang::l('ok'); ?></button>
    <button class="btn btn-sm resize-handle"><i class="bi bi-arrows-angle-expand"></i></button>
  </div>
</div>


<!-- 20241203ここから -->
<div id="candidate-dialog" class="card d-none">
  <h6 class="card-header d-flex">
    <span class="drag-handle flex-fill">
      <span class="dialog-title text-small"><small>Manage Candidates</small></span>
    </span>
    <i class="bi bi-x-lg bt-close bt-x" role="button"></i>
  </h6>
  <div class="card-body container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="m-1">
          <div id="manual-add" class="card">
            <div class="card-body bg-white">
              <div style="font-size: .875rem;">
                <h6>Manual Add</h6>
                <form class="form-manual-add">
                  <input type="text" value="" class="input-candidate form-control" placeholder="New Candidate" aria-label="New Candidate">
                </form>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <a class="bt-ok btn btn-sm btn-primary m-2" style="min-width: 5rem">OK</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="m-1">
          <div id="upload-csv" class="card">
            <div class="card-body bg-white">
              <div style="font-size: .875rem;">
                <h6>Batch Add</h6>
                <div class="btn-group btn-group-sm">
                  <a class="btn btn-sm btn-secondary bt-download-file" href="<?php echo $this->file('module/content/file/label-candidates.csv'); ?>"><i class="bi bi-download"></i> Download CSV Template File</a>
                </div>
                <hr>
                <form name="form-upload-csv">
                  <div class="input-group input-group-sm">
                    <div>
                      <input class="form-control form-control-sm" name="csv" id="csv-file" type="file">
                    </div>
                    <button class="btn btn-primary btn-sm bt-upload-file mt-2"><i class="bi bi-upload"></i> Begin Upload </button>
                  </div>
                </form>
                <div class="batch-result card-body"></div> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="m-1">
          <div id="manage-candidates" class="card">
            <div class="card-body bg-white">
              <form class="form-manage-candidates g-3 needs-validation" novalidate>
                <div class="input-group input-group-sm mb-3">
                  <input type="text" name="keyword" class="form-control w-50 input-keyword" placeholder="Search keyword" aria-label="Keyword">
                  <select name="perpage" class="form-select flex-shrink-1 input-perpage">
                    <option value="1">1</option>
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                  </select>
                  <button class="btn btn-secondary bt-search2"><i class="bi bi-search"></i></button>
                </div>
                <div class="list-candidate scroll-y" style="max-height:200px;"></div>
                <div class="my-2">
                  <span class="badge rounded-pill bg-warning text-dark me-3 bt-toggle-select" role="button">Select/unselect all</span>
                  <small>With selected:</small> <span class="badge rounded-pill bg-danger ms-1 bt-delete-selected" role="button">Delete</span>
                </div>
                <div class="list-candidate-pagination pagination text-center mt-4"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer text-end">
    <button class="btn btn-sm btn-secondary bt-cancel bt-close px-3"><?php echo Lang::l('ok'); ?></button>
  </div>
</div> 
<!-- 20241203ここ -->