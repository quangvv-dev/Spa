<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\DepartmentConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Fanpage;
use App\Models\MultiplePageGroup;
use App\Models\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('marketing.chat_fanpage.chat_one_page');
    }

    public function chatFanpage(Request $request)
    {
        $data = $request->all();
        $data['used'] = 1;
        $user = Auth::user();
        if ($user->department_id == DepartmentConstant::MARKETING) {
            $data['searchUser'] = $user->id;
        }
        $fanpages = Fanpage::search($data)->get();
        $mkts = User::where('department_id', DepartmentConstant::MARKETING)->get();
        $group_multi = self::getGroupMulti();
        if ($request->ajax()) {
            return view('marketing.chat_fanpage.ajax', compact('fanpages', 'mkts'));
        }
        return view('marketing.chat_fanpage.index', compact('fanpages', 'mkts', 'group_multi'));
    }

    public function chatMultiPage()
    {
        return view('marketing.chat_fanpage.chat_multi_page');
    }

    public function getFanpageToken($id)
    {
        $page = Fanpage::where('page_id', $id)->first();
        return response()->json([
            'code' => 200,
            'data' => $page,
        ]);
    }

    public function getPhonePage(Request $request)
    {
        return Customer::select('phone', 'page_id', 'FB_ID')->whereIn('page_id', $request->arr_page)->get();
    }

    public function getCommentPage(Request $request)
    {
        $data = Comment::whereIn('page_id', $request->arr_page)->get();
        return $data;
    }

    public function getDetailComment(Request $request)
    {
        $data = Comment::where('page_id', $request->page_id)->where('post_id', $request->post_id)->where('FB_ID', $request->FB_ID)->first();
        return $data;
    }

    public function updateReadComment(Request $request)
    {
        $data = Comment::where('page_id', $request->page_id)->where('post_id', $request->post_id)->where('FB_ID', $request->FB_ID)->first();
        $data->update(['is_read' => 1]);
        return 1;
    }

    public function addGroup(Request $request)
    {
        $user = Auth::user();
        $group = MultiplePageGroup::create(['name' => 'Group new', 'page_ids' => '[]', 'user_id' => $user->id]);
        return $group;
    }

    public function updateGroup(Request $request)
    {
        if ($request->name) {
            $data['name'] = $request->name;
        }
        if ($request->arr_page) {
            $data['page_ids'] = json_encode($request->arr_page);
        } else {
            $data['page_ids'] = "[]";
        }
        MultiplePageGroup::find($request->id)->update($data);
        $group_multi = self::getGroupMulti();
        return $group_multi;
    }

    public function getGroupMulti()
    {
        $user = Auth::user();
        if ($user->department_id == DepartmentConstant::MARKETING) {
            $group_multi = MultiplePageGroup::where('user_id', $user->id)->get();
        } elseif ($user->department_id == DepartmentConstant::CARE_PAGE || $user->department_id == DepartmentConstant::ADMIN) {
            $group_multi = MultiplePageGroup::get();
        } else {
            $group_multi = [];
        }
        return $group_multi;
    }

    public function deleteGroup($id)
    {
        MultiplePageGroup::find($id)->delete();
        return 1;
    }

    public function getDataFormCustomer()
    {
        $group = Category::select('id', 'name')->where('type',StatusCode::SERVICE)->get();
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->select('name', 'id')->get();// nguồn KH
        $branchs = Branch::select('name', 'id')->get();// chi nhánh
        $telesales = User::select('id', 'department_id', 'full_name')->whereIn('department_id', [DepartmentConstant::WAITER, DepartmentConstant::TELESALES, UserConstant::TECHNICIANS])->get();
        return response()->json([
            'code' => 200,
            'data' => [
                'group' => $group,
                'source' => $source,
                'branch' => $branchs,
                'telesale' => $telesales
            ],
        ]);
    }

    public function createCustomer(Request $request)
    {
        $data = $request->except('group_id');
        $data['carepage_id'] = Auth::user()->id;
        $status = Status::where('code', 'moi')->first();
        if ($status) {
            $data['status_id'] = $status->id;
        }
        $fanpage = Fanpage::where('page_id', $request->page_id)->with('source')->first();
        if ($fanpage->source) {
            $data['source_fb'] = $fanpage->source->id;
            $data['mkt_id'] = $fanpage->source->mkt_id;
        }
        $customer = Customer::create($data);
        self::createCustomerGroup($request->group_id, $customer->id, $customer->branch_id);
        return response()->json([
            'code' => 200,
            'success' => true
        ]);
    }

    protected function createCustomerGroup($group_id, $customer_id, $branch_id)
    {
        $category = Category::find($group_id);
        if (count($category)) {
            foreach ($category as $item) {
                CustomerGroup::create([
                    'customer_id' => $customer_id,
                    'category_id' => $item->id,
                    'branch_id' => $branch_id,
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i')
                ]);
            }
        }
    }

    public function createCommentCustomer(Request $request)
    {
        $comment = Comment::where('page_id', $request->page_id)->where('post_id', $request->post_id)
            ->where('FB_ID', $request->FB_ID)->first();

        $data_content = array([
            'created_time' => date('Y-m-d H:i:s'),
            'message' => $request->snippet,
            'comment_id' => $request->comment_id,
            'parent_id' => $request->parent_id
        ]);
        if ($comment) {
            $data_push = json_decode($comment->content);
            if ($request->snippet != $comment->snippet) {
                array_push($data_push, $data_content[0]);
                $comment->update(['snippet' => $request->snippet, 'content' => json_encode($data_push)]);
            }
            $code = 201;
        } else {
            $data = $request->except(['comment_id', 'parent_id']);
            $data['content'] = json_encode([$data['content']]);
            Comment::create($data);
            $code = 200;
        }
        return response()->json([
            'code' => $code,
            'success' => true
        ]);
    }
}
