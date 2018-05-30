<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index($movement){
        $title = 'Document Create';
        return view('documents.create', compact('title', 'movement'));
    }

    public function store(Request $request, $movement){
        $movement = \App\Movement::findOrFail($movement);

        $documentAux = $request->validate([
            'document_file' => 'file|mimes:pdf,png,jpeg',
            'document_description'=> 'required_if:document_file, file',   
        ]);

        if($request->hasFile('document_file') && $request->file('document_file')->isValid()){
            $document['type'] = $request->file('document_file')->getClientOriginalExtension();
            $document['original_name'] = $request->file('document_file')->getClientOriginalName();
            $document['description'] = $documentAux['document_description'];

            //dd($document);

            $documentID = \App\Document::create($document);

            $movement['document_id'] = $documentID->id;
            $movement->save();
                //$filepath = $request->file('document_file')->storeAs('documents', $account->id, $movCreated->id);
                Storage::putFileAs('documents/'.$movement->account_id, $request->file('document_file'), $movement->id.'.'.$document['type']);
            
        }
        return redirect()->route('movements.list', $movement->account_id)->with('status', 'Document added');
    }

    public function destroy($movement){

    }

    public function download($document){

    }
}
