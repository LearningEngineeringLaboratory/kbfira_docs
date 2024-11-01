<div class="d-flex flex-column vh-100">
  <a class="position-absolute d-flex align-items-center text-white px-3 text-decoration-none" href="<?php echo $this->location('../home'); ?>">
    <i class="bi bi-house pe-2" style="font-size: 1.8rem;"></i> <span>ホーム</span>
  </a>
  <div class="app-navbar d-flex p-2 ps-4" style="border-left: 125px solid #698EFF;">
    <button class="bt-open-kit btn btn-sm btn-primary"><i class="bi bi-folder2-open"></i> キットを開く</button>
    <!-- <div class="btn-group btn-group-sm ms-2" id="recompose-readcontent">
      <button class="bt-content btn btn-sm btn-secondary"><i class="bi bi-file-text-fill"></i> 教材を読む</button>
    </div> -->
    <!-- <div class="btn-group btn-group-sm ms-2" id="recompose-saveload">
      <button class="bt-save btn btn-secondary"><i class="bi bi-download"></i> セーブ</button>
      <button class="bt-load btn btn-secondary"><i class="bi bi-upload"></i> ロード</button>
    </div> -->
    <!-- <div class="btn-group btn-group-sm ms-2" id="recompose-reset">
      <button class="bt-reset btn btn-danger"><i class="bi bi-arrow-counterclockwise"></i> リセット</button>
    </div> -->
    <div class="btn-group btn-group-sm ms-2" id="recompose-feedbacklevel">
      <button class="bt-feedback btn btn-warning"><i class="bi bi-eye-fill"></i> フィードバック <span class="count"></span></button>
      <button class="bt-clear-feedback btn btn-warning"><i class="bi bi-eye-slash-fill"></i> フィードバックを消す</button>
    </div>
    <div class="btn-group btn-group-sm ms-2">
      <button class="bt-submit btn btn-danger"><i class="bi bi-send"></i> マップ提出 <span class="count"></span></button>
    </div>
    <div class="flex-fill">&nbsp;</div>
    <span>
      <div class="btn-group btn-group-sm">
        <!-- <button class="btn btn-outline-secondary btn-sm dropdown-toggle bt-profile <?php if (!isset($_SESSION['user'])) echo 'd-none'; ?>" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-people-fill"></i>
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item cgpass fs-6 text-sm" href="#"><i class="bi bi-lock-fill"></i> パスワード変更</a></li>
        </ul> -->
        <button class="btn btn-danger btn-sm bt-logout <?php if (!isset($_SESSION['user'])) echo 'd-none'; ?>"><i class="bi bi-power"></i> ログアウト</button>
      </div>
      <button class="btn btn-primary btn-sm bt-sign-in <?php if (isset($_SESSION['user'])) echo 'd-none'; ?>"><i class="bi bi-power"></i> サインイン</button>
    </span>
  </div>
  <div class="d-flex flex-fill align-items-stretch p-2">
    <?php $this->pluginView('kitbuild-ui', ["id" => "recompose-canvas"], 0); ?>
  </div>
  <div class="d-flex">
    <div class="status-panel flex-fill m-2 mt-0 d-flex" style="overflow-x: auto"></div>
    <!-- <div class="status-control text-end m-2 mt-0"><button class="btn btn-primary btn-sm opacity-0">&nbsp;</button></div> -->
  </div>
</div>
    
<form id="concept-map-open-dialog" class="card d-none">
  <h6 class="card-header"><i class="bi bi-folder2-open"></i> キットを開く</h6>
  <div class="card-body">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="database" role="tabpanel" aria-labelledby="database-tab">
        <div class="row gx-2 mb-1">
          <div class="col d-flex text-center text-primary">
            <span class="border-bottom px-2 py-1 flex-fill position-relative">トピック</span></div>
          <div class="col d-flex text-center text-primary">
            <span class="border-bottom px-2 py-1 flex-fill position-relative">マップ</span></div>
          <div class="col d-flex text-center text-primary">
            <span class="border-bottom px-2 py-1 flex-fill position-relative">キット</span></div>
        </div>
        <div class="row gx-2 mb-3">
          <div class="col list list-topic">
            <!-- <span class="topic list-item default" data-tid="">
              <em>Unassigned</em><bi class="bi bi-check-lg text-primary"></bi>
            </span> -->
          </div>
          <div class="col list list-concept-map"></div>
          <div class="col list list-kit"></div>
        </div>
        <div class="badge rounded-pill bg-secondary bt-refresh-topic-list px-3" role="button">トピック一覧の更新</div>
      </div>
      <div class="tab-pane fade" id="decode" role="tabpanel" aria-labelledby="decode-tab">
        <div class="mb-3">
          <label for="decode-textarea" class="form-label">マップのデータ</label>
          <textarea class="form-control" id="decode-textarea" rows="4"></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="row">
      <div class="col text-end">
        <button class="bt-cancel btn btn-sm btn-secondary" style="min-width: 6rem;">キャンセル</button>
        <!-- <button class="bt-continue btn btn-sm btn-success ms-1 ps-3 pe-3" style="min-width: 6rem;">
          <i class="bi bi-upload"></i> 以前のマップ組み立てを再開</button> -->
        <button class="bt-open btn btn-sm btn-primary ms-1" style="min-width: 6rem;">
          <i class="bi bi-folder2-open"></i> 開く</button>
      </div>
    </div>
  </div>
</form>

<div id="kit-export-dialog" class="card d-none">
  <h6 class="card-header"><i class="bi bi-send"></i> エクスポート</h6>
  <div class="card-body">
    <textarea class="form-control encoded-data" rows="5"></textarea>
  </div>
  <div class="card-footer text-end">
    <button class="btn btn-sm btn-secondary bt-cancel px-3">キャンセル</button>
    <button class="btn btn-sm btn-primary ms-1 bt-clipboard px-3"><i class="bi bi-clipboard"></i> クリップボードにコピー</button>
  </div>
</div>

<div id="kit-content-dialog" class="card d-none">
  <h6 class="card-header d-flex">
    <span class="drag-handle flex-fill"><i class="dialog-icon bi bi-file-text"></i> <span class="dialog-title">教材</span></span>
    <i class="bi bi-x-lg bt-close bt-x" role="button"></i>
  </h6>
  <div class="card-body position-relative overflow-hidden overflow-scroll d-flex flex-fill mb-3">
    <div class="content text-secondary"></div>
  </div>
  <div class="card-footer d-flex justify-content-between align-items-center">
    <span>
      <span class="bt-scroll-top btn btn-sm ms-1 btn-primary px-3"><i class="bi bi-chevron-bar-up"></i> 一番上に戻る</span>
      <span class="bt-scroll-more btn btn-sm ms-1 btn-primary px-3"><i class="bi bi-chevron-down"></i> スクロール</span>
    </span>
    <span>
      <button class="btn btn-sm btn-secondary bt-close px-3">閉じる</button>
      <button class="btn btn-sm resize-handle pe-0 ps-3"><i class="bi bi-textarea-resize"></i></button>
    </span>
  </div>
</div>

<div id="feedback-dialog" class="card d-none">
  <h6 class="card-header d-flex">
    <span class="drag-handle flex-fill"><i class="dialog-icon bi bi-eye-fill me-2"></i> <span class="dialog-title">フィードバック</span></span>
    <i class="bi bi-x-lg bt-close bt-x" role="button"></i>
  </h6>
  <div class="card-body">
    <div class="feedback-content"></div>
  </div>
  <div class="card-footer text-end">
    <!-- <button class="btn btn-sm btn-secondary bt-cancel bt-close px-3"><?php echo Lang::l('ok'); ?></button> -->
    <button class="btn btn-sm btn-primary bt-modify px-3 ms-1">OK</button>
  </div>
</div>

<div id="continue-dialog" class="card d-none">
  <h6 class="card-header d-flex">
    <span class="drag-handle flex-fill"><i class="dialog-icon bi bi-upload me-2"></i> <span class="dialog-title">以前のマップ組み立てを再開</span></span>
    <i class="bi bi-x-lg bt-close bt-x" role="button"></i>
  </h6>
  <div class="card-body">
    <div class="draft-content d-flex flex-column overflow-auto thin-scroll" style="min-height:0; max-height: 200px;"></div>
  </div>
  <div class="card-footer text-end">
    <button class="btn btn-sm btn-secondary bt-cancel bt-close px-3">キャンセル</button>
    <button class="btn btn-sm btn-primary bt-continue px-3 ms-1">再開</button>
  </div>
</div>

<div id="cgpass-dialog" class="card shadow mx-auto d-none">
  <div class="card-body">
    <h5 class="card-title">パスワード変更</h5>
    <h6 class="card-subtitle mb-2 text-username"><span class="text-secondary">ユーザ</span> &rsaquo; <span class="text-danger user-username"><?php echo isset($_SESSION['user']) ? $_SESSION['user']['username'] : ""; ?></span> &rsaquo; <span class="text-primary user-name"><?php echo isset($_SESSION['user']) ? $_SESSION['user']['name'] : ""; ?></span></h6>
    <hr>
    <form id="form-cgpass" class="text-left" class="needs-validation" novalidate>
      <input type="hidden" name="username" value="<?php echo  isset($_SESSION['user']) ? $_SESSION['user']['username'] : ""; ?>" />
      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="password0">現在のパスワード</label>
            <input type="password" class="form-control" id="password0" required>
            <div class="password0 invalid-feedback">
              現在のパスワードを入力してください。
            </div>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label for="password1">新しいパスワード</label>
            <input type="password" class="form-control" id="password1" required>
            <div class="password1 invalid-feedback">
              新しいパスワードを空欄にすることはできません。
            </div>
          </div>
          <div class="form-group mt-1">
            <label for="password2">新しいパスワード（確認）</label>
            <input type="password" class="form-control" id="password2" required>
            <div class="password2 invalid-feedback">
              確認のため、新しいパスワードをもう一度入力してください。
            </div>
          </div>
        </div>
      </div>
      <div class="text-end"><small class="text-danger">新しいパスワードは最低8文字の英数字である必要があります。</small></div>
      <hr>
      <div class="text-end">
        <button class="btn btn-secondary bt-close">キャンセル</button>
        <button type="submit" class="btn btn-primary ms-2 bt-cgpass">パスワード変更</button>
      </div>
    </form>
  </div>
</div>
