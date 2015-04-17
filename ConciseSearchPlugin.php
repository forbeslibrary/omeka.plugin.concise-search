<?php

class ConciseSearchPlugin extends Omeka_Plugin_AbstractPlugin {
  protected $_filters = array(
    'item_types_select_options',
    'elements_select_options'
  );

  /**
   * Returns an array of item-type id-name pairs suitable for use with
   * select() in html forms. Only item-types in use will be returned.
   */
  function filterItemTypesSelectOptions() {
    $db = get_db();
    $select = $db->select(
      )->distinct(
      )->from(
        array('T' => $db->prefix . 'item_types'),
        array('id', 'name')
      )->join(
        array('I' => $db->prefix . 'items'),
        'T.id=I.item_type_id', array()
      )->where(
        current_user() ? '1=1' : 'I.public'
      ) ;
    $pairs = $db->fetchPairs($select);
    asort($pairs);
    return $pairs;
  }

  /**
   * Removes elements that are not used from the select
   */
  function filterElementsSelectOptions( $elementSets ) {
    $db = get_db();
    $select = $db->select(
      )->distinct(
      )->from(
        array('E' => $db->prefix . 'elements'),
        array('id', 'name')
      )->join(
        array('T' => $db->prefix . 'element_texts'),
        'E.id=T.element_id', array()
      )->join(
        array('I' => $db->prefix . 'items'),
        'T.record_id=I.id'
      )->where(
        'T.record_type = "Item"'
      )->where(
        current_user() ? '1=1' : 'I.public'
      );
    $pairs = $db->fetchPairs($select);
    foreach ($elementSets as $setKey => $elements) {
      foreach ($elements as $elementKey => $element) {
        if (!isset($pairs[$elementKey])) {
          unset($elementSets[$setKey][$elementKey]);
        }
      }
    }
    return $elementSets;
  }
}
