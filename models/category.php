<?php
    function get_catalog() {
        $sql ="SELECT * FROM category WHERE 1 ORDER BY tendm";
        return select_all($sql);
    }
    function get_catalog_list() {
        $sql ="SELECT * FROM category";
        return select_all($sql);
    }
    function home_catalog_list() {
        $sql ="SELECT * FROM category WHERE hienthi = 1";
        return select_all($sql);
    }
    function get_catalog_one($iddm){
        $sql = "SELECT * FROM category WHERE iddm=".$iddm;
        return select_one($sql);
    }
    function get_category_name($iddm){
        $sql = "SELECT * FROM category WHERE iddm=".$iddm;
        $sp = select_one($sql);
        extract($sp);
        return $tendm;
    }
    function delete_dm($iddm){
        $sql = "DELETE FROM category WHERE iddm=".$iddm;
        return exec_sql($sql);
    }
    function add_dm($name, $display,$img) {
        $sql = "INSERT INTO category (tendm, hienthi, imgdm) VALUES ('$name', '$display', '$img')";
        return exec_sql($sql);
    }
    function update_dm($iddm,$name,$image) {
        $sql = "UPDATE category SET tendm='$name', imgdm='$image' WHERE iddm=$iddm";
        return update($sql);
    }
?>