<?php
    session_start();
    ob_start();
    include '../models/global.php';
    include '../models/connect.php';
    include '../models/product.php';
    include '../models/category.php';
    include '../models/user.php';
    include '../models/comment.php';
    include '../models/bill.php';
    include 'view/header.php';

        
        switch ($_GET['page']) {
            case 'home':
                $sanpham = get_product_list();
                $danhmuc = get_catalog_list();
                $nguoidung = get_user_list();
                $bill = get_bill();
                include "view/home.php";
                break;
            case 'product':
                $danhmuc = get_catalog_list();
                $sanpham = get_product_list();
                include "view/product.php";
                break;
            case 'addsp':
                if (isset($_POST['btnaddsp'])) {
                    $iddm = $_POST['iddm'];
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $price2 = $_POST['price2'];
                    $img = $_FILES['image']['name'];
                    if ($img != '') {
                        $imgsp = '../' . PATH_IMG . $img;
                        move_uploaded_file($_FILES["image"]["tmp_name"], $imgsp);
                    }
                }
                add_sp($iddm, $name, $price, $price2, $img);
                $danhmuc = get_catalog_list();
                $sanpham = get_product_list();
                include "view/product.php";
                break;
            case 'deletesp':
                if (isset($_GET['idsp']) && ($_GET['idsp'] > 0)) {
                    $idsp = $_GET['idsp'];
                    delete_sp($idsp);
                }
                $danhmuc = get_catalog_list();
                $sanpham = get_product_list();
                include "view/product.php";
                break;
            case 'updatesp':
                if (isset($_POST['btnupdatesp'])) {
                    $iddm = $_POST['iddm'];
                    $idsp = $_POST['idsp'];
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $img = $_FILES['image']['name'];
                    if ($img != '') {
                        $imgsp = '../' . PATH_IMG . $img;
                        move_uploaded_file($_FILES["image"]["tmp_name"], $imgsp);
                        $img_cu = '../' . PATH_IMG .$_POST['imgcu'];
                        if(file_exists($img_cu));
                        update_sp($iddm,$idsp,$name,$img,$price);
                    }else{
                        $img='';
                    }
                }   
                $sanpham = get_product_list();
                $danhmuc = get_catalog_list();
                include "view/product.php";
                break;
            case 'updatespform':
                if (isset($_GET['idsp']) && ($_GET['idsp'] > 0)) {
                    $idsp = $_GET['idsp'];
                }
                $detail = get_product_detail($idsp);
                $danhmuc = get_catalog_list();
                $sanpham = get_product_list();
                include "view/updatespform.php";
                break;
            case 'catalog':
                $danhmuc = get_catalog_list();
                include "view/catalog.php";
                break;
            case 'deletedm':
                if (isset($_GET['iddm']) && ($_GET['iddm'] > 0)) {
                    $iddm = $_GET['iddm'];
                    $tb = check_khoa_ngoai($iddm);
                    if ($tb > 0) {
                        $thongbao = 'Danh mục này là khóa ngoại của sản phẩm. Không thể xóa!';
                    } else {
                        delete_dm($iddm);
                        $thongbao = "Xóa thành công!";
                    }
    
                }
                $danhmuc = get_catalog_list();
                $sanpham = get_product_list();
                header('location:index.php?page=catalog');
                // include "view/catalog.php";
                break;
            case 'adddm':
                if (isset($_POST['btnadddm'])) {
                    $name = $_POST['name'];
                    $display = $_POST['display'];
                    $img = $_FILES['image']['name'];
                    if ($img != '') {
                        $imgdm = '../' . PATH_IMG . $img;
                        move_uploaded_file($_FILES["image"]["tmp_name"], $imgdm);
                    }
                }
                add_dm($name, $display, $img);
                $danhmuc = get_catalog_list();
                $sanpham = get_product_list();
                include "view/catalog.php";
                break;
            case 'updatedmform':
                if (isset($_GET['iddm']) && ($_GET['iddm'] > 0)) {
                    $iddm = $_GET['iddm'];
                    $dmone= get_catalog_one($iddm);
                    $danhmuc = get_catalog_list();
                    $sanpham = get_product_list();
                    include "view/updatedmform.php";
                }
                break;
            case 'updatedm':
                if (isset($_POST['btnupdatedm'])) {
                    $iddm = $_POST['iddm'];
                    $name = $_POST['name'];
                    $img = $_FILES['image']['name'];
                    if ($img != '') {
                        $imgdm = '../' . PATH_IMG . $img;
                        move_uploaded_file($_FILES["image"]["tmp_name"], $imgdm);
                        $img_cu = '../' . PATH_IMG .$_POST['imgcu'];
                        if(file_exists($img_cu));
                        update_dm($iddm,$name,$img);
                    }else{
                        $img='';
                    }
                }   
                $sanpham = get_product_list();
                $danhmuc = get_catalog_list();
                include "view/catalog.php";
                break;
            case 'user':
                $nguoidung = get_user_list();
                include "view/user.php";
                break;
            case 'deleteuser':
                if (isset($_GET['iduser']) && ($_GET['iduser'] > 0)) {
                    $iduser = $_GET['iduser'];
                    delete_user($iduser);
                }
                $nguoidung = get_user_list();
                header('location:index.php?page=user');
                // include "view/catalog.php";
                break;
            case 'adduser':
                if (isset($_POST['btnadduser'])) {
                    $name = $_POST['name'];
                    $password = $_POST['password'];
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    $role = $_POST['role'];
                    $img = $_FILES['image']['name'];
                    if ($img != '') {
                        $img_user = '../' . PATH_IMG . $img;
                        move_uploaded_file($_FILES["image"]["tmp_name"], $img_user);
                    }
                    add_user($name, $password, $phone, $img, $address, $role);
                    $nguoidung = get_user_list();
                    header('location:index.php?page=user');
                    include "view/user.php";
                }
                break;
            case 'updateuser':
                if (isset($_POST['btnupdateuser'])) {
                    $iduser = $_POST['iduser'];
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    $role = $_POST['role'];
                    $img = $_FILES['image']['name'];
                    if ($img != '') {
                        $img_user = '../' . PATH_IMG . $img;
                        move_uploaded_file($_FILES["image"]["tmp_name"], $img_user);
                        $img_cu = '../' . PATH_IMG .$_POST['imgcu'];
                        if(file_exists($img_cu));
                        update_user($iduser, $name,$email, $password, $phone, $img, $address, $role);
                    }else{
                        $img='';
                    }
                }   
                $nguoidung = get_user_list();
                include "view/user.php";
                break;
            case 'updateuserform':
                if (isset($_GET['iduser']) && ($_GET['iduser'] > 0)) {
                    $iduser = $_GET['iduser'];
                }
                $userone = get_user_one($iduser);
                $nguoidung = get_user_list();
                include "view/updateuserform.php";
                break;
            case 'comment':
                $comment = get_comment_list();
                include "view/comment.php";
                break;
            case 'deletecomment':
                if (isset($_GET['idbl']) && ($_GET['idbl'] > 0)) {
                    $idbl = $_GET['idbl'];
                    delete_comment($idbl);
                }
                $comment = get_comment_list();
                header('location:index.php?page=comment');
                break;
            case 'bill':
                $bill = get_bill();
                include "view/bill.php";
                break;
            case 'bill_detail':
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $id = $_GET['id'];
                    $id_billdetail= get_bill_detail_one($id);
                }
                include "view/bill_detail.php";
                break;
            case 'updatebillform':
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $id = $_GET['id'];
                    $id_bill= get_bill_one($id);
                }
                include "view/updatebillform.php";
                break;
            case 'update_bill':
                if (isset($_POST['btnupdatebill'])) {
                    $id = $_POST['id'];
                    $status = $_POST['status'];
                }
                update_bill($id,$status);   
                $bill = get_bill();
                include "view/bill.php";
                break;
            default:
                include 'view/home.php';
                break;
        }
?>