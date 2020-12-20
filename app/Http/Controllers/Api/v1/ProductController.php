<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiConstants;
use App\Models\Product;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends ApiController
{
   

    /**
     * @OA\Get(
     ** path="/v1/products/list",
     *   tags={"Products"},
     *   summary="List all active products",
     *   operationId="products_list",
     *
     *  @OA\Parameter(
     *      name="token",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {
            $products = Product::where("status" , ApiConstants::ACTIVE_STATUS)->whereHas("owner")->inRandomOrder()->paginate(20);
            $productTransformer = new ProductTransformer();
            return validResponse("Products retrieved", collect_pagination($productTransformer , $products) , $request);
        } catch (\Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return problemResponse($message, ApiConstants::SERVER_ERR_CODE, $request, $e);
        }
    }


     /**
     * @OA\Get(
     ** path="/v1/products/detail",
     *   tags={"Products"},
     *   summary="Show product detail",
     *   operationId="products_details",
     *
     *  @OA\Parameter(
     *      name="product_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="token",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'bail|required|string|exists:products,id',
            ]);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $product = Product::find($request["product_id"]);
            if($product->status != ApiConstants::ACTIVE_STATUS){
                $message = "This product is inactive";
                return problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, $request);
            }
            
            $productTransformer = new ProductTransformer(true);
            return validResponse("Product detail retrieved", collect_pagination($productTransformer , $product) , $request);
        } catch (ValidationException $e) {
            $message = "Input validation errors";
            return inputErrorResponse($message, ApiConstants::VALIDATION_ERR_CODE, $request, $e);
        } catch (\Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return problemResponse($message, ApiConstants::SERVER_ERR_CODE, $request, $e);
        }
    }

}
