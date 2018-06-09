<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Document;
use App\Movement;

class DocumentController extends Controller
{
    public function edit($movement){
        $movement = \App\Movement::findOrFail($movement);
        if(Auth::user()->can('add-document', $movement)){
            $title = 'Document Create';
            return view('documents.create', compact('title', 'movement'));
        }else{
            return abort(403,"Acess Denied!");
        }
    }

    public function store(Request $request, $movement){

        $movement = \App\Movement::findOrFail($movement);

        if(Auth::user()->can('add-document', $movement)){

            $documentAux = $request->validate([
                'document_file' => 'file|mimes:pdf,png,jpeg|required_with:document_description',
                'document_description'=> 'required_with:document_file',   
            ]);

            if($request->hasFile('document_file') && $request->file('document_file')->isValid()){
                $document['type'] = $request->file('document_file')->getClientOriginalExtension();
                $document['original_name'] = $request->file('document_file')->getClientOriginalName();
                $document['description'] = $documentAux['document_description'];

                if($movement->document_id == null){
                    $documentID = \App\Document::create($document);
                    $movement['document_id'] = $documentID->id;
                    $movement->save();
                } else {
                    $doc = Document::findOrFail($movement->document_id);
                    Storage::delete('documents/' . $movement->account_id . '/' . $movement->id . '.' . $doc->type);
                    $doc->fill($document);
                    $doc->save();
                }
                Storage::putFileAs('documents/'.$movement->account_id, $request->file('document_file'), $movement->id.'.'.$document['type']);

            }    
            return redirect()->route('movements.list', $movement->account_id)->with('status', 'Document added');
        }else{
            return abort(403, "Access Denied");
        }
        
    }

    public function destroy($movement){
        $movement = \App\Movement::findOrFail($movement);

        if(Auth::user()->can('add-document', $movement)){
        
        $document = Document::where('id', '=', $movement->document_id)->get()->first();

        Storage::delete('documents/' . $movement->account_id . '/' . $movement->id . '.' . $document->type);

        $movement->document_id = null;

        $movement->save();

        $document->delete();

        return back()->with('status', 'Document Deleted');

        }else{
            return abort(403, "Access Denied");
        }
    }

    public function download($document){
        $document = Document::findOrFail($document);

        $movement= Movement::where('document_id',$document->id)->first();

        if(Auth::user()->can('view-document', $movement)){
            $path = storage_path('app/documents/'. $movement->account_id . '/' . $movement->id . '.' . $document->type);
            return response()->download($path, $document->original_name);
        }else{
            return abort(403, "Access Denied");
        }
    }

    public function view($document){

        $document = Document::findOrFail($document);

        $movement= Movement::where('document_id',$document->id)->first();

        if(Auth::user()->can('view-document', $movement)){

            $path = storage_path('app/documents/'. $movement->account_id . '/' . $movement->id . '.' . $document->type);

            return response()->file($path);
        }else{
            return abort(403, "Access Denied");
        }
    }
}
