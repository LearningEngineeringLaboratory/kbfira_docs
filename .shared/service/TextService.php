<?php

class TextService extends CoreService {

  function getTextList() {
    $db = self::instance();
    $qb = QB::instance('text')->select();
    return $db->query($qb->get());
  }

  function insertText($title, $type = 'markdown', $content = null, $nlp = null, $data = null) {
    $db = self::instance();
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
    $db = self::instance();
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
    $db = self::instance();
    $update['nlp'] = QB::esc($nlp);
    $qb = QB::instance('text')->update($update)->where('tid', $tid);
    $db->query($qb->get());
    return $this->selectText($tid);
  }

  function selectText($tid) {
    $db = self::instance();
    $qb = QB::instance('text')->select()
      ->where('tid', QB::esc($tid));
    return $db->getRow($qb->get());
  }

  function getTexts($keyword = '', $page = 1, $perpage = 10) {
    $db = self::instance();
    $qb = QB::instance('text')->select()
      ->where('title', 'LIKE', "%$keyword%")
      ->orderBy('created', QB::DESC)
      ->limit(($page-1)*$perpage, $perpage);
    return $db->query($qb->get());
  }

  function getTextsCount($keyword = '') {
    $db = self::instance();
    $qb = QB::instance('text')->select(QB::raw('COUNT(*) AS count'))
      ->where('title', 'LIKE', "%$keyword%")
      ->orderBy('created', QB::DESC);
    return $db->getVar($qb->get());
  }

  function deleteText($tid) {
    $db = self::instance();
    $qb = QB::instance('text')->delete()
      ->where('tid', QB::esc($tid));
    return $db->query($qb->get());
  }





  function getTextOfKit($kid) {
    $db = self::instance();
    $qb = QB::instance('text')->select()
      ->where('tid', QB::raw("(SELECT text FROM kit WHERE kid = '".QB::esc($kid)."')"));
    return $db->getRow($qb->get());
  }

  function getTextOfKitConceptMapTopic($kid) {
    $db = self::instance();
    $sqb = QB::instance('kit k')->select('c.topic')
      ->leftJoin('conceptmap c', 'c.cmid', 'k.cmid')
      ->where('k.kid', QB::esc($kid))->limit(1);
    $tqb = QB::instance('topic')->select('text')
      ->where('tid', QB::raw(QB::OG . $sqb->get() . QB::EG));
    $qb = QB::instance('text')->select()
    ->where('tid', QB::raw(QB::OG . $tqb->get() . QB::EG));
    return $db->getRow($qb->get());
  }

//   function getSelectAndFillInList($tid) {
//       try {
//           $db = self::instance();
//           $result = $db->query("SELECT * FROM list_label WHERE tid=$tid");
//           return $result;
//       } catch (Exception $ex) {
//           throw CoreError::instance($ex->getMessage());
//       }
// }

//20241204ここから
function getAllCandidates() {
  try {
      $db = self::instance();
      $result = $db->query("SELECT list FROM list_label");
      return $result;
  } catch (Exception $ex) {
      throw CoreError::instance($ex->getMessage());
  }
}
//20241204ここまで

//20241203ここから
function getCandidate($tid) {
  try {
      $db = self::instance();
      $result = $db->query("SELECT * FROM list_label WHERE tid=$tid");
      return $result;
  } catch (Exception $ex) {
      throw CoreError::instance($ex->getMessage());
  }
}



function addCandidate($tid, $list) {
  try {
      $db = self::instance();
      
      // $listをUTF-8に変換
      //$list = mb_convert_encoding($list, 'UTF-8', 'auto');
      
      $result = $db->query("INSERT INTO list_label(tid, list) values($tid, '$list')");
      return $result;
  } catch (Exception $ex) {
      throw CoreError::instance($ex->getMessage());
  }
}



function getCandidatesPerPage($tid, $keyword, $page, $perpage) {
  try {
      $db = self::instance();
      $limit_start = ($page-1)*$perpage;
      $result = $db->query("SELECT * FROM list_label WHERE tid=$tid AND list LIKE '%$keyword%' LIMIT $limit_start, $perpage");
      return $result;
  } catch (Exception $ex) {
      throw CoreError::instance($ex->getMessage());
  }
}

function getCandidatesCount($tid, $keyword = '') {
  try {
      $db = self::instance();
      $result = $db->query("SELECT COUNT(list) AS count FROM list_label WHERE tid=$tid AND list LIKE '%$keyword%'");
      return $result[0];
  } catch (Exception $ex) {
      throw CoreError::instance($ex->getMessage());
  }
}

//20241203ここまで
}