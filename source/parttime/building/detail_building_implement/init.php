<?php
/*================================================
=			 Section Init block                  =
=            @author: HT                         =
=            @datetime: 2016-12-07               =
=            @describe: Khởi tạo giá trị ban đầu =
=================================================*/
$id = $_GET['token_id'];
$id_building = $id;
$list_id_material = array();
$arr_idhangmuc = array();
require_once "../models/chitiethangmuccongtrinh.php";
require_once "../models/danhsachcongtrinh.php";
require_once "../models/nhomhangmuc.php";
require_once "../models/trangthaihangmuc.php";
require_once '../models/yeucauthaydoihangmuc.php';
require_once "../models/chitietvattucongtrinh.php";
require_once  "../models/yeucauthaydoivattu.php";

$yeucauthaydoihangmuc = new yeucauthaydoihangmuc();
$chitietvattucongtrinh = new detail_material_category();
$chitiethangmuccongtrinh = new detail_category_building();
$ttall = new status_category_building();
$nhangmuc = new group_category_building();
$list_building = new list_building();
$detail_category_building = new detail_category_building();
$yeucauthaydoivattu = new yeucauthaydoivattu();
if (isset($_POST['addcategory'])) {
    $idhangmuc = $_POST['idhangmuc'];
    $khoiluongconviechientai = $_POST['khoiluongconviechientai'];
    $khoiluongcongviecphatsinh = $_POST['khoiluongcongviecphatsinh'];
    $ghichu = $_POST['ghichu'];

    $condition = array('idcongtrinh' => $id, 'idhangmuc' => $idhangmuc);
    if ($chitiethangmuccongtrinh->tontai($condition)) {
        $arr = $chitiethangmuccongtrinh->laygiatri($condition, array('trangthai'));
        $status = $arr[0]['trangthai'];
        if (intval($status) <= 4) {
            $val = array('', $id, $idhangmuc, current_timestamp(), $khoiluongconviechientai, $khoiluongcongviecphatsinh, current_account(), '', STATUS_DEFAULT, $ghichu);
            $id_insert = $yeucauthaydoihangmuc->insert($val);
            if (!empty($id_insert)) {
                header('location');
            }
        }
    } else {
        $val = array('', $id, $idhangmuc, current_timestamp(), $khoiluongconviechientai, $khoiluongcongviecphatsinh, current_account(), '', STATUS_DEFAULT, $ghichu);
        $id_insert = $yeucauthaydoihangmuc->insert($val);
        if (!empty($id_insert)) {
            header('location');
        }
    }
    echo '<script>window.location="";</script>';
}

if ( isset($_POST['themvattu']) ) {
    $idhangmuc = $_POST['idhangmuc'];
    $idvattu = $_POST['vattu'];
    $khoiluongthaydoi = $_POST['soluongphatsinh'];
    $ghichu = $_POST['ghichu'];

    $condition = array('idcongtrinh' => $id, 'idhangmuc' => $idhangmuc);

    if ($chitiethangmuccongtrinh->tontai($condition)) {
        $arr = $chitiethangmuccongtrinh->laygiatri($condition, array('trangthai'));
        $status = $arr[0]['trangthai'];
        if (intval($status) <= 4) {
            $condition['idvattu'] = $idvattu;
            $row = $chitietvattucongtrinh->getDetail($condition, '');
            $param = array('', $id, $idhangmuc, $idvattu, current_timestamp(), 0, $khoiluongthaydoi, current_account(), '', STATUS_DEFAULT, $ghichu);
            if (count($row) == 1) {
                $param[5] = $row['khoiluongbandau'];
            }
            $id_insert = $yeucauthaydoivattu->insert($param);
            echo '<script>window.location="";</script>';
        }
    }

}


$trangthaiall = $ttall->toanbotrangthai();
$manhomhangmuc = $nhangmuc->get_all();

$data_building = array();
$data_detail_category_building = array();
if (isset($id)) :
    $data_building = $list_building->getdetailupdate($id);
    $data_detail = $detail_category_building->getdetailupdate($id);
endif;
require_once '../models/hangmucthicong.php';
$category_building = new category_building();
$data_category_building = $category_building->get_all();
$status = $data_building->trangthai;
if ($status != 3) {
    header("Location: " . "../building/list_building_waiting_for_implement.php");
}
/*=====  End of Section comment block  ======*/
?>

