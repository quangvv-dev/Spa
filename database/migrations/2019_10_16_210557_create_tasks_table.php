<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->comment('Người thực hiện');
            $table->bigInteger('customer_id')->unsigned()->nullable()->comment('Khách hàng liên quan');
            $table->bigInteger('project_id')->unsigned()->nullable()->comment('Dự án');
            $table->bigInteger('parent_id')->comment('id công việc cha')->default(0);
            $table->string('name')->comment('Tên công việc');
            $table->string('code')->comment('Mã công việc');
            $table->integer('type')->comment('Loại công việc');
            $table->integer('amount_of_work')->comment('Khối lượng công việc')->nullable();
            $table->date('date_from')->comment('Thời gian thực hiện(Ngày)')->nullable();
            $table->date('date_to')->comment('Thời gian thực hiện(Ngày)')->nullable();
            $table->string('time_from')->comment('Thời gian thực hiện(Giờ)')->nullable();
            $table->string('time_to')->comment('Thời gian thực hiện(Giờ)')->nullable();
            $table->string('document')->comment('Tài liệu')->nullable();
            $table->text('description')->comment('Nội dung công việc')->nullable();
            $table->integer('priority')->comment('Độ ưu tiên')->nullable();
            $table->integer('task_status_id')->comment('Trạng thái công việc')->nullable();
            $table->integer('progress')->comment('Tiến độ công việc')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
