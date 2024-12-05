<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateUserPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_personal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->OnDelete('cascade');
            $table->integer('position_id')->nullable()->comment('id chức vụ');
            $table->date('birthday')->nullable();
            $table->string('cccd')->nullable()->comment('số căn cước');
            $table->text('note')->nullable();
            $table->string('insurance_number')->nullable()->comment('Số BHXH');
            $table->date('start_probation')->nullable()->comment('Ngày bắt đầu thử việc');
            $table->date('start_work')->nullable()->comment('Ngày bắt đầu chính thức');
            $table->date('insurance_time')->nullable()->comment('Thời gian đóng bảo hiểm');
            $table->date('pause_time')->nullable()->comment('Thời gian tạm nghỉ');
            $table->date('leave_time')->nullable()->comment('Thời gian nghỉ việc');
            $table->integer('leave_reason_id')->nullable()->comment('Lý do nghỉ');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_personal');
    }
}
