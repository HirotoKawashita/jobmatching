<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends BaseModel
{
  use HasFactory;

  // 求人テーブル
  protected $table = 'jobs';
  protected $fillable =
  [
      'corporation_id',
      'industry_id',
      'occupation_id',
      'tag_id',
      'business_content',
      'image_path',
      'salary',
      'is_bonus',
      'various_allowances',
      'welfare',
      'work_location',
      // 'working_hours',
      'contract_period',
      'test_period',
      'work_place',
      'working_start_time',
      'working_end_time',
      'overtime_hours',
      'employment_form',
      'hired_people_no',
      'is_transfer',
      'status',
      'approval_status'
  ];

  public function occupation() {
    return $this->belongsTo(Occupation::class);
}

  public function tag() {
    return $this->belongsTo(Tag::class);
}

}
