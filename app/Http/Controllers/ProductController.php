<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use App\productasset;
use App\Asset;
use App\menus;
use App\Catalog;
use App\Brand;
use Auth;
class ProductController extends Controller
{
     public function list(Request $request){
        $paginate = 25;
        $user = Auth::user();
	    $producer = explode(',', $user['user_grups']);
        $menus = Menus::all();
        $group_id = Auth::user()->group_id;
        $brands = Brand::all();
        $allcataloges = Catalog::all();

       foreach($brands as $itembrandd){
        $brandiscode = $itembrandd->code;
        $brandis[$brandiscode] = $itembrandd->name;
       }
        foreach($allcataloges as $catvi){
            $namescat = $catvi->name;
            $idcat = $catvi->code;
            $cataloges[$idcat] = $namescat;
        }
       
        $group_id = Auth::user()->group_id;
        $price = Auth::user()->price;

        if($price == "asortment"){
            $productcatalog = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->get();
            foreach($productcatalog as $cat){
                $cataloge[mb_strtolower($cat['product_family_id'])]= $cataloges[mb_strtolower($cat['product_family_id'])];
            }
        }
        if($price == "all"){
            $productcatalog = Product::Where('producer', $group_id)->where('deleted', 0)->get();
            foreach($productcatalog as $cat){
                $cataloge[mb_strtolower($cat['product_family_id'])]= $cataloges[mb_strtolower($cat['product_family_id'])];
            }
            }
            if($price == "price"){
        $productcatalog = Product::Where('producer', $group_id)->where('price', "<>", 0)->get();
        $productcatalog2 = Product::Where('producer', $group_id)->where('uvp', "<>", 0)->get();
        foreach($productcatalog2 as $cat){
            $cataloge[mb_strtolower($cat['product_family_id'])]= $cataloges[mb_strtolower($cat['product_family_id'])];
        }
        foreach($productcatalog as $cat){
            $cataloge[mb_strtolower($cat['product_family_id'])]= $cataloges[mb_strtolower($cat['product_family_id'])];
        }
            }
            $catalog = $cataloge;


      if(isset($request->searchproduct)){
        $search = $request->searchproduct;
        if($price == "asortment"){
            $product = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('name', 'like', "%".$search."%")->paginate($paginate);
        }
        if($price == "all"){
            $product = Product::Where('producer', $group_id)->where('deleted', 0)->where('name', 'like', "%".$search."%")->paginate($paginate);
            }
            if($price == "price"){
        $product = Product::Where('producer', $group_id)->where('price', "<>", 0)->where('name', 'like', "%".$search."%")->paginate($paginate);
        $productuvp = Product::Where('producer', $group_id)->where('uvp', "<>", 0)->where('name', 'like', "%".$search."%")->paginate($paginate);
            }
            $allcount = count($product);
    }   
        elseif(isset($request->searchcode)){
            $search = $request->searchcode;
            if($price == "asortment"){
                $product = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('id', 'like', "%".$search."%")->paginate($paginate);
            }
            if($price == "all"){
                $product = Product::Where('producer', $group_id)->where('deleted', 0)->where('id', 'like', "%".$search."%")->paginate($paginate);
                }
                if($price == "price"){
            $product = Product::Where('producer', $group_id)->where('price', "<>", 0)->where('id', 'like', "%".$search."%")->paginate($paginate);
            $productuvp = Product::Where('producer', $group_id)->where('uvp', "<>", 0)->where('id', 'like', "%".$search."%")->paginate($paginate);
                }

        $allcount = count($product);
    
    }
        elseif(isset($request->searchbrand)){
        $search = $request->searchbrand;
        if($price == "asortment"){
            $product = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('brand_id', $search)->paginate($paginate);
        }
        if($price == "all"){
            $product = Product::Where('producer', $group_id)->where('deleted', 0)->where('brand_id', $search)->paginate($paginate);
            }
            if($price == "price"){
        $product = Product::Where('producer', $group_id)->where('price', "<>", 0)->where('brand_id', $search)->paginate($paginate);
        $productuvp = Product::Where('producer', $group_id)->where('uvp', "<>", 0)->where('brand_id', $search)->paginate($paginate);
            }

            $allcount = count($product);

    }   
    elseif(isset($request->orderBy)){
	if($request->orderBy == 'price'){
        if($price == "asortment"){
            $product = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('price', '0')->where('uvp', '0')->paginate($paginate);
        }
        if($price == "all"){
            $product = Product::Where('producer', $group_id)->where('deleted', 0)->where('price', '0')->where('uvp', '0')->paginate($paginate);
            }
            if($price == "price"){
        $product = Product::Where('producer', $group_id)->where('price', "<>", 0)->where('price', '0')->where('uvp', '0')->paginate($paginate);
            }

    }
	if ($request->orderBy == 'nodesc'){
        if($price == "asortment"){
            $product = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('long_description', null)->paginate($paginate);
        }
        if($price == "all"){
            $product = Product::Where('producer', $group_id)->where('deleted', 0)->where('long_description', null)->paginate($paginate);
            }
            if($price == "price"){
        $product = Product::Where('producer', $group_id)->where('price', "<>", 0)->where('long_description', null)->paginate($paginate);
        $productuvp = Product::Where('producer', $group_id)->where('uvp', "<>", 0)->where('long_description', null)->paginate($paginate);
            }
        }

        if ($request->orderBy == 'name'){
            if($price == "asortment"){
                $product = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->orderBy('name', 'ASC')->paginate($paginate);
            }
            if($price == "all"){
                $product = Product::Where('producer', $group_id)->where('deleted', 0)->orderBy('name', 'ASC')->paginate($paginate);
                }
                if($price == "price"){
            $product = Product::Where('producer', $group_id)->where('price', "<>", 0)->orderBy('name', 'ASC')->paginate($paginate);
            $productuvp = Product::Where('producer', $group_id)->where('uvp', "<>", 0)->orderBy('name', 'ASC')->paginate($paginate);
                }
        }
        if ($request->orderBy == 'last'){
            if($price == "asortment"){
                $product = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->orderBy('created_at', 'DESC')->paginate($paginate);
            }
            if($price == "all"){
                $product = Product::Where('producer', $group_id)->where('deleted', 0)->orderBy('created_at', 'DESC')->paginate($paginate);
                }
                if($price == "price"){
            $product = Product::Where('producer', $group_id)->where('price', "<>", 0)->orderBy('created_at', 'DESC')->paginate($paginate);
            $productuvp = Product::Where('producer', $group_id)->where('uvp', "<>", 0)->orderBy('created_at', 'DESC')->paginate($paginate);
                }
        }
    }else{
        
        if($price == "asortment"){
            $product = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->paginate($paginate);
        }
        if($price == "all"){
            $product = Product::Where('producer', $group_id)->where('deleted', 0)->paginate($paginate);;
            }
            if($price == "price"){
        $product = Product::Where('producer', $group_id)->where('price', "<>", 0)->paginate($paginate);;
        $productuvp = Product::Where('producer', $group_id)->where('uvp', "<>", 0)->paginate($paginate);;
       
            }
            $allcount = count($product);
            }
            
$id = 0;

foreach($product as $vi){
    $ids = $vi->mpn;
    $asset = Productasset::Where('product_id', $ids)->Where('is_main_image', 1)->first();
        if(isset($asset['asset_id']) && $asset['asset_id'] != null){
            $as_id = $asset['asset_id'];
            $img = Asset::Where('id', $as_id)->first();
            $img_name = $img->name;
            $images[$ids] = $img_name;
        }
        
        
    $id=$id+1;

}
if(isset($images)){}else{
    $images = null;
}
if($request->ajax()){
    if($request->search){
    $search = $request->search;
    $catalogie = Catalog::where('name', 'like', "%".$search."%")->get();
    foreach($catalogie as $bb){
        $catalogesii[$bb['code']] = $bb['name'];
    }
    return view('ajax.catalog', [
    'catalog' => $catalogesii,
    ])->render();
   
}
if(isset($request->searchproduct)){
   
    return view('ajax.order-by',[
        'product' => $product,
        'cataloge' => $cataloge,
        'brandis' => $brandis,
	'images' => $images,
    ])->render();
}
elseif(isset($request->searchbrand)){
   
    return view('ajax.order-by',[
        'product' => $product,
        'cataloge' => $cataloge,
        'brandis' => $brandis,
	'images' => $images,
    ])->render();
}
elseif(isset($request->searchzak)){
    return view('ajax.order-by',[
        'product' => $product,
        'cataloge' => $cataloge,
        'brandis' => $brandis,
	'images' => $images,
    ])->render();
}elseif(isset($request->searchcode)){
   
    return view('ajax.order-by',[
        'product' => $product,
        'cataloge' => $cataloge,
        'brandis' => $brandis,
    ])->render();
}

elseif(isset($request->orderBy)){
    return view('ajax.order-by',[
	'cataloge' => $cataloge,
	'product' => $product,
	'brandis' => $brandis,
	'images' => $images,
])->render();
}
}else{
    //$catalog = Catalog::all();

    $catalog = $cataloge;
        
        $count_prod = count($product);
        return view('numens.list', [
            'product' => $product,
            'images' => $images,
            'count' => $count_prod,
            'menus' => $menus,
            'catalog' => $catalog,
            'allcount' => $allcount,
            'brands' => $brands,
            'producer' => $producer,
            'cataloge' => $cataloge,
            'brandis' => $brandis,
        ]);
    }
    }








    
    public function showCategory(Request $request, $category_id){
        $id = 0;
        $menus = Menus::all();
        //$catalog = Catalog::all();
        $group_id = Auth::user()->group_id;
        $user = Auth::user();
        $paginate = 25;
        $brands = Brand::all();
        $group_id = Auth::user()->group_id;
        $price = Auth::user()->price;
	$producer = explode(',', $user['user_grups']);
        $allcataloges = catalog::all();
       foreach($brands as $itembrandd){
        $brandiscode = $itembrandd->code;
        $brandis[$brandiscode] = $itembrandd->name;
       }
        foreach($allcataloges as $catvi){
            $namescat = $catvi->name;
            $idcat = $catvi->code;
            $cataloges[$idcat] = $namescat;
        }

        if($price == "asortment"){
            $productcatalog = Product::Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->get();
            foreach($productcatalog as $cat){
                $cataloge[mb_strtolower($cat['product_family_id'])]= $cataloges[mb_strtolower($cat['product_family_id'])];
            }
        }
        if($price == "all"){
            $productcatalog = Product::Where('producer', $group_id)->where('deleted', 0)->get();
            foreach($productcatalog as $cat){
                $cataloge[mb_strtolower($cat['product_family_id'])]= $cataloges[mb_strtolower($cat['product_family_id'])];
            }
            }
            if($price == "price"){
        $productcatalog = Product::Where('producer', $group_id)->where('price', "<>", 0)->get();
        $productcatalog2 = Product::Where('producer', $group_id)->where('uvp', "<>", 0)->get();
        foreach($productcatalog2 as $cat){
            $cataloge[mb_strtolower($cat['product_family_id'])]= $cataloges[mb_strtolower($cat['product_family_id'])];
        }
        foreach($productcatalog as $cat){
            $cataloge[mb_strtolower($cat['product_family_id'])]= $cataloges[mb_strtolower($cat['product_family_id'])];
        }
            }
            $catalog = $cataloge;

        if($request->ajax()){
	    if(isset($request->orderBy)){
        
    	    if ($request->orderBy == 'price'){
                if($price == "asortment"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('price', '0')->where('uvp', '0')->paginate($paginate);
                }
                if($price == "all"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->where('price', '0')->where('uvp', '0')->paginate($paginate);
                    }
                    if($price == "price"){
                $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->where('price', '0')->where('uvp', '0')->paginate($paginate);
                $productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->where('price', '0')->where('uvp', '0')->paginate($paginate);
                    }
    		    }

    	    if ($request->orderBy == 'nofoto'){
                if($price == "asortment"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->orderBy('price', 'ASC')->paginate($paginate);
                }
                if($price == "all"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->orderBy('price', 'ASC')->paginate($paginate);
                    }
                    if($price == "price"){
                $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->orderBy('price', 'ASC')->paginate($paginate);
                $productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->orderBy('price', 'ASC')->paginate($paginate);
                    }
    		    }

    	    if ($request->orderBy == 'nodesc'){
                if($price == "asortment"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('long_description', null)->paginate($paginate);
                }
                if($price == "all"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->where('long_description', null)->paginate($paginate);
                    }
                    if($price == "price"){
                $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->where('long_description', null)->paginate($paginate);
                $productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->where('long_description', null)->paginate($paginate);
                    }
    		    }

    	    if ($request->orderBy == 'name'){
                if($price == "asortment"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->orderBy('name', 'ASC')->paginate($paginate);
                }
                if($price == "all"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->orderBy('name', 'ASC')->paginate($paginate);
                    }
                    if($price == "price"){
                $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->orderBy('name', 'ASC')->paginate($paginate);
                $productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->orderBy('name', 'ASC')->paginate($paginate);
                    }
    		    }
    	    if ($request->orderBy == 'last'){
                if($price == "asortment"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->orderBy('created_at', 'DESC')->paginate($paginate);
                }
                if($price == "all"){
                    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->orderBy('created_at', 'DESC')->paginate($paginate);
                    }
                    if($price == "price"){
                $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->orderBy('created_at', 'DESC')->paginate($paginate);
                $productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->orderBy('created_at', 'DESC')->paginate($paginate);
                    }
    		    }
    }if(isset($request->searchcode)){
 $search = $request->searchcode;
 if($price == "asortment"){
    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('id', 'like', "%".$search."%")->paginate($paginate);
}
if($price == "all"){
    $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->where('id', 'like', "%".$search."%")->paginate($paginate);
    }
    if($price == "price"){
$product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->where('id', 'like', "%".$search."%")->paginate($paginate);
$productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->where('id', 'like', "%".$search."%")->paginate($paginate);
    }
        $allcount = count($product);	    
}if(isset($request->searchproduct)){
        $search = $request->searchproduct;
        if($price == "asortment"){
            $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('name', 'like', "%".$search."%")->paginate($paginate);
        }
        if($price == "all"){
            $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->where('name', 'like', "%".$search."%")->paginate($paginate);
            }
            if($price == "price"){
        $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->where('name', 'like', "%".$search."%")->paginate($paginate);
        $productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->where('name', 'like', "%".$search."%")->paginate($paginate);
            }
        $allcount = count($product);
    }if(isset($request->searchzak)){
        $search = $request->searchzak;
        if($price == "asortment"){
            $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('producer', $search)->paginate($paginate);
        }
        if($price == "all"){
            $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->where('producer', $search)->paginate($paginate);
            }
            if($price == "price"){
        $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->where('producer', $search)->paginate($paginate);
        $productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->where('producer', $search)->paginate($paginate);
            }
        $allcount = count($product);
    }if(isset($request->searchbrand)){
        $search = $request->searchbrand;
        if($price == "asortment"){
            $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->where('brand_id', $search)->paginate($paginate);
        }
        if($price == "all"){
            $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->where('brand_id', $search)->paginate($paginate);
            }
            if($price == "price"){
        $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->where('brand_id', $search)->paginate($paginate);
        $productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->where('brand_id', $search)->paginate($paginate);
            }
        $allcount = count($product);
    }
	if($request->search){
    $search = $request->search;
    $catalog = Catalog::where('name', 'like', "%".$search."%")->get();
	return view('ajax.catalog', [
	'catalog' => $catalog,
    ])->render();
	}
        if($request->ajax()){
            $allcount = count(Product::Where('product_family_id', $category_id)->get());
            foreach($product as $vi){
                $ids = $vi->mpn;
                $asset = Productasset::Where('product_id', $ids)->Where('is_main_image', 1)->first();
                    if(isset($asset['asset_id']) && $asset['asset_id'] != null){
                        $as_id = $asset['asset_id'];
                        $img = Asset::Where('id', $as_id)->first();
                        $img_name = $img->name;
                        $images[$ids] = $img_name;
                    }
                    
                $id=$id+1;
            
            }
            if(isset($images)){}else{
                $images = null;
            }
            return view('ajax.order-by',[
                'allcount' => $allcount,
                'product' => $product,
                'images' => $images,
                'cataloge' =>  $cataloge,
                'brandis' => $brandis,
            ])->render();
        }
           
}else{
    if($group_id!=null){
        if($price == "asortment"){
            $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('tag', 'АССОРТИМЕНТ')->paginate($paginate);
        }
        if($price == "all"){
            $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('deleted', 0)->paginate($paginate);
            }
            if($price == "price"){
        $product = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('price', "<>", 0)->paginate($paginate);
        $productuvp = Product::Where('product_family_id', $category_id)->Where('producer', $group_id)->where('uvp', "<>", 0)->paginate($paginate);
            }
        }else{
            if($price == "asortment"){
                $product = Product::Where('product_family_id', $category_id)->where('tag', 'АССОРТИМЕНТ')->paginate($paginate);
            }
            if($price == "all"){
                $product = Product::Where('product_family_id', $category_id)->where('deleted', 0)->paginate($paginate);
                }
                if($price == "price"){
            $product = Product::Where('product_family_id', $category_id)->where('price', "<>", 0)->paginate($paginate);
            $productuvp = Product::Where('product_family_id', $category_id)->where('uvp', "<>", 0)->paginate($paginate);
                }
        }
        $allcount = count(Product::Where('product_family_id', $category_id)->get());
        foreach($product as $vi){
            $ids = $vi->mpn;
            $asset = Productasset::Where('product_id', $ids)->Where('is_main_image', 1)->first();
                if(isset($asset['asset_id']) && $asset['asset_id'] != null){
                    $as_id = $asset['asset_id'];
                    $img = Asset::Where('id', $as_id)->first();
                    $img_name = $img->name;
                    $images[$ids] = $img_name;
                }
                
            $id=$id+1;
        
        }
        if(isset($images)){}else{
            $images = null;
        }
        return view('numens.showlist',[
            'product' =>$product,
            'images' => $images,
            'user'=>$user,
            'catalog' => $catalog,
            'allcount' => $allcount,
            'menus' => $menus,
            'category_id' => $category_id,
            'brands' => $brands,
            'producer' => $producer,
            'cataloge' => $cataloge,
            'brandis' => $brandis,
        ]);
    }
}
}
