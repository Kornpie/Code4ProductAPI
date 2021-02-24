<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class Product extends ResourceController
{
    use ResponseTrait;
    public function index(){
        $model = new ProductModel();
        $data['products'] = $model ->orderBy('id','DESC')->findAll();
        return $this->respond($data);
    }

    public function getProduct($id=null){
        $model = new ProductModel();
        $data = $model->where('id',$id)->first();
        if ($data) {
            return $this->respond($data);
        } else{
                return $this->failNotFound('No');
        }
    }

    public function create(){
        $model = new ProductModel();
        $data=[
            "name"=>$this->request->getVar('name'),
            "category"=>$this->request->getVar('category'),
            "price"=>$this->request->getVar('price'),
            "tags"=>$this->request->getVar('tags')

        ];
        $model->insert($data);
        $response=[
            'status'=>201,
            'error'=>null,
            "message"=>[
                'success' => 'Product created success'
            ]
            ];
            return $this->respond($response);
    }

    public function update($id=null){
        $model = new ProductModel();
        $data=[
            "name"=>$this->request->getVar('name'),
            "category"=>$this->request->getVar('category'),
            "price"=>$this->request->getVar('price'),
            "tags"=>$this->request->getVar('tags')

        ];
        //$model->where("id",$id)->set($data)->update();
        $model->update($id,$data);
        $response=[
            'status'=>201,
            'error'=>null,
            'product'=>$data,
            "message"=>[
                'success' => 'Product created success'
            ]
            ];
            return $this->respond($response);
    }

    public function delete($id=null){
        $model = new ProductModel();
        $data = $model->find($id);
        if($data){
            $model->delete($id);
            $response=[
                'status'=>201,
                'error'=>null,
                'product'=>$data,
                "message"=>[
                    'success' => 'Product delette success'
                ]
                ];
                return $this->respond($response);
            }else{
                return $this->failNotFound('NO');
            }
    }
    
}