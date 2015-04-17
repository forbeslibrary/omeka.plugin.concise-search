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
  function filterElementsSelectOptions( $selectOptions ) {
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
    foreach ($selectOptions as $optionKey => $optionValue) {
      // For some Omeka installs $selectOptions will be made up of nested arrays
      // If this is the case, then we are iterating over element sets
      if (is_array($optionValue)) {
        foreach ($optionValue as $key => $value) {
          if (!isset($pairs[$key])) {
            unset($selectOptions[$optionKey][$key]);
          }
        }
      } else { // if we had a flat array then we are iterating directly over elements
        if (!isset($pairs[$key])) {
          unset($selectOptions[$optionKey]);
        }
      }
    }
    return $selectOptions;
  }
}
