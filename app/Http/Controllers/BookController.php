<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books->toArray());

    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'book_name'     => 'required|string|unique:books',
                'author'     => 'required|string',
                'cover_image'     => 'required||string'
            ]
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                400
            );
        }


        if(($book = Book::create($validator->validated()))) {
            return response()->json(
                [
                    'status' => true,
                    'book'   => $book ,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return $book;
    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'book_name'     => 'required|string|unique:books',
                'author'     => 'required|string',
                'cover_image'     => 'required||string'
            ]
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                400
            );
        }

        if(($book->update($validator->validated()))) {
            return response()->json(
                [
                    'status' => true,
                    'book'   => $book,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if ($book->delete()) {
            return response()->json(
                [
                    'status' => true,
                    'message'   => "Succefully Deleted",
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Failed to deleted.',
                ]
            );
        }

    }
}