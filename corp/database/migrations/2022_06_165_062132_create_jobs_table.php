
<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id')->unsigned()->comment("ID");
            $table->integer('corporation_id')->index()->comment("企業ID");
            $table->integer('industry_id')->index()->comment("業種ID");
            $table->integer('occupation_id')->index()->comment("職種ID");
            $table->text('title')->comment("求人名s");
            $table->integer('tag_id')->index()->comment("タグID");
            $table->text('business_content')->comment("事業内容");
            $table->text('image_path', 200)->comment("画像のパス");
            $table->integer('salary')->comment("給与");
            $table->tinyInteger('is_bonus')->comment("賞与有無（0: 無し, 1: 有り）");
            $table->string('various_allowances', 50)->comment("諸手当");
            $table->string('welfare', 50)->comment("福利厚生");
            $table->string('work_location', 30)->comment("勤務地");
            // $table->integer('working_hours')->comment("勤務時間");
            $table->integer('contract_period')->comment("契約期間 ~ヶ月");
            $table->integer('test_period')->comment("試用期間 ~ヶ月");
            $table->string('work_place', 30)->comment("就業場所");
            $table->time('working_start_time')->comment("労働開始時間 ~時間");
            $table->time('working_end_time')->comment("労働終了時間 ~時間");
            $table->integer('overtime_hours')->comment("残業時間 ~時間");
            $table->tinyInteger('is_transfer')->comment("転勤有無（0:無し, 1:有り）");
            $table->tinyInteger('employment_form')->comment("1: 正社員 2:契約社員 3:派遣社員　4:パート・アルバイト");
            $table->integer('hired_people_no')->comment("採用予定人数");
            $table->tinyInteger('status')->comment("求人表示（0:非表示 1: 表示）");
            $table->tinyInteger('approval_status')->comment("承認ステータス（0:非承認、 1:承認）");
            $table->timestamp('created_at')->useCurrent()->comment("作成日");
            $table->timestamp('updated_at')->useCurrent()->comment("更新日");
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
        Schema::dropIfExists('jobs');
    }
}
