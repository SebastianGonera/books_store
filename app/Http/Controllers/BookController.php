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
            $books = Book::all()->each(function ($book) {
                return $book->makeDTO();
            });

            if($books->isEmpty()){
                throw new Exception('There are no books yet');
            }

            return response()->json($books);
        }
        catch (Exception $e) {
            print $e->getMessage();
            return response()->json($e->getMessage(), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request): JsonResponse
    {
        try{
            Book::create($request->validated());
            return response()->json('Book created successfully', 201);
        }
        catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            if($id === ""){
                throw new Exception('Book id or book not found');
            }
            $book = Book::find($id);
            if($book == null){
                throw new Exception('Book not found');
            }
            $book = $book->makeDTO();
            return response()->json($book);
        }
        catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id): JsonResponse
    {
        try {
            if($id === ""){
                throw new Exception('Book id or book not found');
            }
            $book = Book::find($id);
            $book->update($request->validated());
            return response()->json($book);
        }
        catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try{
            if($id === ""){
                throw new Exception('Book id or book not found');
            }
            $book = Book::where('id', $id);
            if($book == null){
                throw new Exception('Book not found');
            }
            $book->delete();

            return response()->json('Book successfully deleted');
        }
        catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }
}
