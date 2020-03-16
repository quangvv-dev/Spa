<?php


namespace App\Services;


use App\Components\Filesystem\Filesystem;
use App\Constants\UserConstant;
use App\User;

class UserService
{
    public $user;
    private $fileUpload;

    public function __construct(Filesystem $fileUpload, User $user)
    {
        $this->user = $user;
        $this->fileUpload = $fileUpload;
    }

    public function find($id)
    {
        $data = $this->user->where('id', $id)->first();

        return $data;
    }

    public function create($input)
    {
        if (empty($input) && is_array($input) == false)
            return false;

        $input['active'] = UserConstant::ACTIVE;
        $input['password'] = bcrypt($input['password']);

        if ($input['image']) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($input['image']);
        }

        $data = $this->user->fill($input);
        $data->save();

        return$data;
    }

    public function update($input, $id)
    {
        $data = $this->find($id);

        if ($input['password'] == null) {
            $input['password'] = $data->password;
        } else {
            $input['password'] = bcrypt($input['password']);
        }

        if ($input['image']) {
            $input['avatar'] = $this->fileUpload->uploadUserImage($input['image']);
        }

        $data->update($input);

        return $data;
    }
}
