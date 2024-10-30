<?php

/*

Plugin Name: MenuThroughJSON

Plugin URI: https://aionlab.it

Description: Plugin che permette di creare un menu' tramite pagine e post di wordpress per un uso tramite chiamata API. Consigliato per chi deve scorporare la creazione del menù dall'implementazione di un app IOS/ANDROID. Possibilità di inserire anche voci speciali

Version: 1.1

Author: Simone Condorelli

Author URI: https://www.facebook.com/simone.condorelli.9?ref=bookmarks

*/

define("MTJ","MenuThroughJSON",true);

function MTJ_api_get_posts() {
    include "custom_class/MTJ_dashboard.class.php";
    include "custom_class/MTJ_gestionePlugin.class.php";
    $dash = new MTJ_dashboardMenu();
    $plugin = new MTJ_gestionePlugin();
    $posts = $plugin->getAllMenuVoices($dash);
    if ( empty($posts) ) return json_encode(
        array(
            "code" => -1,
            "data" =>""
        )
    );
    else{
    return json_encode(
        array(
            "code" => 1,
            "data" => $posts
        )
    );
    }
}

function MTJ_create_MenuThroughJSON()
{
    // create new top-level menu
    add_menu_page('MenuThroughJSON', 'MenuThroughJSON', 'administrator', 'MTJ_MenuThroughJSONDashboard', 'MTJ_MenuThroughJSONDashBoard');
    add_submenu_page('MTJ_MenuThroughJSONDashboard', 'Gestione Plugin', 'Gestione Plugin', 'administrator', 'MTJ_gestionePlugin', 'MTJ_gestionePlugin');
    add_submenu_page('MTJ_MenuThroughJSONDashboard', 'Gestione Speciali', 'Gestione Speciali', 'administrator', 'MTJ_gestioneSpeciali', 'MTJ_gestioneSpeciali');
    add_action('admin_enqueue_scripts', 'MTJ_enqueue_assets');
    add_action('admin_print_scripts', 'MTJ_ajax_load_scripts');
}

function MTJ_MenuThroughJSONDashBoard()
{
    require "dashboardmenu.php";
}

function MTJ_gestioneSpeciali()
{
    require "speciali.php";
}

function MTJ_gestionePlugin()
{
    require "gestionePlugin.php";
}

function MTJ_enqueue_assets() {
    //JS FILE
    wp_enqueue_script( 'my_custom_script1', plugin_dir_url( __FILE__ ) . 'assets/datatables.net/js/jquery.dataTables.js');
    wp_enqueue_script( 'my_custom_script2', plugin_dir_url( __FILE__ ) . 'assets/datatables.net-bs/js/dataTables.bootstrap.js');
    wp_enqueue_script( 'my_custom_script3', plugin_dir_url( __FILE__ ) . 'assets/bootstrap/dist/js/bootstrap.js' );
    wp_enqueue_script( 'my_custom_script4', plugin_dir_url( __FILE__ ) . 'assets/bootstrap/dist/js/bootstrap-notify.js' );
    wp_enqueue_script( 'my_custom_script5', plugin_dir_url( __FILE__ ) . 'assets/adminlte.js' );
    wp_enqueue_script( 'my_custom_script6', plugin_dir_url( __FILE__ ) . 'assets/select2/dist/js/select2.full.min.js' );
    wp_enqueue_script( 'my_custom_script7', plugin_dir_url( __FILE__ ) . 'assets/bootstrap-toggle-master/js/bootstrap-toggle.js' );

    //CSS FILE
    wp_enqueue_style ('my_custom_style1', plugin_dir_url( __FILE__ ) . 'assets/bootstrap/dist/css/bootstrap.css');
    wp_enqueue_style ('my_custom_style2', plugin_dir_url( __FILE__ ) . 'assets/AdminLTE.min.css');
    wp_enqueue_style ('my_custom_style3', plugin_dir_url( __FILE__ ) . 'assets/datatables.net-bs/css/dataTables.bootstrap.css');
    wp_enqueue_style ('my_custom_style4', plugin_dir_url( __FILE__ ) . 'assets/select2/dist/css/select2.min.css');
    wp_enqueue_style ('my_custom_style5', plugin_dir_url( __FILE__ ) . 'assets/animate.css');
    wp_enqueue_style ('my_custom_style6', plugin_dir_url( __FILE__ ) . 'assets/bootstrap-toggle-master/css/bootstrap-toggle.css');
    wp_enqueue_style ('my_custom_style7', plugin_dir_url( __FILE__ ) . 'assets/Ionicons/css/ionicons.min.css');
}

function MTJ_ajax_load_scripts() {
    //AJAX PER FARE UPLOAD DELL'ORDINE DEI MENU
    wp_enqueue_script( "my_custom_ajax", plugin_dir_url( __FILE__ ) . '/js/script/updateOrderMenu.js', array( 'jquery','jquery-ui-sortable' ) );
    wp_localize_script( 'my_custom_ajax', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER AGGIUNGERE MENU ITEM
    wp_enqueue_script( "addMenuItem", plugin_dir_url( __FILE__ ) . '/js/script/addMenuItem.js');
    wp_localize_script( 'addMenuItem', 'script_add_item', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER CAMBIARE STATO ITEM
    wp_enqueue_script( "change_state", plugin_dir_url( __FILE__ ) . '/js/script/changeStateItem.js');
    wp_localize_script( 'change_state', 'script_change_state_item', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER DELETE ITEM
    wp_enqueue_script( "delete_item", plugin_dir_url( __FILE__ ) . '/js/script/deleteItem.js');
    wp_localize_script( 'delete_item', 'script_delete_item', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER MODIFICA  NAME ITEM
    wp_enqueue_script( "modify_item", plugin_dir_url( __FILE__ ) . '/js/script/modifyNameMenu.js');
    wp_localize_script( 'modify_item', 'script_modify_item', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER AGGIUNGERE ITEM POST
    wp_enqueue_script( "add_item", plugin_dir_url( __FILE__ ) . '/js/script/addPostItem.js');
    wp_localize_script( 'add_item', 'script_add_post_item', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER delete ITEM POST
    wp_enqueue_script( "delete_Post", plugin_dir_url( __FILE__ ) . '/js/script/deletePost.js');
    wp_localize_script( 'delete_Post', 'script_delete_Post', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER update ITEM POST
    wp_enqueue_script( "modify_Name_Post", plugin_dir_url( __FILE__ ) . '/js/script/modifyNamePost.js');
    wp_localize_script( 'modify_Name_Post', 'script_modify_Name_Post', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER ADD special post
    wp_enqueue_script( "add_special_post", plugin_dir_url( __FILE__ ) . '/js/script/add_special_item.js');
    wp_localize_script( 'add_special_post', 'script_modify_Name_Post', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER DELETE special post
    wp_enqueue_script( "DEL_special_post", plugin_dir_url( __FILE__ ) . '/js/script/delete_special_post.js');
    wp_localize_script( 'del_special_post', 'script_modify_Name_Post', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    //AJAX PER Update special post
    wp_enqueue_script( "mod_special_post", plugin_dir_url( __FILE__ ) . '/js/script/ModifyNameSpecialPost.js');
    wp_localize_script( 'mod_special_post', 'script_modify_Name_Post', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

function MTJ_Control_Numeric_Variable($var){
     return  (is_numeric($var)) ?  true :  false ;
}

function MTJ_Return_Message($status,$message,$data = NULL){
    if($data == NULL){
    echo json_encode(array(
       "status" => $status,
       "message" => $message
    ));}
    else{
        echo json_encode(array(
            "status" => $status,
            "message" => $message,
            "data" => $data
        ));
    }
    die();
}

function MTJ_reload_order_menu() {
    global $wpdb;
    include "custom_class/MTJ_dashboard.class.php";
    include "custom_class/MTJ_gestionePlugin.class.php";
    $dash = new MTJ_dashboardMenu;
    $menuActive = json_decode($dash->getMenuActive(),true);
    if(!MTJ_Control_Numeric_Variable($menuActive[0]["id_menu"])){
        MTJ_Return_Message(-1,"Errore Generico");
    }
    $jsonDecode = [];
    $res = true;
    if(!isset($_POST["data"])) {
        MTJ_Return_Message(-1,"Errore Generico");
        }
        else{
        $data = $_POST["data"];
        $data = str_replace("\\", "", $data);
        $jsonDecode = json_decode($data, true);
        $oldData = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}relations_menu_item WHERE id_menu='%s'", $menuActive[0]["id_menu"]), ARRAY_A);
        $itemNotChanged = 0;
        foreach ($jsonDecode as $row) {
            $i = 0;
            $row["id"] = filter_var($row["id"],FILTER_SANITIZE_NUMBER_INT);
            $row["order"] = filter_var($row["order"],FILTER_SANITIZE_NUMBER_INT);
            $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}relations_menu_item WHERE id_relation='%s' AND order_menu='%s'", $row["id"], $row["order"]), ARRAY_A);
            foreach ($results as $ris) {
                $i++;
                $itemNotChanged++;
            }
            if ($i == 0) {
                $result = $wpdb->update(
                    $wpdb->prefix . 'relations_menu_item',
                    array(
                        'order_menu' => $row["order"],
                    ),
                    array(
                        "id_relation" => $row["id"]
                    )
                );
                if ($result == false) {
                    $res = false;
                    break;
                }
            }
        }
        if ($res == false) {
            foreach ($oldData as $row) {
                $row["id"] = filter_var($row["id"],FILTER_SANITIZE_NUMBER_INT);
                $row["order"] = filter_var($row["order"],FILTER_SANITIZE_NUMBER_INT);
                $i = 0;
                $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}relations_menu_item WHERE id_relation='%s' AND order_menu='%s'", $row["id"], $row["order"]), ARRAY_A);
                foreach ($results as $row) {
                    $i++;
                }
                if ($i == 0) {
                    $result = $wpdb->update(
                        $wpdb->prefix . 'relations_menu_item',
                        array(
                            'order_menu' => $row["order"],
                        ),
                        array(
                            "id_relation" => $row["id"]
                        )
                    );
                }
            }
            MTJ_Return_Message(-1,"Errore durante l'aggiornamento");
        } else if ($res == true && count($jsonDecode) > $itemNotChanged) {
            MTJ_Return_Message(1,"Aggiornamento avvenuto correttamente");
        } else if (count($jsonDecode) == $itemNotChanged) {
            MTJ_Return_Message(0,"Nessun Item Aggiornato");
        }
    }
 }

function MTJ_add_post_menu(){
    global $wpdb;
    include "custom_class/MTJ_dashboard.class.php";
    include "custom_class/MTJ_gestionePlugin.class.php";
    $dash = new MTJ_dashboardMenu;
    $plugin = new MTJ_gestionePlugin;
    $menuActive = array();
    $linksPage = array();
    if(!isset($_POST["data"])){
        MTJ_Return_Message(-1,"Errore Generico");
    }
    else {
        $menuActive = json_decode($dash->getMenuActive(), true);
        if(!MTJ_Control_Numeric_Variable($menuActive[0]["id_menu"])){
            MTJ_Return_Message(-1,"Errore Generico");
        }
        $relactionActive = $dash->getCountRelation($menuActive[0]["id_menu"]);
        if(!MTJ_Control_Numeric_Variable($relactionActive)){
            MTJ_Return_Message(-1,"Errore Generico");
        }
        $data = $_POST["data"];
        $data = str_replace("\\", "", $data);
        $jsonDecode = json_decode($data, true);
        $jsonDecode["link"] = filter_var($jsonDecode["link"],FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $jsonDecode["link_name"] = filter_var($jsonDecode["link_name"],FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        if ($jsonDecode["link_name"] == "") {
            MTJ_Return_Message(-1,"Nome menu' vuoto");
        } else {
            $i = 0;
            $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}relations_menu_item WHERE id_menu='%s' AND nome_menu='%s'", $menuActive[0]["id_menu"], $jsonDecode["link_name"]), ARRAY_A);
            foreach ($results as $row) {
                $i++;
            }
            if ($i == 1) {
                MTJ_Return_Message(-1,"Link gia' esistente");
            } else {
                $results = $wpdb->insert(
                    $wpdb->prefix . 'relations_menu_item',
                    array(
                        'id_post' => $jsonDecode["link"],
                        "order_menu" => $relactionActive + 1,
                        "id_menu" => $menuActive[0]["id_menu"],
                        "nome_menu" => $jsonDecode["link_name"]
                    )
                );
                if ($results == 0) {
                    MTJ_Return_Message(-1,"Errore durante inserimento");
                } else {
                    $nameofLink = json_decode($plugin->getPostNameById($jsonDecode["link"]), true);
                    $id_rel = json_decode($plugin->getIdRelation($menuActive[0]["id_menu"], $jsonDecode["link_name"]), true);
                    $dataToSend = array(
                        "id_link" => $id_rel[0]["id_relation"],
                        "link" => $nameofLink[0]["post_title"] . "(" . $jsonDecode["link"] . ")",
                        "name_link" => $jsonDecode["link_name"]
                    );
                    MTJ_Return_Message(1,"Inserimento avvenuto correttamente",json_encode($dataToSend));
                }
            }
        }
    }
}

function MTJ_add_menu_item()
{
    global $wpdb;
    $i = 0;
    if(!isset($_POST["data"])){
        MTJ_Return_Message(-1,"Errore generico");
    }
    else {
        $data = $_POST["data"];
        $data = str_replace("\\", "", $data);
        $data = filter_var($data,FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}menu WHERE menu_name='%s'", $data), ARRAY_A);
        foreach ($results as $row) {
            $i++;
        }
        if ($i == 1) {
            MTJ_Return_Message(-1,"Menu' gia' esistente");
        } else {
            $results = $wpdb->insert(
                $wpdb->prefix . 'menu',
                array(
                    'menu_name' => $data,
                    'active' => 0
                )
            );
            $data = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}menu WHERE menu_name='%s'", $data), ARRAY_A);
            if ($results != false) {
                MTJ_Return_Message(1,"Inserimento avvenuto correttamente",json_encode($data));
            } else {
                MTJ_Return_Message(-1,"Errore durante l'inserimento");
            }
        }
    }
}

function MTJ_change_state_item(){
    global $wpdb;
    include "custom_class/MTJ_dashboard.class.php";
    $dash = new MTJ_dashboardMenu;
    if(!isset($_POST["data"])){
        MTJ_Return_Message(-1,"Errore generico");
      }
    else {
        $data = $_POST["data"];
        $data = str_replace("\\", "", $data);
        $jsonDecode = json_decode($data, true);
        $jsonDecode["value"] = filter_var($jsonDecode["value"],FILTER_SANITIZE_NUMBER_INT);
        if(!MTJ_Control_Numeric_Variable($jsonDecode["value"])){
            MTJ_Return_Message(-1,"Errore Generico");
        }
        $i = $dash->isMenuActive();
        if ($jsonDecode["value"] == 1 && $i > 0) {
            $result = $wpdb->update(
                $wpdb->prefix . 'menu',
                array(
                    'active' => 0
                ),
                array(
                    "active" => 1
                ));
            if ($result == false) {
                MTJ_Return_Message(-1,"Errore durante l'aggiornamento");
            }
        }
        $result = $wpdb->update(
            $wpdb->prefix . 'menu',
            array(
                'active' => $jsonDecode["value"]
            ),
            array(
                "id_menu" => $jsonDecode["id"]
            ));
        if ($result == false) {
            MTJ_Return_Message(-1,"Errore durante l'aggiornamento");
        }
    MTJ_Return_Message(1,"Aggiornamento avvenuto correttamente");
     }
}

function MTJ_delete_item(){
    global $wpdb;
    include "custom_class/MTJ_dashboard.class.php";
    $dash = new MTJ_dashboardMenu;
    if(!isset($_POST["data"])){
        MTJ_Return_Message(-1,"Errore generico");
    }
    else {
        $data = $_POST["data"];
        $data = filter_var($data,FILTER_SANITIZE_NUMBER_INT);
        if(!MTJ_Control_Numeric_Variable($data)){
            MTJ_Return_Message(-1,"Errore Generico");
        }

        $i = $dash->CountItemForMenu($data);
        if ($i > 0) {
            $result = $wpdb->delete($wpdb->prefix . 'relations_menu_item', array('id_menu' => $data));
            if ($result == false) {
                MTJ_Return_Message(-1,"Errore durante la cancellazione");
            }
        }
        $resultMenuDelete = $wpdb->delete($wpdb->prefix . 'menu', array('id_menu' => $data));
        if ($resultMenuDelete == false) {
            MTJ_Return_Message(-1,"Errore durante la cancellazione");
         }
    MTJ_Return_Message(1,"Cancellazione avvenuta correttamente");
     }
}

function MTJ_update_item(){
    global $wpdb;
    if(!isset($_POST["data"])){
        MTJ_Return_Message(-1,"Errore generico");
    }
    else {
        $data = $_POST["data"];
        $data = str_replace("\\", "", $data);
        $jsonDecode = json_decode($data, true);
        $jsonDecode["col"] = filter_var($jsonDecode["col"],FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $jsonDecode["id"] = filter_var($jsonDecode["id"],FILTER_SANITIZE_NUMBER_INT);
        if(!MTJ_Control_Numeric_Variable($jsonDecode["id"])){
            MTJ_Return_Message(-1,"Errore Generico");
        }
        $result = $wpdb->update(
            $wpdb->prefix . 'menu',
            array(
                'menu_name' => $jsonDecode["col"],
            ),
            array(
                "id_menu" => $jsonDecode["id"]
            )
        );
        if ($result == 0) {
            MTJ_Return_Message(-1,"Errore durante l'aggiornamento");
        }
        MTJ_Return_Message(1,"Aggiornamento avvenuto correttamente",$jsonDecode["col"]);
    }
}

function MTJ_update_post_table(){
    include "custom_class/MTJ_dashboard.class.php";
    include "custom_class/MTJ_gestionePlugin.class.php";
    $dash = new MTJ_dashboardMenu;
    $plugin = new MTJ_gestionePlugin;
    echo json_encode(array(
        "results" => $plugin->getAllMenuVoices($dash)
    ));
    die();
}

function MTJ_delete_post(){
    global $wpdb;
    include "custom_class/MTJ_dashboard.class.php";
    $dash = new MTJ_dashboardMenu;
    $menuActive = array();
    $linksPage = array();
    if(!isset($_POST["data"])) {
        MTJ_Return_Message(-1,"Errore Generico");
    }
    else {
        $data = $_POST["data"];
        $data = str_replace("\\", "", $data);
        $jsonDecode = json_decode($data, true);
        $jsonDecode = filter_var($jsonDecode,FILTER_SANITIZE_NUMBER_INT);
        if(!MTJ_Control_Numeric_Variable($jsonDecode)){
            MTJ_Return_Message(-1,"Errore Generico");
        }
        $menuActive = json_decode($dash->getMenuActive(), true);
        if(!MTJ_Control_Numeric_Variable($menuActive[0]["id_menu"])){
            MTJ_Return_Message(-1,"Errore Generico");
        }
        $relactionActive = $dash->getCountRelation($menuActive[0]["id_menu"]);
        if(!MTJ_Control_Numeric_Variable($relactionActive)){
            MTJ_Return_Message(-1,"Errore Generico");
        }
        $relactionDaCanc = json_decode($dash->getDescribeRelation($jsonDecode), true);
        $order = $relactionDaCanc[0]["order_menu"];
        if ($order < $relactionActive) {
            for ($t = 1; $t <= $relactionActive - $order; $t++) {
                $dash->reload_order_single_post($menuActive[0]["id_menu"], $order);
                $order++;
            }
        }
        $resultPostDelete = $wpdb->delete($wpdb->prefix . 'relations_menu_item', array('id_menu' => $menuActive[0]["id_menu"],
            'id_relation' => $jsonDecode));
        if ($resultPostDelete == false) {
            MTJ_Return_Message(-1,"Errore Durante la cancellazione");
        } else {
            MTJ_Return_Message(1,"Cancellazione avvenuta correttamente");
        }
    }
}

function MTJ_update_post_name(){
    global $wpdb;
    if(!isset($_POST["data"])) {
        MTJ_Return_Message(-1,"Errore Generico");
    }
    else {
        $data = $_POST["data"];
        $data = str_replace("\\", "", $data);
        $jsonDecode = json_decode($data, true);
        $jsonDecode["col"] = filter_var($jsonDecode["col"],FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $jsonDecode["id"] = filter_var($jsonDecode["id"],FILTER_SANITIZE_NUMBER_INT);
        if(!MTJ_Control_Numeric_Variable($jsonDecode["id"])){
            MTJ_Return_Message(-1,"Errore Generico");
        }
        $result = $wpdb->update(
            $wpdb->prefix . 'relations_menu_item',
            array(
                'nome_menu' => $jsonDecode["col"],
            ),
            array(
                "id_relation" => $jsonDecode["id"]
            )
        );
        if ($result == 0) {
            MTJ_Return_Message(-1,"Errore durante l'aggiornamento");
        }
        MTJ_Return_Message(1,"Aggiornamento avvenuto correttamente",$jsonDecode["col"]);
    }
}

function MTJ_update_special_post(){
    global $wpdb;
    if(!isset($_POST["data"])) {
        MTJ_Return_Message(-1,"Errore Generico");
    }
    else {
        $data = $_POST["data"];
        $data = str_replace("\\", "", $data);
        $jsonDecode = json_decode($data, true);
        $jsonDecode["col"] = filter_var($jsonDecode["col"],FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $jsonDecode["descr"] = filter_var($jsonDecode["descr"],FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $result = $wpdb->update(
            $wpdb->prefix . 'special_post',
            array(
                'value' => $jsonDecode["col"],
                'label' => $jsonDecode["col"],
                'descrizione' => $jsonDecode["descr"],
            ),
            array(
                "id" => $jsonDecode["id"]
            )
        );
        if ($result == 0) {
            MTJ_Return_Message(-1,"Errore durante l'aggiornamento");
        }
        echo json_encode(array(
            "status" => 1,
            "message" => "Aggiornamento avvenuto correttamente",
            "value" => $jsonDecode["col"],
            "descr" => $jsonDecode["descr"]
        ));
        die();
    }
}

function MTJ_add_post_special(){
    global $wpdb;
    include "custom_class/MTJ_speciali.class.php";
    $speciali = new MTJ_speciali();
    if(!isset($_POST["data"])) {
        MTJ_Return_Message(-1,"Errore Generico");
    }
    else {
        $data = $_POST["data"];
        $data = str_replace("\\", "", $data);
        $jsonDecode = json_decode($data, true);
        $jsonDecode["name"] = filter_var($jsonDecode["name"],FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $jsonDecode["descrizione"] = filter_var($jsonDecode["descrizione"],FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $i = $speciali->isSpecialLinkExistbyValue($jsonDecode["name"]);
        if ($i == 1) {
            MTJ_Return_Message(-1,"Post speciale gia' esistente");
        } else {
            $results = $wpdb->insert(
                $wpdb->prefix . 'special_post',
                array(
                    'value' => $jsonDecode["name"],
                    'label' => $jsonDecode["name"],
                    'descrizione' => $jsonDecode["descrizione"]
                )
            );
            if ($results == 1) {
                MTJ_Return_Message(1,"Inserimento avvenuto correttamente",json_encode($jsonDecode));
            } else {
                MTJ_Return_Message(-1,"Errore durante l'inserimento");
            }
        }
    }
}

function MTJ_delete_post_special(){
    global $wpdb;
    include "custom_class/MTJ_speciali.class.php";
    $speciali = new MTJ_speciali();
    if(!isset($_POST["data"])) {
        MTJ_Return_Message(-1,"Errore Generico");
    }
    else {
        $data = $_POST["data"];
        if(!MTJ_Control_Numeric_Variable($data)){
            MTJ_Return_Message(-1,"Errore Generico");
        }
        $i = $speciali->isSpecialLinkExistbyID($data);
        if ($i > 0) {
            $result = $wpdb->delete($wpdb->prefix . 'special_post', array('id' => $data));
            if ($result == false) {
                MTJ_Return_Message(-1,"Errore durante la cancellazione");
            } else {
                MTJ_Return_Message(1,"Cancellazione avvenuta correttamente");
            }
        }
    }
}

function MTJ_load_call_api(){
    add_action( 'rest_api_init', function () {
        // tutto come prima a parte che non abbiamo più un'opzione specificata
        register_rest_route( 'production/v1', '/menu/', array(
            'methods' => 'GET',
            'callback' => 'MTJ_api_get_posts',
        ));
    });
}

function MTJ_ajax_load_script_action(){
    //AJAX PER AGGIUNGERE MENU ITEM
    add_action( 'wp_ajax_nopriv_MTJ_add_item_menu', 'MTJ_add_menu_item' );
    add_action( 'wp_ajax_MTJ_add_item_menu', 'MTJ_add_menu_item' );
    //AJAX PER FARE UPLOAD DELL'ORDINE DEI MENU
    add_action( 'wp_ajax_nopriv_MTJ_reload_menu', 'MTJ_reload_order_menu' );
    add_action( 'wp_ajax_MTJ_reload_menu', 'MTJ_reload_order_menu' );
    //AJAX PER COSTRUIRE LA TABELLA
    add_action( 'wp_ajax_nopriv_MTJ_construct_table', 'MTJ_construct_table' );
    add_action( 'wp_ajax_MTJ_construct_table', 'MTJ_construct_table' );
    //AJAX PER CAMBIARE STATO ITEM
    add_action( 'wp_ajax_nopriv_MTJ_change_state_item', 'MTJ_change_state_item' );
    add_action( 'wp_ajax_MTJ_change_state_item', 'MTJ_change_state_item' );
    //AJAX PER DELETE ITEM
    add_action( 'wp_ajax_nopriv_MTJ_delete_item', 'MTJ_delete_item' );
    add_action( 'wp_ajax_MTJ_delete_item', 'MTJ_delete_item' );
    //AJAX PER UPDATE ITEM
    add_action( 'wp_ajax_nopriv_MTJ_update_item', 'MTJ_update_item' );
    add_action( 'wp_ajax_MTJ_update_item', 'MTJ_update_item' );
    //AJAX UPDATE TABLE POST
    add_action( 'wp_ajax_nopriv_MTJ_update_post_table', 'MTJ_update_post_table' );
    add_action( 'wp_ajax_MTJ_update_post_table', 'MTJ_update_post_table' );
    //AJAX UPDATE POST TABELLA
    add_action( 'wp_ajax_nopriv_MTJ_change_state_post', 'MTJ_change_state_post' );
    add_action( 'wp_ajax_MTJ_change_state_post', 'MTJ_change_state_post' );
    //AJAX PER AGGIUNGERE ITEM POST
    add_action( 'wp_ajax_nopriv_MTJ_add_post_menu', 'MTJ_add_post_menu' );
    add_action( 'wp_ajax_MTJ_add_post_menu', 'MTJ_add_post_menu' );
    //AJAX PER DELETE ITEM POST
    add_action( 'wp_ajax_nopriv_MTJ_delete_post', 'MTJ_delete_post' );
    add_action( 'wp_ajax_MTJ_delete_post', 'MTJ_delete_post' );
    //AJAX PER update ITEM POST
    add_action( 'wp_ajax_nopriv_MTJ_update_post_name', 'MTJ_update_post_name' );
    add_action( 'wp_ajax_MTJ_update_post_name', 'MTJ_update_post_name' );
    //AJAX PER ADD SPECIAL POST
    add_action( 'wp_ajax_nopriv_MTJ_add_post_special', 'MTJ_add_post_special' );
    add_action( 'wp_ajax_MTJ_add_post_special', 'MTJ_add_post_special' );
    //AJAX PER DELETE SPECIAL POST
    add_action( 'wp_ajax_nopriv_MTJ_delete_post_special', 'MTJ_delete_post_special' );
    add_action( 'wp_ajax_MTJ_delete_post_special', 'MTJ_delete_post_special' );
    //AJAX PER UPDATE SPECIAL POST
    add_action( 'wp_ajax_nopriv_MTJ_update_special_post', 'MTJ_update_special_post' );
    add_action( 'wp_ajax_MTJ_update_special_post', 'MTJ_update_special_post' );
}

function MTJ_create_table_if_not_exist(){
    global $wpdb;
    global $charset_collate;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix.'menu';
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
     //table not in database. Create new table
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
          `id_menu` int(11)  NOT NULL AUTO_INCREMENT,
        `menu_name` varchar(25) NOT NULL,
        `active` int(11) NOT NULL COMMENT '0-->non Attivo 1--> Attivo',
        UNIQUE KEY id_menu (id_menu)
    )$charset_collate;";
    dbDelta($sql);

}
    $table_name = $wpdb->prefix.'relations_menu_item';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
              `id_relation` int(11)  NOT NULL AUTO_INCREMENT,
              `id_post` varchar(11) NOT NULL,
              `order_menu` int(11) NOT NULL,
              `id_menu` int(11) NOT NULL,
              `nome_menu` varchar(40) NOT NULL,
              UNIQUE KEY id_relation (id_relation)
    )$charset_collate;";
        dbDelta($sql);
    }

    $table_name = $wpdb->prefix.'special_post';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `value` varchar(30) NOT NULL,
              `label` varchar(30) NOT NULL,
              `descrizione` varchar(100) NOT NULL,
               UNIQUE KEY id (id)
    )$charset_collate;";
        dbDelta($sql);
    }
}

function MTJ_delete_all_table(){
    global $wpdb;
    $table = [$wpdb->prefix.'menu',$wpdb->prefix.'relations_menu_item',$wpdb->prefix.'special_post'];
    foreach ($table as $tab){
    $wpdb->query("DROP TABLE IF EXISTS $tab");}
}

register_activation_hook(__FILE__,'MTJ_create_table_if_not_exist');
register_deactivation_hook(__FILE__, 'MTJ_delete_all_table');
MTJ_ajax_load_script_action();
MTJ_load_call_api();
add_action('admin_menu', 'MTJ_create_MenuThroughJSON');



?>

