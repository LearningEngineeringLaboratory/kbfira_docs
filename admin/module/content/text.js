class CoreEditor {
  constructor(elementId, options) {
    var editor = CodeMirror.fromTextArea(document.getElementById(elementId), {
      mode: {
        name: "gfm",
        tokenTypeOverrides: {
          emoji: "emoji"
        }
      },
      lineNumbers: false,
      // theme: "default"
    });
    let toolbar = `<div class="border rounded-top p-1 mt-2 bg-light">`
    toolbar += `<div class="btn-group btn-group-sm">`
    toolbar += `<button class="btn"><i class="bi bi-type-bold"></i></button>`
    toolbar += `<button class="btn"><i class="bi bi-type-italic"></i></button>`
    toolbar += `<button class="btn"><i class="bi bi-type-underline"></i></button>`
    toolbar += `<button class="btn"><i class="bi bi-code"></i></button>`
    toolbar += `<button class="btn"><i class="bi bi-blockquote"></i></button>`
    toolbar += `</div>`
    toolbar += `</div>`
    $('#CodeMirror-wrapper').remove()
    $('.CodeMirror').wrap('<div id="CodeMirror-wrapper" class="wrapper flex-fill d-flex flex-column"></div>')
      .addClass('flex-fill border rounded-bottom').css('height', 100)
    $('#CodeMirror-wrapper').prepend(toolbar)
    $('.CodeMirror-scroll').css('min-height', 100)
  }
  static instance(element, options) {
    return new CoreEditor(element, options)
  }
}

class TextApp {
  constructor(options) {
    this.settings = Object.assign({}, options)
    this.handleEvent();
  }
  static instance(options) {
    return new TextApp(options)
  }
  handleEvent() {

    this.ajax = Core.instance().ajax();
    this.pagination = {
      page: 1,
      maxpage: 1,
      perpage: 1,
      count: 0,
      keyword: null
    }

    let textDialog = UI.modal('#text-dialog', {
      hideElement: '.bt-close',
      backdrop: false,
      draggable: true,
      dragHandle: '.drag-handle',
      resizable: true,
      resizeHandle: '.resize-handle',
      width: '550px',
      minHeight: 100,
      minWidth: 300,
      height: 500,
      onShow: () => {
        if (!textDialog.simplemde) {
          textDialog.simplemde = new SimpleMDE({
            toolbar: ["bold", "italic", "heading", "|", "quote", "code", "unordered-list", "ordered-list", "|", "horizontal-rule", "link", "image", "|", "preview", "side-by-side", "fullscreen", "|", "guide"],
            renderingConfig: {
              singleLineBreaks: false,
              codeSyntaxHighlighting: true,
            },
          });
          $('.CodeMirror').addClass('flex-fill border rounded-bottom').css('height', 100).css('min-height', 100)
          $('.CodeMirror-scroll').css('min-height', 100)
          $('.editor-toolbar').addClass('bg-light')
          textDialog.resize.minHeight = $('#text-dialog').outerHeight() - 110
        }
        if (textDialog.text) textDialog.simplemde.value(textDialog.text.content);
        else textDialog.simplemde.value('')
      }
    })
    textDialog.setText = (text) => {
      textDialog.text = text;
      $('#text-dialog .dialog-title').html('Edit Text');
      $('#input-title').val(text.title);
      // textDialog.simplemde.value(text.content);
      return textDialog
    }

    let nlpDialog = UI.modal('#nlp-dialog', {
      hideElement: '.bt-close',
      backdrop: false,
      draggable: true,
      dragHandle: '.drag-handle',
      resizable: true,
      resizeHandle: '.resize-handle',
      width: '550px',
      minHeight: 100,
      minWidth: 300,
      height: 500,
      onShow: () => {}
    })
    nlpDialog.setText = (text) => {
      nlpDialog.text = text;
      $('#nlp-dialog .dialog-title').html('NLP Data');
      $('#input-nlp').val(text.nlp);
      return nlpDialog
    }


    $('.bt-list-text').on('click', () => {
      
    })
    $('.bt-new').on('click', (e) => {
      textDialog.text = null;
      $('#text-dialog .dialog-title').html('New Text');
      $('#input-title').val('');
      textDialog.show()
    })


    $('#form-search-text').on('submit', (e) => {
      e.preventDefault();
      e.stopPropagation();
      let perpage = $('#form-search-text .input-perpage').val();
      let keyword = $('#form-search-text .input-keyword').val();

      if (!TextApp.pagination) {
        TextApp.pagination = Pagination.instance('#pagination-text', 1, perpage)
          .listen('#form-search-text').update();
          TextApp.pagination.keyword = keyword;
      }

      if (keyword != TextApp.pagination.keyword) TextApp.pagination.page = 1
      TextApp.pagination.keyword = keyword;
      TextApp.pagination.perpage = perpage;
      
      Promise.all([
        this.ajax.post(`contentApi/getTexts/${TextApp.pagination.page}/${TextApp.pagination.perpage}`, {
          keyword: keyword
        }),
        this.ajax.post(`contentApi/getTextsCount`, {
          keyword: keyword
        })
      ]).then(results => {
        let [texts, count] = results;
        TextApp.pagination.count = count
        TextApp.pagination.update(count, perpage);
        TextApp.populateTexts(texts);
      });
    })

    $('#text-dialog form.form-text').on('submit', (e) => {
      e.preventDefault();
      e.stopPropagation();
      $('#text-dialog form.form-text').addClass('was-validated')
      let title = $('#input-title').val().trim();
      let content = textDialog.simplemde.value()
      if (!title.length) return
      if (!textDialog.text) {
        this.ajax.post('contentApi/createText', {
          title: title,
          content: content,
        }).then(text => { // console.warn(text)
          textDialog.hide();
          UI.success('Text created successfully.').show()
          $('.bt-search').trigger('click')
        }).catch(error => UI.error(error).show())
      } else {
        this.ajax.post('contentApi/updateText', {
          tid: textDialog.text.tid,
          title: title,
          content: content,
        }).then(text => { // console.warn(text)
          textDialog.hide();
          UI.success('Text updated successfully.').show()
          $('.bt-search').trigger('click')
        }).catch(error => UI.error(error).show())
      }
    })
    $('#text-dialog .bt-generate-tid').on('click', (e) => {
      e.preventDefault()
      e.stopPropagation()
      $('#input-tid').val($('#input-title').val().replace(/\s/g, '').substring(0, 20).trim().toUpperCase())
    })
    $('#text-dialog').on('click', '.bt-ok', (e) => {
      $('#text-dialog form.form-text').trigger('submit')
    })







    $('#list-text').on('click', '.bt-edit', (e) => {
      let tid = $(e.currentTarget).parents('.text-item').attr('data-tid')
      this.ajax.get(`contentApi/getText/${tid}`).then(text => {
        textDialog.setText(text).show()
      })
    })

    $('#list-text').on('click', '.bt-delete', (e) => {
      let tid = $(e.currentTarget).parents('.text-item').attr('data-tid')
      let title = $(e.currentTarget).parents('.text-item').attr('data-title')
      let confirm = UI.confirm(`Do you want to <span class="text-danger">DELETE</span> this text?<br><span class="text-primary">"${title}"</span>`).positive(() => {
        this.ajax.post(`contentApi/deleteText/`, { tid: tid }).then(result => {
          UI.success('Selected text has been deleted successfully.').show()
          confirm.hide()
          $(e.currentTarget).parents('.text-item').slideUp('fast', () => {
            $(e.currentTarget).parents('.text-item').remove()
          })
        })
      }).show()
    })

    $('#list-text').on('click', '.bt-detail', (e) => {
      let tid = $(e.currentTarget).parents('.text-item').attr('data-tid')
      this.ajax.get(`contentApi/getTextDetail/${tid}`).then(text => {
        TextApp.populateTextDetail(text)
      })
    })

//20241203ここから 

    /**
     * form-manage-candidatesフォーム（bt-searchを含んでいるフォーム）が送信された際に発火する関数．DBに登録されている候補のうち，現在注目しているテキストに対応するものを取得した後，populateManageCandidates()によってそれらのHTMLをページごとに生成し，アイアログ内に表示する．
     * @param {e} e 現在発火しているclickイベント
     * @todo Paginationクラスについて勉強してコメントを入れる
     */
    $('form.form-manage-candidates').on('submit', (e) => {
      e.preventDefault();
      e.stopPropagation(); // 親要素へのイベントの伝播を停止

      let perpage = parseInt($('form.form-manage-candidates .input-perpage').val());
      let keyword = $('form.form-manage-candidates .input-keyword').val();

      console.log(TextApp.manageCandidatesPagination);
      if (!TextApp.manageCandidatesPagination) {
        TextApp.manageCandidatesPagination = Pagination.instance('form.form-manage-candidates .list-candidate-pagination', 1, perpage);
        TextApp.manageCandidatesPagination.update(1, perpage).keyword = keyword;
        TextApp.manageCandidatesPagination.listen('form.form-manage-candidates');
      }

      let page = TextApp.manageCandidatesPagination.page;
      if (keyword != TextApp.manageCandidatesPagination.keyword) {
        page = 1;
        TextApp.manageCandidatesPagination.page;
      }

      Promise.all([
        //console.log(candidateDialog.tid, page, perpage),
        this.ajax.post(`contentApi/getCandidatesPerPage/${candidateDialog.tid}/${page}/${perpage}`, {
          keyword: keyword
        }), 
        this.ajax.post(`contentApi/getCandidatesCount/${candidateDialog.tid}`, {
          keyword: keyword
        })])
      .then(results => {
        let [candidates_object, count] = results;
        //let [count, candidates_object] = results;
        console.log(results);
        console.log(candidates_object);
        console.log(count);
        let candidates = [];
        candidates_object.forEach((candidate_object) => {
          candidates.push(candidate_object.list);
          console.log();
        });
        console.log(candidates);
        TextApp.populateManageCandidates(candidates, candidateDialog.tid);
        TextApp.manageCandidatesPagination.page = page;
        TextApp.manageCandidatesPagination.update(count, perpage).keyword = keyword;  
      });

    });

    /**
     * バグが追加された部品のラベルを修正する際のautocompleteの候補を管理するためのダイアログ
     * @type {Modal}
     * @memberof TextApp#
     */
    let candidateDialog = UI.modal('#candidate-dialog', {
      hideElement: '.bt-close',
      width: '1200px',
    });

    /**
     * list-text（テキストのリスト）内のbt-candidate（緑のボタン）が押された際に発火する関数．candidate-dialogを表示する．
     * @param {e} e 現在発火しているclickイベント
     */
    $('#list-text').on('click', '.bt-candidate', (e) => {
      let tid = $(e.currentTarget).parents('.text-item').attr('data-tid');
      console.warn(tid);
      candidateDialog.tid = tid;
      //$('form.form-manage-candidates').trigger('submit'); // ダイアログが開く前に予め候補のリストを表示させておく
      candidateDialog.show();
    })

    $('#candidate-dialog .bt-ok').on('click', (e) => {
      // console.warn(candidateDialog.tid);

      let candidate = $('.input-candidate').val();
      let candidates = [];
      
      if (candidate != '') {
        this.ajax.get(`contentApi/getCandidate/${candidateDialog.tid}`).then(candidates_object => {
            candidates_object.forEach((candidate_object) => {
              candidates.push(candidate_object.candidate);
          });
          console.log(candidates);
        }).then(() => {
          if (candidates.includes(candidate)) {
            UI.error('The candidate you entered has already been registered.').show();
          }
          else {
            this.ajax.post(`ContentApi/addCandidate/${candidateDialog.tid}/${candidate}`).then(() => {
              UI.success('Candidate has been saved successfully.').show();
              $('.input-candidate').val('');
              $('form.form-manage-candidates').trigger('submit'); // ダイアログ右側の候補のリストを更新
            });
          }
        }).catch(error => { UI.error(error).show(); });
      }
    })
    
//ここまで






    $('#list-text').on('click', '.bt-nlp', (e) => {
      let tid = $(e.currentTarget).parents('.text-item').attr('data-tid')
      this.ajax.get(`contentApi/getText/${tid}`).then(text => {
        nlpDialog.setText(text).show()
      })
    })
    $('#nlp-dialog form.form-nlp').on('submit', (e) => {
      e.preventDefault()
      e.stopPropagation()
      $('#nlp-dialog form.form-nlp').addClass('was-validated')
      let nlp = $('#input-nlp').val().trim();
      if (!nlpDialog.text) return
      this.ajax.post('contentApi/updateTextNlp', {
        tid: nlpDialog.text.tid,
        nlp: nlp,
      }).then(nlp => { // console.warn(text)
        nlpDialog.hide();
        UI.success('NLP data has been updated.').show()
      }).catch(error => UI.error(error).show())
    })
    $('#nlp-dialog').on('click', '.bt-ok', (e) => {
      $('#nlp-dialog form.form-nlp').trigger('submit')
    })

    $('.bt-search').trigger('click')

  }
}

TextApp.populateTexts = texts => {
  let textsHtml = '';
  texts.forEach(text => {
    textsHtml += `<div class="text-item d-flex align-items-center py-1 border-bottom" role="button"`
    textsHtml += `  data-tid="${text.tid}" data-title="${text.title}">`
    textsHtml += `  <span class="flex-fill ps-2 text-truncate text-nowrap">${text.title}</span>`
    textsHtml += `  <span class="text-end text-nowrap ms-3">`
    textsHtml += `    <button class="btn btn-sm btn-secondary bt-detail"><i class="bi bi-journal-text"></i></button>`
    textsHtml += `    <button class="btn btn-sm btn-primary bt-nlp">AI</button>`
    textsHtml += `    <button class="btn btn-sm btn-warning bt-edit"><i class="bi bi-pencil"></i></button>`
    textsHtml += `    <button class="btn btn-sm btn-success bt-candidate"><i class="bi bi-list-ul"></i></button>`
    textsHtml += `    <button class="btn btn-sm btn-danger bt-delete"><i class="bi bi-trash"></i></button>`
    textsHtml += `  </span>`
    textsHtml += `</div>`
  });
  if (textsHtml.length == 0) textsHtml = '<em class="d-block m-3 text-muted">No texts found in current search.</em>';
  $('#list-text').html(textsHtml)
}

// TextApp.populatePagination = (count, page, perpage) => {
//   let paginationHtml = ''
//   let maxpage = Math.ceil(count/perpage);
//   console.log(count, page, maxpage)
//   if (count) {
//     paginationHtml += `<li class="page-item${page == 1 ? ' disabled': ''}">`
//     paginationHtml += `  <a class="page-link pagination-prev" href="#" tabindex="-1" aria-disabled="true">Previous</a>`
//     paginationHtml += `</li>`

//     let min = page - 2 < 1 ? 1 : page - 2
//     let max = page + 2 > maxpage ? maxpage : page + 2

//     for(let p = min; p <= max; p++) {
//       paginationHtml += `<li class="page-item${page == p ? ' disabled': ''}"><a class="page-link pagination-page" data-page="${p}" href="#">${p}</a></li>`
//     }

//     paginationHtml += `<li class="page-item${page == maxpage ? ' disabled': ''}">`
//     paginationHtml += `  <a class="page-link pagination-next" href="#">Next</a>`
//     paginationHtml += `</li>`
//   }
//   $('#pagination-text').html(paginationHtml)
// }

TextApp.populateTextDetail = text => {
  let textDetailHtml = '';

  let content = text.content 
    ? new showdown.Converter({}).makeHtml(text.content) 
    : '<em class="text-muted">This text has no content.</em>'

  textDetailHtml += `<span class="text-title h4 text-primary">${text.title}</span>`
  textDetailHtml += `<div class="align-middle"><span class="badge rounded-pill bg-warning text-dark px-3">ID ${text.tid}</span>`
  textDetailHtml += ` <span class="badge rounded-pill bg-secondary mx-1 px-3">${text.created}</span></div>`
  textDetailHtml += `<hr>`
  // textDetailHtml += `<span class="d-block"><span class="text-primary">3 concept maps</span> were associated to this text.</span>`
  // textDetailHtml += `<span class="d-block">This text has text: <span class="text-primary">This is the title of the text.</span></span>`
  // textDetailHtml += `<div class="mt-4">Attached data: <span class="badge rounded-pill bg-primary mx-2" role="button">Attach</span></div>`
  textDetailHtml += `<div class="border rounded p-2 my-2 bg-light scroll-y" style="max-height: 300px">`
  textDetailHtml += `  <div>${content}</div>`
  textDetailHtml += `</div>`
  textDetailHtml += `<div class="border rounded p-2 my-2 bg-light scroll-y" style="max-height: 300px">`
  textDetailHtml += `  <code>${text.nlp ? text.nlp : '<span class="text-muted">This text has no NLP data.</span>'}</code>`
  textDetailHtml += `</div>`
  textDetailHtml += `<div class="border rounded p-2 my-2 bg-light">`
  textDetailHtml += `  <code>${text.data ? text.data : 'This text has no attachment data.'}</code>`
  textDetailHtml += `</div>`


  $('#detail-text').html(textDetailHtml)
  hljs.highlightAll();

}

TextApp.populateManageCandidates = (candidates, tid) => {
  let candidatesHtml = '';
  candidates.forEach(candidate => {
    candidatesHtml += `<div class="item-candidate d-flex align-items-center py-1 border-bottom" role="button"`
    candidatesHtml += `  data-candidatename="${candidate}" data-tid="${tid}" style="min-width:0">`
    candidatesHtml += `  <input type="checkbox" data-candidatename="${candidate}" data-tid="${tid}">`
    candidatesHtml += `  <span class="flex-fill ps-2 d-flex align-items-center">`
    candidatesHtml += `  <span class="candidate-truncate" style="min-width:0">${candidate}`
    candidatesHtml += `  </span>`
    candidatesHtml += `  </span>`
    candidatesHtml += `  <span class="badge rounded-pill bg-danger bt-delete-candidate"><i class="bi bi-trash"></i></span>`
    candidatesHtml += `</div>`
  });
  if (candidatesHtml.length == 0) candidatesHtml = '<em class="d-block m-3 candidate-muted">No candidates found in current search.</em>';
  $('form.form-manage-candidates .list-candidate').html(candidatesHtml)
  //$('form.form-manage-candidates .ここを変える').html(candidatesHtml)
}

$(() => {
  let app = TextApp.instance()
})