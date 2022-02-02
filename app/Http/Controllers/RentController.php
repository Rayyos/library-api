<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Models\user;
use Carbon\Carbon;
use JWTAuth;


class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['rentedbook' => function ($query) {
            $query->where('rented_book.return_date', '=', null);
        }]);

        return response()->json($users->get());

    }

   
    public function rentBook(Request $request){

        $validator = Validator::make(
            $request->all(),
            [
                'b_id'     => 'required',              
            ],
            [ 'b_id.required' => 'The Book id field is required.']
        );
        $book = Book::where('b_id', $request->b_id )->exists();
      
        if ($validator->fails() | !$book) {
            if(!$book){
                $validator->errors()->add('b_id','Book not found');  
            }
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                400
            );
        }

     
        $rentBook = new Rent();
        $rentBook->u_id = auth()->user()->u_id;
        $rentBook->b_id = $request->b_id;
        $rentBook->rent_date = Carbon::now();
      

        if($rentBook->save()) {
            return response()->json(
                [
                    'status' => true,
                    'message'   => "Successfully Rented",
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Failed to Updated.',
                ]
            );
        }

    }
    


    public function returnBook(Request $request){

        $validator = Validator::make(
            $request->all(),
            [             
                'rented_id' => 'required',              
            ]
        );
  
      
        if ($validator->fails() ) {
            
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                400
            );
        }

        $rentBook = Rent::find($request->rented_id);
        $rentBook->return_date = Carbon::now();
      

        if($rentBook->save()) {
            return response()->json(
                [
                    'status' => true,
                    'message'   => "Successfully Return",
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Failed to Updated.',
                ]
            );
        }

    }
   

 
}
