<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $books = Book::all()
                ->makeHidden(['category_id', 'created_at', 'updated_at'])
                ->map(function ($book) {
                    $book['category'] = $book->category;
                    return $book;
                })
            ;

            if($books->isEmpty()){
                return response()->json(['error'=> 'There are no books yet.'], 404);
            }

            return response()->json(['message'=>'Successfully get all books.','data'=>$books]);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request): JsonResponse
    {
        try{
            $book = Book::create($request->validated());
            return response()->json(['message'=> 'Successfully added new books.', 'data'=>$book], 201);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            if($id === ""){
                return response()->json(['error'=> 'Book id is required.'], 400);
            }
            $book = Book::where('id', $id)
                ->get()
                ->makeHidden(['category_id', 'created_at', 'updated_at'])
                ->map(function ($book) {
                    $book['category'] = $book->category;
                    return $book;
                });
            if($book == null){
                return response()->json(['error'=> 'Book not found.'], 404);
            }
            return response()->json($book);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id): JsonResponse
    {
        try {
            if($id === ""){
                return response()->json(['error'=> 'Book id is required.'], 400);
            }
            $book = Book::find($id);
            $book->update($request->validated());

            return response()->json(['message'=>'Book updated successfully.','data'=>$book],201);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try{
            if($id === ""){
                return response()->json(['error'=> 'Book id is required.'], 400);
            }
            $book = Book::where('id', $id);
            if($book == null){
                return response()->json(['error'=> 'Book not found.'], 404);
            }
            $book->delete();

            return response()->json(['message'=>'Book successfully deleted']);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
