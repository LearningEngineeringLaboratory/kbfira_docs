<?php

class TextService extends CoreService {

  function getTextList() {
    $db = self::instance('kbv2');
    $qb = QB::instance('text')->select();
    return $db->query($qb->get());
  }

  function insertText($title, $type = 'markdown', $content = null, $nlp = null, $data = null) {
    $db = self::instance('kbv2');
    $insert['title']   = QB::esc($title);
    $insert['type']    = QB::esc($type);
    $insert['content'] = QB::esc($content);
    $insert['nlp']     = QB::esc($nlp);
    $insert['data']    = QB::esc($data);
    $qb = QB::instance('text')->insert($insert);
    $db->query($qb->get());
    $tid = $db->getInsertId();
    return $this->selectText($tid);
  }

  function updateText($tid, $title, $type = 'markdown', $content = null, $nlp = null, $data = null) {
    $db = self::instance('kbv2');
    $update['title']   = QB::esc($title);
    $update['type']    = QB::esc($type);
    $update['content'] = QB::esc($content);
    $update['nlp']     = QB::esc($nlp);
    $update['data']    = QB::esc($data);
    $qb = QB::instance('text')->update($update)->where('tid', $tid);
    $db->query($qb->get());
    return $this->selectText($tid);
  }

  function updateTextNlp($tid, $nlp = null) {
    $db = self::instance('kbv2');
    $update['nlp'] = QB::esc($nlp);
    $qb = QB::instance('text')->update($update)->where('tid', $tid);
    $db->query($qb->get());
    return $this->selectText($tid);
  }

  function selectText($tid) {
    $db = self::instance('kbv2');
    $qb = QB::instance('text')->select()
      ->where('tid', QB::esc($tid));
    return $db->getRow($qb->get());
  }

  function getTexts($keyword = '', $page = 1, $perpage = 10) {
    $db = self::instance('kbv2');
    $qb = QB::instance('text')->select()
      ->where('title', 'LIKE', "%$keyword%")
      ->orderBy('created', QB::DESC)
      ->limit(($page-1)*$perpage, $perpage);
    return $db->query($qb->get());
  }

  function getTextsCount($keyword = '') {
    $db = self::instance('kbv2');
    $qb = QB::instance('text')->select(QB::raw('COUNT(*) AS count'))
      ->where('title', 'LIKE', "%$keyword%")
      ->orderBy('created', QB::DESC);
    return $db->getVar($qb->get());
  }

  function deleteText($tid) {
    $db = self::instance('kbv2');
    $qb = QB::instance('text')->delete()
      ->where('tid', QB::esc($tid));
    return $db->query($qb->get());
  }

}