<?php
/**
 * Created by PhpStorm.
 * User: simone
 * Date: 30/07/18
 * Time: 9.56
 */

class MTJ_gestionePlugin
{
    public function getAllMenu(){
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}menu ",ARRAY_A);
        if($results != NULL){
            return json_encode($results);}
        else
            return NULL;
    }

    public function  getAllLinks(){
        global $wpdb;
        $result = array();
        $i=0;
        $resultsAllPost = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type!='revision' ORDER BY post_type ASC", ARRAY_A);
            foreach ($resultsAllPost as $row) {
                $result[$i] = array(
                    "id" => $row["ID"],
                    "name" => $row["post_title"],
                    "post_type"=> $row["post_type"]
                );
                $i++;
            }
        return(json_encode($result));

    }

    public function getPostNameById($id){
        global $wpdb;
        $result = array();
        $result = $wpdb->get_results($wpdb->prepare("SELECT post_title FROM {$wpdb->prefix}posts "
            . " WHERE ID = '%s' ",$id, ARRAY_A));
        return json_encode($result);
    }

    public function getIdRelation($id_menu,$nome_menu){
        global $wpdb;
        $result = array();
        $result = $wpdb->get_results($wpdb->prepare("SELECT id_relation FROM {$wpdb->prefix}relations_menu_item "
            . " WHERE id_menu='%s' AND nome_menu='%s' ",$id_menu,$nome_menu, ARRAY_A));
        return json_encode($result);
    }

    public function getAllMenuVoices($dashBoard){
        global $wpdb;
        $result = array();
        $resultMenuActive = array();
        $relationActive = array();
        $i=0;
        $resultMenuActive = json_decode($dashBoard->getMenuActive(),true);
        if($resultMenuActive != NULL) {
            $relationActive = json_decode($dashBoard->getRelation($resultMenuActive[0]["id_menu"]),true);
            $resultsAllPost = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}relations_menu_item "
                . "WHERE id_menu = '%d' ORDER BY order_menu ",$resultMenuActive[0]["id_menu"]), ARRAY_A);
            if($relationActive != NULL) {
                foreach ($resultsAllPost as $row) {
                    $resultsPost = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts "
                        . "WHERE ID = '%d' ",$row["id_post"]), ARRAY_A);
                    if($resultsPost == null) {
                        $result[$i] = array(
                            "id_rel" => $row["id_relation"],
                            "id" => $row["id_post"],
                            "order_menu" => $row["order_menu"],
                            "name" => $row["nome_menu"],
                            "post_name" => "SPECIAL",
                            "post_type" => "SPECIAL"
                        );
                    }
                    else{
                        $result[$i] = array(
                            "id_rel" => $row["id_relation"],
                            "id" => $row["id_post"],
                            "order_menu" => $row["order_menu"],
                            "name" => $row["nome_menu"],
                            "post_name" => $resultsPost[0]["post_title"],
                            "post_type" => $resultsPost[0]["post_type"]
                        );
                    }
                    $i++;
                }
                return json_encode($result);
            }
        else
           return NULL;
        }
        else
            return NULL;
    }

}