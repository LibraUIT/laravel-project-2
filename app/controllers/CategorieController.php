<?php
class CategorieController extends BaseController{
	public function getIndex()
	{
		$cate = Categorie::all();
		return View::make(Device::make().".minhquan.indexCate")->with("title","Quản lý chủ đề")->with("cates", $cate);
	}
	public function getApiIndex()
	{
		$cate = Categorie::orderBy('id', 'DESC')->get();
		return Response::Json($cate);
	}
	public function postCreate()
	{
		if(Request::ajax()){
			$name=Input::get("name");
			$cate=Categorie::where("title",$name)->first();
			if($cate){
				return Response::Json(array("status"=>"error","mess"=>"Chủ đề này đã tồn tại"));
			}else{
				$cate=Categorie::create(array("title"=>$name));
				$str="<tr id='cate_".$cate->id."'>";
				$str.="<td class='alert alert-success'>$cate->title</td>";
				$str.="<td class='alert alert-success'><a href='javascritp:void(0)' onclick=\"editCate($cate->id, '$cate->title')\">Sửa</a></td>";
				$str.="<td class='alert alert-success'><a href='javascritp:void(0)' onclick=\"deleteCate($cate->id)\">Xóa</a></td>";
				$str.="</tr>";
				return $str;
			}
		}
	}
	public function postUpdate()
	{
		if(Request::ajax())
		{
			$id = Input::get('id');
			$name = Input::get('name');
			$cateCheck = Categorie::where("title", $name)->where("id", "!=", $id)->first();
			if($cateCheck)
			{
				return Response::Json(array("status"=>"error","mess"=>"Chủ đề này đã tồn tại"));
			}else
			{
				$cate = Categorie::find($id);
				$cate->update(array("title"=>$name));
				$str="<td class='alert alert-success'>$cate->title</td>";
				$str.="<td class='alert alert-success'><a href='javascritp:void(0)' onclick=\"editCate($cate->id, '$cate->title')\">Sửa</a></td>";
				$str.="<td class='alert alert-success'><a href='javascritp:void(0)' onclick=\"deleteCate($cate->id)\">Xóa</a></td>";
				return $str;
			}
		}
	}
	public function getDelete($id)
	{
		if(Request::ajax())
		{
			$cate = Categorie::find($id);
			if($cate)
			{
				$cate->delete();
				return "OK";
			}else
			{
				return Response::Json(array("status"=>"error","mess"=>"Chủ đề này không tồn tại"));
			}
		}
	}
	public function postApiDelete()
	{
			$data = $_POST['data'];
			$data = explode(',', $data);
			if(count($data) > 0)
			{
				foreach ($data as $item) {
					$cate = Categorie::find((int)$item);
					if($cate)
					{
						$cate->delete();
					}
				}
			}
			
	}
	public function postApiCreate()
	{
			$name=Input::get("data");
			$cate=Categorie::where("title",$name)->first();
			if($cate){
				return Response::Json(array("status"=>"error","mess"=>"Chủ đề này đã tồn tại"));
			}else{
				$cate=Categorie::create(array("title"=>$name));
				return Response::Json(array("status"=>"success","mess"=>"OK"));
			}
	}
	public function postApiEdit()
	{
			$id=Input::get("data");
			$cate = Categorie::find($id);
			return Response::Json($cate);
	}
	public function postApiActEdit()
	{
			$data = Input::get('data');
			$data = explode('_', $data);
			$id = (int) $data[0];
			$name = $data[1];
			$cateCheck = Categorie::where("title", $name)->where("id", "!=", $id)->first();
			if($cateCheck)
			{
				return Response::Json(array("status"=>"error","mess"=>"Chủ đề này đã tồn tại"));
			}else
			{
				$cate = Categorie::find($id);
				$cate->update(array("title"=>$name));
				return Response::Json(array("status"=>"success","mess"=>"OK"));
			}
	}
}