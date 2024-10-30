<?php
/**
 * Created by PhpStorm.
 * User: simone
 * Date: 07/08/18
 * Time: 12.37
 */

class MTJ_speciali
{
    public function  getAllSpecialsLinks(){
        global $wpdb;
        $result = array();
        $i=0;
        $resultsAllPost = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}special_post ORDER BY {$wpdb->prefix}special_post.`id` ASC ", ARRAY_A);
        foreach ($resultsAllPost as $row) {
            $result[$i] = array(
                "id" =>  $row["id"],
                "value" => $row["value"],
                "label" => $row["label"],
                "descrizione" => $row["descrizione"]
            );
            $i++;
        }
        return(json_encode($result));
    }

    public function isSpecialLinkExistbyValue($special_link){
        global $wpdb;
        $results = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}special_post WHERE value='%s'", $special_link));
        return $results;
    }

    public function isSpecialLinkExistbyID($special_link){
        global $wpdb;
        $results = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}special_post WHERE id='%s'", $special_link));
        return $results;
    }
}