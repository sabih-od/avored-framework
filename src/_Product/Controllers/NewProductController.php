<?php

namespace AvoRed\Framework\_Product\Controllers;

use App\Models\_Category;
use App\Models\_Product;
use AvoRed\Framework\_Category\Requests\NewProductRequest;
use AvoRed\Framework\Database\Contracts\NewCategoryModelInterface;
use AvoRed\Framework\Database\Repository\NewProductRepository;
use AvoRed\Framework\Recipe\Requests\RecipeRequest;
use AvoRed\Framework\Database\Contracts\RecipeModelInterface;
use AvoRed\Framework\Database\Models\Recipe;
use AvoRed\Framework\Tab\Tab;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class NewProductController extends Controller
{

    /**
     * @var AvoRed\Framework\Database\Repository\RecipeRepository $productRepository
     */
    protected $productRepository;
    /**
     *
     * @param RecipeRepository $repository
     */
    public function __construct(
        NewProductRepository $repository
    ) {
        $this->productRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = $this->productRepository->paginate();
        $_products = $this->productRepository->list();
        return view('avored::_product.index')->with('_products', $_products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('avored::_product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewProductRequest $request)
    {
        $_product = $this->productRepository->create($request->all());

        return redirect(route('admin.new_product.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(_Product $_product)
    {
        return view('avored::_product.edit')->with('_product', $_product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest  $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(NewProductRequest $request, _Product $_product)
    {

        $_product->update($request->all());

        return redirect(route('admin.new_product.index'));
    }

    /**
     * @param Recipe $product
     * @return mixed
     */
    public function destroy(_Product $_product, $id)
    {
        _Product::findOrFail($id)->delete();
//        $_product->delete();
        return redirect(route('admin.new_product.index'));
    }
}
