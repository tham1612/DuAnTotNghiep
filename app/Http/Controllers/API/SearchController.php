<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; 
use App\Models\Board;
use App\Models\Catalog;
use App\Models\Task;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');  // Từ khóa tìm kiếm
        $workspaceId = $request->input('workspace_id');

        // Tìm kiếm bảng (board) thuộc workspace 
        $boards = Board::where('workspace_id', $workspaceId)
                        ->where('name', 'like', "%{$query}%")
                        ->get();
        session(['board' => $boards]);      
                        
        $catalogs = Catalog::whereHas('board',function($query) use($workspaceId) {
            $query->where('workspace_id',$workspaceId);
        })
        ->where('name','like',"%{$query}%")
        ->with('board')
        ->get();  

        // Tìm kiếm task thuộc catalog trong workspace
        $tasks = Task::whereHas('catalog.board', function ($query) use ($workspaceId) {
            $query->where('workspace_id', $workspaceId);
        })
        ->where('text', 'like', "%{$query}%")
        ->with(['catalog.board'])
        ->get();

        $results = [
            'boards' => $boards->map(function($board) {
                return [
                    'id' => $board->id,
                    'name' => $board->name,
                    'image' => $board->image,
                ];
            }),
            'catalogs'=>$catalogs->map(function($catalog){
                return [
                'id'=> $catalog->id,
                'name'=>$catalog->name,
                'image' => $catalog->image,
                'board_id'=>$catalog->board->id,
                'board_name'=>$catalog->board->name
                ];
            }),
            'tasks' => $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'text' => $task->text,
                    'image' => $task->image,
                    'catalog_id' => $task->catalog->id,
                    'catalog_name' => $task->catalog->name,
                    'board_id' => $task->catalog->board->id,
                    'board_name' => $task->catalog->board->name
                ];
            })
            
        ];
        // Trả về kết quả dưới dạng JSON
        return response()->json($results);
    }
}
