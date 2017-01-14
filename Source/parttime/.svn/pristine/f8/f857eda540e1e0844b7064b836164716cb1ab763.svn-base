<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class nhanvien_entity {
	public $manv;
	public $macn;
	public $password;
	public $hoten;
	public $uid;
	public $ngaysinh;
	public $diachi;
	public $dienthoai;
    public $dienthoaiban;
    public $bophan;
	public $email; 
	public $enable;
	
	public function nhanvien_entity()
	{
        $this->hoten = '';
        $this->diachi = '';
        $this->dienthoai = '';
        $this->dienthoaiban = '';
        $this->email = '';
        $this->bophan = NULL;
		$this->enable = BIT_TRUE;
	}
	
	public function copy()
	{
		$item = new nhanvien_entity();
		
		$item->manv = $this->manv;
		$item->macn = $this->macn;
		$item->password = $this->password;
		$item->hoten = $this->hoten;
		//$item->uid = $this->uid;
        $item->ngaysinh = $this->ngaysinh;
		$item->diachi = $this->diachi;
		$item->dienthoai = $this->dienthoai;
        $item->dienthoaiban = $this->dienthoaiban;
		$item->email = $this->email;
		$item->bophan = $this->bophan;
		$item->enable = $this->enable;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->manv = $array['manv'];
		$this->macn = $array['macn'];
		$this->password = $array['password'];
		$this->hoten = $array['hoten'];
		$this->uid = $array['uid'];
		$this->ngaysinh = $array['ngaysinh'];
		$this->diachi = $array['diachi'];
		$this->dienthoai = $array['dienthoai'];
        $this->dienthoaiban = $array['dienthoaiban'];
        $this->email = $array['email'];
        $this->bophan = $array['bophan'];
		$this->enable = $array['enable'];
	}
}
