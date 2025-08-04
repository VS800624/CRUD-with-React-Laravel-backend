<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book = Book::query()->orderBy('id','desc')->get();
          return response()->json([
                    'status' => true,
                    'message' => 'All Book Data.',
                    'book' => $book,
                ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validateUser = Validator::make(
            $request->all(),[
            'title' => 'required',
            'author' => 'required|string',
            'publisher' => 'required',
            'price' => 'required|numeric',
        ]);

         if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateUser->errors()->all()
                ],401);
            }

        $book = new Book();

        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->price = $request->price;

        $book->save();

        return response()->json([
            'status' => 'true',
            'message' => 'Book Created Successfully',
            'book'    =>  $book
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
        return response()->json(['message' => 'Book not found'], 404);
    }

         return response()->json([
                    'status' => true,
                    'message' => 'Your Single Book',
                    'book' => $book,
                ],200);
    }

    public function edit(string $id){
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'User not found'], 404);
        }

            return response()->json($book, 200);
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validateUser = Validator::make(
            $request->all(),[
            'title' => 'required',
            'author' => 'required|string',
            'publisher' => 'required',
            'price' => 'required|numeric',
        ]);

         if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateUser->errors()->all()
                ],401);
            }

        $book = Book::find($id);

        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->price = $request->price;

        $book->save();

        return response()->json([
            'status' => true,
            'message' => 'New Book Added Successfully',
            'book'    =>  $book
    ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
        $book->delete();

          return response()->json([
            'status' => true,
            'message' => 'Book Deleted Successfully',
            'book'    =>  $book
    ], 201);
    }
}
