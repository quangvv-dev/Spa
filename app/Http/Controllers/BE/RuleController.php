<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Element;
use App\Models\Rule;
use App\Models\Status;
use App\Models\Category;
use App\Models\RuleOutput;
use App\Helpers\Functions;

class RuleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:rules.list', ['only' => ['index']]);
        $this->middleware('permission:rules.edit', ['only' => ['show']]);
        $this->middleware('permission:rules.add', ['only' => ['create']]);
        $this->middleware('permission:rules.delete', ['only' => ['destroy']]);

        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray();//trạng thái KH
        $category = Category::pluck('name', 'id')->toArray();//danh sách nhóm dịch vụ

        view()->share([
            'category' => $category,
            'status' => $status,
            'schedule_status' => Schedule::SCHEDULE_STATUS,
        ]);
    }

    function findIndexOfKey($key_to_index, $array)
    {
        return @$array[$key_to_index];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Automation';
        $docs = Rule::orderBy('id', 'desc');
        $docs = $docs->paginate(10);
        $total = $docs->total();
        return view('rules.index', compact('docs', 'title', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Automation';
        $elements = Element::all();
        return view('rules._form', compact('elements', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['id', 'title', 'start_at', 'end_at', 'configs', 'status']);
        if (!$request->has('status')) {
            $data['status'] = 0;
        }
        if (!empty($data['id'])) {
            $rule = Rule::find($data['id']);
            if (!empty($rule)) {
                $rule->update($data);
            }
        } else {
            $rule = new Rule($data);
            $rule->save();
        }
        $this->output($rule);
        return redirect('rules');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $elements = Element::all();
        $rule = Rule::find($id);
        return view('rules._form', compact(['elements', 'rule']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rule::find($id)->delete();
        $this->removeOutput($id);
        return 1;
    }

    public function delete($id)
    {

    }

    public function output($rule)
    {
        $configs = json_decode(json_decode($rule->configs));
        $data = collect($configs->nodeDataArray);
        $links = collect($configs->linkDataArray);
        $nodes = $data->mapWithKeys(function ($item) {
            return [$item->key => $item];
        });
        $arr = [];
        $link_nodes = [];
        foreach ($links as $key1 => $link1) {
            $link = [];
            foreach ($links as $key2 => $link2) {
                if ($link1->to == $link2->from && count($link) == 0) {
                    array_push($link, $link1->from, $link1->to, $link2->to);
                }
                if ($link1->from == $link2->to && count($link) == 0) {
                    array_push($link, $link2->from, $link2->to, $link1->to);
                }
            }
            if (!in_array($link, $link_nodes, true)) {
                array_push($link_nodes, $link);
            }
        }
        //---------- Kiểm tra bước 2: Trạng thái KH, Nhóm KH, TT lịch hẹn ---------/
        $key = array_keys(array_column((array)$configs->nodeDataArray, 'key'), 3);
        $key_status = array_keys(array_column((array)$configs->nodeDataArray, 'key'), 4);
        $schedule_status = array_keys(array_column((array)$configs->nodeDataArray, 'key'), 10);
        if (count($key)){
            $category_data = $configs->nodeDataArray[$key[0]];
            $category_ids = $category_data->configs->group;
        }if (count($key_status)){
            $status_data = $configs->nodeDataArray[$key_status[0]];
            $status_ids = $status_data->configs->group;
        }
        if (count($schedule_status)){
            $schedule_status = $configs->nodeDataArray[$schedule_status[0]];
            $schedule_ids = $schedule_status->configs->group;
        }
        foreach ($link_nodes as $key => $record) {
            $new = [];
            if (!empty($category_ids) && count($category_ids)) {
                foreach ($category_ids as $item) {
                    $new['rule_id'] = $rule->id;
                    $new['category_id'] = $item;
                    $new['status'] = $rule->status;
                    $new['event'] = $nodes[$record[0]]->value;
                    $new['action'] = $nodes[$record[2]]->value;
                    $new['configs'] = isset($nodes[$record[2]]->configs) ? json_encode($nodes[$record[2]]->configs) : null;

                    if (isset($nodes[$record[1]]->configs) && isset($nodes[$record[1]]->configs->group) && count($nodes[$record[1]]->configs->group)) {
                        foreach ($nodes[$record[1]]->configs->group as $key => $gr) {
                            $new['actor'] = $gr;
                            array_push($arr, $new);
                        }
                    }
                }
            }elseif(!empty($status_ids) && count($status_ids)){
                $new['rule_id'] = $rule->id;
                $new['category_id'] = 0;
                $new['status'] = $rule->status;
                $new['event'] = $nodes[$record[0]]->value;
                $new['action'] = $nodes[$record[2]]->value;
                $new['configs'] = isset($nodes[$record[2]]->configs) ? json_encode($nodes[$record[2]]->configs) : null;

                if (isset($nodes[$record[1]]->configs) && isset($nodes[$record[1]]->configs->group) && count($nodes[$record[1]]->configs->group)) {
                    foreach ($nodes[$record[1]]->configs->group as $key => $gr) {
                        $new['actor'] = $gr;
                        array_push($arr, $new);
                    }
                }
            }elseif(!empty($schedule_status) && count($schedule_ids)){
                $new['rule_id'] = $rule->id;
                $new['category_id'] = 0;
                $new['status'] = $rule->status;
                $new['event'] = $nodes[$record[0]]->value;
                $new['action'] = $nodes[$record[2]]->value;
                $new['configs'] = isset($nodes[$record[2]]->configs) ? json_encode($nodes[$record[2]]->configs) : null;

                if (isset($nodes[$record[1]]->configs) && isset($nodes[$record[1]]->configs->group) && count($nodes[$record[1]]->configs->group)) {
                    foreach ($nodes[$record[1]]->configs->group as $key => $gr) {
                        $new['actor'] = $gr;
                        array_push($arr, $new);
                    }
                }
            }
        }
        $this->removeOutput($rule->id); // Remove before insert
        RuleOutput::insert($arr);
    }

    public function removeOutput($ruleId)
    {
        RuleOutput::where('rule_id', $ruleId)->delete();
    }
}
