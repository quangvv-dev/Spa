<?php

namespace App\Http\Controllers\API\Contact;

use App\Constants\DepartmentConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Model\Contact;
use App\Models\Customer;
use App\Services\ContactService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends BaseApiController
{

    protected $validate = [
        'customer_id'     => 'required',
        'code'            => 'required',
        'full_name'       => 'required',
        'phone'           => 'required',
        'service'         => 'string',
        //        'address'         => 'string',
        //        'cccd'            => 'integer',
        'warranty_number' => 'required|integer',
        'date'            => 'required',
        'before'          => 'required',
        'after'           => 'required',
        'price'           => 'required',
        'result'          => 'string',
        'warranty_time'   => 'string',
    ];
    protected $contact;

    public function __construct(ContactService $contact)
    {
        $this->contact = $contact;
    }


    /**
     * Display record
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->contact->getAll($request->except('limit', 'page'))->orderByDesc('id')
            ->paginate(!empty($params->limit) ? $params->limit : StatusCode::PAGINATE_20);
        return $this->responseApi(ResponseStatusCode::OK, 'Success', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validate);
        if ($validator->fails()) {
            return response()->json([
                'code'    => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }
        $data = $this->contact->create($request->all());
        return $this->responseApi(ResponseStatusCode::OK, 'Success', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Contact $contact)
    {
        return $this->responseApi(ResponseStatusCode::OK, 'Success', $contact);
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
        //
    }

    /**
     * @param Request $request
     * @param Contact $contact
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), $this->validate);
        if ($validator->fails()) {
            return response()->json([
                'code'    => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }
        $contact->update($request->all());
        return $this->responseApi(ResponseStatusCode::OK, 'Cập nhật hồ sơ thành công !', $contact);
    }

    /**
     * @param Request $request
     * @param Contact $contact
     *
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function destroy(Request $request, Contact $contact)
    {
        $user = User::find($request->jwtUser->id);
        if (!empty($user) && $user->department_id == DepartmentConstant::ADMIN) {
            $contact->delete();
            return $this->responseApi(ResponseStatusCode::OK, 'Xóa hồ sơ thành công !');
        } else {
            return $this->responseApi(ResponseStatusCode::UNAUTHORIZED, 'Bạn không có quyền thao xóa hồ sơ !');
        }
    }
}
