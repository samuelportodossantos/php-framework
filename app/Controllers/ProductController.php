<?php

class ProductController implements Controller
{

  public function index($request)
  {
    $products = new Product();
    Utils::apiReturn(200, "Retornando produtos", $products->all());
  }

  public function save($request)
  {
    $products = new Product();
    $products->where('description', $request['description']);
    if (!$products->get()) {
      $products->save($request);
      Utils::apiReturn(200, "Registro realizado com sucesso!", $products->get());
    } else {
      Utils::apiReturn(200, "Produto já existe!", (new Product())->all());
    }
  }

  public function delete($request)
  {
    $product = new Product();
    $product->delete($request['id']);
    Utils::apiReturn(200, "Registro removido com sucesso", (new Product())->all());
  }

}
