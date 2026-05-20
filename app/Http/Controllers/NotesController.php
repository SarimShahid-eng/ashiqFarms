<?php
    namespace App\Http\Controllers;
    use App\Notes;
    use Illuminate\Http\Request;


    class NotesController extends Controller
    {

        public function index()  {

            return view('note.new_index');
        }

        public function save(Request $request)
        {

            $user = auth('web')->user()->id;
            $status = $request->status;
            $id = $request->id;
            // dd($request[0]["id"]);

            $notes = Notes::Find($id);
            //checking if its edit or add
            if(!empty($notes)){
                $msg = 'Notes has been updated successfully';
            }else{
                $notes = new Notes();
                $msg = 'Notes has been added successfully';
                $notes->id = $id;
            }
            //adding the rest of the data
            $notes->name = $request->name;
            $notes->note = $request->note;
            $notes->color = $request->colo;
            $notes->user = $user;

            // dd($notes);
            // dd()
            if($notes->save()){
                return response()->json([
                    'success' => $msg,
                ]);
            }
        }

        public function delete(Request $request)
        {
            $notes = Notes::Find($request->id)->delete();
            if ($notes){
                return response()->json([
                    'success' => 'Note Deleted Successfully',
                    'reload' => true
                ]);
            }
            return response()->json([
                'error' => 'Something Went Wrong',
            ]);
        }

    }

