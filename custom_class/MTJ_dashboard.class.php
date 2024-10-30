<?php
class MTJ_dashboardMenu
{
  public function getRelation($id){
      global $wpdb;
      $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}relations_menu_item WHERE id_menu='%d' ORDER BY order_menu ASC",$id),ARRAY_A);
      if($results != NULL){
         return json_encode($results);}
      else
         return NULL;
  }

  public function CountItemForMenu($data){
      global $wpdb;
      $i = 0;
      $numItem = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}relations_menu_item WHERE id_menu='%s'", $data));
      return $numItem;
  }


  public function isMenuActive(){
      global $wpdb;
      $i = 0;
      $results = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}menu WHERE active=1");
      return $results;
  }

    public function getDescribeRelation($id){
        global $wpdb;
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}relations_menu_item WHERE id_relation='%d' ORDER BY order_menu ASC",$id),ARRAY_A);
        if($results != NULL){
            return json_encode($results);}
        else
            return NULL;
    }

    public function getRelationWithName($id){
        global $wpdb;
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}relations_menu_item ".
                                                     "LEFT JOIN {$wpdb->prefix}posts ".
                                                     "ON {$wpdb->prefix}relations_menu_item.id_post = {$wpdb->prefix}posts.ID ".
                                                     "WHERE id_menu='%d' ORDER BY order_menu ASC",$id),ARRAY_A);
        if($results != NULL){
            return json_encode($results);}
        else
            return NULL;
    }

  public function getMenuActive(){
      global $wpdb;
      $query = "SELECT * FROM {$wpdb->prefix}menu WHERE active = 1";
      $results = $wpdb->get_results($query,ARRAY_A);
      if($results != NULL){
          return json_encode($results);}
      else
          return NULL;
  }

  public function getCountRelation($id){
      global $wpdb;
      $i = 0;
      $results = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}relations_menu_item WHERE id_menu='%d' ",$id));
      return $results;
  }



    function reload_order_single_post($id_menu,$new_order) {
        global $wpdb;
            $result = $wpdb->update(
                $wpdb->prefix .'relations_menu_item',
                array(
                    'order_menu' => $new_order,
                ),
                array(
                    'order_menu' => $new_order+1,
                    "id_menu" => $id_menu

                )
            );
    }
}

?>