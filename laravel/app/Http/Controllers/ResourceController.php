<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Tool;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{
    public function index()
    {
        $rooms = Room::get();
        $tools = Tool::get();

        return response()->json(['rooms' => $rooms, 'tools' => $tools]);
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search_query');

        $roomQuery = Room::query();
        $roomQuery->where('name', 'like', '%' . $searchQuery . '%');

        $toolQuery = Tool::query();
        $toolQuery->where('name', 'like', '%' . $searchQuery . '%');

        $filteredRooms = $roomQuery->get();
        $filteredTools = $toolQuery->get();

        return response()->json(['rooms' => $filteredRooms, 'tools' => $filteredTools]);
    }

    public function filter($value)
    {
        if ($value == 'rooms') {
            $rooms = Room::get();
            return response()->json(['resources' => $rooms, 'type' => $value]);
        }

        if ($value == 'tools') {
            $tools = Tool::get();
            return response()->json(['resources' => $tools, 'type' => $value]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'type' => 'required|in:room,tool',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->input('type') == 'room'){
            $room = Room::create([
                'name' => $request->input('name'),
                'bookable_online' => $request->input('bookable_online', 0),
            ]);
    
            return response()->json(['message' => 'Room created successfully']);
        }

        if($request->input('type') == 'tool'){
            $tool = Tool::create([
                'name' => $request->input('name'),
                'bookable_online' => $request->input('bookable_online', 0),
            ]);
    
            return response()->json(['message' => 'Tool created successfully']);
        }

    }

    public function update(Request $request, $type, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'bookable_online' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($type == 'rooms') {
            $room = Room::find($id);

            if (!$room) {
                return response()->json(['message' => 'Room not found'], 404);
            }

            $room->update([
                'name' => $request->input('name'),
                'bookable_online' => $request->input('bookable_online', 0),
            ]);

            return response()->json(['message' => 'Room updated successfully']);
        }

        if ($type == 'tools') {
            $tool = Tool::find($id);

            if (!$tool) {
                return response()->json(['message' => 'Tool not found'], 404);
            }

            $tool->update([
                'name' => $request->input('name'),
                'bookable_online' => $request->input('bookable_online', 0),
            ]);

            return response()->json(['message' => 'Tool updated successfully']);
        }

        return response()->json(['message' => 'Invalid resource type'], 422);
    }

    public function getResource($type, $id)
    {
        if($type == 'rooms'){
            $resource = Room::find($id);
            if(!$resource){
                return response()->json('Resource not found', 404);
            }

            return response()->json($resource);
        }

        if($type == 'tools'){
            $resource = Tool::find($id);
            if(!$resource){
                return response()->json('Resource not found', 404);
            }

            return response()->json($resource);
        }
    }

    public function delete(Request $request, $type, $id)
    {
        if($type == 'rooms'){
            $resource = Room::find($id);

            if(!$resource){
                return response()->json('Resource group not found', 404);
            }

            $resource->delete();

            return response()->json('Resource deleted successfully', 200);
        }

        if($type == 'tools'){
            $resource = Tool::find($id);

            if(!$resource){
                return response()->json('Resource group not found', 404);
            }

            $resource->delete();

            return response()->json('Resource deleted successfully', 200);
        }
    }
}
