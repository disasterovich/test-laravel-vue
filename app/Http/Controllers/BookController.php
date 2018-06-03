<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Resources\Book as BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];

        if ($request->input('name')) $where['name'] = $request->input('name');
        if ($request->input('description')) $where['description'] = $request->input('description');

        $books = Book::where($where)->orderBy('id', 'desc')->paginate(5);

        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\Book\BookResource
     */
    public function store(Request $request)
    {
        //
        $data = $request->json()->all();

        $book = $request->isMethod('put') ? Book::findOrFail($data['id']) : new Book;

        $book->name = $data['name'];
        $book->description = $data['description'];

        if ($book->save()) {
            return new BookResource($book);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $book
     * @return \App\Http\Resources\Book\BookResource
     */
    public function show($id)
    {
        //
        $book = Book::findOrFail($id);

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $book
     * @return \App\Http\Resources\Book\BookResource
     */
    public function destroy($id)
    {
        //
        $book = Book::findOrFail($id);

        if ($book->delete()) {
            return new BookResource($book);
        }
    }
}
