<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agreement;
use App\Helpers\CommonHelpers;
use App\Schedule;
use App\Head;
use App\Expense;
use App\Note;

class NoteController extends Controller
{
public function index()  {
    $data=Note::all();
return view('note.index',compact('data'));
}
public function store(Request $request)  {
    $Input=$request->all();
if($request->update_id){
        // Find the record you want to update
        $record = Note::findOrFail($request->update_id);
  // Update the record
  $record->update($Input);
  return response([
    'success'  => 'Data Updated successfully',
    'redirect' => route('note.show'),
]);
}else{
  // Insert the record

    Note::create($Input);
    return response([
      'success'  => 'Data Inserted successfully',
      'redirect' => route('note.show'),
  ]);
}

}
public function edit($id) {
    // if(!empty($id)){
    $data=Note::all();

        $id= Note::findorFail($id);
    return view('note.index',['id'=>$id,'data'=>$data]);
    // }
}
public function delete($id) {
    if($note = Note::find($id)){
        $note->forceDelete();
        return response()->json([
            'success' => 'Note Deleted Successfully',
            'reload' => TRUE,
        ]);

    }
    else{
        return redirect()->back()->with('error','Permission Denied');
    }
}

}
